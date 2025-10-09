<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\ArchivePartenaire;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Dashboard simplifié - juste un aperçu rapide
        $partnersCount = ArchivePartenaire::count();
        $recentPartners = ArchivePartenaire::latest()->take(6)->get();

        return view('dashboard', compact(
            'partnersCount',
            'recentPartners'
        ));
    }

    public function statistics()
    {
        // Statistiques Partenaires
        $partnersCount = \App\Models\ArchivePartenaire::count();
        $recentPartners = \App\Models\ArchivePartenaire::latest()->take(6)->get();
        $partnersByType = \App\Models\ArchivePartenaire::select('type')
            ->selectRaw('count(*) as total')
            ->groupBy('type')
            ->get();
        $partnersByMonth = \App\Models\ArchivePartenaire::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month')
            ->selectRaw('count(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->take(6)
            ->get();

        // Statistiques Bénéficiaires
        $beneficiairesCount = \App\Models\Beneficiaire::count();
        $beneficiairesByType = \App\Models\Beneficiaire::select('type')
            ->selectRaw('count(*) as total')
            ->groupBy('type')
            ->get();
        $beneficiairesByGenre = \App\Models\Beneficiaire::select('genre')
            ->selectRaw('count(*) as total')
            ->groupBy('genre')
            ->get();
        $beneficiairesByStatus = \App\Models\Beneficiaire::select('status')
            ->selectRaw('count(*) as total')
            ->groupBy('status')
            ->get();

        // Statistiques Employés
        $employeesCount = \App\Models\Archive\Employee::count();
        $employeesActifs = \App\Models\Archive\Employee::where('actif', true)->count();
        $employeesByContrat = \App\Models\Archive\Employee::select('type_contrat')
            ->selectRaw('count(*) as total')
            ->groupBy('type_contrat')
            ->get();

        // Statistiques Pointages
        $pointagesCount = \App\Models\Pointage::count();
        $pointagesByStatut = \App\Models\Pointage::select('statut')
            ->selectRaw('count(*) as total')
            ->groupBy('statut')
            ->get();
        $pointagesToday = \App\Models\Pointage::whereDate('date', today())->count();

        // Statistiques Visiteurs
        $visiteursCount = \App\Models\Visiteur::count();
        $visiteursToday = \App\Models\Visiteur::whereDate('created_at', today())->count();
        $visiteursByMonth = \App\Models\Visiteur::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month')
            ->selectRaw('count(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->take(6)
            ->get();

        // Statistiques Archives RH
        $rhCount = \App\Models\ArchiveRh::count();
        $rhByType = \App\Models\ArchiveRh::select('type')
            ->selectRaw('count(*) as total')
            ->groupBy('type')
            ->get();

        // Statistiques Financiers
        $financiersCount = \App\Models\ArchiveFinancier::count();
        $financiersByType = \App\Models\ArchiveFinancier::select('type')
            ->selectRaw('count(*) as total')
            ->groupBy('type')
            ->get();
        $totalMontant = \App\Models\ArchiveFinancier::sum('montant');
        $financiersByStatut = \App\Models\ArchiveFinancier::select('statut')
            ->selectRaw('count(*) as total')
            ->groupBy('statut')
            ->get();

        // Statistiques Administratifs
        $administratifsCount = \App\Models\Administratif::count();
        $administratifsByType = \App\Models\Administratif::select('type')
            ->selectRaw('count(*) as total')
            ->groupBy('type')
            ->get();

        // Statistiques Communications
        $communicationsCount = \App\Models\Communication::count();
        $communicationsByType = \App\Models\Communication::select('type')
            ->selectRaw('count(*) as total')
            ->groupBy('type')
            ->get();

        // Statistiques Événements
        $evenementsCount = \App\Models\Evenement::count();
        $evenementsByType = \App\Models\Evenement::select('type')
            ->selectRaw('count(*) as total')
            ->groupBy('type')
            ->get();
        $evenementsByStatut = \App\Models\Evenement::select('statut')
            ->selectRaw('count(*) as total')
            ->groupBy('statut')
            ->get();
        $totalParticipants = \App\Models\Evenement::sum('nombre_participants');

        // Activités récentes (tous types confondus)
        $recentActivities = collect()
            ->merge(\App\Models\ArchivePartenaire::latest()->take(3)->get()->map(function($item) {
                return ['type' => 'Partenaire', 'titre' => $item->nom, 'date' => $item->created_at];
            }))
            ->merge(\App\Models\Beneficiaire::latest()->take(3)->get()->map(function($item) {
                return ['type' => 'Bénéficiaire', 'titre' => $item->nom . ' ' . $item->prenom, 'date' => $item->created_at];
            }))
            ->merge(\App\Models\Evenement::latest()->take(3)->get()->map(function($item) {
                return ['type' => 'Événement', 'titre' => $item->titre, 'date' => $item->created_at];
            }))
            ->sortByDesc('date')
            ->take(10);

        return view('statistics', compact(
            'partnersCount', 'recentPartners', 'partnersByType', 'partnersByMonth',
            'beneficiairesCount', 'beneficiairesByType', 'beneficiairesByGenre', 'beneficiairesByStatus',
            'employeesCount', 'employeesActifs', 'employeesByContrat',
            'pointagesCount', 'pointagesByStatut', 'pointagesToday',
            'visiteursCount', 'visiteursToday', 'visiteursByMonth',
            'rhCount', 'rhByType',
            'financiersCount', 'financiersByType', 'totalMontant', 'financiersByStatut',
            'administratifsCount', 'administratifsByType',
            'communicationsCount', 'communicationsByType',
            'evenementsCount', 'evenementsByType', 'evenementsByStatut', 'totalParticipants',
            'recentActivities'
        ));
    }
}