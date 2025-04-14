<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\ArchivePartenaire;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    // Récupération des données existantes
    $partnersCount = ArchivePartenaire::count();
    $recentPartners = ArchivePartenaire::latest()->take(6)->get();

    // Ajout des données pour les graphiques
    $partnersByType = ArchivePartenaire::select('type')
        ->selectRaw('count(*) as total')
        ->groupBy('type')
        ->get();

    $partnersByMonth = ArchivePartenaire::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month')
        ->selectRaw('count(*) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->take(6)
        ->get();

    return view('dashboard', compact(
        'partnersCount',
        'recentPartners',
        'partnersByType',
        'partnersByMonth'
    ));
}
}