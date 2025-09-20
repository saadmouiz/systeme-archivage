@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-900">Nouveau Dossier Bénéficiaire</h2>
                <a href="{{ route('archives.beneficiaires.index') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour à la liste
                </a>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mx-6 mt-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Il y a {{ $errors->count() }} erreur(s) dans votre formulaire :
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('archives.beneficiaires.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-md font-medium text-gray-700 mb-4">Informations principales</h3>
                    
                    <!-- Type de dossier -->
                    <div class="mb-5">
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type de dossier <span class="text-red-500">*</span></label>
                        <select name="type" id="type" 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                required>
                            <option value="">Sélectionnez un type</option>
                            @foreach($types as $value => $label)
                                <option value="{{ $value }}" {{ old('type') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom') }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                required>
                            @error('nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Prénom -->
                        <div>
                            <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom <span class="text-red-500">*</span></label>
                            <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                required>
                            @error('prenom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- CIN et Age -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-5">
                        <div>
                            <label for="cin" class="block text-sm font-medium text-gray-700 mb-1">CIN</label>
                            <input type="text" name="cin" id="cin" value="{{ old('cin') }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                            @error('cin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Age -->
                        <div>
                            <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                            <input type="number" name="age" id="age" value="{{ old('age') }}" min="1" max="120"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                            @error('age')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Niveau et Spécialité (conditionnel pour Dossier individuel) -->
                <div id="niveau_div" class="bg-gray-50 p-4 rounded-lg border border-gray-200 hidden">
                    <h3 class="text-md font-medium text-gray-700 mb-4">Informations académiques</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Niveau -->
                        <div>
                            <label for="niveau" class="block text-sm font-medium text-gray-700 mb-1">Niveau <span class="text-red-500">*</span></label>
                            <select name="niveau" id="niveau" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                                <option value="">Sélectionnez un niveau</option>
                                @foreach($niveaux as $value => $label)
                                    <option value="{{ $value }}" {{ old('niveau') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('niveau')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Spécialité -->
                        <div>
                            <label for="specialite" class="block text-sm font-medium text-gray-700 mb-1">Spécialité <span class="text-red-500">*</span></label>
                            <input type="text" name="specialite" id="specialite" value="{{ old('specialite') }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                            @error('specialite')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Genre et Type d'intervention -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <!-- Genre -->
                        <div>
                            <label for="genre_individuel" class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
                            <select name="genre" id="genre_individuel" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                                <option value="">Sélectionnez un genre</option>
                                <option value="Homme" {{ old('genre') === 'Homme' ? 'selected' : '' }}>Homme</option>
                                <option value="Femme" {{ old('genre') === 'Femme' ? 'selected' : '' }}>Femme</option>
                            </select>
                            @error('genre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type d'intervention -->
                        <div>
                            <label for="type_intervention" class="block text-sm font-medium text-gray-700 mb-1">Type d'intervention</label>
                            <select name="type_intervention" id="type_intervention" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                                <option value="">Sélectionnez un type d'intervention</option>
                                <option value="IP" {{ old('type_intervention') === 'IP' ? 'selected' : '' }}>IP</option>
                                <option value="AGR" {{ old('type_intervention') === 'AGR' ? 'selected' : '' }}>AGR</option>
                            </select>
                            @error('type_intervention')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- École (conditionnel) -->
                <div id="ecole_div" class="bg-gray-50 p-4 rounded-lg border border-gray-200 hidden">
                    <h3 class="text-md font-medium text-gray-700 mb-4">Informations éducatives</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Genre -->
                        <div>
                            <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Genre <span class="text-red-500">*</span></label>
                            <select name="genre" id="genre" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                                <option value="">Sélectionnez un genre</option>
                                <option value="Homme" {{ old('genre') === 'Homme' ? 'selected' : '' }}>Homme</option>
                                <option value="Femme" {{ old('genre') === 'Femme' ? 'selected' : '' }}>Femme</option>
                            </select>
                            @error('genre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                            <select name="status" id="status" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                                <option value="">Sélectionnez un status</option>
                                <option value="Accepter" {{ old('status') === 'Accepter' ? 'selected' : '' }}>Accepter</option>
                                <option value="Refuser" {{ old('status') === 'Refuser' ? 'selected' : '' }}>Refuser</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ass/Eps -->
                        <div>
                            <label for="ass_eps" class="block text-sm font-medium text-gray-700 mb-1">Ass/Eps <span class="text-red-500">*</span></label>
                            <select name="ass_eps" id="ass_eps" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                                <option value="">Sélectionnez un type</option>
                                <option value="Association" {{ old('ass_eps') === 'Association' ? 'selected' : '' }}>Association</option>
                                <option value="Eps" {{ old('ass_eps') === 'Eps' ? 'selected' : '' }}>Eps</option>
                            </select>
                            @error('ass_eps')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- École -->
                    <div class="mt-6">
                        <label for="ecole_id" class="block text-sm font-medium text-gray-700 mb-1">École <span class="text-red-500">*</span></label>
                        <select name="ecole_id" id="ecole_id" 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                            <option value="">Sélectionnez une école</option>
                            @foreach($ecoles as $ecole)
                                <option value="{{ $ecole->id }}" {{ old('ecole_id') == $ecole->id ? 'selected' : '' }}>
                                    {{ $ecole->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('ecole_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-md font-medium text-gray-700 mb-4">Détails supplémentaires</h3>
                    
                    <!-- Société -->
                    <div class="mb-5">
                        <label for="societe" class="block text-sm font-medium text-gray-700 mb-1">Société</label>
                        <input type="text" name="societe" id="societe" value="{{ old('societe') }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                            placeholder="Nom de la société">
                        @error('societe')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Fichier -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-md font-medium text-gray-700 mb-4">Document <span class="text-red-500">*</span></h3>
                    
                    <div class="flex justify-center">
                        <div class="w-full">
                            <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-100 transition-all duration-200">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="fichier"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500 px-3 py-1 border border-gray-300">
                                            <span>Téléverser un fichier</span>
                                            <input id="fichier" name="fichier" type="file" class="sr-only" required>
                                        </label>
                                        <p class="pl-1 flex items-center">ou glisser-déposer</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, DOC, DOCX, JPG, JPEG, PNG jusqu'à 10MB</p>
                                    <p id="file-selected" class="text-sm text-green-600 font-medium hidden mt-2"></p>
                                </div>
                            </div>
                            @error('fichier')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6 flex justify-end space-x-3">
                    <a href="{{ route('archives.beneficiaires.index') }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                        Créer le dossier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de l'affichage des champs conditionnels
    const typeSelect = document.getElementById('type');
    const ecoleDiv = document.getElementById('ecole_div');
    const niveauDiv = document.getElementById('niveau_div');
    
    function toggleConditionalFields() {
        if (typeSelect.value === 'Document éducatif') {
            ecoleDiv.classList.remove('hidden');
            niveauDiv.classList.add('hidden');
            
            // Champs requis pour Document éducatif
            document.getElementById('ecole_id').setAttribute('required', 'required');
            const genreEducatif = document.getElementById('genre');
            if (genreEducatif) genreEducatif.setAttribute('required', 'required');
            document.getElementById('status').setAttribute('required', 'required');
            document.getElementById('ass_eps').setAttribute('required', 'required');
            
            // Champs non requis pour Document éducatif
            document.getElementById('niveau').removeAttribute('required');
            document.getElementById('specialite').removeAttribute('required');
            const genreIndividuel = document.getElementById('genre_individuel');
            if (genreIndividuel) genreIndividuel.removeAttribute('required');
        } else if (typeSelect.value === 'Dossier individuel') {
            ecoleDiv.classList.add('hidden');
            niveauDiv.classList.remove('hidden');
            
            // Champs requis pour Dossier individuel
            document.getElementById('niveau').setAttribute('required', 'required');
            document.getElementById('specialite').setAttribute('required', 'required');
            
            // Champs non requis pour Dossier individuel
            document.getElementById('ecole_id').removeAttribute('required');
            const genreEducatif = document.getElementById('genre');
            if (genreEducatif) genreEducatif.removeAttribute('required');
            document.getElementById('status').removeAttribute('required');
            document.getElementById('ass_eps').removeAttribute('required');
            // Le genre pour dossier individuel est optionnel
        } else {
            ecoleDiv.classList.add('hidden');
            niveauDiv.classList.add('hidden');
            
            // Aucun champ requis
            document.getElementById('ecole_id').removeAttribute('required');
            const genreEducatif = document.getElementById('genre');
            if (genreEducatif) genreEducatif.removeAttribute('required');
            document.getElementById('status').removeAttribute('required');
            document.getElementById('ass_eps').removeAttribute('required');
            document.getElementById('niveau').removeAttribute('required');
            document.getElementById('specialite').removeAttribute('required');
            // Tous les champs genre sont optionnels pour les autres types
        }
    }
    
    typeSelect.addEventListener('change', toggleConditionalFields);
    
    // Exécuter au chargement pour gérer le cas où le type est déjà sélectionné
    toggleConditionalFields();
    
    // Afficher le nom du fichier sélectionné
    const fileInput = document.getElementById('fichier');
    const fileSelected = document.getElementById('file-selected');
    
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            fileSelected.textContent = 'Fichier sélectionné: ' + this.files[0].name;
            fileSelected.classList.remove('hidden');
        } else {
            fileSelected.classList.add('hidden');
        }
    });
});
</script>
@endsection