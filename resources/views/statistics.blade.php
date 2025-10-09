@extends('layouts.sidebar')

@section('title', 'Statistiques')

@section('content')
<div class="min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">📊 Statistiques Complètes</h1>
            <p class="mt-2 text-gray-600">Analyse détaillée de toutes les données du système</p>
        </div>

        <!-- Vue d'ensemble globale -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-[#FEE2E2] rounded-xl shadow-lg p-6 border border-red-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-900 text-sm font-medium">Partenaires</p>
                        <p class="text-3xl font-bold mt-2 text-red-900">{{ $partnersCount }}</p>
                    </div>
                    <div class="bg-red-200 rounded-full p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-[#FEE2E2] rounded-xl shadow-lg p-6 border border-red-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-900 text-sm font-medium">Bénéficiaires</p>
                        <p class="text-3xl font-bold mt-2 text-red-900">{{ $beneficiairesCount }}</p>
                    </div>
                    <div class="bg-red-200 rounded-full p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-[#FEE2E2] rounded-xl shadow-lg p-6 border border-red-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-900 text-sm font-medium">Employés</p>
                        <p class="text-3xl font-bold mt-2 text-red-900">{{ $employeesCount }}</p>
                        <p class="text-xs text-red-900 mt-1">{{ $employeesActifs }} actifs</p>
                    </div>
                    <div class="bg-red-200 rounded-full p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-[#FEE2E2] rounded-xl shadow-lg p-6 border border-red-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-900 text-sm font-medium">Événements</p>
                        <p class="text-3xl font-bold mt-2 text-red-900">{{ $evenementsCount }}</p>
                        <p class="text-xs text-red-900 mt-1">{{ number_format($totalParticipants) }} participants</p>
                    </div>
                    <div class="bg-red-200 rounded-full p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques RH -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Ressources Humaines
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-4">Contrats Employés</h3>
                    <canvas id="employeesChart"></canvas>
                </div>
                
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-4">Pointages du jour</h3>
                    <div class="space-y-3">
                        <div class="bg-[#FEE2E2] rounded-lg p-4 border border-red-900">
                            <p class="text-sm text-gray-600">Total pointages</p>
                            <p class="text-2xl font-bold text-red-900">{{ $pointagesToday }}</p>
                        </div>
                        @foreach($pointagesByStatut as $statut)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700 capitalize">{{ $statut->statut }}</span>
                            <span class="text-lg font-bold text-gray-900">{{ $statut->total }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-4">Archives RH</h3>
                    <div class="bg-[#FEE2E2] rounded-lg p-4 border border-purple-100 mb-4">
                        <p class="text-sm text-gray-600">Total documents RH</p>
                        <p class="text-2xl font-bold text-red-900">{{ $rhCount }}</p>
                    </div>
                    <div class="space-y-2">
                        @foreach($rhByType as $type)
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                            <span class="text-xs text-gray-700">{{ $type->type }}</span>
                            <span class="font-semibold text-sm">{{ $type->total }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques Financières -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Finances
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-red-900">
                    <p class="text-sm text-gray-600 mb-2">Montant Total</p>
                    <p class="text-3xl font-bold text-red-900">{{ number_format($totalMontant, 2, ',', ' ') }} DH</p>
                    <p class="text-xs text-gray-500 mt-2">{{ $financiersCount }} documents</p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-4">Par Statut</h3>
                    <div class="space-y-2">
                        @foreach($financiersByStatut as $statut)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <span class="text-sm font-medium text-gray-700 capitalize">{{ $statut->statut }}</span>
                            <span class="text-lg font-bold 
                                @if($statut->statut === 'payé') text-red-900 
                                @elseif($statut->statut === 'validé') text-red-900 
                                @elseif($statut->statut === 'en attente') text-red-900 
                                @else text-red-600 @endif">
                                {{ $statut->total }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-4">Par Type</h3>
                    <canvas id="financiersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Bénéficiaires détaillés -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Bénéficiaires
                </h2>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-3">Par Genre</h3>
                        <canvas id="beneficiairesGenreChart"></canvas>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-3">Par Statut</h3>
                        <canvas id="beneficiairesStatusChart"></canvas>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-3">Par Type</h3>
                    <div class="space-y-2">
                        @foreach($beneficiairesByType as $type)
                        <div class="flex items-center justify-between p-3 bg-[#FEE2E2] rounded-lg border border-red-300">
                            <span class="text-sm font-medium text-red-900">{{ $type->type }}</span>
                            <span class="text-lg font-bold text-red-900">{{ $type->total }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Visiteurs et Communications -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Visiteurs
                    </h2>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-[#FEE2E2] rounded-lg p-4 border border-indigo-100">
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-2xl font-bold text-red-900">{{ $visiteursCount }}</p>
                        </div>
                        <div class="bg-[#FEE2E2] rounded-lg p-4 border border-indigo-100">
                            <p class="text-sm text-gray-600">Aujourd'hui</p>
                            <p class="text-2xl font-bold text-red-900">{{ $visiteursToday }}</p>
                        </div>
                    </div>

                    <h3 class="text-sm font-semibold text-gray-600 mb-3">Évolution Mensuelle</h3>
                    <canvas id="visiteursChart"></canvas>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                        Communications ({{ $communicationsCount }})
                    </h2>
                    <div class="space-y-2">
                        @foreach($communicationsByType as $type)
                        <div class="flex items-center justify-between p-3 bg-[#FEE2E2] rounded-lg border border-red-300">
                            <span class="text-sm font-medium text-red-900">{{ $type->type }}</span>
                            <span class="text-lg font-bold text-red-900">{{ $type->total }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Partenaires et Événements -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Partenaires
                </h2>

                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-600 mb-3">Répartition par Type</h3>
                    <canvas id="partnersChart"></canvas>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-3">Évolution Mensuelle</h3>
                    <canvas id="partnersMonthChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Événements
                </h2>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-3">Par Type</h3>
                        <canvas id="evenementsTypeChart"></canvas>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-3">Par Statut</h3>
                        <canvas id="evenementsStatutChart"></canvas>
                    </div>
                </div>

                <div class="bg-[#FEE2E2] rounded-lg p-4 border border-orange-100">
                    <p class="text-sm text-gray-600">Total Participants</p>
                    <p class="text-3xl font-bold text-red-900">{{ number_format($totalParticipants) }}</p>
                </div>
            </div>
        </div>

        <!-- Documents Administratifs -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Documents Administratifs ({{ $administratifsCount }})
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($administratifsByType as $type)
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 text-center">
                    <p class="text-sm text-gray-600 mb-2">{{ $type->type }}</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $type->total }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Activités Récentes -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Activités Récentes
            </h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentActivities as $activity)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($activity['type'] === 'Partenaire') bg-red-100 text-red-900
                                    @elseif($activity['type'] === 'Bénéficiaire') bg-red-100 text-red-900
                                    @else bg-red-100 text-red-900 @endif">
                                    {{ $activity['type'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $activity['titre'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $activity['date']->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Configuration globale des graphiques
    Chart.defaults.font.family = "'Inter', sans-serif";
    
    // Palette de couleurs
    const colors = {
        primary: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16'],
        blue: '#3B82F6',
        green: '#10B981',
        purple: '#8B5CF6',
        orange: '#F59E0B',
        pink: '#EC4899',
        indigo: '#6366F1'
    };

    // Graphique Employés par Contrat
    new Chart(document.getElementById('employeesChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($employeesByContrat->pluck('type_contrat')) !!},
            datasets: [{
                data: {!! json_encode($employeesByContrat->pluck('total')) !!},
                backgroundColor: colors.primary
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Graphique Financiers par Type
    new Chart(document.getElementById('financiersChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($financiersByType->pluck('type')) !!},
            datasets: [{
                data: {!! json_encode($financiersByType->pluck('total')) !!},
                backgroundColor: colors.primary
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Graphique Bénéficiaires par Genre
    new Chart(document.getElementById('beneficiairesGenreChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($beneficiairesByGenre->pluck('genre')) !!},
            datasets: [{
                data: {!! json_encode($beneficiairesByGenre->pluck('total')) !!},
                backgroundColor: [colors.blue, colors.pink]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Graphique Bénéficiaires par Statut
    new Chart(document.getElementById('beneficiairesStatusChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($beneficiairesByStatus->pluck('status')) !!},
            datasets: [{
                data: {!! json_encode($beneficiairesByStatus->pluck('total')) !!},
                backgroundColor: colors.primary
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Graphique Visiteurs par Mois
    new Chart(document.getElementById('visiteursChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($visiteursByMonth->pluck('month')) !!},
            datasets: [{
                label: 'Visiteurs',
                data: {!! json_encode($visiteursByMonth->pluck('total')) !!},
                borderColor: colors.indigo,
                backgroundColor: colors.indigo + '20',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Graphique Partenaires par Type
    new Chart(document.getElementById('partnersChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($partnersByType->pluck('type')) !!},
            datasets: [{
                data: {!! json_encode($partnersByType->pluck('total')) !!},
                backgroundColor: colors.primary
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Graphique Partenaires par Mois
    new Chart(document.getElementById('partnersMonthChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($partnersByMonth->pluck('month')) !!},
            datasets: [{
                label: 'Partenaires',
                data: {!! json_encode($partnersByMonth->pluck('total')) !!},
                backgroundColor: colors.blue
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Graphique Événements par Type
    new Chart(document.getElementById('evenementsTypeChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($evenementsByType->pluck('type')) !!},
            datasets: [{
                data: {!! json_encode($evenementsByType->pluck('total')) !!},
                backgroundColor: colors.primary
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Graphique Événements par Statut
    new Chart(document.getElementById('evenementsStatutChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($evenementsByStatut->pluck('statut')) !!},
            datasets: [{
                data: {!! json_encode($evenementsByStatut->pluck('total')) !!},
                backgroundColor: colors.primary
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endsection


