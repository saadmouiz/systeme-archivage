<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Beneficiaire;
use Illuminate\Support\Facades\Storage;

class DeleteAllBeneficiaires extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beneficiaires:delete-all {--force : Forcer la suppression sans confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Supprimer tous les bénéficiaires et leurs fichiers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Beneficiaire::count();
        
        if ($count === 0) {
            $this->info('✓ Aucun bénéficiaire à supprimer.');
            return 0;
        }
        
        $this->warn("⚠️  Vous êtes sur le point de supprimer $count bénéficiaire(s).");
        
        // Demander confirmation si --force n'est pas utilisé
        if (!$this->option('force')) {
            if (!$this->confirm('Êtes-vous sûr de vouloir continuer ?')) {
                $this->info('Opération annulée.');
                return 0;
            }
        }
        
        $this->info('Suppression en cours...');
        
        $bar = $this->output->createProgressBar($count);
        $bar->start();
        
        $deletedFiles = 0;
        $deletedRecords = 0;
        
        // Supprimer chaque bénéficiaire et son fichier
        Beneficiaire::chunk(100, function ($beneficiaires) use (&$deletedFiles, &$deletedRecords, $bar) {
            foreach ($beneficiaires as $beneficiaire) {
                // Supprimer le fichier associé
                if ($beneficiaire->fichier && Storage::disk('public')->exists($beneficiaire->fichier)) {
                    Storage::disk('public')->delete($beneficiaire->fichier);
                    $deletedFiles++;
                }
                
                // Supprimer le bénéficiaire (force delete pour ignorer soft delete)
                $beneficiaire->forceDelete();
                $deletedRecords++;
                
                $bar->advance();
            }
        });
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info("✓ $deletedRecords bénéficiaire(s) supprimé(s)");
        $this->info("✓ $deletedFiles fichier(s) supprimé(s)");
        $this->info('✓ Opération terminée avec succès!');
        
        return 0;
    }
}
