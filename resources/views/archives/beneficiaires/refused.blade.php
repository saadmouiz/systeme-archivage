@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100">
    <!-- Header avec statistiques -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white shadow-2xl">
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
                <div class="mb-6 lg:mb-0">
                    <div class="flex items-center mb-3">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mr-4 shadow-lg ring-2 ring-red-400/20">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold mb-2 tracking-tight">Dossiers Refusés</h1>
                            <p class="text-slate-300 text-sm">Gestion et suivi des dossiers non retenus</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('archives.beneficiaires.index') }}" 
                   class="group inline-flex items-center px-6 py-3 bg-white/10 backdrop-blur-sm border border-white/20 text-white rounded-xl hover:bg-white/20 transition-all duration-300 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="font-medium">Retour</span>
                </a>
            </div>

            <!-- Statistiques -->
            @php
                $totalRefused = $beneficiaires->flatten()->count();
                $byType = $beneficiaires->map->count();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-5 border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-300 text-sm font-medium mb-1">Total Refusés</p>
                            <p class="text-3xl font-bold">{{ $totalRefused }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                @foreach($beneficiaires as $type => $items)
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-5 border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-300 text-sm font-medium mb-1">{{ Str::limit($type, 20) }}</p>
                            <p class="text-3xl font-bold">{{ $items->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Filtres Section -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <!-- Barre de recherche -->
                <div class="mb-6">
                    <form action="{{ route('archives.beneficiaires.refused') }}" method="GET" class="relative">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   placeholder="Rechercher par nom, prénom, CIN..." 
                                   class="w-full pl-12 pr-32 py-3 text-base border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                   value="{{ request('search') }}">
                            <button type="submit" 
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 px-5 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 shadow-md hover:shadow-lg transition-all duration-200 font-medium">
                                Rechercher
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Filtres -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Types de documents -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Types de dossiers</label>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('archives.beneficiaires.refused') }}" 
                               class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ !request('type') ? 'bg-gradient-to-r from-red-600 to-red-700 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Tous
                            </a>
                            @foreach($types as $type)
                                <a href="{{ route('archives.beneficiaires.refused', ['type' => $type]) }}" 
                                   class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request('type') === $type ? 'bg-gradient-to-r from-red-600 to-red-700 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    {{ $type }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Écoles -->
                    @if($ecoles->count() > 0)
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Écoles</label>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('archives.beneficiaires.refused', ['type' => request('type')]) }}" 
                               class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ !request('ecole') ? 'bg-gradient-to-r from-red-600 to-red-700 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Toutes
                            </a>
                            @foreach($ecoles as $ecole)
                                <a href="{{ route('archives.beneficiaires.refused', ['type' => request('type'), 'ecole' => $ecole->id]) }}" 
                                   class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request('ecole') == $ecole->id ? 'bg-gradient-to-r from-red-600 to-red-700 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    {{ $ecole->nom }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-gradient-to-r from-emerald-50 to-green-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-md">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Documents Section -->
        <div class="space-y-8">
            @if($beneficiaires->count() > 0)
                @foreach($beneficiaires as $type => $typeBeneficiaires)
                <div>
                    <!-- Section Header -->
                    <div class="mb-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center mr-4 shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $type }}</h2>
                                <p class="text-sm text-gray-500">{{ $typeBeneficiaires->count() }} dossier(s) refusé(s)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($typeBeneficiaires as $beneficiaire)
                            <div class="group relative bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-200 hover:border-red-300 overflow-hidden">
                                <!-- Badge de statut en haut -->
                                <div class="absolute top-0 right-0 bg-gradient-to-r from-red-600 to-red-700 text-white px-3 py-1 text-xs font-semibold rounded-bl-lg shadow-lg z-10">
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Refusé
                                    </div>
                                </div>

                                <div class="p-6 cursor-pointer" onclick="window.location.href='{{ route('archives.beneficiaires.show', $beneficiaire) }}'">
                                    <!-- Header Card -->
                                    <div class="mb-4">
                                        <h3 class="font-bold text-gray-900 text-lg mb-2 group-hover:text-red-600 transition-colors">{{ $beneficiaire->nom_complet }}</h3>
                                        <div class="flex flex-wrap gap-2">
                                            @if($beneficiaire->reference)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-amber-100 text-amber-800">
                                                    Réf: {{ $beneficiaire->reference }}
                                                </span>
                                            @endif
                                            @if($beneficiaire->cin)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800 font-mono">
                                                    CIN: {{ $beneficiaire->cin }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Informations -->
                                    <div class="space-y-3 mb-4">
                                        @if($beneficiaire->ville)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span class="font-medium">{{ $beneficiaire->ville }}</span>
                                        </div>
                                        @endif
                                        
                                        @if($beneficiaire->ecole)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            <span class="font-medium">{{ $beneficiaire->ecole->nom }}</span>
                                        </div>
                                        @endif

                                        @if($beneficiaire->niveau)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                            <span class="font-medium">{{ $beneficiaire->niveau }}</span>
                                        </div>
                                        @endif

                                        @if($beneficiaire->specialite)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                            </svg>
                                            <span class="font-medium">{{ $beneficiaire->specialite }}</span>
                                        </div>
                                        @endif
                                    </div>

                                    @if($beneficiaire->description)
                                    <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <p class="text-xs text-gray-600 line-clamp-2">
                                            {{ Str::limit($beneficiaire->description, 80) }}
                                        </p>
                                    </div>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('archives.beneficiaires.show', $beneficiaire) }}" 
                                           class="inline-flex items-center justify-center w-9 h-9 text-gray-600 hover:text-white hover:bg-blue-600 rounded-lg transition-all duration-200 hover:scale-110"
                                           title="Voir"
                                           onclick="event.stopPropagation()">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        @if($beneficiaire->fichier)
                                        <a href="{{ $beneficiaire->download_url }}" 
                                           class="inline-flex items-center justify-center w-9 h-9 text-gray-600 hover:text-white hover:bg-green-600 rounded-lg transition-all duration-200 hover:scale-110"
                                           target="_blank"
                                           title="Télécharger"
                                           onclick="event.stopPropagation()">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                        </a>
                                        @endif
                                        <a href="{{ route('archives.beneficiaires.edit', $beneficiaire) }}" 
                                           class="inline-flex items-center justify-center w-9 h-9 text-gray-600 hover:text-white hover:bg-amber-600 rounded-lg transition-all duration-200 hover:scale-110"
                                           title="Modifier"
                                           onclick="event.stopPropagation()">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                    </div>
                                    <form action="{{ route('archives.beneficiaires.destroy', $beneficiaire) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce dossier ?');"
                                          class="inline"
                                          onclick="event.stopPropagation()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center justify-center w-9 h-9 text-gray-600 hover:text-white hover:bg-red-600 rounded-lg transition-all duration-200 hover:scale-110"
                                                title="Supprimer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-16 bg-white rounded-2xl shadow-lg border border-gray-200">
                    <div class="mx-auto w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Aucun dossier refusé</h3>
                    <p class="text-gray-600 mb-6">Il n'y a actuellement aucun dossier de bénéficiaire refusé dans le système.</p>
                    <a href="{{ route('archives.beneficiaires.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-slate-700 to-slate-800 text-white rounded-xl hover:from-slate-800 hover:to-slate-900 shadow-lg hover:shadow-xl transition-all duration-200 font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Retour aux Bénéficiaires
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
