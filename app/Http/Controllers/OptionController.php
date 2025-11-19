<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;

class OptionController extends Controller
{
    public function store(Request $request)
    {
        // only admin or super_admin
        if (!(Auth::check() && in_array(Auth::user()->role, ['admin','super_admin']))) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'type' => 'required|in:bidang,jabatan',
            'value' => 'required|string|max:255',
        ]);

        $opt = Option::firstOrCreate([
            'type' => $data['type'],
            'value' => $data['value'],
        ]);

        return response()->json(['success' => true, 'option' => $opt]);
    }

    // Helper endpoint used by the frontend to fetch options list as JSON
    public function list(Request $request)
    {
        $type = $request->query('type');
        if (!in_array($type, ['bidang','jabatan'])) {
            return response()->json(['options' => []]);
        }
        $opts = Option::where('type', $type)->orderBy('value')->get(['id','value']);
        return response()->json(['options' => $opts]);
    }

    public function destroy(Option $option)
    {
        if (!(Auth::check() && in_array(Auth::user()->role, ['admin','super_admin']))) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $option->delete();
        return response()->json(['success' => true]);
    }
}
