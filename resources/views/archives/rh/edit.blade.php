@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier le Document RH</h1>

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <ul class="text-sm text-red-600">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('archives.rh.update', $rh) }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="titre" class="block text-base font-medium text-gray-700 mb-2">Titre</label>
                            <input type="text" 
                                   name="titre" 
                                   id="titre" 
                                   class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900"
                                   value="{{ old('titre', $rh->titre) }}" 
                                   required>
                        </div>

                        <div>
                            <label for="type" class="block text-base font-medium text-gray-700 mb-2">Type de document</label>
                            <select name="type" 
                                    id="type" 
                                    class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900"
                                    required>
                                @foreach($types as $key => $value)
                                    <option value="{{ $key }}" {{ old('type', $rh->type) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="employe_nom" class="block text-base font-medium text-gray-700 mb-2">Nom de l'employé</label>
                        <input type="text" 
                               name="employe_nom" 
                               id="employe_nom" 
                               class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900"
                               value="{{ old('employe_nom', $rh->employe_nom) }}">
                    </div>

                    <div>
                        <label for="date_document" class="block text-base font-medium text-gray-700 mb-2">Date du document</label>
                        <input type="date" 
                               name="date_document" 
                               id="date_document" 
                               class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900"
                               value="{{ old('date_document', $rh->date_document->format('Y-m-d')) }}"
                               required>
                    </div>

                    <div>
                        <label for="statut" class="block text-base font-medium text-gray-700 mb-2">Statut</label>
                        <select name="statut" 
                                id="statut" 
                                class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900"
                                required>
                            @foreach($statuts as $key => $value)
                                <option value="{{ $key }}" {{ old('statut', $rh->statut) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="description" class="block text-base font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="6" 
                                  class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900">{{ old('description', $rh->description) }}</textarea>
                    </div>

                    <!-- Fichier actuel -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Document actuel</label>
                        <div class="mt-1 flex items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-base text-gray-700">{{ basename($rh->fichier) }}</span>
                            <a href="{{ Storage::url($rh->fichier) }}" 
                               class="ml-3 text-base text-red-900 hover:text-red-900 font-medium"
                               target="_blank">
                                Voir le document
                            </a>
                        </div>
                    </div>

                    <!-- Nouveau fichier -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Nouveau document (optionnel)</label>
                        <div class="mt-1 flex justify-center px-8 pt-8 pb-8 border-2 border-gray-300 border-dashed rounded-lg">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-16 w-16 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" 
                                          stroke-width="2" 
                                          stroke-linecap="round" 
                                          stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-base text-gray-600">
                                    <label for="fichier" class="relative cursor-pointer bg-white rounded-lg font-medium text-red-900 hover:text-red-900 hover:underline px-4 py-2">
                                        <span>Téléverser un nouveau fichier</span>
                                        <input id="fichier" name="fichier" type="file" class="sr-only">
                                    </label>
                                </div>
                                <p class="text-sm text-gray-500">PDF, DOC, DOCX, JPG, PNG jusqu'à 10MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('archives.rh.index') }}" 
                           class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-lg text-gray-700 bg-gray-100 hover:bg-gray-200">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-lg text-white bg-red-900 hover:bg-red-800">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection