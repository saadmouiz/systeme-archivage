<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Beneficiaire;
use App\Models\ArchivePartenaire;
use Illuminate\Support\Facades\File;

class BeneficiaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Noms marocains
        $noms = [
            'Alami', 'Bennani', 'Cherkaoui', 'Idrissi', 'Fassi', 'Alaoui', 'Tazi', 'Berrada',
            'Kabbaj', 'Filali', 'Sekkat', 'Bennis', 'Khamlichi', 'Benchekroun', 'Lazrak',
            'Kadiri', 'Kettani', 'Sqalli', 'Lahlou', 'Benjelloun', 'Kbaili', 'Hamdani'
        ];
        
        $prenoms = [
            'Mohammed', 'Ahmed', 'Hassan', 'Youssef', 'Karim', 'Rachid', 'Omar',
            'Fatima', 'Aicha', 'Khadija', 'Samira', 'Nadia', 'Laila', 'Amina',
            'Said', 'Khalid', 'Hamza', 'Mehdi', 'Salma', 'Yasmine', 'Oussama'
        ];
        
        $villes = [
            'Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès',
            'Oujda', 'Kenitra', 'Tétouan', 'Safi', 'Mohammedia', 'El Jadida'
        ];
        
        $specialites = [
            'Informatique', 'Comptabilité', 'Marketing', 'Ressources Humaines',
            'Gestion', 'Commerce', 'Communication', 'Finance', 'Électronique'
        ];
        
        $niveaux = [
            '1ère année collège', '2ème année collège', '3ème année collège',
            'Tronc Commun', '1ère année bac', '2ème année bac', 'Bac+2', 'Bac+3'
        ];
        
        // Récupérer des écoles existantes ou en créer
        $ecoles = ArchivePartenaire::where('type', 'école')->get();
        
        if ($ecoles->isEmpty()) {
            // Créer quelques écoles de test
            $ecolesNoms = [
                'École Secondaire Al Andalous',
                'École Primaire Al Manar',
                'Ispep',
                'Lycée Mohammed V',
                'Collège Al Massira'
            ];
            
            foreach ($ecolesNoms as $ecoleNom) {
                $ecoles->push(ArchivePartenaire::create([
                    'type' => 'école',
                    'nom' => $ecoleNom,
                    'email' => 'contact@' . strtolower(str_replace(' ', '', $ecoleNom)) . '.ma',
                    'telephone' => '0' . rand(5, 6) . rand(10000000, 99999999),
                    'adresse' => $villes[array_rand($villes)],
                    'responsable' => 'Directeur ' . $noms[array_rand($noms)],
                    'description' => 'École d\'enseignement général',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
        
        // Créer le dossier pour les fichiers de test
        $storagePath = storage_path('app/public/beneficiaires');
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }
        
        // Créer un fichier PDF de test
        $testPdfContent = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj 2 0 obj<</Type/Pages/Count 1/Kids[3 0 R]>>endobj 3 0 obj<</Type/Page/MediaBox[0 0 612 792]/Parent 2 0 R/Resources<<>>>>endobj\nxref\n0 4\n0000000000 65535 f\n0000000009 00000 n\n0000000056 00000 n\n0000000115 00000 n\ntrailer<</Size 4/Root 1 0 R>>\nstartxref\n190\n%%EOF";
        
        $this->command->info('🔄 Création de 15 Dossiers individuels (Employés)...');
        
        // Créer 15 Dossiers individuels
        for ($i = 1; $i <= 15; $i++) {
            $nom = $noms[array_rand($noms)];
            $prenom = $prenoms[array_rand($prenoms)];
            $genre = rand(0, 1) ? 'Homme' : 'Femme';
            
            // Créer un fichier PDF de test
            $fileName = time() . '_' . $i . '_dossier_individuel.pdf';
            File::put($storagePath . '/' . $fileName, $testPdfContent);
            
            Beneficiaire::create([
                'type' => 'Dossier individuel',
                'reference' => 'DI-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'nom' => $nom,
                'prenom' => $prenom,
                'ville' => $villes[array_rand($villes)],
                'cin' => strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2)) . rand(100000, 999999),
                'age' => rand(18, 55),
                'genre' => $genre,
                'niveau' => $niveaux[array_rand($niveaux)],
                'specialite' => $specialites[array_rand($specialites)],
                'type_intervention' => rand(0, 1) ? 'IP' : 'AGR',
                'societe' => 'Entreprise ' . $noms[array_rand($noms)],
                'description' => 'Dossier individuel de ' . $prenom . ' ' . $nom . '. Spécialité: ' . $specialites[array_rand($specialites)],
                'fichier' => 'beneficiaires/' . $fileName,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]);
            
            $this->command->info("  ✓ Créé: $prenom $nom ($genre)");
        }
        
        $this->command->newLine();
        $this->command->info('🔄 Création de 15 Documents éducatifs (Étudiants)...');
        
        // Créer 15 Documents éducatifs
        for ($i = 1; $i <= 15; $i++) {
            $nom = $noms[array_rand($noms)];
            $prenom = $prenoms[array_rand($prenoms)];
            $genre = rand(0, 1) ? 'Homme' : 'Femme';
            $ecole = $ecoles->random();
            
            // Créer un fichier PDF de test
            $fileName = time() . '_' . ($i + 15) . '_document_educatif.pdf';
            File::put($storagePath . '/' . $fileName, $testPdfContent);
            
            Beneficiaire::create([
                'type' => 'Document éducatif',
                'reference' => 'DE-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'nom' => $nom,
                'prenom' => $prenom,
                'ville' => $villes[array_rand($villes)],
                'cin' => strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2)) . rand(100000, 999999),
                'age' => rand(15, 30),
                'genre' => $genre,
                'status' => ['Accepter', 'Refuser'][rand(0, 1)],
                'ass_eps' => ['Association', 'Eps'][rand(0, 1)],
                'ecole_id' => $ecole->id,
                'description' => 'Document éducatif de ' . $prenom . ' ' . $nom . ' inscrit(e) à ' . $ecole->nom,
                'fichier' => 'beneficiaires/' . $fileName,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]);
            
            $this->command->info("  ✓ Créé: $prenom $nom - {$ecole->nom}");
        }
        
        $this->command->newLine();
        $this->command->info('✅ Terminé! 30 bénéficiaires créés avec succès:');
        $this->command->info('   - 15 Dossiers individuels');
        $this->command->info('   - 15 Documents éducatifs');
    }
}
