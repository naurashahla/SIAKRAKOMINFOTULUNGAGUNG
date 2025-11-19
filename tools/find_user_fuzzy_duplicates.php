<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$users = User::select('id','name','email','nip','bidang','jabatan')->get()->toArray();
$count = count($users);

echo "Scanning $count users for fuzzy duplicates...\n\n";

$emailCandidates = [];
$nameCandidates = [];

for ($i = 0; $i < $count; $i++) {
    for ($j = $i + 1; $j < $count; $j++) {
        $a = $users[$i];
        $b = $users[$j];

        // Email-based checks
        $emailA = strtolower(trim($a['email'] ?? ''));
        $emailB = strtolower(trim($b['email'] ?? ''));
        if ($emailA !== '' && $emailB !== '') {
            similar_text($emailA, $emailB, $percent);
            $lev = levenshtein($emailA, $emailB);

            // also compare local parts if domains match
            $localA = $emailA;
            $localB = $emailB;
            $domainMatch = false;
            if (strpos($emailA, '@') !== false && strpos($emailB, '@') !== false) {
                list($la, $da) = explode('@', $emailA, 2);
                list($lb, $db) = explode('@', $emailB, 2);
                $localA = $la; $localB = $lb;
                $domainMatch = ($da === $db);
            }
            $levLocal = levenshtein($localA, $localB);

            // threshold: similar >=85% OR levenshtein <=2 OR same domain and local levenshtein <=2
            if ($percent >= 85 || $lev <= 2 || ($domainMatch && $levLocal <= 2)) {
                $emailCandidates[] = [
                    'a' => $a,
                    'b' => $b,
                    'percent' => round($percent,2),
                    'lev' => $lev,
                    'levLocal' => $levLocal,
                    'domainMatch' => $domainMatch,
                ];
            }
        }

        // Name-based checks
        $nameA = strtolower(trim($a['name'] ?? ''));
        $nameB = strtolower(trim($b['name'] ?? ''));
        if ($nameA !== '' && $nameB !== '') {
            similar_text($nameA, $nameB, $npercent);
            $nlev = levenshtein($nameA, $nameB);
            if ($npercent >= 90 || $nlev <= 2) {
                $nameCandidates[] = [
                    'a' => $a,
                    'b' => $b,
                    'percent' => round($npercent,2),
                    'lev' => $nlev,
                ];
            }
        }
    }
}

if (empty($emailCandidates)) {
    echo "No fuzzy email candidates found.\n\n";
} else {
    echo "Fuzzy email candidates:\n";
    foreach ($emailCandidates as $c) {
        $a = $c['a']; $b = $c['b'];
        echo "- [E] ({$c['percent']}% sim, lev={$c['lev']}, levLocal={$c['levLocal']}, domainMatch=" . ($c['domainMatch']? 'yes':'no') . ")\n";
        echo "    {$a['id']} | {$a['email']} | {$a['name']} | {$a['nip']} | {$a['bidang']} | {$a['jabatan']}\n";
        echo "    {$b['id']} | {$b['email']} | {$b['name']} | {$b['nip']} | {$b['bidang']} | {$b['jabatan']}\n\n";
    }
}

if (empty($nameCandidates)) {
    echo "No fuzzy name candidates found.\n\n";
} else {
    echo "Fuzzy name candidates:\n";
    foreach ($nameCandidates as $c) {
        $a = $c['a']; $b = $c['b'];
        echo "- [N] ({$c['percent']}% sim, lev={$c['lev']})\n";
        echo "    {$a['id']} | {$a['email']} | {$a['name']} | {$a['nip']} | {$a['bidang']} | {$a['jabatan']}\n";
        echo "    {$b['id']} | {$b['email']} | {$b['name']} | {$b['nip']} | {$b['bidang']} | {$b['jabatan']}\n\n";
    }
}

if (empty($emailCandidates) && empty($nameCandidates)) {
    echo "No fuzzy duplicates found.\n";
} else {
    echo "Review the above candidate pairs and decide which ones to merge/delete.\n";
}
