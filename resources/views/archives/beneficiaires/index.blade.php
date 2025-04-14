@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dossiers des Bénéficiaires</h1>
        </div>
        <a href="{{ route('archives.beneficiaires.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nouveau Dossier
        </a>
    </div>

    <!-- Barre de recherche -->
    <div class="mb-6">
        <form action="{{ route('archives.beneficiaires.index') }}" method="GET" class="flex gap-2">
            <input type="text" 
                   name="search" 
                   placeholder="Rechercher par nom, prénom, CIN..." 
                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                   value="{{ request('search') }}">
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Rechercher
            </button>
        </form>
    </div>

    <!-- Filtres -->
    <div class="mb-6 space-y-4">
        <!-- Type de dossier -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('archives.beneficiaires.index') }}" 
               class="px-4 py-2 text-sm rounded-full {{ !request('type') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Tous les types
            </a>
            @foreach($types as $type)
                <a href="{{ route('archives.beneficiaires.index', ['type' => $type]) }}" 
                   class="px-4 py-2 text-sm rounded-full {{ request('type') === $type ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $type }}
                </a>
            @endforeach
        </div>

        <!-- Écoles -->
        @if($ecoles->count() > 0)
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('archives.beneficiaires.index', ['type' => request('type')]) }}" 
                   class="px-4 py-2 text-sm rounded-full {{ !request('ecole') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Toutes les écoles
                </a>
                @foreach($ecoles as $ecole)
                    <a href="{{ route('archives.beneficiaires.index', ['type' => request('type'), 'ecole' => $ecole->id]) }}" 
                       class="px-4 py-2 text-sm rounded-full {{ request('ecole') == $ecole->id ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $ecole->nom }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Liste des bénéficiaires -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($beneficiaires as $type => $typeBeneficiaires)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $type }}</h2>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        @foreach($typeBeneficiaires as $beneficiaire)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="mb-3">
                                    <h3 class="font-medium text-gray-900">{{ $beneficiaire->nom_complet }}</h3>
                                    @if($beneficiaire->cin)
                                        <p class="text-sm text-gray-600">CIN: {{ $beneficiaire->cin }}</p>
                                    @endif
                                </div>

                                @if($beneficiaire->ecole)
                                    <div class="mb-3">
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                            {{ $beneficiaire->ecole->nom }}
                                        </span>
                                    </div>
                                @endif

                                @if($beneficiaire->description)
                                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($beneficiaire->description, 100) }}</p>
                                @endif

                                <div class="flex justify-between items-center">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('archives.beneficiaires.show', $beneficiaire) }}" 
                                           class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Voir
                                        </a>
                                        @if($beneficiaire->fichier)
                                        <a href="{{ $beneficiaire->download_url }}"
                                        class="inline-flex items-center text-sm text-green-600 hover:text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                        Télécharger le document</a>
                                            
                                        @endif
                                        <a href="{{ route('archives.beneficiaires.edit', $beneficiaire) }}" 
                                           class="inline-flex items-center text-sm text-yellow-600 hover:text-yellow-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Modifier
                                        </a>
                                    </div>
                                    <form action="{{ route('archives.beneficiaires.destroy', $beneficiaire) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce dossier ?');"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">
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
            </div>
        @empty
            <div class="col-span-3">
                <p class="text-center text-gray-500">Aucun dossier trouvé.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection