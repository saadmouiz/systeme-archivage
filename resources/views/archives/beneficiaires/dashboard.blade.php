@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8 flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard Bénéficiaires</h1>
                <p class="mt-2 text-lg text-gray-600">Statistiques et analyses des documents des bénéficiaires</p>
            </div>
            <div class="flex flex-wrap gap-3 justify-end">
                <a href="{{ route('archives.beneficiaires.create') }}" 
                   class="inline-flex items-center px-3 py-2 sm:px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-900 hover:bg-red-800 transition-colors">
                    <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden sm:inline">Ajouter un bénéficiaire</span>
                    <span class="sm:hidden">Ajouter</span>
                </a>
                <a href="{{ route('archives.beneficiaires.export.excel') }}" 
                   class="inline-flex items-center px-3 py-2 sm:px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-900 hover:bg-red-800 transition-colors">
                    <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="hidden sm:inline">Exporter en Excel</span>
                    <span class="sm:hidden">Excel</span>
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

        <!-- Cartes de statistiques principales supprimées sur demande -->

        <!-- Graphiques et analyses -->
        <!-- Première ligne : Genre et Status -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Statistiques par Genre -->
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Répartition par Genre</h3>
                        <p class="text-sm text-gray-600">Analyse des bénéficiaires par genre (Homme/Femme)</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="h-72">
                    <canvas id="genreChart"></canvas>
                </div>
            </div>

            <!-- Statistiques par Status -->
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Répartition par Status</h3>
                        <p class="text-sm text-gray-600">Analyse des bénéficiaires par status (Inscrit/Refuser)</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="h-72">
                    <canvas id="statusChart"></canvas>
                </div>
                </div>
            </div>

        <!-- Deuxième ligne : Documents Éducatifs (centré) -->
        <div class="flex justify-center mb-8">
            <div class="w-full max-w-2xl">
            <!-- Statistiques du tableau -->
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Répartition des Documents Éducatifs</h3>
                        <p class="text-sm text-gray-600">Vue d'ensemble des statistiques globales</p>
                    </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                    </div>
                </div>
                <div class="h-72">
                    <canvas id="tableauChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau détaillé par école -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Statistiques Détaillées par École</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Établissement</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inscrit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Refuser</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hommes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Femmes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Association</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Eps</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($statsParEcole as $stat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $stat['etablissement'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-900">
                                    {{ $stat['candidat'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-900">
                                    {{ $stat['inscrit'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    {{ $stat['refuser'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-900">
                                    {{ $stat['hommes'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-900">
                                    {{ $stat['femmes'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-900">
                                    {{ $stat['association'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-900">
                                    {{ $stat['eps'] }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Aucune donnée disponible pour les documents éducatifs
                            </td>
                        </tr>
                        @endforelse
                        
                        <!-- Ligne de total -->
                        @if($statsParEcole->count() > 0)
                        <tr class="bg-gray-100 border-t-2 border-gray-300">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                <strong>TOTAL</strong>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-900">
                                    {{ $totauxStats['candidat'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-900">
                                    {{ $totauxStats['inscrit'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-200 text-red-900">
                                    {{ $totauxStats['refuser'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-900">
                                    {{ $totauxStats['hommes'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-900">
                                    {{ $totauxStats['femmes'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-900">
                                    {{ $totauxStats['association'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-900">
                                    {{ $totauxStats['eps'] }}
                                </span>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top écoles et bénéficiaires récents -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Top 5 des écoles -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Top 5 des Écoles</h3>
                <div class="space-y-3">
                    @forelse($topEcoles as $index => $ecole)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-[#FEE2E2] flex items-center justify-center mr-3">
                                <span class="text-sm font-medium text-red-900">{{ $index + 1 }}</span>
                            </div>
                            <span class="font-medium text-gray-900">{{ $ecole['ecole'] }}</span>
                        </div>
                        <span class="text-lg font-bold text-red-900">{{ $ecole['total'] }}</span>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-4">Aucune donnée disponible</p>
                    @endforelse
                </div>
            </div>

            <!-- Bénéficiaires récents -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Bénéficiaires Récents</h3>
                <div class="space-y-3">
                    @forelse($beneficiairesRecents as $beneficiaire)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <div class="font-medium text-gray-900">{{ $beneficiaire->nom_complet }}</div>
                            <div class="text-sm text-gray-500">{{ $beneficiaire->type }}</div>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $beneficiaire->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-4">Aucun bénéficiaire récent</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Scripts pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Données pour les graphiques
    const evolutionData = @json($evolutionMensuelle);
    const typeData = @json($beneficiairesParType);
    const repartitionData = @json($repartitionAnnuelle);
    const totauxStats = @json($totauxStats);
    const statsGlobales = @json($statsGlobales ?? []);
    
    // Créer des gradients pour un effet moderne
    const createGradient = (ctx, color) => {
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, color);
        gradient.addColorStop(1, color.replace('0.8', '0.3'));
        return gradient;
    };

    // Graphique par Genre (gauche) - Design moderne
    const genreCtx = document.getElementById('genreChart').getContext('2d');
    
    const genreChart = new Chart(genreCtx, {
        type: 'doughnut',
        data: {
            labels: ['Hommes', 'Femmes'],
            datasets: [{
                label: 'Répartition par Genre',
                data: [
                    statsGlobales.hommes || 0,
                    statsGlobales.femmes || 0
                ],
                backgroundColor: [
                    'rgba(99, 102, 241, 0.9)',   // Bleu pour Hommes
                    'rgba(236, 72, 153, 0.9)'    // Rose pour Femmes
                ],
                borderColor: [
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)'
                ],
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
                duration: 1500,
                easing: 'easeInOutCubic',
                onComplete: function() {
                    // Dessiner les pourcentages au centre après l'animation
                    drawCenterTextGenre(genreChart);
                }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        font: {
                            size: 13,
                            weight: '600'
                        },
                        generateLabels: function(chart) {
                            const data = chart.data;
                            return data.labels.map((label, i) => {
                                const value = data.datasets[0].data[i];
                                const emoji = label === 'Hommes' ? '👨' : '👩';
                                return {
                                    text: `${emoji} ${label}: ${value}`,
                                    fillStyle: data.datasets[0].backgroundColor[i],
                                    hidden: false,
                                    index: i
                                };
                            });
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            const label = context[0].label;
                            const emoji = label === 'Hommes' ? '👨' : '👩';
                            return `${emoji} ${label}`;
                        },
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                            return [
                                `Nombre: ${context.parsed}`,
                                `Pourcentage: ${percentage}%`
                            ];
                        }
                    }
                }
            }
        }
    });

    // Fonction pour dessiner le texte au centre du graphique Genre
    function drawCenterTextGenre(chart) {
        const width = chart.width;
        const height = chart.height;
        const ctx = chart.ctx;
        
        ctx.restore();
        ctx.textBaseline = 'middle';
        ctx.textAlign = 'center';
        
        const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
        if (total > 0) {
            const hommes = chart.data.datasets[0].data[0] || 0;
            const femmes = chart.data.datasets[0].data[1] || 0;
            const hommesPercent = ((hommes / total) * 100).toFixed(1);
            const femmesPercent = ((femmes / total) * 100).toFixed(1);
            
            // Titre principal
            ctx.fillStyle = '#1f2937';
            ctx.font = 'bold 18px Inter, sans-serif';
            ctx.fillText('Genre', width / 2, height / 2 - 25);
            
            // Pourcentage Hommes
            ctx.fillStyle = '#6366f1';
            ctx.font = 'bold 14px Inter, sans-serif';
            ctx.fillText(`👨 ${hommesPercent}%`, width / 2, height / 2 - 5);
            
            // Pourcentage Femmes
            ctx.fillStyle = '#ec4899';
            ctx.font = 'bold 14px Inter, sans-serif';
            ctx.fillText(`👩 ${femmesPercent}%`, width / 2, height / 2 + 15);
        }
        ctx.save();
    }

    // Graphique par Status (droite) - Design moderne
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    
    new Chart(statusCtx, {
        type: 'bar',
        data: {
            labels: ['Inscrit', 'Refuser'],
            datasets: [{
                label: 'Répartition par Status',
                data: [
                    statsGlobales.inscrit || 0,
                    statsGlobales.refuser || 0
                ],
                backgroundColor: [
                    createGradient(statusCtx, 'rgba(16, 185, 129, 0.9)'),   // Vert pour Inscrit
                    createGradient(statusCtx, 'rgba(239, 68, 68, 0.9)')     // Rouge pour Refuser
                ],
                borderColor: [
                    'rgb(16, 185, 129)',
                    'rgb(239, 68, 68)'
                ],
                borderWidth: 3,
                borderRadius: 8,
                borderSkipped: false,
                hoverBackgroundColor: [
                    'rgba(16, 185, 129, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                hoverBorderWidth: 4
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
                delay: (context) => context.dataIndex * 200
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12,
                            weight: 'bold'
                        },
                        color: '#6b7280'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(107, 114, 128, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 11,
                            weight: '500'
                        },
                        color: '#6b7280'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            const label = context[0].label;
                            const emoji = label === 'Inscrit' ? '✅' : '❌';
                            return `${emoji} ${label}`;
                        },
                        label: function(context) {
                            return `Nombre: ${context.parsed.y}`;
                        }
                    }
                }
            }
        }
    });

    // Graphique en donut avec les totaux du tableau (droite) - Design moderne
    const tableauCtx = document.getElementById('tableauChart').getContext('2d');
    
    // Créer des gradients radiaux pour le donut
    const createRadialGradient = (ctx, color1, color2) => {
        const gradient = ctx.createRadialGradient(150, 150, 50, 150, 150, 150);
        gradient.addColorStop(0, color1);
        gradient.addColorStop(1, color2);
        return gradient;
    };

    const documentsChart = new Chart(tableauCtx, {
        type: 'doughnut',
        data: {
            labels: ['Candidat', 'Inscrit', 'Refuser', 'Hommes', 'Femmes', 'Association', 'Eps'],
            datasets: [{
                data: [
                    totauxStats.candidat || 0,
                    totauxStats.inscrit || 0,
                    totauxStats.refuser || 0,
                    totauxStats.hommes || 0,
                    totauxStats.femmes || 0,
                    totauxStats.association || 0,
                    totauxStats.eps || 0
                ],
                backgroundColor: [
                    createRadialGradient(tableauCtx, 'rgba(99, 102, 241, 0.9)', 'rgba(99, 102, 241, 0.4)'),   // Indigo gradient pour Candidat
                    createRadialGradient(tableauCtx, 'rgba(16, 185, 129, 0.9)', 'rgba(16, 185, 129, 0.4)'),   // Emerald gradient pour Inscrit
                    createRadialGradient(tableauCtx, 'rgba(239, 68, 68, 0.9)', 'rgba(239, 68, 68, 0.4)'),    // Red gradient pour Refuser
                    createRadialGradient(tableauCtx, 'rgba(99, 102, 241, 0.6)', 'rgba(99, 102, 241, 0.2)'),   // Indigo clair pour Hommes
                    createRadialGradient(tableauCtx, 'rgba(236, 72, 153, 0.9)', 'rgba(236, 72, 153, 0.4)'),   // Pink gradient pour Femmes
                    createRadialGradient(tableauCtx, 'rgba(79, 70, 229, 0.9)', 'rgba(79, 70, 229, 0.4)'),    // Indigo pour Association
                    createRadialGradient(tableauCtx, 'rgba(147, 51, 234, 0.9)', 'rgba(147, 51, 234, 0.4)')    // Purple pour Eps
                ],
                borderColor: [
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)'
                ],
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
                // Plugin personnalisé pour afficher les pourcentages au centre
                beforeDraw: function(chart) {
                    const width = chart.width;
                    const height = chart.height;
                    const ctx = chart.ctx;
                    
                    ctx.restore();
                    const fontSize = (height / 120).toFixed(2);
                    ctx.textBaseline = 'middle';
                    ctx.textAlign = 'center';
                    
                    const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    if (total > 0) {
                        // Titre principal
                        ctx.fillStyle = '#1f2937';
                        ctx.font = `bold ${fontSize * 1.3}em Inter, sans-serif`;
                        ctx.fillText('Documents', width / 2, height / 2 - 15);
                        ctx.fillText('Éducatifs', width / 2, height / 2);
                        
                        // Total
                        ctx.fillStyle = '#6b7280';
                        ctx.font = `bold ${fontSize * 1.1}em Inter, sans-serif`;
                        ctx.fillText(`Total: ${total}`, width / 2, height / 2 + 20);
                    }
                    ctx.save();
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

    // Redessiner le texte lors du redimensionnement
    window.addEventListener('resize', function() {
        setTimeout(() => {
            if (typeof genreChart !== 'undefined') {
                drawCenterTextGenre(genreChart);
            }
        }, 100);
    });
});
</script>
@endsection



