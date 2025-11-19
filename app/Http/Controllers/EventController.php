<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\EventAttendance;
use App\Models\EventCompletion;
use App\Mail\EventCreatedNotification;
use App\Mail\DocumentTransferredNotification;
use App\Mail\EventUpdatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index(Request $request)
    {
        $query = Event::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->get('status');
            $today = now()->format('Y-m-d');
            
            switch ($status) {
                case 'upcoming':
                    $query->where('startDate', '>', $today);
                    break;
                case 'ongoing':
                    $query->where('startDate', '<=', $today)
                          ->where(function($q) use ($today) {
                              $q->whereNull('endDate')
                                ->orWhere('endDate', '>=', $today);
                          });
                    break;
                case 'completed':
                    $query->where('endDate', '<', $today)
                          ->whereNotNull('endDate');
                    break;
            }
        }

        // Notification status filter (sent | pending | failed)
        if ($request->filled('notification_status')) {
            $ns = $request->get('notification_status');
            if (in_array($ns, ['sent', 'pending', 'failed'])) {
                $query->where('notification_status', $ns);
            }
        }

        // Date filter - Set default to 'today' if no date filter is specified
        $dateFilter = $request->get('date_filter');
        if (!$request->filled('date_filter') && !$request->hasAny(['search', 'status', 'search_year', 'search_month', 'search_day', 'search_day_name', 'specific_date', 'date_from', 'date_to'])) {
            $dateFilter = 'today';
        }
        
        if ($dateFilter) {
            $today = now();
            
            switch ($dateFilter) {
                case 'today':
                    $query->whereDate('startDate', $today->format('Y-m-d'));
                    break;
                case 'tomorrow':
                    $query->whereDate('startDate', $today->addDay()->format('Y-m-d'));
                    break;
                case 'upcoming':
                    $query->where('startDate', '>', $today->format('Y-m-d'));
                    break;
                case 'this_week':
                    $query->whereBetween('startDate', [
                        $today->startOfWeek()->format('Y-m-d'),
                        $today->endOfWeek()->format('Y-m-d')
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('startDate', $today->month)
                          ->whereYear('startDate', $today->year);
                    break;
                case 'next_month':
                    $nextMonth = $today->copy()->addMonth();
                    $query->whereMonth('startDate', $nextMonth->month)
                          ->whereYear('startDate', $nextMonth->year);
                    break;
            }
        }

        // Advanced date search filters
        if ($request->filled('search_year')) {
            $query->whereYear('startDate', $request->get('search_year'));
        }

        if ($request->filled('search_month')) {
            $query->whereMonth('startDate', $request->get('search_month'));
        }

        if ($request->filled('search_day')) {
            $query->whereDay('startDate', $request->get('search_day'));
        }

        if ($request->filled('search_day_name')) {
            $dayName = $request->get('search_day_name');
            $query->whereRaw('DAYNAME(startDate) = ?', [$dayName]);
        }

        if ($request->filled('specific_date')) {
            $query->whereDate('startDate', $request->get('specific_date'));
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('startDate', [
                $request->get('date_from'),
                $request->get('date_to')
            ]);
        } elseif ($request->filled('date_from')) {
            $query->where('startDate', '>=', $request->get('date_from'));
        } elseif ($request->filled('date_to')) {
            $query->where('startDate', '<=', $request->get('date_to'));
        }

        // Get sort parameter, default to descending (newest first)
        $sortOrder = $request->get('sort', 'desc');
        $sortField = $request->get('sort_field', 'startDate');
        
        // Validate sort parameters
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }
        if (!in_array($sortField, ['startDate', 'title', 'created_at'])) {
            $sortField = 'startDate';
        }

        // Apply sorting and pagination
        // Apply 'mine' filter: when user wants to see only their own agenda
        if ($request->filled('mine') && Auth::check()) {
            $user = Auth::user();

            // Only allow 'mine' for non-admin users (defense in depth).
            // If current user is admin/super_admin, ignore the 'mine' parameter.
            if (!in_array($user->role, ['admin', 'super_admin'])) {
                // Prefer matching via recipients relation (users)
                $query->whereHas('recipients', function($q) use ($user) {
                    // recipients relation is a belongsToMany to users table, so filter by users.email
                    // use explicit table prefix to be safe in complex queries
                    $q->where('users.email', $user->email);
                });

                // Legacy fallback: some deployments had events.email column
                if (Schema::hasColumn('events', 'email')) {
                    // Grouped or condition so it doesn't break other query parts
                    $query->orWhere('events.email', $user->email);
                }
            }
        }

        $events = $query->orderBy($sortField, $sortOrder)->paginate(12)->withQueryString();
        
        // Also get events data for calendar widget (inline fallback)
        $eventsForCalendar = Event::select('id', 'title', 'startDate', 'endDate', 'startTime', 'endTime', 'location')
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'startDate' => $event->startDate ? $event->startDate->format('Y-m-d') : null,
                    'endDate' => $event->endDate ? $event->endDate->format('Y-m-d') : null,
                    'startTime' => $event->startTime,
                    'endTime' => $event->endTime,
                    'location' => $event->location,
                ];
            });
        
        // Pass the effective date filter to the view for proper display
        $effectiveDateFilter = $dateFilter ?: ($request->filled('date_filter') ? $request->get('date_filter') : null);

        // If a specific date parameter is present, infer the best matching bucket
        // so the dropdown reflects what the user is effectively seeing (e.g. 'tomorrow', 'this_week').
        if ($request->filled('specific_date')) {
            try {
                $specific = Carbon::parse($request->get('specific_date'))->startOfDay();
                $now = Carbon::today();

                if ($specific->equalTo($now)) {
                    $effectiveDateFilter = 'today';
                } elseif ($specific->equalTo($now->copy()->addDay())) {
                    $effectiveDateFilter = 'tomorrow';
                } elseif ($specific->between($now->copy()->startOfWeek(), $now->copy()->endOfWeek())) {
                    $effectiveDateFilter = 'this_week';
                } elseif ($specific->month === $now->copy()->addMonth()->month && $specific->year === $now->copy()->addMonth()->year) {
                    $effectiveDateFilter = 'next_month';
                } elseif ($specific->month === $now->month && $specific->year === $now->year) {
                    $effectiveDateFilter = 'this_month';
                } else {
                    $effectiveDateFilter = 'specific';
                }
            } catch (\Exception $e) {
                // If parsing fails, fall back to marking as specific
                $effectiveDateFilter = 'specific';
            }
        }
        
        // Special handling for status=upcoming from dashboard
        if ($request->get('status') === 'upcoming' && !$request->filled('date_filter')) {
            $effectiveDateFilter = 'upcoming';
        }
        
        // Performance: compute attendance aggregates for events on this page
        try {
            // Ensure recipients count is available on each event (uses the recipients relation)
            $events->getCollection()->loadCount('recipients');

            $eventIds = $events->pluck('id')->toArray();

            $attendanceRows = EventAttendance::whereIn('event_id', $eventIds)
                ->selectRaw('event_id, SUM(CASE WHEN status IN ("attended","completed") THEN 1 ELSE 0 END) as attended_count')
                ->groupBy('event_id')
                ->pluck('attended_count', 'event_id')
                ->toArray();

            // Also compute completions per event (count distinct users who submitted completions)
            try {
                if (Schema::hasTable('event_completions')) {
                    $completionRows = EventCompletion::whereIn('event_id', $eventIds)
                        ->selectRaw('event_id, COUNT(DISTINCT user_id) as completed_count')
                        ->groupBy('event_id')
                        ->pluck('completed_count', 'event_id')
                        ->toArray();
                } else {
                    $completionRows = [];
                }
            } catch (\Exception $e) {
                Log::warning('Failed computing completion aggregates: ' . $e->getMessage());
                $completionRows = [];
            }

        } catch (\Exception $e) {
            Log::warning('Failed computing attendance aggregates: ' . $e->getMessage());
            $attendanceRows = [];
        }

        return view('events.index', compact('events', 'sortOrder', 'sortField', 'eventsForCalendar', 'effectiveDateFilter', 'attendanceRows', 'completionRows'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        // Use users as recipients source
        $pegawaiList = User::orderBy('name')->get();
        $pegawaiCount = $pegawaiList->count();

        // Build bidang options from Option model merged with distinct users.bidang
        $fromUsers = User::whereNotNull('bidang')->distinct()->pluck('bidang')->filter()->values();
        $fromOptions = \App\Models\Option::getOptionsByType('bidang');
        $bidangOptions = $fromUsers->merge($fromOptions)->unique()->sort()->values();

        // Count users per bidang for preview
        $bidangCounts = [];
        foreach ($bidangOptions as $bidang) {
            $bidangCounts[$bidang] = User::where('bidang', $bidang)->count();
        }

        // Get kepala bidang data and count per bidang
        $kepalaBidangList = User::where('jabatan', 'LIKE', 'KEPALA BIDANG%')
                                  ->orWhere('jabatan', '=', 'SEKRETARIS')
                                  ->orderBy('jabatan')
                                  ->orderBy('name')
                                  ->get();
        $kepalaBidangCount = $kepalaBidangList->count();

        // Count kepala bidang per bidang for preview
        $kepalaBidangCounts = [];
        foreach ($bidangOptions as $bidang) {
            $kepalaBidangCounts[$bidang] = User::where('bidang', $bidang)
                                                 ->where(function($query) {
                                                     $query->where('jabatan', 'LIKE', 'KEPALA BIDANG%')
                                                           ->orWhere('jabatan', '=', 'SEKRETARIS');
                                                 })
                                                 ->count();
        }

        return view('events.create', compact('pegawaiList', 'pegawaiCount', 'bidangOptions', 'bidangCounts', 'kepalaBidangList', 'kepalaBidangCount', 'kepalaBidangCounts'));
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'startDate' => 'required|date',
            'startTime' => 'nullable|string',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'endTime' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'asal_surat' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'no_end_date' => 'nullable|boolean',
            'document' => 'nullable|file|mimes:pdf,docx|max:10240', // 10MB max
            'recipient_type' => 'nullable|in:all,bidang,kepala_bidang,individual',
            'selected_bidangs' => 'nullable|array',
            'selected_bidangs.*' => 'string',
            'selected_kepala_bidangs' => 'nullable|array',
            'selected_kepala_bidangs.*' => 'string',
            'selected_individuals' => 'nullable|array',
            'selected_individuals.*' => 'integer|exists:users,id',
        ]);

        // Handle file upload
        $documentPath = null;
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $documentPath = $file->storeAs('documents', $fileName, 'public');
        }

        $event = Event::create(array_merge(
            $request->only([
                'title', 'description', 'startDate', 'startTime', 
                'endDate', 'endTime', 'location', 'asal_surat', 'keterangan', 'no_end_date'
            ]),
            ['document_path' => $documentPath]
        ));
        
        // Handle recipients based on type
        $this->handleRecipients($event, $request);

        // After recipients are set, determine notification status according to requirement:
        // - If there are recipients -> mark 'sent'
        // - If no recipients -> mark 'pending'
        $allEmails = $event->getAllEmails();
        if (empty($allEmails)) {
            $event->update(['notification_status' => 'pending']);
        } else {
            $event->update(['notification_status' => 'sent']);
        }

        // Try to actually send emails when recipients exist; if sending fails, set status 'failed'
        if (!empty($allEmails)) {
            try {
                foreach ($allEmails as $email) {
                    Mail::to($email)->send(new EventCreatedNotification($event));
                }
                // if mailer throws no exception we keep status 'sent'
                return redirect()->route('events.index')
                                ->with('success', 'Event berhasil dibuat dan notifikasi email telah dikirim!');
            } catch (\Exception $e) {
                Log::error('Email sending failed: ' . $e->getMessage(), [
                    'event_id' => $event->id,
                    'error' => $e->getTrace()
                ]);

                // Update notification status to failed
                $event->update(['notification_status' => 'failed']);

                return redirect()->route('events.index')
                                ->with('warning', 'Event berhasil dibuat! Namun email notifikasi gagal dikirim. Error: ' . $e->getMessage());
            }
        }

        // No recipients case
        return redirect()->route('events.index')
                        ->with('success', 'Event berhasil dibuat. Tidak ada penerima sehingga notifikasi tidak dikirim.');
    }

    /**
     * Handle recipients assignment based on recipient type
     */
    private function handleRecipients(Event $event, Request $request)
    {
        $recipientType = $request->input('recipient_type');
        
        if (!$recipientType) {
            // If no recipient type provided, clear any existing recipients for this event.
            // This allows users to leave the recipient section empty to remove recipients.
            try {
                $event->recipients()->detach();
            } catch (\Exception $e) {
                // Log but don't break the flow; detaching may be a no-op if event is new.
                Log::info('No recipients to detach or detach failed: ' . $e->getMessage(), ['event_id' => $event->id ?? null]);
            }

            return;
        }
        
        $recipientIds = [];
        
        switch ($recipientType) {
            case 'all':
                $recipientIds = User::pluck('id')->toArray();
                break;
                
            case 'bidang':
                $selectedBidangs = $request->input('selected_bidangs', []);
                if (!empty($selectedBidangs)) {
                    $recipientIds = User::whereIn('bidang', $selectedBidangs)->pluck('id')->toArray();
                }
                break;
                
            case 'kepala_bidang':
                $selectedBidangs = $request->input('selected_kepala_bidangs', []);
                if (!empty($selectedBidangs)) {
                    $recipientIds = User::whereIn('bidang', $selectedBidangs)
                                          ->where(function($query) {
                                              $query->where('jabatan', 'LIKE', 'KEPALA BIDANG%')
                                                    ->orWhere('jabatan', '=', 'SEKRETARIS');
                                          })
                                          ->pluck('id')->toArray();
                }
                break;
                
            case 'individual':
                $recipientIds = $request->input('selected_individuals', []);
                break;
        }
        
        // Attach recipients to event
        if (!empty($recipientIds)) {
            $event->recipients()->sync($recipientIds);
        }
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        // Provide user list for transfer modal
        $pegawaiList = User::orderBy('name')->get();
        // Get completions for this event (notulen + bukti dukung)
        // Guard against missing table (e.g., migrations not run yet)
        if (Schema::hasTable('event_completions')) {
            $completions = EventCompletion::with('user')
                ->where('event_id', $event->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $completions = collect();
        }

        // Load attendance records for this event and key by user_id for easy lookup in the view
        $attendances = EventAttendance::where('event_id', $event->id)->get()->keyBy('user_id');

        return view('events.show', compact('event', 'pegawaiList', 'completions', 'attendances'));
    }

    /**
     * Show completion form for an event (notulen + bukti dukung)
     */
    public function completeForm(Event $event)
    {
        if (!auth()->check()) {
            return redirect()->route('events.show', $event)->with('warning', 'Anda harus login untuk menyelesaikan agenda.');
        }

        $user = auth()->user();
        // Only recipients can submit completion (defensive)
        if (!$event->recipients->contains('id', $user->id)) {
            return redirect()->route('events.show', $event)->with('warning', 'Anda bukan penerima undangan untuk agenda ini.');
        }

        return view('events.complete', compact('event'));
    }

    /**
     * Handle completion submission: save notulen and supporting files
     */
    public function submitCompletion(Request $request, Event $event)
    {
        if (!auth()->check()) {
            return redirect()->route('events.show', $event)->with('warning', 'Anda harus login untuk menyelesaikan agenda.');
        }

        $user = auth()->user();

        // Validate input
        $request->validate([
            'notulen' => 'required|string',
            'bukti_dukung.*' => 'nullable|file|mimes:pdf,docx,jpeg,jpg|max:10240'
        ]);

        $stored = [];
        if ($request->hasFile('bukti_dukung')) {
            foreach ($request->file('bukti_dukung') as $file) {
                if (!$file->isValid()) continue;
                $dir = 'completions/event_' . $event->id;
                $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-.]/', '_', $file->getClientOriginalName());
                $path = $file->storeAs($dir, $fileName, 'public');
                if ($path) $stored[] = $path;
            }
        }

        // Try to create completion record. If the table doesn't exist (migrations not run),
        // clean up uploaded files and return a friendly message.
        try {
            $completion = EventCompletion::create([
                'event_id' => $event->id,
                'user_id' => $user->id,
                'notulen' => $request->input('notulen'),
                'files' => !empty($stored) ? $stored : null,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // If table missing (MySQL error 1146) or SQLSTATE 42S02, remove uploaded files to avoid orphaned files
            $sqlState = $e->getCode();
            $mysqlErrNo = isset($e->errorInfo[1]) ? $e->errorInfo[1] : null;

            if ($sqlState === '42S02' || $mysqlErrNo === 1146) {
                try {
                    foreach ($stored as $p) {
                        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($p)) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($p);
                        }
                    }
                } catch (\Exception $ex) {
                    // Log but continue
                    Log::warning('Failed cleaning up uploaded completion files after missing table: ' . $ex->getMessage(), ['files' => $stored]);
                }

                Log::error('EventCompletion table missing when submitting completion: ' . $e->getMessage(), ['event_id' => $event->id, 'user_id' => $user->id]);

                return redirect()->route('events.show', $event)
                                 ->with('warning', 'Tabel `event_completions` belum tersedia di database. Silakan jalankan migrasi proyek: `php artisan migrate`. Jika butuh, minta admin untuk menjalankan migrasi.');
            }

            // Unknown DB error - rethrow after logging
            Log::error('Database error creating EventCompletion: ' . $e->getMessage(), ['event_id' => $event->id, 'user_id' => $user->id]);
            throw $e;
        }

        // Optionally log
        Log::info('Event completed', ['event_id' => $event->id, 'completion_id' => $completion->id, 'user_id' => $user->id]);

        // Mark attendance as completed for this user (so status becomes 'selesai')
        try {
            EventAttendance::updateOrCreate(
                ['event_id' => $event->id, 'user_id' => $user->id],
                ['status' => 'completed', 'transferred_to_user_id' => null, 'transferred_at' => null]
            );
        } catch (\Exception $e) {
            Log::warning('Failed to update attendance status after completion: ' . $e->getMessage(), ['event_id' => $event->id, 'user_id' => $user->id]);
        }

        return redirect()->route('events.show', $event)->with('success', 'Terima kasih — notulen dan bukti dukung telah disimpan.');
    }

    /**
     * Show edit form for a specific completion (notulen + files).
     */
    public function editCompletion(Event $event, EventCompletion $completion)
    {
        if (!auth()->check()) {
            return redirect()->route('events.show', $event)->with('warning', 'Anda harus login untuk mengubah notulen.');
        }

        // Ensure completion belongs to event
        if ($completion->event_id != $event->id) {
            return redirect()->route('events.show', $event)->with('warning', 'Notulen tidak ditemukan untuk agenda ini.');
        }

        $user = auth()->user();

        // Only the author of the completion or admins can edit
        if ($completion->user_id !== $user->id && !in_array($user->role ?? '', ['admin', 'super_admin'])) {
            return redirect()->route('events.show', $event)->with('warning', 'Anda tidak memiliki akses untuk mengedit notulen ini.');
        }

        // Make sure files are an array for the view
        $files = is_array($completion->files) ? $completion->files : ( $completion->files ? (array) $completion->files : [] );

        return view('events.complete_edit', compact('event', 'completion', 'files'));
    }

    /**
     * Update an existing completion: allow editing notulen and adding/removing files.
     */
    public function updateCompletion(Request $request, Event $event, EventCompletion $completion)
    {
        if (!auth()->check()) {
            return redirect()->route('events.show', $event)->with('warning', 'Anda harus login untuk mengubah notulen.');
        }

        // Ensure completion belongs to event
        if ($completion->event_id != $event->id) {
            return redirect()->route('events.show', $event)->with('warning', 'Notulen tidak ditemukan untuk agenda ini.');
        }

        $user = auth()->user();

        // Authorization: only author or admin
        if ($completion->user_id !== $user->id && !in_array($user->role ?? '', ['admin', 'super_admin'])) {
            return redirect()->route('events.show', $event)->with('warning', 'Anda tidak memiliki akses untuk mengedit notulen ini.');
        }

        $request->validate([
            'notulen' => 'required|string',
            'bukti_dukung.*' => 'nullable|file|mimes:pdf,docx,jpeg,jpg|max:10240',
            'remove_files' => 'nullable|array',
            'remove_files.*' => 'string'
        ]);

        // Remove selected files if requested
        $existingFiles = is_array($completion->files) ? $completion->files : ( $completion->files ? (array) $completion->files : [] );
        $remove = $request->input('remove_files', []);

        if (!empty($remove)) {
            foreach ($remove as $rpath) {
                // remove from storage and from array
                if (Storage::disk('public')->exists($rpath)) {
                    Storage::disk('public')->delete($rpath);
                }
                $existingFiles = array_values(array_filter($existingFiles, function($v) use ($rpath) {
                    return $v !== $rpath;
                }));
            }
        }

        // Handle newly uploaded files (append)
        $stored = [];
        if ($request->hasFile('bukti_dukung')) {
            foreach ($request->file('bukti_dukung') as $file) {
                if (!$file->isValid()) continue;
                $dir = 'completions/event_' . $event->id;
                $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-.]/', '_', $file->getClientOriginalName());
                $path = $file->storeAs($dir, $fileName, 'public');
                if ($path) $stored[] = $path;
            }
        }

        $finalFiles = array_values(array_filter(array_merge($existingFiles, $stored)));

        $completion->notulen = $request->input('notulen');
        $completion->files = !empty($finalFiles) ? $finalFiles : null;
        $completion->save();

        return redirect()->route('events.show', $event)->with('success', 'Notulen berhasil diperbarui.');
    }

    /**
     * Delete a completion and its files.
     */
    public function destroyCompletion(Event $event, EventCompletion $completion)
    {
        if (!auth()->check()) {
            return redirect()->route('events.show', $event)->with('warning', 'Anda harus login untuk melakukan aksi ini.');
        }

        // Ensure completion belongs to event
        if ($completion->event_id != $event->id) {
            return redirect()->route('events.show', $event)->with('warning', 'Notulen tidak ditemukan untuk agenda ini.');
        }

        $user = auth()->user();

        // Authorization: only author or admin
        if ($completion->user_id !== $user->id && !in_array($user->role ?? '', ['admin', 'super_admin'])) {
            return redirect()->route('events.show', $event)->with('warning', 'Anda tidak memiliki akses untuk menghapus notulen ini.');
        }

        // Remove attached files
        $existingFiles = is_array($completion->files) ? $completion->files : ( $completion->files ? (array) $completion->files : [] );
        foreach ($existingFiles as $f) {
            if (Storage::disk('public')->exists($f)) {
                Storage::disk('public')->delete($f);
            }
        }

        $completion->delete();

        return redirect()->route('events.show', $event)->with('success', 'Notulen berhasil dihapus.');
    }

    /**
     * Delete a single attached file from a completion (AJAX)
     */
    public function deleteCompletionFile(Request $request, Event $event, EventCompletion $completion)
    {
        $request->validate([
            'path' => 'required|string'
        ]);

        if ($completion->event_id != $event->id) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Only author or admin can delete a file
        if ($completion->user_id !== $user->id && !in_array($user->role ?? '', ['admin', 'super_admin'])) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $path = $request->input('path');
        $files = is_array($completion->files) ? $completion->files : ($completion->files ? (array)$completion->files : []);

        // Only allow deletion of files actually attached
        if (!in_array($path, $files)) {
            return response()->json(['error' => 'File not attached'], 400);
        }

        // Delete from storage if exists
        try {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        } catch (\Exception $e) {
            // Log and continue—return error
            Log::warning('Failed deleting completion file: ' . $e->getMessage(), ['path' => $path, 'completion_id' => $completion->id]);
            return response()->json(['error' => 'Failed to delete file'], 500);
        }

        // Remove from model
        $remaining = array_values(array_filter($files, function ($v) use ($path) { return $v !== $path; }));
        $completion->files = !empty($remaining) ? $remaining : null;
        $completion->save();

        return response()->json(['success' => true]);
    }

    /**
     * Preview a single attached file for a completion.
     * Returns the file inline (images, pdf) if allowed.
     */
    public function previewCompletionFile(Request $request, Event $event, EventCompletion $completion)
    {
        $path = $request->query('path');
        if (empty($path)) {
            abort(400, 'Missing path');
        }

        // Ensure completion belongs to event
        if ($completion->event_id != $event->id) {
            abort(404);
        }

        $files = is_array($completion->files) ? $completion->files : ($completion->files ? (array)$completion->files : []);
        if (!in_array($path, $files)) {
            abort(404);
        }

        // Normalize and ensure no directory traversal
        if (strpos($path, '..') !== false) {
            abort(400, 'Invalid path');
        }

        $full = storage_path('app/public/' . ltrim($path, '/'));
        if (!file_exists($full)) {
            abort(404);
        }

        // Let PHP/Laravel return the file with appropriate headers.
        return response()->file($full);
    }

    /**
     * Download a single attached file for a completion.
     */
    public function downloadCompletionFile(Request $request, Event $event, EventCompletion $completion)
    {
        $path = $request->query('path');
        if (empty($path)) {
            abort(400, 'Missing path');
        }

        if ($completion->event_id != $event->id) {
            abort(404);
        }

        $files = is_array($completion->files) ? $completion->files : ($completion->files ? (array)$completion->files : []);
        if (!in_array($path, $files)) {
            abort(404);
        }

        if (strpos($path, '..') !== false) {
            abort(400, 'Invalid path');
        }

        $disk = Storage::disk('public');
        if (!$disk->exists($path)) {
            abort(404);
        }

        return $disk->download($path);
    }

    /**
     * Mark current user as attended for an event (assignment completed)
     */
    public function attend(Request $request, Event $event)
    {
        if (!auth()->check()) {
            return redirect()->route('events.show', $event)->with('warning', 'Anda harus login untuk menandai kehadiran.');
        }

        $user = auth()->user();

        // Ensure the user is a recipient of this event before marking attended
        $isRecipient = $event->recipients->contains('id', $user->id);

        if (!$isRecipient) {
            return redirect()->route('events.show', $event)->with('warning', 'Anda bukan penerima undangan untuk agenda ini.');
        }

        $attendance = EventAttendance::updateOrCreate(
            ['event_id' => $event->id, 'user_id' => $user->id],
            ['status' => 'attended', 'transferred_to_user_id' => null, 'transferred_at' => null]
        );

        // Attempt to append attendance record to monthly CSV spreadsheet
        $message = 'Terima kasih — kehadiran Anda telah dicatat.';
        $severity = 'success';
        try {
            $dir = storage_path('app/public/attendance_spreadsheets');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $filename = $dir . DIRECTORY_SEPARATOR . 'attendance-' . now()->format('Y-m') . '.csv';
            $isNew = !file_exists($filename);

            $columns = ['event_id', 'event_title', 'user_id', 'user_name', 'user_email', 'attended_at'];
            $line = [
                $event->id,
                $event->title,
                $user->id,
                $user->name,
                $user->email ?? '',
                now()->toDateTimeString()
            ];

            if ($isNew) {
                file_put_contents($filename, implode(',', $columns) . PHP_EOL, FILE_APPEND | LOCK_EX);
            }

            // escape double quotes in fields
            $escaped = array_map(function ($v) {
                return '"' . str_replace('"', '""', (string)$v) . '"';
            }, $line);

            file_put_contents($filename, implode(',', $escaped) . PHP_EOL, FILE_APPEND | LOCK_EX);

            $message .= ' dan ditambahkan ke spreadsheet (' . basename($filename) . ').';
        } catch (\Exception $e) {
            // Attendance recorded in DB, but spreadsheet append failed
            \Log::warning('Failed to append attendance to spreadsheet: ' . $e->getMessage(), ['event_id' => $event->id, 'user_id' => $user->id]);
            $message = 'Kehadiran dicatat, tetapi gagal menulis spreadsheet: ' . $e->getMessage();
            $severity = 'warning';
        }

        // Return JSON for AJAX or normal redirect for standard requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'status' => 'attended'
            ]);
        }

        if ($severity === 'success') {
            return redirect()->route('events.show', $event)->with('success', $message);
        }

        return redirect()->route('events.show', $event)->with('warning', $message);
    }

    /**
     * Transfer document to another user when the recipient cannot attend.
     */
    public function transferDocument(Request $request, Event $event)
    {
        $request->validate([
            'to_user_id' => 'required|integer|exists:users,id'
        ]);

        if (!auth()->check()) {
            return redirect()->route('events.show', $event)->with('warning', 'Anda harus login untuk melakukan aksi ini.');
        }

        $user = auth()->user();
        $toUser = User::find($request->input('to_user_id'));

        // Ensure the requester is a recipient
        if (!$event->recipients->contains('id', $user->id)) {
            return redirect()->route('events.show', $event)->with('warning', 'Anda bukan penerima undangan untuk agenda ini.');
        }

        // Record transfer in attendances
        $attendance = EventAttendance::updateOrCreate(
            ['event_id' => $event->id, 'user_id' => $user->id],
            ['status' => 'transferred', 'transferred_to_user_id' => $toUser->id, 'transferred_at' => now()]
        );
        // Add the target user as a recipient for this event so they appear in the recipient list
        try {
            $event->recipients()->syncWithoutDetaching([$toUser->id]);
        } catch (\Exception $e) {
            Log::warning('Failed to add transferred recipient to event recipients: ' . $e->getMessage(), ['event_id' => $event->id, 'to_user_id' => $toUser->id]);
        }
        // Attempt to notify the target user by sending the standard event notification
        // (do not attach the document; simply send the same template as the original notification)
        $mailSent = false;
        $mailAttempted = false;

        if (filter_var($toUser->email, FILTER_VALIDATE_EMAIL)) {
            try {
                $mailAttempted = true;
                Mail::to($toUser->email)->send(new EventCreatedNotification($event));
                $mailSent = true;
            } catch (\Exception $e) {
                \Log::warning('Failed to notify transfer recipient: ' . $e->getMessage(), ['event_id' => $event->id, 'to_user_id' => $toUser->id]);
                $mailSent = false;
            }
        }

        if ($mailAttempted) {
            if ($mailSent) {
                return redirect()->route('events.show', $event)->with('success', 'Notifikasi agenda berhasil dialihkan ke ' . $toUser->name . ' dan email notifikasi telah dikirim.');
            }
            return redirect()->route('events.show', $event)->with('warning', 'Notifikasi agenda berhasil dialihkan ke ' . $toUser->name . ', tetapi pengiriman email gagal.');
        }

        // No valid email for target user — still treat as success for transfer record
        return redirect()->route('events.show', $event)->with('success', 'Notifikasi agenda berhasil dialihkan ke ' . $toUser->name . '.');
    }

    /**
     * Download the document attached to the event.
     */
    public function downloadDocument(Event $event)
    {
        if (!$event->document_path) {
            abort(404, 'Dokumen tidak ditemukan.');
        }
        $path = $event->document_path; // relative to storage/app/public

        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            abort(404, 'File dokumen tidak ditemukan.');
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download($path);
    }

    /**
     * Stream/preview the document inline (useful for PDFs)
     */
    public function previewDocument(Event $event)
    {
        if (!$event->document_path) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        $path = $event->document_path;

        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            abort(404, 'File dokumen tidak ditemukan.');
        }

        $fullPath = storage_path('app/public/' . $path);
        $mimeType = mime_content_type($fullPath) ?: 'application/octet-stream';

        // For PDFs we can try to display inline, otherwise force download
        $disposition = strpos($mimeType, 'pdf') !== false ? 'inline' : 'attachment';

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => $disposition . '; filename="' . basename($path) . '"'
        ]);
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        // Get the same data as create method for recipients (use users)
        $pegawaiList = User::orderBy('name')->get();
        $pegawaiCount = $pegawaiList->count();
        $fromUsers = User::whereNotNull('bidang')->distinct()->pluck('bidang')->filter()->values();
        $fromOptions = \App\Models\Option::getOptionsByType('bidang');
        $bidangOptions = $fromUsers->merge($fromOptions)->unique()->sort()->values();
        $bidangCounts = [];

        foreach ($bidangOptions as $bidang) {
            $bidangCounts[$bidang] = User::where('bidang', $bidang)->count();
        }

        // Get kepala bidang data
        $kepalaBidangList = User::where('jabatan', 'LIKE', 'KEPALA BIDANG%')
                                  ->orWhere('jabatan', '=', 'SEKRETARIS')
                                  ->orderBy('jabatan')
                                  ->orderBy('name')
                                  ->get();
        $kepalaBidangCount = $kepalaBidangList->count();

        // Count kepala bidang per bidang for preview
        $kepalaBidangCounts = [];
        foreach ($bidangOptions as $bidang) {
            $kepalaBidangCounts[$bidang] = User::where('bidang', $bidang)
                                                 ->where(function($query) {
                                                     $query->where('jabatan', 'LIKE', 'KEPALA BIDANG%')
                                                           ->orWhere('jabatan', '=', 'SEKRETARIS');
                                                 })
                                                 ->count();
        }
        
        // Get current recipients for pre-filling the form
        $currentRecipients = $event->recipients->pluck('id')->toArray();
        $currentBidangs = $event->recipients->pluck('bidang')->unique()->toArray();
        
        return view('events.edit', compact('event', 'pegawaiList', 'pegawaiCount', 'bidangOptions', 'bidangCounts', 'kepalaBidangList', 'kepalaBidangCount', 'kepalaBidangCounts', 'currentRecipients', 'currentBidangs'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'startDate' => 'required|date',
            'startTime' => 'nullable|string',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'endTime' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'asal_surat' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'no_end_date' => 'nullable|boolean',
            'document' => 'nullable|file|mimes:pdf,docx|max:10240', // 10MB max
            // Allow recipient_type to be nullable on update so users can clear recipients
            'recipient_type' => 'nullable|in:all,bidang,kepala_bidang,individual',
            'selected_bidangs' => 'nullable|array',
            'selected_bidangs.*' => 'string',
            'selected_kepala_bidangs' => 'nullable|array',
            'selected_kepala_bidangs.*' => 'string',
            'selected_individuals' => 'nullable|array',
                'selected_individuals.*' => 'integer|exists:users,id',
        ]);

        // Track changes for email notification
        $changes = [];
        $originalData = $event->getOriginal();
        
        // Fields to track for changes (removed email field)
        $fieldsToTrack = ['title', 'description', 'startDate', 'startTime', 'endDate', 'endTime', 'location', 'asal_surat', 'keterangan'];
        
        foreach ($fieldsToTrack as $field) {
            $oldValue = $originalData[$field] ?? '';
            $newValue = $request->input($field) ?? '';
            
            if ($oldValue != $newValue) {
                $changes[$field] = [
                    'from' => $oldValue,
                    'to' => $newValue
                ];
            }
        }

        // Handle file upload
        $updateData = $request->only([
            'title', 'description', 'startDate', 'startTime', 
            'endDate', 'endTime', 'location', 'asal_surat', 'keterangan', 'no_end_date'
        ]);
        
        if ($request->hasFile('document')) {
            // Delete old file if exists
            if ($event->document_path && Storage::disk('public')->exists($event->document_path)) {
                Storage::disk('public')->delete($event->document_path);
            }
            
            // Store new file
            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $updateData['document_path'] = $file->storeAs('documents', $fileName, 'public');
        }

        // Update the event
        $event->update($updateData);
        
        // Handle recipients
        $this->handleRecipients($event, $request);

        // After recipients are set, update notification status according to requirement:
        // - If there are recipients -> 'sent'
        // - If none -> 'pending'
        $allEmails = $event->getAllEmails();
        if (empty($allEmails)) {
            $event->update(['notification_status' => 'pending']);
        } else {
            $event->update(['notification_status' => 'sent']);
        }

        // Send email notification if there are tracked changes and recipients exist
        if (!empty($changes)) {
            // If there are no recipients, skip sending and inform user
            if (empty($allEmails)) {
                return redirect()->route('events.index')
                                ->with('success', 'Event berhasil diupdate. Tidak ada penerima sehingga notifikasi tidak dikirim.');
            }

            try {
                $emailSent = false;
                foreach ($allEmails as $email) {
                    Mail::to($email)->send(new EventUpdatedNotification($event, $changes));
                    $emailSent = true;
                }

                if ($emailSent) {
                    // ensure status remains 'sent' after successful sending
                    $event->update(['notification_status' => 'sent']);
                }

                return redirect()->route('events.index')
                                ->with('success', 'Event berhasil diupdate dan notifikasi email telah dikirim!');
            } catch (\Exception $e) {
                $event->update(['notification_status' => 'failed']);

                return redirect()->route('events.index')
                                ->with('success', 'Event berhasil diupdate! (Catatan: Email notifikasi tidak dapat dikirim)');
            }
        }

        return redirect()->route('events.index')
                        ->with('success', 'Event berhasil diupdate!');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        // Delete associated document file if exists
        if ($event->document_path && Storage::disk('public')->exists($event->document_path)) {
            Storage::disk('public')->delete($event->document_path);
        }

        $event->delete();

        return redirect()->route('events.index')
                        ->with('success', 'Event berhasil dihapus!');
    }

    public function exportDailyEventsToWord($date)
    {
        // Validate date format
        try {
            $parsedDate = \Carbon\Carbon::parse($date);
        } catch (\Exception $e) {
            abort(404, 'Invalid date format');
        }

        // Get events for the specified date
        $events = Event::with('recipients')
            ->whereDate('startDate', $parsedDate)
            ->orderBy('startTime')
            ->get();

        // Create new PhpWord object
        $phpWord = new PhpWord();

        // Set document properties
        $properties = $phpWord->getDocInfo();
        $properties->setCreator('SIAKRA - Dinas Kominfo');
        $properties->setCompany('Dinas Komunikasi dan Informatika');
        $properties->setTitle('Agenda Harian Events - ' . $parsedDate->format('d F Y'));
        $properties->setDescription('Daftar agenda kegiatan untuk tanggal ' . $parsedDate->format('d F Y'));

        // Add section with Folio (F4) paper size in landscape orientation
        $section = $phpWord->addSection([
            'marginTop' => 1440,    // 1 inch
            'marginBottom' => 1440,
            'marginLeft' => 720,
            'marginRight' => 720,
            'pageSizeW' => 18720,   // 13 inch (Folio height becomes width in landscape)
            'pageSizeH' => 12240,   // 8.5 inch (Folio width becomes height in landscape)
            'orientation' => 'landscape',
        ]);
        
        // Add main title
        $section->addText('AGENDA KEGIATAN', [
            'name' => 'Times New Roman',
            'size' => 14,
            'bold' => true,
            'color' => '000000'
        ], [
            'alignment' => 'center',
            'spaceAfter' => 120
        ]);

        $section->addText('DINAS KOMUNIKASI DAN INFORMATIKA', [
            'name' => 'Times New Roman',
            'size' => 14,
            'bold' => true,
            'color' => '000000'
        ], [
            'alignment' => 'center',
            'spaceAfter' => 60
        ]);

        $section->addText('KABUPATEN TULUNGAGUNG', [
            'name' => 'Times New Roman',
            'size' => 14,
            'bold' => true,
            'color' => '000000'
        ], [
            'alignment' => 'center',
            'spaceAfter' => 480
        ]);

        if ($events->count() > 0) {
            // Create main agenda table
            $table = $section->addTable([
                'borderSize' => 6,
                'borderColor' => '000000',
                'cellMargin' => 80,
                'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
            ]);

            // Add table header
            $table->addRow(null, ['tblHeader' => true]);
            $table->addCell(600, ['bgColor' => 'FFFFFF'])->addText('No', [
                'name' => 'Times New Roman', 'size' => 12, 'bold' => true
            ], ['alignment' => 'center']);
            
            $table->addCell(2500, ['bgColor' => 'FFFFFF'])->addText('Asal Surat', [
                'name' => 'Times New Roman', 'size' => 12, 'bold' => true
            ], ['alignment' => 'center']);

            $table->addCell(2200, ['bgColor' => 'FFFFFF'])->addText('Hari/Tanggal', [
                'name' => 'Times New Roman', 'size' => 12, 'bold' => true
            ], ['alignment' => 'center']);
            
            $table->addCell(2200, ['bgColor' => 'FFFFFF'])->addText('Waktu', [
                'name' => 'Times New Roman', 'size' => 12, 'bold' => true
            ], ['alignment' => 'center']);
            
            $table->addCell(2500, ['bgColor' => 'FFFFFF'])->addText('Tempat', [
                'name' => 'Times New Roman', 'size' => 12, 'bold' => true
            ], ['alignment' => 'center']);
            
            $table->addCell(3000, ['bgColor' => 'FFFFFF'])->addText('Acara', [
                'name' => 'Times New Roman', 'size' => 12, 'bold' => true
            ], ['alignment' => 'center']);
            
            $table->addCell(2500, ['bgColor' => 'FFFFFF'])->addText('Disposisi Dihadiri', [
                'name' => 'Times New Roman', 'size' => 12, 'bold' => true
            ], ['alignment' => 'center']);
            
            $table->addCell(3000, ['bgColor' => 'FFFFFF'])->addText('Ket.', [
                'name' => 'Times New Roman', 'size' => 12, 'bold' => true
            ], ['alignment' => 'center']);

            // Add events data
            foreach ($events as $index => $event) {
                $table->addRow();
                
                // No
                $table->addCell(800)->addText(($index + 1) . '.', [
                    'name' => 'Times New Roman', 'size' => 12
                ], ['alignment' => 'center']);
                
                // Asal Surat
                $asalSurat = $event->asal_surat ?: '-';
                $table->addCell(1500)->addText($asalSurat, [
                    'name' => 'Times New Roman', 'size' => 12
                ]);
                
                // Hari/Tanggal
                $months = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                           '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                           '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];

                $startDate = \Carbon\Carbon::parse($event->startDate)->startOfDay();
                $dayNameStart = [
                    'Sunday' => 'Minggu',
                    'Monday' => 'Senin',
                    'Tuesday' => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis',
                    'Friday' => 'Jumat',
                    'Saturday' => 'Sabtu'
                ][$startDate->format('l')] ?? $startDate->format('l');

                // If an end date exists and is different from start date, show range: "Hari, d Month Y - Hari, d Month Y"
                $hariTanggal = '';
                if (!empty($event->endDate)) {
                    $endDate = \Carbon\Carbon::parse($event->endDate)->startOfDay();
                    if ($endDate->equalTo($startDate)) {
                        // Same date
                        $hariTanggal = $dayNameStart . ', ' . $startDate->format('d') . ' ' . $months[$startDate->format('m')] . ' ' . $startDate->format('Y');
                    } else {
                        $dayNameEnd = [
                            'Sunday' => 'Minggu',
                            'Monday' => 'Senin',
                            'Tuesday' => 'Selasa',
                            'Wednesday' => 'Rabu',
                            'Thursday' => 'Kamis',
                            'Friday' => 'Jumat',
                            'Saturday' => 'Sabtu'
                        ][$endDate->format('l')] ?? $endDate->format('l');

                        $hariTanggal = $dayNameStart . ', ' . $startDate->format('d') . ' ' . $months[$startDate->format('m')] . ' ' . $startDate->format('Y')
                                     . ' - ' . $dayNameEnd . ', ' . $endDate->format('d') . ' ' . $months[$endDate->format('m')] . ' ' . $endDate->format('Y');
                    }
                } else {
                    // No end date provided
                    $hariTanggal = $dayNameStart . ', ' . $startDate->format('d') . ' ' . $months[$startDate->format('m')] . ' ' . $startDate->format('Y');
                }

                $table->addCell(1200)->addText($hariTanggal, [
                    'name' => 'Times New Roman', 'size' => 12
                ]);
                
                // Waktu
                $waktu = '';
                if ($event->startTime) {
                    // Use colon-separated time to match UI (HH:MM)
                    $startTime = \Carbon\Carbon::parse($event->startTime)->format('H:i');
                    if ($event->endTime) {
                        // Normal case: "HH:MM WIB - HH:MM WIB"
                        $endTime = \Carbon\Carbon::parse($event->endTime)->format('H:i');
                        $waktu = $startTime . ' - ' . $endTime . ' WIB';
                    } elseif (!empty($event->no_end_date)) {
                        // S/D Selesai case: "HH:MM WIB - Selesai"
                        $waktu = $startTime . ' WIB - Selesai';
                    } else {
                        // No end time and not marked as S/D Selesai
                        $waktu = $startTime . ' WIB';
                    }
                } else {
                    $waktu = '- WIB';
                }
                $table->addCell(1000)->addText($waktu, [
                    'name' => 'Times New Roman', 'size' => 12
                ], ['alignment' => 'left']);
                
                // Tempat
                $table->addCell(1200)->addText($event->location ?: '-', [
                    'name' => 'Times New Roman', 'size' => 12
                ]);
                
                // Acara
                $table->addCell(2000)->addText($event->title, [
                    'name' => 'Times New Roman', 'size' => 12
                ]);
                
                // Disposisi Dihadiri - show recipients appropriately
                $disposisiText = '';
                if ($event->recipients->count() > 0) {
                    // Check if all recipients are kepala bidang/sekretaris
                    $allKepalaBidang = $event->recipients->every(function($recipient) {
                        return stripos($recipient->jabatan, 'KEPALA BIDANG') !== false || 
                               $recipient->jabatan === 'SEKRETARIS';
                    });
                    
                    if ($allKepalaBidang) {
                        // All recipients are kepala bidang/sekretaris - show jabatan
                        $jabatanList = $event->recipients->pluck('jabatan')->unique()->sort()->values();
                        $disposisiText = $jabatanList->implode(', ');
                    } else {
                        // Mixed recipients or regular staff - use existing logic
                        $allBidang = $event->recipients->pluck('bidang')->filter()->unique();
                        $recipientsWithoutBidang = $event->recipients->where('bidang', null)->count();
                        $totalRecipients = $event->recipients->count();
                        
                        if ($recipientsWithoutBidang > 0) {
                            // Some recipients have no bidang - this is individual selection
                            // Show individual names
                            $disposisiText = $event->recipients->pluck('nama')->implode(', ');
                        } else {
                            // All recipients have bidang - check if it's bidang selection or individual selection
                            $displayBidang = [];
                            
                            foreach ($allBidang as $bidang) {
                                $recipientsInThisBidang = $event->recipients->where('bidang', $bidang);
                                $totalPegawaiInBidang = \App\Models\User::where('bidang', $bidang)->count();
                                
                                if ($recipientsInThisBidang->count() == $totalPegawaiInBidang) {
                                    // All people from this bidang are selected = bidang selection
                                    $displayBidang[] = $bidang;
                                } else {
                                    // Only some people from this bidang = individual selection
                                    // Show individual names instead of bidang
                                            foreach ($recipientsInThisBidang as $recipient) {
                                                $displayBidang[] = $recipient->name;
                                            }
                                }
                            }
                            
                            $disposisiText = implode(', ', array_unique($displayBidang));
                        }
                        
                        // If still empty, fallback
                        if (empty($disposisiText)) {
                            $disposisiText = $event->recipients->pluck('name')->implode(', ');
                        }
                    }
                } else {
                    $disposisiText = '';
                }
                
                $table->addCell(1500)->addText($disposisiText, [
                    'name' => 'Times New Roman', 'size' => 12
                ]);
                
                // Ket
                $table->addCell(800)->addText($event->keterangan, [
                    'name' => 'Times New Roman', 'size' => 12     
                ]);
            }
        } else {
            $section->addText('Tidak ada kegiatan pada tanggal ini.', [
                'name' => 'Times New Roman',
                'size' => 12,
                'color' => '6b7280'
            ], [
                'alignment' => 'center'
            ]);
        }

        // Add footer
        $footer = $section->addFooter();
        $footer->addText('', [
            'name' => 'Times New Roman',
            'size' => 8
        ]);

        // Generate filename with formatted date
        $formattedDate = $parsedDate->format('d') . ' ' . 
            ['01' => 'JANUARI', '02' => 'FEBRUARI', '03' => 'MARET', '04' => 'APRIL',
             '05' => 'MEI', '06' => 'JUNI', '07' => 'JULI', '08' => 'AGUSTUS', 
             '09' => 'SEPTEMBER', '10' => 'OKTOBER', '11' => 'NOVEMBER', '12' => 'DESEMBER'][$parsedDate->format('m')] . 
            ' ' . $parsedDate->format('Y');
        $filename = 'AGENDA KEGIATAN ' . $formattedDate . '.docx';

        // Create temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'phpword');
        
        // Save document
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        // Return Word document as download
        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Get events data for calendar widget
     */
    public function getEventsData()
    {
        try {
            $events = Event::select('id', 'title', 'startDate', 'endDate', 'startTime', 'endTime', 'location', 'no_end_date')
                ->orderBy('startDate', 'asc')
                ->get()
                ->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'startDate' => $event->startDate ? $event->startDate->format('Y-m-d H:i:s') : null,
                        'endDate' => $event->endDate ? $event->endDate->format('Y-m-d H:i:s') : null,
                        'startTime' => $event->startTime,
                        'endTime' => $event->endTime,
                        'no_end_date' => (bool) $event->no_end_date,
                        'location' => $event->location,
                    ];
                });

            Log::info('Events data requested', [
                'count' => $events->count(),
                'user_id' => Auth::id(),
                'sample_event' => $events->first()
            ]);

            return response()->json($events, 200, [
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getEventsData', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'Failed to fetch events data'], 500);
        }
    }
}