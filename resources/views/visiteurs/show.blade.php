@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:p-8">
                <!-- En-tête -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Détails du Visiteur</h2>
                        <p class="mt-1 text-sm text-gray-600">Informations complètes sur le visiteur</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('visiteurs.edit', $visiteur) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Modifier
                        </a>
                        <a href="{{ route('visiteurs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Retour
                        </a>
                    </div>
                </div>

                <!-- Informations du visiteur -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Nom</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $visiteur->nom }}</p>
                        </div>

                        <!-- Prénom -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Prénom</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $visiteur->prenom }}</p>
                        </div>

                        <!-- CIN -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">CIN</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $visiteur->cin ?? 'Non renseigné' }}</p>
                        </div>

                        <!-- Heure d'arrivée -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Heure d'arrivée</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $visiteur->heure_arrivee->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bouton de suppression -->
                <div class="mt-8 flex justify-end">
                    <form action="{{ route('visiteurs.destroy', $visiteur) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce visiteur ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 