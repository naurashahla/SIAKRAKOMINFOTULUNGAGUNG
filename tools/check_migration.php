<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "users: " . \App\Models\User::count() . PHP_EOL;
echo "pegawai: " . \App\Models\Pegawai::count() . PHP_EOL;

echo "\nLast 5 users (by id desc):\n";
foreach (\App\Models\User::orderBy('id', 'desc')->limit(5)->get() as $u) {
    echo "USER: {$u->id} | {$u->email} | role={$u->role} | bidang={$u->bidang} | jabatan={$u->jabatan} | nip={$u->nip}" . PHP_EOL;
}

$pegCount = \App\Models\Pegawai::count();
if ($pegCount === 0) {
    echo "\nPegawai table is empty\n";
} else {
    echo "\nSample pegawai rows:\n";
    foreach (\App\Models\Pegawai::limit(5)->get() as $p) {
        echo "PEG: {$p->id} | {$p->email} | {$p->nama}" . PHP_EOL;
    }
}
