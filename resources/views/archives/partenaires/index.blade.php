@extends('layouts.sidebar')

@section('title', 'Partenaires')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Partenaires</h1>
        <a href="{{ route('archives.partenaires.create') }}" 
           class="bg-red-900 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded-lg inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nouveau Partenaire
        </a>
    </div>

    <!-- Barre de recherche -->
    <div class="mb-6">
        <form action="{{ route('archives.partenaires.index') }}" method="GET" class="flex gap-2">
            <input type="text" 
                   name="search" 
                   placeholder="Rechercher un partenaire..." 
                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-red-900 focus:border-red-900 p-2"
                   value="{{ request('search') }}">
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-red-100 text-red-900 rounded-md hover:bg-red-900">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Rechercher
            </button>
        </form>
    </div>

    <!-- Filtres -->
    <div class="mb-6 space-y-4">
        <!-- Types de partenaires -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('archives.partenaires.index') }}" 
               class="px-4 py-2 text-sm rounded-full {{ !request('type') ? 'bg-red-100 text-red-900' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Tous les types
            </a>
            @foreach($types as $type)
                <a href="{{ route('archives.partenaires.index', ['type' => $type]) }}" 
                   class="px-4 py-2 text-sm rounded-full {{ request('type') == $type ? 'bg-red-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $type }}
                </a>
            @endforeach
        </div>

        <!-- Statuts -->
        <div class="flex flex-wrap gap-2">
            @foreach($statuts as $key => $label)
                <a href="{{ route('archives.partenaires.index', ['statut' => $key]) }}" 
                   class="px-4 py-2 text-sm rounded-full {{ request('statut') == $key ? 'bg-red-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    @if(session('success'))
        <div class="bg-[#FEE2E2] border border-red-300 text-red-900 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($partenaires as $type => $groupPartenaires)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $type }}</h2>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        @foreach($groupPartenaires as $partenaire)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="mb-3">
                                    <h3 class="font-medium text-gray-900">{{ $partenaire->nom }}</h3>
                                    <div class="mt-1 text-sm">
                                        @if($partenaire->responsable)
                                            <p class="text-gray-600">Responsable: {{ $partenaire->responsable }}</p>
                                        @endif
                                        @if($partenaire->email)
                                            <p class="text-gray-600">Email: {{ $partenaire->email }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center mb-3">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $partenaire->statut_partenariat === 'actif' ? 'bg-red-100 text-red-900' : 
                                           ($partenaire->statut_partenariat === 'inactif' ? 'bg-red-100 text-red-800' : 'bg-red-100 text-red-900') }}">
                                        {{ ucfirst($partenaire->statut_partenariat) }}
                                    </span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('archives.partenaires.show', $partenaire) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 transition-colors text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Voir
                                        </a>
                                        @if($partenaire->fichier)
                                        <a href="{{ route('archives.partenaires.download', $partenaire) }}"
                                           class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-md hover:bg-green-200 transition-colors text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Document
                                        </a>
                                        @endif
                                        <a href="{{ route('archives.partenaires.edit', $partenaire) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-md hover:bg-yellow-200 transition-colors text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Modifier
                                        </a>
                                    </div>
                                    <form action="{{ route('archives.partenaires.destroy', $partenaire) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce partenaire ?');"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
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
                <p class="text-center text-gray-500">Aucun partenaire trouvé.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection