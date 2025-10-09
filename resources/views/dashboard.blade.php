@extends('layouts.sidebar')

@section('title', 'Tableau de Bord')

@section('content')
<div class="min-h-screen">
    <div class="container mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Tableau de Bord</h1>
            <p class="text-gray-600">Bienvenue dans votre espace de gestion</p>
        </div>

        <!-- Cartes d'accès rapide -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Archives -->
            <a href="{{ route('archives.index') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all transform hover:scale-105 border-l-4 border-red-900">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-[#FEE2E2] border border-red-300 p-3 rounded-lg shadow-md">
                            <svg class="w-8 h-8 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Archives</h3>
                    <p class="text-sm text-gray-600">Accéder à toutes les archives</p>
                    <div class="mt-4 flex items-center text-red-900 font-medium text-sm">
                        <span>Voir tout</span>
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Partenaires -->
            <a href="{{ route('archives.partenaires.index') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all transform hover:scale-105 border-l-4 border-red-900">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-[#FEE2E2] border border-red-300 p-3 rounded-lg shadow-md">
                            <svg class="w-8 h-8 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Partenaires</h3>
                    <p class="text-sm text-gray-600">{{ $partnersCount }} partenaires</p>
                    <div class="mt-4 flex items-center text-red-900 font-medium text-sm">
                        <span>Gérer</span>
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Statistiques -->
            <a href="{{ route('statistics') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all transform hover:scale-105 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-[#FEE2E2] border border-red-300 p-3 rounded-lg shadow-md">
                            <svg class="w-8 h-8 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Statistiques</h3>
                    <p class="text-sm text-gray-600">Analyses et rapports</p>
                    <div class="mt-4 flex items-center text-red-900 font-medium text-sm">
                        <span>Consulter</span>
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Nouveau Partenaire -->
            <a href="{{ route('archives.partenaires.create') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all transform hover:scale-105 border-l-4 border-orange-500">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-[#FEE2E2] border border-red-300 p-3 rounded-lg shadow-md">
                            <svg class="w-8 h-8 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Nouveau</h3>
                    <p class="text-sm text-gray-600">Ajouter un partenaire</p>
                    <div class="mt-4 flex items-center text-red-900 font-medium text-sm">
                        <span>Créer</span>
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Derniers partenaires ajoutés -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-red-900 to-red-900 p-6">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Activité Récente
                </h2>
            </div>
            <div class="p-6">
                @forelse($recentPartners as $partner)
                    <div class="flex items-center justify-between p-4 mb-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-[#FEE2E2] border border-red-300 rounded-full flex items-center justify-center text-white font-bold mr-4">
                                {{ substr($partner->nom, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $partner->nom }}</h3>
                                <p class="text-sm text-gray-600">{{ $partner->type }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-red-100 text-red-900 rounded-full text-xs font-semibold">Nouveau</span>
                            <a href="{{ route('archives.partenaires.show', $partner) }}" class="p-2 text-red-900 hover:bg-red-900 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-8">Aucune activité récente</p>
                @endforelse

                @if($recentPartners->count() > 0)
                    <div class="mt-6 text-center">
                        <a href="{{ route('archives.partenaires.index') }}" class="inline-flex items-center px-6 py-3 bg-[#7F1D1D] border border-red-900 text-white font-semibold rounded-lg hover:bg-red-800 transition-colors">
                            Voir tous les partenaires
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


