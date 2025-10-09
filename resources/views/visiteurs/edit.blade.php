@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Modifier le Visiteur</h1>
            <p class="mt-2 text-sm text-gray-600">Modifier les informations du visiteur</p>
        </div>

        <!-- Formulaire -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('visiteurs.update', $visiteur) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Nom -->
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $visiteur->nom) }}" required
                            class="mt-1 focus:ring-red-900 focus:border-red-900 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('nom') border-red-300 @enderror">
                        @error('nom')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prénom -->
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $visiteur->prenom) }}" required
                            class="mt-1 focus:ring-red-900 focus:border-red-900 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('prenom') border-red-300 @enderror">
                        @error('prenom')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CIN -->
                    <div>
                        <label for="cin" class="block text-sm font-medium text-gray-700">CIN</label>
                        <input type="text" name="cin" id="cin" value="{{ old('cin', $visiteur->cin) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('cin') border-red-500 @enderror">
                        @error('cin')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Heure d'arrivée -->
                    <div class="sm:col-span-2">
                        <label for="heure_arrivee" class="block text-sm font-medium text-gray-700">Heure d'arrivée</label>
                        <input type="datetime-local" name="heure_arrivee" id="heure_arrivee" 
                            value="{{ old('heure_arrivee', $visiteur->heure_arrivee->format('Y-m-d\TH:i')) }}" required
                            class="mt-1 focus:ring-red-900 focus:border-red-900 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('heure_arrivee') border-red-300 @enderror">
                        @error('heure_arrivee')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Boutons -->
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('visiteurs.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900">
                        Annuler
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-900 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 

