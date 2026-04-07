<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo 'DB=' . Illuminate\Support\Facades\DB::connection()->getDatabaseName() . PHP_EOL;

$rows = Illuminate\Support\Facades\DB::table('beneficiaires')
    ->orderByDesc('id')
    ->limit(5)
    ->get(['id', 'nom', 'prenom', 'reference', 'created_at', 'deleted_at']);

foreach ($rows as $row) {
    echo implode('|', [
        $row->id,
        $row->nom,
        $row->prenom,
        $row->reference ?? '',
        $row->created_at,
        $row->deleted_at ?? 'NULL',
    ]) . PHP_EOL;
}
