@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier le Dossier Bénéficiaire</h1>

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

                <form action="{{ route('archives.beneficiaires.update', $beneficiaire) }}" 
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
                                   value="{{ old('nom', $beneficiaire->nom) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                   required>
                        </div>

                        <div>
                            <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                            <input type="text" 
                                   name="prenom" 
                                   id="prenom" 
                                   value="{{ old('prenom', $beneficiaire->prenom) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                   required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="cin" class="block text-sm font-medium text-gray-700">CIN</label>
                            <input type="text" 
                                   name="cin" 
                                   id="cin" 
                                   value="{{ old('cin', $beneficiaire->cin) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                            <input type="number" 
                                   name="age" 
                                   id="age" 
                                   value="{{ old('age', $beneficiaire->age) }}" 
                                   min="1" 
                                   max="120"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Champs conditionnels pour Dossier individuel -->
                    <div id="niveau_fields" class="grid grid-cols-1 md:grid-cols-2 gap-6" style="display: none;">
                        <div>
                            <label for="niveau" class="block text-sm font-medium text-gray-700">Niveau</label>
                            <select name="niveau" 
                                    id="niveau" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md">
                                <option value="">Sélectionnez un niveau</option>
                                @foreach($niveaux as $value => $label)
                                    <option value="{{ $value }}" {{ old('niveau', $beneficiaire->niveau) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="specialite" class="block text-sm font-medium text-gray-700">Spécialité</label>
                            <input type="text" 
                                   name="specialite" 
                                   id="specialite" 
                                   value="{{ old('specialite', $beneficiaire->specialite) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Champs supplémentaires pour Dossier individuel -->
                    <div id="genre_type_intervention_fields" class="grid grid-cols-1 md:grid-cols-2 gap-6" style="display: none;">
                        <div>
                            <label for="genre_individuel" class="block text-sm font-medium text-gray-700">Genre</label>
                            <select name="genre" 
                                    id="genre_individuel" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md">
                                <option value="">Sélectionnez un genre</option>
                                <option value="Homme" {{ old('genre', $beneficiaire->genre) == 'Homme' ? 'selected' : '' }}>Homme</option>
                                <option value="Femme" {{ old('genre', $beneficiaire->genre) == 'Femme' ? 'selected' : '' }}>Femme</option>
                            </select>
                        </div>

                        <div>
                            <label for="type_intervention" class="block text-sm font-medium text-gray-700">Type d'intervention</label>
                            <select name="type_intervention" 
                                    id="type_intervention" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md">
                                <option value="">Sélectionnez un type d'intervention</option>
                                <option value="IP" {{ old('type_intervention', $beneficiaire->type_intervention) == 'IP' ? 'selected' : '' }}>IP</option>
                                <option value="AGR" {{ old('type_intervention', $beneficiaire->type_intervention) == 'AGR' ? 'selected' : '' }}>AGR</option>
                            </select>
                        </div>
                    </div>

                    <!-- Champs conditionnels pour Document éducatif -->
                    <div id="educatif_fields" class="grid grid-cols-1 md:grid-cols-2 gap-6" style="display: none;">
                        <div>
                            <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
                            <select name="genre" 
                                    id="genre" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md">
                                <option value="">Sélectionnez un genre</option>
                                <option value="Homme" {{ old('genre', $beneficiaire->genre) == 'Homme' ? 'selected' : '' }}>Homme</option>
                                <option value="Femme" {{ old('genre', $beneficiaire->genre) == 'Femme' ? 'selected' : '' }}>Femme</option>
                            </select>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" 
                                    id="status" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md">
                                <option value="">Sélectionnez un status</option>
                                <option value="Accepter" {{ old('status', $beneficiaire->status) == 'Accepter' ? 'selected' : '' }}>Accepter</option>
                                <option value="Refuser" {{ old('status', $beneficiaire->status) == 'Refuser' ? 'selected' : '' }}>Refuser</option>
                            </select>
                        </div>

                        <div>
                            <label for="ass_eps" class="block text-sm font-medium text-gray-700">Ass/Eps</label>
                            <select name="ass_eps" 
                                    id="ass_eps" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md">
                                <option value="">Sélectionnez un type</option>
                                <option value="Association" {{ old('ass_eps', $beneficiaire->ass_eps) == 'Association' ? 'selected' : '' }}>Association</option>
                                <option value="Eps" {{ old('ass_eps', $beneficiaire->ass_eps) == 'Eps' ? 'selected' : '' }}>Eps</option>
                            </select>
                        </div>

                        <div>
                            <label for="ecole_id" class="block text-sm font-medium text-gray-700">École</label>
                            <select name="ecole_id" 
                                    id="ecole_id" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md">
                                <option value="">Sélectionnez une école</option>
                                @foreach($ecoles as $id => $nom)
                                    <option value="{{ $id }}" {{ old('ecole_id', $beneficiaire->ecole_id) == $id ? 'selected' : '' }}>{{ $nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Type de document</label>
                        <select name="type" 
                                id="type" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md" 
                                required>
                            @foreach($types as $value => $label)
                                <option value="{{ $value }}" {{ old('type', $beneficiaire->type) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="societe" class="block text-sm font-medium text-gray-700">Société</label>
                        <input type="text" 
                               name="societe" 
                               id="societe" 
                               value="{{ old('societe', $beneficiaire->societe) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Nom de la société">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $beneficiaire->description) }}</textarea>
                    </div>

                    <!-- Fichier actuel -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fichier actuel</label>
                        <div class="mt-1 flex items-center">
                            <span class="text-sm text-gray-500">{{ basename($beneficiaire->fichier) }}</span>
                            <a href="{{ Storage::url($beneficiaire->fichier) }}" 
                               class="ml-2 text-sm text-blue-600 hover:text-blue-500"
                               target="_blank">
                                Voir le fichier
                            </a>
                        </div>
                    </div>

                    <!-- Nouveau fichier -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nouveau fichier (optionnel)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" 
                                          stroke-width="2" 
                                          stroke-linecap="round" 
                                          stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="fichier" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 hover:underline">
                                        <span>Téléverser un nouveau fichier</span>
                                        <input id="fichier" 
                                               name="fichier" 
                                               type="file" 
                                               class="sr-only">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX, JPG, JPEG, PNG jusqu'à 10MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('archives.beneficiaires.index') }}" 
                           class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const educatifFields = document.getElementById('educatif_fields');
    const niveauFields = document.getElementById('niveau_fields');
    
    function toggleConditionalFields() {
        const genreTypeInterventionFields = document.getElementById('genre_type_intervention_fields');
        
        if (typeSelect.value === 'Document éducatif') {
            educatifFields.style.display = 'grid';
            niveauFields.style.display = 'none';
            genreTypeInterventionFields.style.display = 'none';
            
            // Champs requis pour Document éducatif
            document.getElementById('genre').setAttribute('required', 'required');
            document.getElementById('status').setAttribute('required', 'required');
            document.getElementById('ass_eps').setAttribute('required', 'required');
            document.getElementById('ecole_id').setAttribute('required', 'required');
            
            // Champs non requis pour Document éducatif
            document.getElementById('niveau').removeAttribute('required');
            document.getElementById('specialite').removeAttribute('required');
        } else if (typeSelect.value === 'Dossier individuel') {
            educatifFields.style.display = 'none';
            niveauFields.style.display = 'grid';
            genreTypeInterventionFields.style.display = 'grid';
            
            // Champs requis pour Dossier individuel
            document.getElementById('niveau').setAttribute('required', 'required');
            document.getElementById('specialite').setAttribute('required', 'required');
            
            // Champs non requis pour Dossier individuel
            document.getElementById('genre').removeAttribute('required');
            document.getElementById('status').removeAttribute('required');
            document.getElementById('ass_eps').removeAttribute('required');
            document.getElementById('ecole_id').removeAttribute('required');
        } else {
            educatifFields.style.display = 'none';
            niveauFields.style.display = 'none';
            genreTypeInterventionFields.style.display = 'none';
            
            // Aucun champ requis
            document.getElementById('genre').removeAttribute('required');
            document.getElementById('status').removeAttribute('required');
            document.getElementById('ass_eps').removeAttribute('required');
            document.getElementById('ecole_id').removeAttribute('required');
            document.getElementById('niveau').removeAttribute('required');
            document.getElementById('specialite').removeAttribute('required');
        }
    }
    
    typeSelect.addEventListener('change', toggleConditionalFields);
    
    // Exécuter au chargement pour gérer le cas où le type est déjà sélectionné
    toggleConditionalFields();
});
</script>