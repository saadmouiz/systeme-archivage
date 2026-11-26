<?php

namespace App\Console\Commands;

use App\Support\CdcSchemaEnsurer;
use Illuminate\Console\Command;

class EnsureCdcSchema extends Command
{
    protected $signature = 'cdc:ensure-schema';

    protected $description = 'Crée les colonnes/tables CDC manquantes (Lot 1 & 2) de façon idempotente';

    public function handle(): int
    {
        $this->info('Vérification / création du schéma CDC…');
        CdcSchemaEnsurer::ensure();
        $this->info('Schéma CDC OK.');
        return self::SUCCESS;
    }
}
