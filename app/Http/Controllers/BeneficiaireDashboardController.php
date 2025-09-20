<?php

namespace App\Http\Controllers;

use App\Models\Beneficiaire;
use App\Models\ArchivePartenaire;
use App\Models\ArchiveProjet;
use App\Models\Evenement;
use App\Models\Communication;
use App\Models\Pointage;
use App\Models\Visiteur;
use App\Models\ArchiveFinancier;
use App\Models\Administratif;
use App\Models\Archive\Employee;
use App\Models\Archive\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class BeneficiaireDashboardController extends Controller
{
    public function index()
    {
        // Vérifier si la table des bénéficiaires existe
        if (!Schema::hasTable('beneficiaires')) {
            return view('archives.beneficiaires.dashboard', [
                'totalBeneficiaires' => 0,
                'beneficiairesParType' => collect(),
                'beneficiairesParEcole' => collect(),
                'statsParEcole' => collect(),
                'totauxStats' => [
                'candidat' => 0,
                'inscrit' => 0,
                    'refuser' => 0,
                    'hommes' => 0,
                    'femmes' => 0
                ],
                'evolutionMensuelle' => collect(),
                'statsModules' => [],
                'beneficiairesRecents' => collect(),
                'repartitionAnnuelle' => collect(),
                'topEcoles' => collect(),
                'croissanceMensuelle' => 0,
                'croissanceAnnuelle' => 0,
                'documentsParType' => collect(),
            ]);
        }

        // Statistiques générales des bénéficiaires
        $totalBeneficiaires = Beneficiaire::count();
        $beneficiairesParType = Beneficiaire::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get()
            ->pluck('total', 'type');

        // Statistiques par école
        $beneficiairesParEcole = Beneficiaire::with('ecole')
            ->select('ecole_id', DB::raw('count(*) as total'))
            ->whereNotNull('ecole_id')
            ->groupBy('ecole_id')
            ->get()
            ->map(function($item) {
                return [
                    'ecole' => $item->ecole ? $item->ecole->nom : 'Non spécifiée',
                    'total' => $item->total
                ];
            });

        // Statistiques détaillées par école avec genre et status
        $statsParEcole = Beneficiaire::with('ecole')
            ->select(
                'ecole_id',
                DB::raw('count(*) as total_beneficiaires'),
                DB::raw('SUM(CASE WHEN status = "Accepter" THEN 1 ELSE 0 END) as inscrit'),
                DB::raw('SUM(CASE WHEN status = "Refuser" THEN 1 ELSE 0 END) as refuser'),
                DB::raw('SUM(CASE WHEN genre = "Homme" THEN 1 ELSE 0 END) as hommes'),
                DB::raw('SUM(CASE WHEN genre = "Femme" THEN 1 ELSE 0 END) as femmes'),
                DB::raw('SUM(CASE WHEN ass_eps = "Association" THEN 1 ELSE 0 END) as association'),
                DB::raw('SUM(CASE WHEN ass_eps = "Eps" THEN 1 ELSE 0 END) as eps')
            )
            ->where('type', 'Document éducatif')
            ->whereNotNull('ecole_id')
            ->groupBy('ecole_id')
            ->get()
            ->map(function($item) {
                return [
                    'etablissement' => $item->ecole ? $item->ecole->nom : 'Non spécifiée',
                    'candidat' => $item->total_beneficiaires,
                    'inscrit' => $item->inscrit,
                    'refuser' => $item->refuser,
                    'hommes' => $item->hommes,
                    'femmes' => $item->femmes,
                    'association' => $item->association,
                    'eps' => $item->eps
                ];
            });

        // Calcul des totaux
        $totauxStats = [
            'candidat' => $statsParEcole->sum('candidat'),
            'inscrit' => $statsParEcole->sum('inscrit'),
            'refuser' => $statsParEcole->sum('refuser'),
            'hommes' => $statsParEcole->sum('hommes'),
            'femmes' => $statsParEcole->sum('femmes'),
            'association' => $statsParEcole->sum('association'),
            'eps' => $statsParEcole->sum('eps')
        ];

        // Évolution mensuelle des bénéficiaires
        $evolutionMensuelle = Beneficiaire::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mois'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // Statistiques des autres modules (avec vérification de l'existence des tables)
        $statsModules = [];
        
        $modules = [
            'projets' => ArchiveProjet::class,
            'evenements' => Evenement::class,
            'communications' => Communication::class,
            'pointages' => Pointage::class,
            'visiteurs' => Visiteur::class,
            'financiers' => ArchiveFinancier::class,
            'administratifs' => Administratif::class,
            'employes' => Employee::class,
        ];
        
        foreach ($modules as $module => $modelClass) {
            try {
                $tableName = (new $modelClass)->getTable();
                if (Schema::hasTable($tableName)) {
                    $statsModules[$module] = $modelClass::count();
                } else {
                    $statsModules[$module] = 0;
                }
            } catch (\Exception $e) {
                $statsModules[$module] = 0;
            }
        }

        // Bénéficiaires récents (derniers 30 jours)
        $beneficiairesRecents = Beneficiaire::with('ecole')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Répartition par mois de l'année en cours
        $repartitionAnnuelle = Beneficiaire::select(
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('count(*) as total')
            )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('mois')
            ->orderBy('mois')
            ->get()
            ->pluck('total', 'mois');

        // Top 5 des écoles avec le plus de bénéficiaires
        $topEcoles = Beneficiaire::with('ecole')
            ->select('ecole_id', DB::raw('count(*) as total'))
            ->whereNotNull('ecole_id')
            ->groupBy('ecole_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get()
            ->map(function($item) {
                return [
                    'ecole' => $item->ecole ? $item->ecole->nom : 'Non spécifiée',
                    'total' => $item->total
                ];
            });

        // Statistiques de croissance
        $croissanceMensuelle = $this->calculerCroissanceMensuelle();
        $croissanceAnnuelle = $this->calculerCroissanceAnnuelle();

        // Documents par type de fichier
        $documentsParType = Beneficiaire::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get()
            ->pluck('total', 'type');

        return view('archives.beneficiaires.dashboard', compact(
            'totalBeneficiaires',
            'beneficiairesParType',
            'beneficiairesParEcole',
            'statsParEcole',
            'totauxStats',
            'evolutionMensuelle',
            'statsModules',
            'beneficiairesRecents',
            'repartitionAnnuelle',
            'topEcoles',
            'croissanceMensuelle',
            'croissanceAnnuelle',
            'documentsParType'
        ));
    }

    private function calculerCroissanceMensuelle()
    {
        $moisActuel = Beneficiaire::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $moisPrecedent = Beneficiaire::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        if ($moisPrecedent == 0) {
            return $moisActuel > 0 ? 100 : 0;
        }

        return round((($moisActuel - $moisPrecedent) / $moisPrecedent) * 100, 2);
    }

    private function calculerCroissanceAnnuelle()
    {
        $anneeActuelle = Beneficiaire::whereYear('created_at', Carbon::now()->year)->count();
        $anneePrecedente = Beneficiaire::whereYear('created_at', Carbon::now()->subYear()->year)->count();

        if ($anneePrecedente == 0) {
            return $anneeActuelle > 0 ? 100 : 0;
        }

        return round((($anneeActuelle - $anneePrecedente) / $anneePrecedente) * 100, 2);
    }

    public function getStatsData(Request $request)
    {
        $type = $request->get('type', 'monthly');
        
        if ($type === 'monthly') {
            $data = Beneficiaire::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as period'),
                    DB::raw('count(*) as total')
                )
                ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy('period')
                ->orderBy('period')
                ->get();
        } else {
            $data = Beneficiaire::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y") as period'),
                    DB::raw('count(*) as total')
                )
                ->groupBy('period')
                ->orderBy('period')
                ->get();
        }

        return response()->json($data);
    }

    public function exportStats()
    {
        // Vérifier si la table des bénéficiaires existe
        if (!Schema::hasTable('beneficiaires')) {
            return redirect()->back()->with('error', 'Aucune donnée disponible pour l\'exportation');
        }

        // Récupérer les mêmes données que pour le dashboard
        $totalBeneficiaires = Beneficiaire::count();
        $beneficiairesParType = Beneficiaire::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get()
            ->pluck('total', 'type');

        // Statistiques détaillées par école avec genre et status
        $statsParEcole = Beneficiaire::with('ecole')
            ->select(
                'ecole_id',
                DB::raw('count(*) as total_beneficiaires'),
                DB::raw('SUM(CASE WHEN status = "Accepter" THEN 1 ELSE 0 END) as inscrit'),
                DB::raw('SUM(CASE WHEN status = "Refuser" THEN 1 ELSE 0 END) as refuser'),
                DB::raw('SUM(CASE WHEN genre = "Homme" THEN 1 ELSE 0 END) as hommes'),
                DB::raw('SUM(CASE WHEN genre = "Femme" THEN 1 ELSE 0 END) as femmes'),
                DB::raw('SUM(CASE WHEN ass_eps = "Association" THEN 1 ELSE 0 END) as association'),
                DB::raw('SUM(CASE WHEN ass_eps = "Eps" THEN 1 ELSE 0 END) as eps')
            )
            ->where('type', 'Document éducatif')
            ->whereNotNull('ecole_id')
            ->groupBy('ecole_id')
            ->get()
            ->map(function($item) {
                return [
                    'etablissement' => $item->ecole ? $item->ecole->nom : 'Non spécifiée',
                    'candidat' => $item->total_beneficiaires,
                    'inscrit' => $item->inscrit,
                    'refuser' => $item->refuser,
                    'hommes' => $item->hommes,
                    'femmes' => $item->femmes,
                    'association' => $item->association,
                    'eps' => $item->eps
                ];
            });

        // Calcul des totaux
        $totauxStats = [
            'candidat' => $statsParEcole->sum('candidat'),
            'inscrit' => $statsParEcole->sum('inscrit'),
            'refuser' => $statsParEcole->sum('refuser'),
            'hommes' => $statsParEcole->sum('hommes'),
            'femmes' => $statsParEcole->sum('femmes'),
            'association' => $statsParEcole->sum('association'),
            'eps' => $statsParEcole->sum('eps')
        ];

        // Données pour les graphiques
        $evolutionMensuelle = Beneficiaire::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mois'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        $repartitionAnnuelle = Beneficiaire::select(
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('count(*) as total')
            )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('mois')
            ->orderBy('mois')
            ->get()
            ->pluck('total', 'mois');

        // Générer le PDF
        $pdf = Pdf::loadView('archives.beneficiaires.export', compact(
            'totalBeneficiaires',
            'beneficiairesParType',
            'statsParEcole',
            'totauxStats',
            'evolutionMensuelle',
            'repartitionAnnuelle'
        ));

        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('statistiques-beneficiaires-' . date('Y-m-d') . '.pdf');
    }

    public function dashboardIndividuels()
    {
        // Vérifier si la table des bénéficiaires existe
        if (!Schema::hasTable('beneficiaires')) {
            return view('archives.beneficiaires.dashboard-individuels', [
                'totalDossiersIndividuels' => 0,
                'statsParNiveau' => collect(),
                'statsParSpecialite' => collect(),
                'croissanceMensuelle' => 0,
                'croissanceAnnuelle' => 0,
                'evolutionMensuelle' => collect(),
                'repartitionNiveaux' => collect(),
                'dossiersRecents' => collect(),
                'topSpecialites' => collect(),
                'repartitionAnnuelle' => collect(),
                'niveauxAvecStats' => collect(),
            ]);
        }

        // Statistiques spécifiques aux dossiers individuels
        $totalDossiersIndividuels = Beneficiaire::where('type', 'Dossier individuel')->count();
        
        // Statistiques par niveau
        $statsParNiveau = Beneficiaire::where('type', 'Dossier individuel')
            ->select('niveau', DB::raw('count(*) as total'))
            ->whereNotNull('niveau')
            ->groupBy('niveau')
            ->get()
            ->pluck('total', 'niveau');

        // Statistiques par spécialité
        $statsParSpecialite = Beneficiaire::where('type', 'Dossier individuel')
            ->select('specialite', DB::raw('count(*) as total'))
            ->whereNotNull('specialite')
            ->groupBy('specialite')
            ->get()
            ->pluck('total', 'specialite');


        // Évolution mensuelle des dossiers individuels
        $evolutionMensuelle = Beneficiaire::where('type', 'Dossier individuel')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mois'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // Répartition des niveaux avec pourcentages
        $repartitionNiveaux = Beneficiaire::where('type', 'Dossier individuel')
            ->select('niveau', DB::raw('count(*) as total'))
            ->whereNotNull('niveau')
            ->groupBy('niveau')
            ->get()
            ->map(function($item) use ($totalDossiersIndividuels) {
                return [
                    'niveau' => $item->niveau,
                    'total' => $item->total,
                    'pourcentage' => $totalDossiersIndividuels > 0 ? round(($item->total / $totalDossiersIndividuels) * 100, 2) : 0
                ];
            });

        // Dossiers récents (derniers 30 jours)
        $dossiersRecents = Beneficiaire::where('type', 'Dossier individuel')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Top 10 des spécialités les plus populaires
        $topSpecialites = Beneficiaire::where('type', 'Dossier individuel')
            ->select('specialite', DB::raw('count(*) as total'))
            ->whereNotNull('specialite')
            ->groupBy('specialite')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get()
            ->map(function($item) {
                return [
                    'specialite' => $item->specialite,
                    'total' => $item->total
                ];
            });

        // Répartition par mois de l'année en cours
        $repartitionAnnuelle = Beneficiaire::where('type', 'Dossier individuel')
            ->select(
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('count(*) as total')
            )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('mois')
            ->orderBy('mois')
            ->get()
            ->pluck('total', 'mois');

        // Statistiques détaillées par niveau avec spécialités
        $niveauxAvecStats = Beneficiaire::where('type', 'Dossier individuel')
            ->select('niveau')
            ->whereNotNull('niveau')
            ->groupBy('niveau')
            ->get()
            ->map(function($item) {
                $niveau = $item->niveau;
                $totalNiveau = Beneficiaire::where('type', 'Dossier individuel')
                    ->where('niveau', $niveau)
                    ->count();
                
                $specialitesCount = Beneficiaire::where('type', 'Dossier individuel')
                    ->where('niveau', $niveau)
                    ->whereNotNull('specialite')
                    ->distinct('specialite')
                    ->count();

                $recentCount = Beneficiaire::where('type', 'Dossier individuel')
                    ->where('niveau', $niveau)
                    ->where('created_at', '>=', Carbon::now()->subDays(30))
                    ->count();

                return [
                    'niveau' => $niveau,
                    'total' => $totalNiveau,
                    'specialites_count' => $specialitesCount,
                    'recent_count' => $recentCount
                ];
            });

        // Statistiques de croissance spécifiques aux dossiers individuels
        $croissanceMensuelle = $this->calculerCroissanceMensuelleIndividuels();
        $croissanceAnnuelle = $this->calculerCroissanceAnnuelleIndividuels();

        return view('archives.beneficiaires.dashboard-individuels', compact(
            'totalDossiersIndividuels',
            'statsParNiveau',
            'statsParSpecialite',
            'croissanceMensuelle',
            'croissanceAnnuelle',
            'evolutionMensuelle',
            'repartitionNiveaux',
            'dossiersRecents',
            'topSpecialites',
            'repartitionAnnuelle',
            'niveauxAvecStats'
        ));
    }

    private function calculerCroissanceMensuelleIndividuels()
    {
        $moisActuel = Beneficiaire::where('type', 'Dossier individuel')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $moisPrecedent = Beneficiaire::where('type', 'Dossier individuel')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        if ($moisPrecedent == 0) {
            return $moisActuel > 0 ? 100 : 0;
        }

        return round((($moisActuel - $moisPrecedent) / $moisPrecedent) * 100, 2);
    }

    private function calculerCroissanceAnnuelleIndividuels()
    {
        $anneeActuelle = Beneficiaire::where('type', 'Dossier individuel')
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        $anneePrecedente = Beneficiaire::where('type', 'Dossier individuel')
            ->whereYear('created_at', Carbon::now()->subYear()->year)
            ->count();

        if ($anneePrecedente == 0) {
            return $anneeActuelle > 0 ? 100 : 0;
        }

        return round((($anneeActuelle - $anneePrecedente) / $anneePrecedente) * 100, 2);
    }

    public function exportExcel()
    {
        // Récupérer les données du tableau
        $statsParEcole = Beneficiaire::with('ecole')
            ->select(
                'ecole_id',
                DB::raw('count(*) as total_beneficiaires'),
                DB::raw('SUM(CASE WHEN status = "Accepter" THEN 1 ELSE 0 END) as inscrit'),
                DB::raw('SUM(CASE WHEN status = "Refuser" THEN 1 ELSE 0 END) as refuser'),
                DB::raw('SUM(CASE WHEN genre = "Homme" THEN 1 ELSE 0 END) as hommes'),
                DB::raw('SUM(CASE WHEN genre = "Femme" THEN 1 ELSE 0 END) as femmes'),
                DB::raw('SUM(CASE WHEN ass_eps = "Association" THEN 1 ELSE 0 END) as association'),
                DB::raw('SUM(CASE WHEN ass_eps = "Eps" THEN 1 ELSE 0 END) as eps')
            )
            ->where('type', 'Document éducatif')
            ->whereNotNull('ecole_id')
            ->groupBy('ecole_id')
            ->get()
            ->map(function($item) {
                return [
                    'etablissement' => $item->ecole ? $item->ecole->nom : 'Non spécifiée',
                    'candidat' => $item->total_beneficiaires,
                    'inscrit' => $item->inscrit,
                    'refuser' => $item->refuser,
                    'hommes' => $item->hommes,
                    'femmes' => $item->femmes,
                    'association' => $item->association,
                    'eps' => $item->eps
                ];
            });

        // Calculer les totaux
        $totauxStats = [
            'candidat' => $statsParEcole->sum('candidat'),
            'inscrit' => $statsParEcole->sum('inscrit'),
            'refuser' => $statsParEcole->sum('refuser'),
            'hommes' => $statsParEcole->sum('hommes'),
            'femmes' => $statsParEcole->sum('femmes'),
            'association' => $statsParEcole->sum('association'),
            'eps' => $statsParEcole->sum('eps')
        ];

        // Créer le contenu HTML pour Excel (format .xls)
        $htmlContent = '<?xml version="1.0" encoding="UTF-8"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Title>Statistiques Bénéficiaires</Title>
  <Created>' . date('Y-m-d\TH:i:s\Z') . '</Created>
 </DocumentProperties>
 <Styles>
  <Style ss:ID="header">
   <Font ss:Bold="1"/>
   <Interior ss:Color="#2563EB" ss:Pattern="Solid"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="total">
   <Font ss:Bold="1"/>
   <Interior ss:Color="#F3F4F6" ss:Pattern="Solid"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="normal">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
 </Styles>
 <Worksheet ss:Name="Statistiques par École">
  <Table>
   <Column ss:Width="120"/>
   <Column ss:Width="80"/>
   <Column ss:Width="80"/>
   <Column ss:Width="80"/>
   <Column ss:Width="80"/>
   <Column ss:Width="80"/>
   <Column ss:Width="80"/>
   <Column ss:Width="80"/>
   <Row>
    <Cell ss:StyleID="header"><Data ss:Type="String">Établissement</Data></Cell>
    <Cell ss:StyleID="header"><Data ss:Type="String">Candidat</Data></Cell>
    <Cell ss:StyleID="header"><Data ss:Type="String">Inscrit</Data></Cell>
    <Cell ss:StyleID="header"><Data ss:Type="String">Refuser</Data></Cell>
    <Cell ss:StyleID="header"><Data ss:Type="String">Hommes</Data></Cell>
    <Cell ss:StyleID="header"><Data ss:Type="String">Femmes</Data></Cell>
    <Cell ss:StyleID="header"><Data ss:Type="String">Association</Data></Cell>
    <Cell ss:StyleID="header"><Data ss:Type="String">Eps</Data></Cell>
   </Row>';

        // Ajouter les données des écoles
        foreach ($statsParEcole as $stat) {
            $htmlContent .= '
   <Row>
    <Cell ss:StyleID="normal"><Data ss:Type="String">' . htmlspecialchars($stat['etablissement']) . '</Data></Cell>
    <Cell ss:StyleID="normal"><Data ss:Type="Number">' . $stat['candidat'] . '</Data></Cell>
    <Cell ss:StyleID="normal"><Data ss:Type="Number">' . $stat['inscrit'] . '</Data></Cell>
    <Cell ss:StyleID="normal"><Data ss:Type="Number">' . $stat['refuser'] . '</Data></Cell>
    <Cell ss:StyleID="normal"><Data ss:Type="Number">' . $stat['hommes'] . '</Data></Cell>
    <Cell ss:StyleID="normal"><Data ss:Type="Number">' . $stat['femmes'] . '</Data></Cell>
    <Cell ss:StyleID="normal"><Data ss:Type="Number">' . $stat['association'] . '</Data></Cell>
    <Cell ss:StyleID="normal"><Data ss:Type="Number">' . $stat['eps'] . '</Data></Cell>
   </Row>';
        }
 
        // Ajouter la ligne de total
        if ($statsParEcole->count() > 0) {
            $htmlContent .= '
   <Row>
    <Cell ss:StyleID="total"><Data ss:Type="String">TOTAL</Data></Cell>
    <Cell ss:StyleID="total"><Data ss:Type="Number">' . $totauxStats['candidat'] . '</Data></Cell>
    <Cell ss:StyleID="total"><Data ss:Type="Number">' . $totauxStats['inscrit'] . '</Data></Cell>
    <Cell ss:StyleID="total"><Data ss:Type="Number">' . $totauxStats['refuser'] . '</Data></Cell>
    <Cell ss:StyleID="total"><Data ss:Type="Number">' . $totauxStats['hommes'] . '</Data></Cell>
    <Cell ss:StyleID="total"><Data ss:Type="Number">' . $totauxStats['femmes'] . '</Data></Cell>
    <Cell ss:StyleID="total"><Data ss:Type="Number">' . $totauxStats['association'] . '</Data></Cell>
    <Cell ss:StyleID="total"><Data ss:Type="Number">' . $totauxStats['eps'] . '</Data></Cell>
   </Row>';
        }

        $htmlContent .= '
  </Table>
 </Worksheet>
</Workbook>';

        // Créer la réponse avec les headers appropriés pour Excel
        $filename = 'statistiques-beneficiaires-' . date('Y-m-d') . '.xls';
        
        return response($htmlContent)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
    }
}