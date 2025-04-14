<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Archive\Project;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        Project::create([
            'titre' => 'Projet de Test 1',
            'description' => 'Description du projet de test 1',
            'objectifs' => 'Objectifs du projet 1',
            'statut' => 'en_cours',
            'beneficiaires' => 'Bénéficiaires 1',
            'date_debut' => now(),
            'budget' => 100000.00,
        ]);

        Project::create([
            'titre' => 'Projet de Test 2',
            'description' => 'Description du projet de test 2',
            'objectifs' => 'Objectifs du projet 2',
            'statut' => 'termine',
            'beneficiaires' => 'Bénéficiaires 2',
            'date_debut' => now()->subMonths(3),
            'date_fin' => now(),
            'budget' => 150000.00,
        ]);

        Project::create([
            'titre' => 'Projet de Test 3',
            'description' => 'Description du projet de test 3',
            'objectifs' => 'Objectifs du projet 3',
            'statut' => 'planifie',
            'beneficiaires' => 'Bénéficiaires 3',
            'date_debut' => now()->addMonths(2),
            'budget' => 200000.00,
        ]);
    }
}