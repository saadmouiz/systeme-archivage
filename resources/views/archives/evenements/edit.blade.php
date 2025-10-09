@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier l'événement</h1>

            <form action="{{ route('archives.evenements.update', $evenement) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label for="titre" class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" name="titre" id="titre" 
                               value="{{ old('titre', $evenement->titre) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                        @error('titre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">{{ old('description', $evenement->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="type" id="type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                                <option value="interne" {{ old('type', $evenement->type) === 'interne' ? 'selected' : '' }}>Interne</option>
                                <option value="externe" {{ old('type', $evenement->type) === 'externe' ? 'selected' : '' }}>Externe</option>
                            </select>
                        </div>

                        <div>
                            <label for="categorie" class="block text-sm font-medium text-gray-700">Catégorie</label>
                            <select name="categorie" id="categorie"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                                <option value="collecte" {{ old('categorie', $evenement->categorie) === 'collecte' ? 'selected' : '' }}>Collecte de fonds</option>
                                <option value="conference" {{ old('categorie', $evenement->categorie) === 'conference' ? 'selected' : '' }}>Conférence</option>
                                <option value="campagne" {{ old('categorie', $evenement->categorie) === 'campagne' ? 'selected' : '' }}>Campagne</option>
                                <option value="autre" {{ old('categorie', $evenement->categorie) === 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de début</label>
                            <input type="datetime-local" name="date_debut" id="date_debut"
                                   value="{{ old('date_debut', $evenement->date_debut->format('Y-m-d\TH:i')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                        </div>

                        <div>
                            <label for="date_fin" class="block text-sm font-medium text-gray-700">Date de fin</label>
                            <input type="datetime-local" name="date_fin" id="date_fin"
                                   value="{{ old('date_fin', $evenement->date_fin->format('Y-m-d\TH:i')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                        </div>
                    </div>

                    <div>
                        <label for="lieu" class="block text-sm font-medium text-gray-700">Lieu</label>
                        <input type="text" name="lieu" id="lieu"
                               value="{{ old('lieu', $evenement->lieu) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="nombre_participants" class="block text-sm font-medium text-gray-700">Nombre de participants</label>
                            <input type="number" name="nombre_participants" id="nombre_participants"
                                   value="{{ old('nombre_participants', $evenement->nombre_participants) }}"
                                   <!-- Suite de resources/views/evenements/edit.blade.php -->

                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                        </div>

                        <div>
                            <label for="budget" class="block text-sm font-medium text-gray-700">Budget</label>
                            <input type="number" step="0.01" name="budget" id="budget"
                                   value="{{ old('budget', $evenement->budget) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                        </div>
                    </div>

                    <div>
                        <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                        <select name="statut" id="statut"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                            <option value="planifie" {{ old('statut', $evenement->statut) === 'planifie' ? 'selected' : '' }}>Planifié</option>
                            <option value="en_cours" {{ old('statut', $evenement->statut) === 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="termine" {{ old('statut', $evenement->statut) === 'termine' ? 'selected' : '' }}>Terminé</option>
                            <option value="annule" {{ old('statut', $evenement->statut) === 'annule' ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </div>

                    <!-- Section Médias existants -->
                    @if($evenement->medias->count() > 0)
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Médias existants</h3>
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0<!-- Fin de resources/views/evenements/edit.blade.php -->
                                            2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                    <form action="{{ route('evenements.deleteMedia', ['evenement' => $evenement->id, 'media' => $media->id]) }}" 
                                          method="POST" 
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-white hover:text-red-500 transition-colors"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce média ?')">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    @endif

                    <!-- Ajout de nouveaux médias -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Ajouter de nouveaux médias</h3>
                        <input type="file" name="medias[]" multiple
                               class="mt-1 block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-[#0d9488] file:text-white
                                      hover:file:bg-red-900">
                        <p class="mt-1 text-sm text-gray-500">Vous pouvez sélectionner plusieurs fichiers</p>
                    </div>

                    <div class="flex justify-end pt-5 border-t">
                        <button type="button" 
                                onclick="window.history.back()"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
                            Annuler
                        </button>
                        <button type="submit"
                                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#0d9488] hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
                            Mettre à jour l'événement
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection