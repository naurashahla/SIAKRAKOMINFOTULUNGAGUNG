<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "Scanning users table for duplicates...\n\n";

// 1) Duplicates by email
$dupByEmail = User::select('email')
    ->groupBy('email')
    ->havingRaw('COUNT(*) > 1')
    ->pluck('email');

if ($dupByEmail->isEmpty()) {
    echo "No duplicate emails found.\n\n";
} else {
    echo "Duplicate emails:\n";
    foreach ($dupByEmail as $email) {
        $rows = User::where('email', $email)->get();
        echo "- $email :\n";
        foreach ($rows as $r) {
            echo "    id={$r->id} | name={$r->name} | nip={$r->nip} | bidang={$r->bidang} | jabatan={$r->jabatan}\n";
        }
    }
    echo "\n";
}

// 2) Duplicates by nip (non-empty)
$dupByNip = User::whereNotNull('nip')->where('nip', '!=', '')->select('nip')
    ->groupBy('nip')
    ->havingRaw('COUNT(*) > 1')
    ->pluck('nip');

if ($dupByNip->isEmpty()) {
    echo "No duplicate NIP found.\n\n";
} else {
    echo "Duplicate NIP:\n";
    foreach ($dupByNip as $nip) {
        $rows = User::where('nip', $nip)->get();
        echo "- $nip :\n";
        foreach ($rows as $r) {
            echo "    id={$r->id} | email={$r->email} | name={$r->name} | bidang={$r->bidang} | jabatan={$r->jabatan}\n";
        }
    }
    echo "\n";
}

// 3) Duplicates by name+bidang+jabatan
$all = User::select('id','name','bidang','jabatan','email')->get();
$groups = [];
foreach ($all as $u) {
    $key = trim(strtolower($u->name)) . '||' . trim(strtolower($u->bidang ?? '')) . '||' . trim(strtolower($u->jabatan ?? ''));
    $groups[$key][] = $u;
}
$dups = array_filter($groups, function($g){ return count($g) > 1; });
if (empty($dups)) {
    echo "No duplicates by name+bidang+jabatan found.\n\n";
} else {
    echo "Duplicates by name+bidang+jabatan:\n";
    foreach ($dups as $key => $rows) {
        echo "- group: $key\n";
        foreach ($rows as $r) {
            echo "    id={$r->id} | email={$r->email} | name={$r->name} | bidang={$r->bidang} | jabatan={$r->jabatan}\n";
        }
    }
    echo "\n";
}

echo "Scan complete.\n";
