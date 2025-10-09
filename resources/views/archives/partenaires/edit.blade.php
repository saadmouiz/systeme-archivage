@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier le Partenaire</h1>

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

                <form action="{{ route('archives.partenaires.update', $partenaire) }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" 
                                   name="nom" 
                                   id="nom" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900"
                                   value="{{ old('nom', $partenaire->nom) }}" 
                                   required>
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="type" 
                                    id="type" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900"
                                    required>
                                @foreach($types as $key => $value)
                                    <option value="{{ $key }}" {{ old('type', $partenaire->type) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900"
                                   value="{{ old('email', $partenaire->email) }}">
                        </div>

                        <div>
                            <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="text" 
                                   name="telephone" 
                                   id="telephone" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900"
                                   value="{{ old('telephone', $partenaire->telephone) }}">
                        </div>
                    </div>

                    <div>
                        <label for="statut_partenariat" class="block text-sm font-medium text-gray-700">Statut</label>
                        <select name="statut_partenariat" 
                                id="statut_partenariat" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900"
                                required>
                            <option value="">Sélectionnez un statut</option>
                            @foreach($statuts as $key => $value)
                                <option value="{{ $key }}" {{ old('statut_partenariat',$partenaire->statut_partenariat) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Les autres champs restent les mêmes que dans create.blade.php mais avec value="{{ old('field', $partenaire->field) }}" -->

                    <!-- Section fichier actuel -->
                    @if($partenaire->fichier)
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Document actuel</label>
                            <div class="mt-1 flex items-center">
                                <span class="text-sm text-gray-500">{{ basename($partenaire->fichier) }}</span>
                                <a href="{{ Storage::url($partenaire->fichier) }}" 
                                   class="ml-2 text-sm text-red-900 hover:text-red-900"
                                   target="_blank">
                                    Voir le document
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Nouveau fichier -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nouveau document (optionnel)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" 
                                          stroke-width="2" 
                                          stroke-linecap="round" 
                                          stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="fichier" class="relative cursor-pointer bg-white rounded-md font-medium text-red-900 hover:text-red-900">
                                        <span>Téléverser un nouveau fichier</span>
                                        <input id="fichier" name="fichier" type="file" class="sr-only">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX jusqu'à 10MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('archives.partenaires.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-900 hover:bg-red-800">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection