<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

$sourceId = 33; // will be deleted
$targetId = 69; // will be kept

/**
 * Merge source user into target user.
 * - copy non-empty fields from source to target when target field empty
 * - reassign sessions.user_id and any other known user_id references
 * - delete source user
 */

DB::beginTransaction();
try {
    $source = User::find($sourceId);
    $target = User::find($targetId);

    if (!$source) {
        throw new \Exception("Source user id={$sourceId} not found");
    }
    if (!$target) {
        throw new \Exception("Target user id={$targetId} not found");
    }

    echo "Merging user {$sourceId} ({$source->email}) -> {$targetId} ({$target->email})\n";

    $fields = ['name','nip','bidang','jabatan','role'];
    foreach ($fields as $f) {
        $sVal = trim((string)($source->{$f} ?? ''));
        $tVal = trim((string)($target->{$f} ?? ''));
        if ($tVal === '' && $sVal !== '') {
            $target->{$f} = $sVal;
            echo "  - copied {$f}: '{$sVal}'\n";
        }
    }

    // do not overwrite target email
    if (trim((string)$target->email) === '') {
        // unlikely, but in case
        $target->email = $source->email;
        echo "  - target email was empty, copied email\n";
    }

    $target->save();

    // Reassign sessions.user_id from source to target
    $updated = DB::table('sessions')->where('user_id', $sourceId)->update(['user_id' => $targetId]);
    echo "  - reassigned sessions: {$updated} rows updated\n";

    // Add other reassignments here if needed (search for other tables with user_id)
    // Example placeholder:
    // $updated2 = DB::table('some_table')->where('user_id', $sourceId)->update(['user_id' => $targetId]);

    // Finally delete source
    $source->delete();
    echo "  - deleted source user id={$sourceId}\n";

    DB::commit();
    echo "Merge completed successfully.\n";
} catch (\Exception $e) {
    DB::rollBack();
    echo "Error during merge: " . $e->getMessage() . "\n";
    exit(1);
}
