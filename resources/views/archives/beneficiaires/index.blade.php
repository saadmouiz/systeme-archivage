@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-green-50">
    <div class="container mx-auto px-4 py-12">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-6 lg:mb-0">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-600 to-green-700 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                                Dossiers des Bénéficiaires
                            </h1>
                            <p class="text-gray-600 mt-2">Gestion centralisée des dossiers des bénéficiaires</p>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('archives.beneficiaires.dashboard') }}" 
                       class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 via-green-700 to-green-800 text-white font-semibold rounded-2xl shadow-2xl hover:shadow-green-500/25 transition-all duration-300 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-800 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-300"></div>
                        <svg class="w-5 h-5 mr-3 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="relative z-10">Dashboard Éducatifs</span>
                    </a>
                    <a href="{{ route('archives.dossiers-individuels.dashboard') }}" 
                       class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 via-indigo-700 to-indigo-800 text-white font-semibold rounded-2xl shadow-2xl hover:shadow-indigo-500/25 transition-all duration-300 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-300"></div>
                        <svg class="w-5 h-5 mr-3 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="relative z-10">Dashboard Individuels</span>
                    </a>
                    <a href="{{ route('archives.beneficiaires.create') }}" 
                       class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 text-white font-semibold rounded-2xl shadow-2xl hover:shadow-blue-500/25 transition-all duration-300 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-300"></div>
                        <svg class="w-5 h-5 mr-3 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="relative z-10">Nouveau Dossier</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtres Section -->
        <div class="mb-12">
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-white/20">
                <!-- Barre de recherche -->
                <div class="mb-8">
                    <form action="{{ route('archives.beneficiaires.index') }}" method="GET" class="relative">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   placeholder="Rechercher par nom, prénom, CIN..." 
                                   class="w-full pl-12 pr-32 py-4 text-lg border-2 border-gray-200 rounded-2xl shadow-sm focus:ring-4 focus:ring-green-500/20 focus:border-green-500 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                   value="{{ request('search') }}">
                            <button type="submit" 
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 px-6 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 shadow-lg hover:shadow-xl transition-all duration-200">
                                Rechercher
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Filtres -->
                <div class="space-y-6">
                    <!-- Types de documents -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wider">Types de dossiers</h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('archives.beneficiaires.index') }}" 
                               class="px-6 py-3 text-sm font-medium rounded-2xl transition-all duration-300 {{ !request('type') ? 'bg-gradient-to-r from-green-600 to-green-700 text-white shadow-lg scale-105' : 'bg-white/60 text-gray-700 hover:bg-white hover:shadow-md border border-gray-200' }}">
                                Tous
                            </a>
                            @foreach($types as $type)
                                <a href="{{ route('archives.beneficiaires.index', ['type' => $type]) }}" 
                                   class="px-6 py-3 text-sm font-medium rounded-2xl transition-all duration-300 {{ request('type') === $type ? 'bg-gradient-to-r from-green-600 to-green-700 text-white shadow-lg scale-105' : 'bg-white/60 text-gray-700 hover:bg-white hover:shadow-md border border-gray-200' }}">
                                    {{ $type }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Écoles -->
                    @if($ecoles->count() > 0)
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wider">Écoles</h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('archives.beneficiaires.index', ['type' => request('type')]) }}" 
                               class="px-6 py-3 text-sm font-medium rounded-2xl transition-all duration-300 {{ !request('ecole') ? 'bg-gradient-to-r from-green-600 to-green-700 text-white shadow-lg scale-105' : 'bg-white/60 text-gray-700 hover:bg-white hover:shadow-md border border-gray-200' }}">
                                Toutes
                            </a>
                            @foreach($ecoles as $ecole)
                                <a href="{{ route('archives.beneficiaires.index', ['type' => request('type'), 'ecole' => $ecole->id]) }}" 
                                   class="px-6 py-3 text-sm font-medium rounded-2xl transition-all duration-300 {{ request('ecole') == $ecole->id ? 'bg-gradient-to-r from-green-600 to-green-700 text-white shadow-lg scale-105' : 'bg-white/60 text-gray-700 hover:bg-white hover:shadow-md border border-gray-200' }}">
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
            <div class="mb-8 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 p-6 rounded-r-2xl shadow-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Documents Section -->
        <div class="space-y-12">
            @forelse($beneficiaires as $type => $typeBeneficiaires)
                <div class="group">
                    <!-- Section Header -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mr-6 shadow-xl">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $type }}</h2>
                                    <div class="flex items-center space-x-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                            {{ $typeBeneficiaires->count() }} dossier(s)
                                        </span>
                                        <span class="text-gray-500 text-sm">Dernière mise à jour: {{ now()->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden group-hover:block transition-all duration-300">
                                <div class="flex items-center space-x-2 text-sm text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Gestion des dossiers</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Grid -->
                    <div class="bg-white/60 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-white/20">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($typeBeneficiaires as $beneficiaire)
                                <div class="card-hover relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-green-200 hover:-translate-y-2 cursor-pointer" 
                                     onclick="window.location.href='{{ route('archives.beneficiaires.show', $beneficiaire) }}'">
                                    <!-- Card Header -->
                                    <div class="flex items-start justify-between mb-6">
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-900 text-lg leading-tight mb-2 hover:text-green-600 transition-colors duration-200">{{ $beneficiaire->nom_complet }}</h3>
                                            @if($beneficiaire->cin)
                                                <p class="text-sm text-gray-500 font-mono bg-gray-50 px-3 py-1 rounded-lg inline-block hover:bg-green-50 hover:text-green-700 transition-all duration-200">
                                                    CIN: {{ $beneficiaire->cin }}
                                                </p>
                                            @endif
                                        </div>
                                        <!-- Type badge -->
                                        <div class="flex items-center space-x-2">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300">
                                                {{ $beneficiaire->type }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Card Content -->
                                    <div class="space-y-4 mb-6">
                                        @if($beneficiaire->ecole)
                                        <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl hover:from-green-50 hover:to-green-100 transition-all duration-200">
                                            <div class="flex items-center text-gray-600 hover:text-green-700 transition-colors duration-200">
                                                <svg class="w-5 h-5 mr-3 text-gray-400 hover:text-green-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                <span class="font-medium">{{ $beneficiaire->ecole->nom }}</span>
                                            </div>
                                        </div>
                                        @endif

                                        @if($beneficiaire->niveau)
                                        <div class="flex items-center p-4 bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-xl hover:from-indigo-100 hover:to-indigo-200 transition-all duration-200">
                                            <div class="flex items-center text-indigo-600 hover:text-indigo-700 transition-colors duration-200">
                                                <svg class="w-5 h-5 mr-3 text-indigo-400 hover:text-indigo-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                                <span class="font-medium">{{ $beneficiaire->niveau }}</span>
                                            </div>
                                        </div>
                                        @endif

                                        @if($beneficiaire->specialite)
                                        <div class="flex items-center p-4 bg-gradient-to-r from-teal-50 to-teal-100 rounded-xl hover:from-teal-100 hover:to-teal-200 transition-all duration-200">
                                            <div class="flex items-center text-teal-600 hover:text-teal-700 transition-colors duration-200">
                                                <svg class="w-5 h-5 mr-3 text-teal-400 hover:text-teal-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                                </svg>
                                                <span class="font-medium">{{ $beneficiaire->specialite }}</span>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @if($beneficiaire->description)
                                        <div class="p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl hover:from-green-50 hover:to-green-100 transition-all duration-200">
                                            <p class="text-sm text-gray-600 hover:text-green-700 transition-colors duration-200">
                                                {{ Str::limit($beneficiaire->description, 100) }}
                                            </p>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Card Actions -->
                                    <div class="flex justify-between items-center pt-6 border-t border-gray-100">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('archives.beneficiaires.show', $beneficiaire) }}" 
                                               class="group/btn inline-flex items-center justify-center w-10 h-10 text-green-600 hover:text-white hover:bg-green-600 rounded-xl transition-all duration-300 hover:scale-110 shadow-sm hover:shadow-lg"
                                               title="Voir le dossier"
                                               onclick="event.stopPropagation()">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            @if($beneficiaire->fichier)
                                            <a href="{{ $beneficiaire->download_url }}" 
                                               class="group/btn inline-flex items-center justify-center w-10 h-10 text-blue-600 hover:text-white hover:bg-blue-600 rounded-xl transition-all duration-300 hover:scale-110 shadow-sm hover:shadow-lg"
                                               target="_blank"
                                               title="Télécharger le document"
                                               onclick="event.stopPropagation()">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                </svg>
                                            </a>
                                            @endif
                                            <a href="{{ route('archives.beneficiaires.edit', $beneficiaire) }}" 
                                               class="group/btn inline-flex items-center justify-center w-10 h-10 text-yellow-600 hover:text-white hover:bg-yellow-600 rounded-xl transition-all duration-300 hover:scale-110 shadow-sm hover:shadow-lg"
                                               title="Modifier"
                                               onclick="event.stopPropagation()">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                                    class="group/btn inline-flex items-center justify-center w-10 h-10 text-red-600 hover:text-white hover:bg-red-600 rounded-xl transition-all duration-300 hover:scale-110 shadow-sm hover:shadow-lg"
                                                    title="Supprimer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20">
                    <div class="mx-auto w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-8 shadow-xl">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Aucun dossier trouvé</h3>
                    <p class="text-gray-600 text-lg mb-8">Commencez par ajouter votre premier dossier de bénéficiaire pour organiser vos archives.</p>
                    <a href="{{ route('archives.beneficiaires.create') }}" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Créer le premier dossier
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
</div>
@endsection