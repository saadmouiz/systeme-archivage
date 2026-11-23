<?php

namespace App\Console\Commands;

use App\Models\Beneficiaire;
use App\Support\SearchNormalizer;
use Illuminate\Console\Command;

class AuditBeneficiaireDoublons extends Command
{
    protected $signature = 'beneficiaires:audit-doublons';

    protected $description = 'Liste les bénéficiaires en doublon (même CIN normalisé)';

    public function handle(): int
    {
        $groups = [];

        Beneficiaire::query()
            ->whereNotNull('cin')
            ->where('cin', '!=', '')
            ->orderBy('id')
            ->get(['id', 'cin', 'reference', 'nom', 'prenom'])
            ->each(function (Beneficiaire $beneficiaire) use (&$groups) {
                $key = SearchNormalizer::normalize($beneficiaire->cin);
                if ($key === '') {
                    return;
                }
                $groups[$key][] = $beneficiaire;
            });

        $duplicates = collect($groups)->filter(fn ($items) => count($items) > 1);

        if ($duplicates->isEmpty()) {
            $this->info('Aucun doublon CIN détecté.');
            return self::SUCCESS;
        }

        $this->warn($duplicates->count() . ' CIN en doublon détecté(s) :');

        foreach ($duplicates as $cinKey => $items) {
            $this->line('');
            $this->line("CIN normalisé: {$cinKey}");
            foreach ($items as $item) {
                $this->line(sprintf(
                    '  - #%d | Réf: %s | %s %s | CIN: %s',
                    $item->id,
                    $item->reference ?: '-',
                    $item->nom,
                    $item->prenom,
                    $item->cin
                ));
            }
        }

        return self::SUCCESS;
    }
}
