@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- En-tête de l'événement -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $evenement->titre }}</h1>
                        <div class="mt-2 flex items-center">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $evenement->type === 'interne' ? 'bg-red-100 text-red-900' : 'bg-red-100 text-red-900' }}">
                                {{ ucfirst($evenement->type) }}
                            </span>
                            <span class="ml-2 px-2 py-1 text-xs rounded-full 
                                @switch($evenement->statut)
                                    @case('planifie') bg-red-100 text-red-900 @break
                                    @case('en_cours') bg-red-100 text-red-900 @break
                                    @case('termine') bg-red-100 text-red-900 @break
                                    @case('annule') bg-red-100 text-red-800 @break
                                @endswitch">
                                {{ ucfirst($evenement->statut) }}
                            </span>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('archives.evenements.edit', $evenement) }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Modifier
                        </a>
                        <form action="{{ route('archives.evenements.destroy', $evenement) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Détails de l'événement -->
            <div class="p-6 grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                    <p class="text-gray-600">{{ $evenement->description }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Informations</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Date de début</dt>
                            <dd class="text-sm text-gray-900">{{ $evenement->date_debut->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Date de fin</dt>
                            <dd class="text-sm text-gray-900">{{ $evenement->date_fin->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Lieu</dt>
                            <dd class="text-sm text-gray-900">{{ $evenement->lieu }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Détails supplémentaires</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nombre de participants</dt>
                            <dd class="text-sm text-gray-900">{{ $evenement->nombre_participants ?? 'Non défini' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Budget</dt>
                            <dd class="text-sm text-gray-900">{{ $evenement->budget ? number_format($evenement->budget, 2) . ' €' : 'Non défini' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Catégorie</dt>
                            <dd class="text-sm text-gray-900">{{ ucfirst($evenement->categorie) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Médias -->
            @if($evenement->medias->count() > 0)
            <div class="p-6 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Médias</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($evenement->medias as $media)
                    <div class="relative group">
                        @if(Str::startsWith($media->type_media, 'image'))
                            <img src="{{ Storage::url($media->chemin_fichier) }}" 
                                 alt="{{ $media->titre }}"
                                 class="rounded-lg w-full h-32 object-cover">
                        @else
                            <div class="rounded-lg w-full h-32 bg-gray-100 flex items-center justify-center">
                                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Témoignages -->
            @if($evenement->temoignages->count() > 0)
            <div class="p-6 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Témoignages</h3>
                <div class="space-y-4">
                    @foreach($evenement->temoignages as $temoignage)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-600 italic">{{ $temoignage->contenu }}</p>
                        <p class="text-sm text-gray-500 mt-2">- {{ $temoignage->nom_temoin }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>