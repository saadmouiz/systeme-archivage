@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- En-tête -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Tableau de Bord</h1>
                <p class="mt-1 text-gray-600">Aperçu de vos collaborations</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('archives.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                    </svg>
                    Archives
                </a>
                <a href="{{ route('archives.partenaires.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Nouveau Partenaire
                </a>
            </div>
        </div>

        <!-- Cartes statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Partenaires -->
            <div class="bg-white rounded-lg border p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Partenaires</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $partnersCount }}</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('archives.partenaires.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        Voir tous les partenaires →
                    </a>
                </div>
            </div>

            <!-- Partenaires Récents -->
            <div class="bg-white rounded-lg border p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Partenaires Récents</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $recentPartners->count() }}</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="space-y-3">
                    @forelse($recentPartners->take(3) as $partner)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">{{ $partner->nom }}</span>
                            <span class="px-2 py-1 bg-green-50 text-green-700 rounded-full text-xs">Nouveau</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Aucun partenaire récent</p>
                    @endforelse
                </div>
            </div>

            <!-- Types de Partenaires -->
            <div class="bg-white rounded-lg border p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Types de Partenaires</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">
                            {{ $recentPartners->pluck('type')->unique()->count() }}
                        </p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($recentPartners->pluck('type')->unique() as $type)
                        <span class="px-2 py-1 bg-purple-50 text-purple-700 rounded-full text-xs">
                            {{ $type }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Graphique par type -->
            <div class="bg-white rounded-lg border p-6 hover:shadow-md transition-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Répartition par Type</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="typeChart"></canvas>
                </div>
            </div>

            <!-- Graphique par mois -->
            <div class="bg-white rounded-lg border p-6 hover:shadow-md transition-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Évolution Mensuelle</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Table des partenaires récents -->
        <div class="bg-white rounded-lg border">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-900">Derniers Partenaires Ajoutés</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-sm text-gray-600">
                            <th class="px-6 py-3 text-left font-medium">Nom</th>
                            <th class="px-6 py-3 text-left font-medium">Type</th>
                            <th class="px-6 py-3 text-left font-medium">Date de Convention</th>
                            <th class="px-6 py-3 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentPartners as $partner)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-900">{{ $partner->nom }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium bg-blue-50 text-blue-700 rounded-full">
                                        {{ $partner->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $partner->date_de_convention }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('archives.partenaires.show', $partner) }}" 
                                           class="text-gray-600 hover:text-blue-600" title="Voir">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('archives.partenaires.edit', $partner) }}" 
                                           class="text-gray-600 hover:text-blue-600" title="Modifier">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Scripts pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique par type
    const typeCtx = document.getElementById('typeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($partnersByType->pluck('type')) !!},
            datasets: [{
                data: {!! json_encode($partnersByType->pluck('total')) !!},
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        boxWidth: 6
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            return `${label}: ${value} partenaire(s)`;
                        }
                    }
                }
            }
        }
    });

    // Graphique mensuel
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($partnersByMonth->pluck('month')) !!},
            datasets: [{
                label: 'Nouveaux partenaires',
                data: {!! json_encode($partnersByMonth->pluck('total')) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1,
                borderRadius: 4,
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    },
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw || 0;
                            return `${value} partenaire(s)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection