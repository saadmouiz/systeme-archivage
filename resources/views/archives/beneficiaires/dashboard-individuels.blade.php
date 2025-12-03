@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8 flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard Dossiers Individuels</h1>
                <p class="mt-2 text-lg text-gray-600">Statistiques et analyses des dossiers académiques individuels</p>
            </div>
            <div class="flex flex-wrap gap-3 justify-end">
                <a href="{{ route('archives.beneficiaires.create') }}" 
                   class="inline-flex items-center px-3 py-2 sm:px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-900 hover:bg-red-800 transition-colors">
                    <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden sm:inline">Ajouter un dossier</span>
                    <span class="sm:hidden">Ajouter</span>
                </a>
                <a href="{{ route('archives.beneficiaires.index') }}" 
                   class="inline-flex items-center px-3 py-2 sm:px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-900 hover:bg-red-800 transition-colors">
                    <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="hidden sm:inline">Voir tous les dossiers</span>
                    <span class="sm:hidden">Dossiers</span>
                </a>
                <a href="{{ route('archives.index') }}" 
                   class="inline-flex items-center px-3 py-2 sm:px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Retour aux archives</span>
                    <span class="sm:hidden">Retour</span>
                </a>
            </div>
        </div>

        <!-- Cartes de statistiques principales supprimées -->
        </div>

        <!-- Graphiques et analyses -->
        <!-- Première ligne : Niveau et Société -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Statistiques par Niveau -->
            <div class="group bg-white hover:bg-gray-50 transition-all duration-300 shadow-lg hover:shadow-2xl rounded-3xl p-8 border border-gray-100/50 backdrop-blur-sm relative overflow-hidden">
                <!-- Décoration de fond -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-indigo-100/30 to-transparent rounded-full -translate-y-16 translate-x-16"></div>
                
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-8">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="w-3 h-3 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full mr-3"></div>
                                <h3 class="text-xl font-bold text-gray-900">Répartition par Niveau</h3>
                            </div>
                            <p class="text-sm text-gray-500 leading-relaxed">Analyse détaillée des dossiers par niveau académique</p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 via-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="h-80 relative">
                        <div id="niveauChartContainer" class="h-full">
                            <canvas id="niveauChart" class="w-full h-full"></canvas>
                        </div>
                        <div id="niveauEmptyState" class="hidden absolute inset-0 flex items-center justify-center">
                            <div class="text-center py-12">
                                <div class="w-20 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                    <svg class="w-10 h-10 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                                <h4 class="text-lg font-semibold text-gray-700 mb-2">Aucun niveau renseigné</h4>
                                <p class="text-gray-500 text-sm">Les données de niveau apparaîtront ici une fois<br>que des dossiers avec niveau seront créés.</p>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                
            <!-- Statistiques par Société -->
            <div class="group bg-white hover:bg-gray-50 transition-all duration-300 shadow-lg hover:shadow-2xl rounded-3xl p-8 border border-gray-100/50 backdrop-blur-sm relative overflow-hidden">
                <!-- Décoration de fond -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-emerald-100/30 to-transparent rounded-full -translate-y-16 translate-x-16"></div>
                
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-8">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="w-3 h-3 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-full mr-3"></div>
                                <h3 class="text-xl font-bold text-gray-900">Répartition par Société</h3>
                            </div>
                            <p class="text-sm text-gray-500 leading-relaxed">Vue d'ensemble des sociétés (employeurs)</p>
                            </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 via-teal-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                </div>
            </div>

                    <div class="h-80 relative">
                        <div id="societeChartContainer" class="h-full">
                            <canvas id="societeChart" class="w-full h-full"></canvas>
                        </div>
                        <div id="societeEmptyState" class="hidden absolute inset-0 flex items-center justify-center">
                            <div class="text-center py-12">
                                <div class="w-20 h-20 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                    <svg class="w-10 h-10 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            </svg>
                        </div>
                                <h4 class="text-lg font-semibold text-gray-700 mb-2">Aucune société renseignée</h4>
                                <p class="text-gray-500 text-sm">Les données de société apparaîtront ici une fois<br>que des dossiers avec société seront créés.</p>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
                
        <!-- Deuxième ligne : Répartition par Genre (dossiers individuels) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="group bg-white hover:bg-gray-50 transition-all duration-300 shadow-lg hover:shadow-2xl rounded-3xl p-8 border border-gray-100/50 backdrop-blur-sm relative overflow-hidden">
                <!-- Décoration de fond -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-pink-100/30 to-transparent rounded-full -translate-y-16 translate-x-16"></div>
                
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-8">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="w-3 h-3 bg-gradient-to-r from-blue-500 to-pink-500 rounded-full mr-3"></div>
                                <h3 class="text-xl font-bold text-gray-900">Répartition par Genre</h3>
                            </div>
                            <p class="text-sm text-gray-500 leading-relaxed">Vue d'ensemble des genres des dossiers individuels (Homme / Femme)</p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 via-indigo-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="h-80">
                        <canvas id="genreChartIndividuel" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des Statistiques Détaillées -->
        @if($dossiersRecents->count() > 0)
        <div class="bg-white shadow-xl rounded-3xl p-8 mb-12 border border-gray-100/50 backdrop-blur-sm relative overflow-hidden">
            <!-- Décoration de fond -->
            <div class="absolute top-0 left-0 w-40 h-40 bg-gradient-to-br from-red-50/30 to-transparent rounded-full -translate-y-20 -translate-x-20"></div>
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-tl from-purple-50/30 to-transparent rounded-full translate-y-16 translate-x-16"></div>
            
            <div class="relative z-10">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center">
                        <div class="w-3 h-3 bg-gradient-to-r from-red-900 to-purple-600 rounded-full mr-4"></div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Statistiques Détaillées</h3>
                            <p class="text-sm text-gray-500">Aperçu complet des dossiers individuels récents</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-900 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
                <div class="overflow-x-auto rounded-2xl border border-gray-100 shadow-sm">
                    <table class="min-w-full">
                    <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100/80">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Nom Complet
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        Référence
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                        Genre
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        Niveau
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                        </svg>
                                        Spécialité
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Age
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Type d'intervention
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Société
                                    </div>
                                </th>
                        </tr>
                    </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($dossiersRecents as $index => $dossier)
                            <tr class="hover:bg-gradient-to-r hover:from-red-50/30 hover:to-purple-50/30 transition-all duration-200 group">
                                <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-red-900 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm mr-4 group-hover:scale-110 transition-transform duration-200">
                                            {{ substr($dossier->nom, 0, 1) }}{{ substr($dossier->prenom, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $dossier->nom_complet }}</div>
                                            <div class="text-xs text-gray-500">{{ $dossier->created_at->format('d/m/Y') }}</div>
                                        </div>
                                </div>
                            </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-orange-100 to-orange-200 text-red-900 shadow-sm">
                                        {{ $dossier->reference ?? 'Non spécifiée' }}
                                </span>
                            </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold shadow-sm
                                        @if($dossier->genre === 'Homme') bg-gradient-to-r from-red-100 to-red-200 text-red-900
                                        @elseif($dossier->genre === 'Femme') bg-gradient-to-r from-pink-100 to-pink-200 text-red-900
                                        @else bg-gradient-to-r from-gray-100 to-gray-200 text-gray-600
                                        @endif">
                                        @if($dossier->genre === 'Homme') 👨 {{ $dossier->genre }}
                                        @elseif($dossier->genre === 'Femme') 👩 {{ $dossier->genre }}
                                        @else Non spécifié
                                        @endif
                                </span>
                            </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-indigo-100 to-indigo-200 text-red-900 shadow-sm">
                                        {{ $dossier->niveau ?? 'Non spécifié' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-teal-100 to-teal-200 text-red-900 shadow-sm">
                                        {{ $dossier->specialite ?? 'Non spécifiée' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-amber-100 to-amber-200 text-red-900 shadow-sm">
                                        {{ $dossier->age ? $dossier->age . ' ans' : 'Non spécifié' }}
                                </span>
                            </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold shadow-sm
                                        @if($dossier->type_intervention === 'IP') bg-gradient-to-r from-red-100 to-red-200 text-red-900
                                        @elseif($dossier->type_intervention === 'AGR') bg-gradient-to-r from-green-100 to-green-200 text-red-900
                                        @else bg-gradient-to-r from-gray-100 to-gray-200 text-gray-600
                                        @endif">
                                        {{ $dossier->type_intervention ?? 'Non spécifié' }}
                                </span>
                            </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-purple-100 to-purple-200 text-red-900 shadow-sm">
                                        {{ $dossier->societe ?? 'Non spécifiée' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                
                @if($dossiersRecents->count() >= 10)
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500 mb-4">Affichage des 10 derniers dossiers</p>
                    <a href="{{ route('archives.beneficiaires.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-900 to-purple-600 text-white font-semibold rounded-xl hover:from-red-800 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Voir tous les dossiers
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Top niveaux et dossiers récents -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Top 5 des niveaux -->
            @if($repartitionNiveaux->count() > 0)
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Top 5 des Niveaux</h3>
                <div class="space-y-3">
                    @foreach($repartitionNiveaux->take(5) as $index => $niveau)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center">
                            <div class="w-8 h-8 bg-[#FEE2E2] flex items-center justify-center mr-3">
                                <span class="text-sm font-medium text-red-900">{{ $index + 1 }}</span>
                    </div>
                            <span class="font-medium text-gray-900">{{ $niveau['niveau'] }}</span>
                    </div>
                        <span class="text-lg font-bold text-red-900">{{ $niveau['total'] }}</span>
                </div>
                    @endforeach
                        </div>
                    </div>
                    @endif
                    
            <!-- Dossiers récents -->
            @if($dossiersRecents->count() > 0)
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Dossiers Récents</h3>
                <div class="space-y-3">
                @foreach($dossiersRecents as $dossier)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <div class="font-medium text-gray-900">{{ $dossier->nom_complet }}</div>
                            <div class="text-sm text-gray-500">{{ $dossier->niveau ?? 'Niveau non spécifié' }}</div>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $dossier->created_at->format('d/m/Y') }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
</div>

<!-- Scripts pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Données pour les graphiques
    const statsParNiveau = @json($statsParNiveau);
    const statsParSociete = @json($statsParSociete ?? []);
    const statsParGenre = @json($statsParGenre ?? []);

    // Fonction pour gérer les états vides
    function handleEmptyState(containerId, emptyStateId, hasData) {
        const container = document.getElementById(containerId);
        const emptyState = document.getElementById(emptyStateId);
        
        if (hasData) {
            container.style.display = 'block';
            emptyState.classList.add('hidden');
        } else {
            container.style.display = 'none';
            emptyState.classList.remove('hidden');
        }
    }

    // Configuration des couleurs modernes
    const modernColors = {
        primary: ['#6366f1', '#8b5cf6', '#ec4899', '#ef4444', '#f59e0b', '#10b981', '#06b6d4', '#84cc16'],
        gradients: [
            'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
            'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
            'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
            'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
            'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
            'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)',
            'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)'
        ]
    };

    // Graphique par niveau - Design moderne avec gestion d'état vide
    const niveauLabels = Object.keys(statsParNiveau);
    const niveauData = Object.values(statsParNiveau);
    const hasNiveauData = niveauLabels.length > 0 && niveauData.some(value => value > 0);
    
    handleEmptyState('niveauChartContainer', 'niveauEmptyState', hasNiveauData);
    
    if (hasNiveauData) {
        const niveauCtx = document.getElementById('niveauChart').getContext('2d');
        
        // Créer des gradients pour un effet moderne
        const createGradient = (ctx, color) => {
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, color);
            gradient.addColorStop(1, color.replace('0.9', '0.4'));
            return gradient;
        };

        new Chart(niveauCtx, {
            type: 'bar',
            data: {
                labels: niveauLabels,
                datasets: [{
                    label: 'Nombre d\'étudiants',
                    data: niveauData,
                    backgroundColor: niveauLabels.map((_, index) => {
                        const colorIndex = index % modernColors.primary.length;
                        return createGradient(niveauCtx, `rgba(${parseInt(modernColors.primary[colorIndex].slice(1, 3), 16)}, ${parseInt(modernColors.primary[colorIndex].slice(3, 5), 16)}, ${parseInt(modernColors.primary[colorIndex].slice(5, 7), 16)}, 0.9)`);
                    }),
                    borderColor: niveauLabels.map((_, index) => modernColors.primary[index % modernColors.primary.length]),
                    borderWidth: 0,
                    borderRadius: {
                        topLeft: 12,
                        topRight: 12,
                        bottomLeft: 4,
                        bottomRight: 4
                    },
                    borderSkipped: false,
                    hoverBackgroundColor: niveauLabels.map((_, index) => modernColors.primary[index % modernColors.primary.length]),
                    hoverBorderWidth: 2,
                    hoverBorderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                animation: {
                    duration: 1500,
                    easing: 'easeInOutCubic',
                    delay: (context) => context.dataIndex * 100
                },
                hover: {
                    animationDuration: 300
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: '600',
                                family: "'Inter', sans-serif"
                            },
                            color: '#64748b',
                            maxRotation: 0,
                            padding: 10
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.1)',
                            drawBorder: false,
                            lineWidth: 1
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 11,
                                weight: '500',
                                family: "'Inter', sans-serif"
                            },
                            color: '#64748b',
                            padding: 10,
                            callback: function(value) {
                                return value;
                            }
                        }
                    }
                },
            plugins: {
                legend: {
                    display: false
                },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        titleColor: '#f1f5f9',
                        bodyColor: '#e2e8f0',
                        borderColor: 'rgba(99, 102, 241, 0.3)',
                        borderWidth: 1,
                        cornerRadius: 12,
                        displayColors: false,
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold',
                            family: "'Inter', sans-serif"
                        },
                        bodyFont: {
                            size: 13,
                            family: "'Inter', sans-serif"
                        },
                        callbacks: {
                            title: function(context) {
                                return `📊 ${context[0].label}`;
                            },
                            label: function(context) {
                                return `Étudiants: ${context.parsed.y}`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Graphique par société
    const societeLabels = Object.keys(statsParSociete);
    const societeData = Object.values(statsParSociete);
    const hasSocieteData = societeLabels.length > 0 && societeData.some(value => value > 0);

    handleEmptyState('societeChartContainer', 'societeEmptyState', hasSocieteData);

    if (hasSocieteData) {
        const societeCtx = document.getElementById('societeChart').getContext('2d');
        
        new Chart(societeCtx, {
            type: 'doughnut',
            data: {
                labels: societeLabels,
                datasets: [{
                    data: societeData,
                    backgroundColor: modernColors.primary,
                    borderWidth: 2,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 16
                        }
                    }
                },
                cutout: '60%'
            }
        });
    }

    // Graphique par genre (Homme / Femme)
    const genreLabels = Object.keys(statsParGenre);
    const genreData = Object.values(statsParGenre);
    const hasGenreData = genreLabels.length > 0 && genreData.some(value => value > 0);

    if (hasGenreData) {
        const genreCtx = document.getElementById('genreChartIndividuel')?.getContext('2d');
        if (genreCtx) {
            new Chart(genreCtx, {
                type: 'doughnut',
                data: {
                    labels: genreLabels,
                    datasets: [{
                        data: genreData,
                        backgroundColor: ['#3b82f6', '#ec4899'],
                        borderWidth: 2,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 16
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        }
    }

    // Graphique en donut par spécialité - Design moderne avec gestion d'état vide
    const specialiteLabels = Object.keys(statsParSpecialite);
    const specialiteData = Object.values(statsParSpecialite);
    const hasSpecialiteData = specialiteLabels.length > 0 && specialiteData.some(value => value > 0);
    
    handleEmptyState('specialiteChartContainer', 'specialiteEmptyState', hasSpecialiteData);
    
    if (hasSpecialiteData) {
        const specialiteCtx = document.getElementById('specialiteChart').getContext('2d');
        
        // Créer des gradients radiaux pour le donut
        const createRadialGradient = (ctx, color1, color2) => {
            const gradient = ctx.createRadialGradient(150, 150, 50, 150, 150, 150);
            gradient.addColorStop(0, color1);
            gradient.addColorStop(1, color2);
            return gradient;
        };

    new Chart(specialiteCtx, {
        type: 'doughnut',
        data: {
            labels: specialiteLabels,
            datasets: [{
                data: specialiteData,
                backgroundColor: specialiteLabels.map((_, index) => {
                    const colors = [
                        ['rgba(99, 102, 241, 0.9)', 'rgba(99, 102, 241, 0.4)'],
                        ['rgba(16, 185, 129, 0.9)', 'rgba(16, 185, 129, 0.4)'],
                        ['rgba(239, 68, 68, 0.9)', 'rgba(239, 68, 68, 0.4)'],
                        ['rgba(236, 72, 153, 0.9)', 'rgba(236, 72, 153, 0.4)'],
                        ['rgba(79, 70, 229, 0.9)', 'rgba(79, 70, 229, 0.4)'],
                        ['rgba(147, 51, 234, 0.9)', 'rgba(147, 51, 234, 0.4)']
                    ];
                    const colorIndex = index % colors.length;
                    return createRadialGradient(specialiteCtx, colors[colorIndex][0], colors[colorIndex][1]);
                }),
                borderColor: Array(specialiteLabels.length).fill('rgba(255, 255, 255, 1)'),
                borderWidth: 4,
                hoverBorderWidth: 6,
                cutout: '65%',
                hoverOffset: 15,
                spacing: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 2000,
                easing: 'easeInOutQuart'
            },
            interaction: {
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    align: 'center',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 25,
                        font: {
                            size: 12,
                            weight: '600',
                            family: "'Inter', sans-serif"
                        },
                        color: '#374151',
                        generateLabels: function(chart) {
                            const data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                return data.labels.map((label, i) => {
                                    const value = data.datasets[0].data[i];
                                    return {
                                        text: `${label}: ${value}`,
                                        fillStyle: data.datasets[0].backgroundColor[i],
                                        strokeStyle: data.datasets[0].borderColor[i],
                                        lineWidth: 2,
                                        pointStyle: 'circle',
                                        hidden: false,
                                        index: i
                                    };
                                });
                            }
                            return [];
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(17, 24, 39, 0.95)',
                    titleColor: '#f9fafb',
                    bodyColor: '#f9fafb',
                    borderColor: 'rgba(255, 255, 255, 0.2)',
                    borderWidth: 1,
                    cornerRadius: 12,
                    displayColors: true,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13,
                        weight: '500'
                    },
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        },
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                            return [
                                `Valeur: ${context.parsed}`,
                                `Pourcentage: ${percentage}%`
                            ];
                        }
                    }
                }
            }
        }
    });
    }

});
</script>
@endsection



