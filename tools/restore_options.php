<?php
// tools/restore_options.php
// Reconstruct options for bidang/jabatan from users and pegawai and insert missing values into options table.

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Gathering distinct values from users and pegawai...\n";

$bidangUsers = \DB::table('users')->whereNotNull('bidang')->pluck('bidang')->filter()->unique()->values()->all();
$bidangPegawai = [];
try {
    $bidangPegawai = \App\Models\Pegawai::whereNotNull('bidang')->pluck('bidang')->filter()->unique()->values()->all();
} catch (\Throwable $e) {
    $bidangPegawai = [];
}
$existingB = \App\Models\Option::where('type', 'bidang')->pluck('value')->all();

$mergedB = array_values(array_unique(array_merge($existingB, $bidangUsers, $bidangPegawai)));
$toInsertB = array_values(array_diff(array_unique(array_merge($bidangUsers, $bidangPegawai)), $existingB));

$jabUsers = \DB::table('users')->whereNotNull('jabatan')->pluck('jabatan')->filter()->unique()->values()->all();
$jabPeg = [];
try {
    $jabPeg = \App\Models\Pegawai::whereNotNull('jabatan')->pluck('jabatan')->filter()->unique()->values()->all();
} catch (\Throwable $e) {
    $jabPeg = [];
}
$existingJ = \App\Models\Option::where('type', 'jabatan')->pluck('value')->all();

$mergedJ = array_values(array_unique(array_merge($existingJ, $jabUsers, $jabPeg)));
$toInsertJ = array_values(array_diff(array_unique(array_merge($jabUsers, $jabPeg)), $existingJ));

echo "\nExisting opsi (bidang):\n"; print_r($existingB);
echo "\nDistinct bidang in users:\n"; print_r($bidangUsers);
echo "\nDistinct bidang in pegawai:\n"; print_r($bidangPegawai);
echo "\nWill insert into options (bidang):\n"; print_r($toInsertB);

echo "\nExisting opsi (jabatan):\n"; print_r($existingJ);
echo "\nDistinct jabatan in users:\n"; print_r($jabUsers);
echo "\nDistinct jabatan in pegawai:\n"; print_r($jabPeg);
echo "\nWill insert into options (jabatan):\n"; print_r($toInsertJ);

if (empty($toInsertB) && empty($toInsertJ)) {
    echo "\nNo new options to insert. Exiting.\n";
    exit(0);
}

// Ask for confirmation? We'll proceed automatically as requested.

$insertedB = [];
foreach ($toInsertB as $v) {
    if (trim($v) === '') continue;
    $opt = \App\Models\Option::firstOrCreate(['type' => 'bidang', 'value' => $v]);
    $insertedB[] = $v;
}

$insertedJ = [];
foreach ($toInsertJ as $v) {
    if (trim($v) === '') continue;
    $opt = \App\Models\Option::firstOrCreate(['type' => 'jabatan', 'value' => $v]);
    $insertedJ[] = $v;
}

echo "\nInserted (bidang) count: " . count($insertedB) . "\n";
if (!empty($insertedB)) print_r($insertedB);

echo "Inserted (jabatan) count: " . count($insertedJ) . "\n";
if (!empty($insertedJ)) print_r($insertedJ);

echo "\nFinal opsi (bidang):\n"; print_r(\App\Models\Option::where('type','bidang')->orderBy('value')->pluck('value')->all());
echo "\nFinal opsi (jabatan):\n"; print_r(\App\Models\Option::where('type','jabatan')->orderBy('value')->pluck('value')->all());

echo "\nDone.\n";
