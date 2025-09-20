<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Archive\EmployeeController;
use App\Http\Controllers\Archive\ArchiveController;
use App\Http\Controllers\Archive\ArchiveProjetController;
use App\Http\Controllers\Archive\PartenaireController;
use App\Http\Controllers\Archive\FinancierController;
use App\Http\Controllers\PointageController;
use App\Http\Controllers\BeneficiaireController;
use App\Http\Controllers\Archive\RhController;
use App\Http\Controllers\AdministratifController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\LegalDocumentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VisiteurController;
use Carbon\Carbon;

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Home
Route::get('/', function () {
   return view('home');
})->name('home');

// Routes protÃ©gÃ©es par l'authentification
Route::middleware(['auth'])->group(function () {
    // Dashboard accessible Ã  tous les admins
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes pour les visiteurs
    Route::resource('visiteurs', VisiteurController::class);
    
    // Archives - page principale accessible Ã  tous les admins authentifiÃ©s
    Route::prefix('archives')->name('archives.')->group(function () {
        Route::get('/', [ArchiveController::class, 'index'])->name('index');
        Route::post('/store', [ArchiveController::class, 'store'])->name('store');

        // Admin 1 : AccÃ¨s aux RH, administratifs, financiers, employÃ©s
        Route::middleware(['can:access-rh'])->group(function () {
            Route::resource('rh', RhController::class);
            Route::get('/rh/search', [RhController::class, 'search'])->name('rh.search');
            Route::get('/rh/filter/{type}', [RhController::class, 'filter'])->name('rh.filter');
            Route::get('/rh/{rh}/download', [RhController::class, 'download'])->name('rh.download');
        });
        
        Route::middleware(['can:access-administratifs'])->group(function () {
            Route::resource('administratifs', AdministratifController::class);
            Route::get('/administratifs/search', [AdministratifController::class, 'search'])->name('administratifs.search');
            Route::get('/administratifs/filter/{type}', [AdministratifController::class, 'filter'])->name('administratifs.filter');
            Route::get('/administratifs/{administratif}/download', [AdministratifController::class, 'download'])->name('administratifs.download');
        });
        
        Route::middleware(['can:access-financiers'])->group(function () {
            Route::resource('financiers', FinancierController::class);
            Route::get('/financiers/search', [FinancierController::class, 'search'])->name('financiers.search');
            Route::get('/financiers/filter/{type}', [FinancierController::class, 'filter'])->name('financiers.filter');
            Route::get('/financiers/{financier}/download', [FinancierController::class, 'download'])->name('financiers.download');
            Route::get('/financiers/excel/template', [FinancierController::class, 'excelTemplate'])->name('financiers.excel-template');
        });

        Route::middleware(['can:access-employes'])->group(function () {
            Route::resource('employees', EmployeeController::class);
        });

        Route::middleware(['can:access-pointages'])->group(function () {
            Route::get('/pointages', [PointageController::class, 'index'])->name('pointages.index');
            Route::get('/pointages/create', [PointageController::class, 'create'])->name('pointages.create');
            Route::post('/pointages', [PointageController::class, 'store'])->name('pointages.store');
            Route::get('/pointages/{employee}', [PointageController::class, 'show'])->name('pointages.show');
            Route::get('/pointages/{pointage}/edit', [PointageController::class, 'edit'])->name('pointages.edit');
            Route::put('/pointages/{pointage}', [PointageController::class, 'update'])->name('pointages.update');
            Route::delete('/pointages/{pointage}', [PointageController::class, 'destroy'])->name('pointages.destroy');
            Route::get('/pointages/export-pdf', [PointageController::class, 'exportPdf'])->name('pointages.export-pdf');
        });

        // Admin 2 : AccÃ¨s aux bÃ©nÃ©ficiaires, partenaires, communications, Ã©vÃ©nements  
        Route::middleware(['can:access-beneficiaires'])->group(function () {
            Route::resource('beneficiaires', BeneficiaireController::class);
            Route::get('/beneficiaires/{beneficiaire}/download', [BeneficiaireController::class, 'download'])
                ->name('beneficiaires.download');
            Route::get('/beneficiaires-dashboard', [App\Http\Controllers\BeneficiaireDashboardController::class, 'index'])
                ->name('beneficiaires.dashboard');
            Route::get('/dossiers-individuels-dashboard', [App\Http\Controllers\BeneficiaireDashboardController::class, 'dashboardIndividuels'])
                ->name('dossiers-individuels.dashboard');
            Route::get('/beneficiaires-stats', [App\Http\Controllers\BeneficiaireDashboardController::class, 'getStatsData'])
                ->name('beneficiaires.stats');
            Route::get('/beneficiaires-export', [App\Http\Controllers\BeneficiaireDashboardController::class, 'exportStats'])
                ->name('beneficiaires.export');
            Route::get('/beneficiaires-export-excel', [App\Http\Controllers\BeneficiaireDashboardController::class, 'exportExcel'])
                ->name('beneficiaires.export.excel');
        });
        
        Route::middleware(['can:access-partenaires'])->group(function () {
            Route::resource('partenaires', PartenaireController::class);
            Route::get('/partenaires/search', [PartenaireController::class, 'search'])->name('partenaires.search');
            Route::get('/partenaires/filter/{type}', [PartenaireController::class, 'filter'])->name('partenaires.filter');
            Route::get('/partenaires/{partenaire}/download', [PartenaireController::class, 'download'])->name('partenaires.download');
        });

        Route::middleware(['can:access-communications'])->group(function () {
            Route::resource('communications', CommunicationController::class);
        });
        
        Route::middleware(['can:access-evenements'])->group(function () {
            Route::resource('evenements', EvenementController::class);
        });
    });
});

Route::get('/unauthorized', function () {
    return view('unauthorized');
})->name('unauthorized');
// Route pour tester l'authentification et l'utilisateur connectÃ©
Route::get('/test-auth', function () {
    return response()->json(Auth::user());
}); 
  
Route::get('/simple', function () { return 'Hello'; }); 
  
Route::get('/test', function () { return 'Test OK'; }); 
