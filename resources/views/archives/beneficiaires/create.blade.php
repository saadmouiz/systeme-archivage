@extends('layouts.sidebar')

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

            @if(session('duplicate_warning'))
                <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mx-6 mt-4">
                    <p class="text-sm font-medium text-amber-900">{{ session('duplicate_warning') }}</p>
                    @if(session('duplicate_id'))
                        <div class="mt-3 flex flex-wrap gap-2">
                            <a href="{{ route('archives.beneficiaires.show', session('duplicate_id')) }}"
                               class="inline-flex items-center px-3 py-1.5 text-sm bg-amber-600 text-white rounded-lg hover:bg-amber-700">
                                Consulter le dossier existant
                            </a>
                            <a href="{{ route('archives.beneficiaires.edit', session('duplicate_id')) }}"
                               class="inline-flex items-center px-3 py-1.5 text-sm bg-white border border-amber-600 text-amber-800 rounded-lg hover:bg-amber-50">
                                Ajouter une mise à jour / document
                            </a>
                        </div>
                    @endif
                </div>
            @endif

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

                    <!-- Reference -->
                    <div class="mb-5">
                        <label for="reference" class="block text-sm font-medium text-gray-700 mb-1">Référence</label>
                        <input type="text" name="reference" id="reference" value="{{ old('reference') }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                            placeholder="Référence du dossier">
                        @error('reference')
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

                    <!-- Ville -->
                    <div class="mt-5">
                        <label for="ville" class="block text-sm font-medium text-gray-700 mb-1">Ville <span class="text-red-500">*</span></label>
                        <input type="text" name="ville" id="ville" value="{{ old('ville') }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                            required>
                        @error('ville')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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

                    <div id="cin-duplicate-alert" class="mt-4 hidden bg-amber-50 border border-amber-300 rounded-lg p-4">
                        <p id="cin-duplicate-message" class="text-sm text-amber-900 font-medium"></p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <a id="cin-duplicate-show" href="#" class="inline-flex items-center px-3 py-1.5 text-sm bg-amber-600 text-white rounded-lg hover:bg-amber-700">Consulter le dossier existant</a>
                            <a id="cin-duplicate-edit" href="#" class="inline-flex items-center px-3 py-1.5 text-sm bg-white border border-amber-600 text-amber-800 rounded-lg hover:bg-amber-50">Ajouter une mise à jour / document</a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-5">
                        <div>
                            <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-1">Date de naissance</label>
                            <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                            @error('date_naissance')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
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
                    </div>

                    <!-- Situation sociale -->
                    <div class="mt-5">
                        <label for="situation_sociale" class="block text-sm font-medium text-gray-700 mb-1">Situation sociale / Profil de vulnérabilité <span class="text-red-500">*</span></label>
                        <select name="situation_sociale" id="situation_sociale" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                            <option value="">Sélectionnez une situation</option>
                            @foreach(($situationsSociales ?? []) as $value => $label)
                                <option value="{{ $value }}" {{ old('situation_sociale') === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('situation_sociale')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div id="situation_sociale_precision_div" class="mt-4 {{ old('situation_sociale') === 'autre' ? '' : 'hidden' }}">
                        <label for="situation_sociale_precision" class="block text-sm font-medium text-gray-700 mb-1">Précision de la situation <span class="text-red-500">*</span></label>
                        <input type="text" name="situation_sociale_precision" id="situation_sociale_precision" value="{{ old('situation_sociale_precision') }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                            placeholder="Précisez la situation de vulnérabilité">
                        @error('situation_sociale_precision')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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

                    <!-- Type d'intervention -->
                    <div class="mt-6">
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

                <!-- École (conditionnel) -->
                <div id="ecole_div" class="bg-gray-50 p-4 rounded-lg border border-gray-200 hidden">
                    <h3 class="text-md font-medium text-gray-700 mb-4">Informations éducatives</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                    <!-- Nom d'association -->
                    <div id="nom_association_div" class="mt-6 {{ old('ass_eps') === 'Association' ? '' : 'hidden' }}">
                        <label for="nom_association" class="block text-sm font-medium text-gray-700 mb-1">Nom de l'association</label>
                        <input type="text" name="nom_association" id="nom_association" value="{{ old('nom_association') }}"
                            placeholder="Ex: Association Initiative Al Amal"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        @error('nom_association')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- École/Centre -->
                    <div class="mt-6">
                        <label for="ecole_id" class="block text-sm font-medium text-gray-700 mb-1">École/Centre <span class="text-red-500">*</span></label>
                        <select name="ecole_id" id="ecole_id" 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                            <option value="">Sélectionnez une école ou un centre</option>
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

                    <!-- Filière -->
                    <div class="mt-6">
                        <label for="filiere" class="block text-sm font-medium text-gray-700 mb-1">Filière <span class="text-red-500">*</span></label>
                        <input type="text" name="filiere" id="filiere" value="{{ old('filiere') }}"
                            placeholder="Ex: Informatique, Comptabilité, Marketing, etc."
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        @error('filiere')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Conflits d'ordre juridique (conditionnel) -->
                <div id="conflits_div" class="bg-gray-50 p-4 rounded-lg border border-gray-200 hidden">
                    <h3 class="text-md font-medium text-gray-700 mb-4">Informations juridiques</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Niveau scolarité -->
                        <div>
                            <label for="niveau_scolarite" class="block text-sm font-medium text-gray-700 mb-1">Niveau scolarité</label>
                            <select name="niveau_scolarite" id="niveau_scolarite" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                                <option value="">Sélectionnez un niveau</option>
                                <option value="Analphabète" {{ old('niveau_scolarite') === 'Analphabète' ? 'selected' : '' }}>Analphabète</option>
                                <option value="Primaire" {{ old('niveau_scolarite') === 'Primaire' ? 'selected' : '' }}>Primaire</option>
                                <option value="Collège" {{ old('niveau_scolarite') === 'Collège' ? 'selected' : '' }}>Collège</option>
                                <option value="Lycée" {{ old('niveau_scolarite') === 'Lycée' ? 'selected' : '' }}>Lycée</option>
                                <option value="Baccalauréat" {{ old('niveau_scolarite') === 'Baccalauréat' ? 'selected' : '' }}>Baccalauréat</option>
                                <option value="Bac+2" {{ old('niveau_scolarite') === 'Bac+2' ? 'selected' : '' }}>Bac+2</option>
                                <option value="Bac+3" {{ old('niveau_scolarite') === 'Bac+3' ? 'selected' : '' }}>Bac+3</option>
                                <option value="Bac+4" {{ old('niveau_scolarite') === 'Bac+4' ? 'selected' : '' }}>Bac+4</option>
                                <option value="Bac+5" {{ old('niveau_scolarite') === 'Bac+5' ? 'selected' : '' }}>Bac+5</option>
                                <option value="Supérieur" {{ old('niveau_scolarite') === 'Supérieur' ? 'selected' : '' }}>Supérieur</option>
                            </select>
                            @error('niveau_scolarite')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Services offerts aux bénéficiaires -->
                        <div>
                            <label for="services_offerts" class="block text-sm font-medium text-gray-700 mb-1">Services offerts aux bénéficiaires</label>
                            <select name="services_offerts" id="services_offerts" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition-all durée-200">
                                <option value="">Sélectionnez un service</option>
                                <option value="Prise en charge des situations difficiles" {{ old('services_offerts') === 'Prise en charge des situations difficiles' ? 'selected' : '' }}>
                                    Prise en charge des situations difficiles
                                </option>
                                <option value="Situation sociale" {{ old('services_offerts') === 'Situation sociale' ? 'selected' : '' }}>
                                    Situation sociale
                                </option>
                            </select>
                            @error('services_offerts')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-md font-medium text-gray-700 mb-4">Détails supplémentaires</h3>
                    
                    <!-- Société (uniquement pour Dossier individuel) -->
                    <div class="mb-5" id="societe_div">
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
    const societeDiv = document.getElementById('societe_div');
    const conflitsDiv = document.getElementById('conflits_div');
    
    function toggleConditionalFields() {
        const niveauSelect = document.getElementById('niveau');
        const niveauBacOption = niveauSelect.querySelector('option[value="Niveau Bac"]');
        const bacOption = niveauSelect.querySelector('option[value="Bac"]');
        
        if (typeSelect.value === 'Document éducatif') {
            ecoleDiv.classList.remove('hidden');
            niveauDiv.classList.add('hidden');
            societeDiv.classList.add('hidden');
            conflitsDiv.classList.add('hidden');
            
            // Champs requis pour Document éducatif
            document.getElementById('ecole_id').setAttribute('required', 'required');
            document.getElementById('genre').setAttribute('required', 'required');
            document.getElementById('status').setAttribute('required', 'required');
            document.getElementById('ass_eps').setAttribute('required', 'required');
            
            // Champs non requis pour Document éducatif
            document.getElementById('niveau').removeAttribute('required');
            document.getElementById('specialite').removeAttribute('required');
            document.getElementById('societe').removeAttribute('required');
            
            // Supprimer les options "Niveau Bac" et "Bac" si elles existent
            // Réinitialiser la sélection si l'une de ces options était sélectionnée
            if (niveauSelect.value === 'Niveau Bac' || niveauSelect.value === 'Bac') {
                niveauSelect.value = '';
            }
            if (niveauBacOption) {
                niveauBacOption.remove();
            }
            if (bacOption) {
                bacOption.remove();
            }
        } else if (typeSelect.value === 'Dossier individuel') {
            ecoleDiv.classList.add('hidden');
            niveauDiv.classList.remove('hidden');
            societeDiv.classList.remove('hidden');
            conflitsDiv.classList.add('hidden');
            
            // Champs requis pour Dossier individuel
            document.getElementById('niveau').setAttribute('required', 'required');
            document.getElementById('specialite').setAttribute('required', 'required');
            
            // Champs non requis pour Dossier individuel
            document.getElementById('ecole_id').removeAttribute('required');
            document.getElementById('status').removeAttribute('required');
            document.getElementById('ass_eps').removeAttribute('required');
            // Le genre pour dossier individuel est optionnel
            document.getElementById('genre').removeAttribute('required');
            
            // Ajouter les options "Niveau Bac" et "Bac" si elles n'existent pas déjà
            if (!niveauBacOption) {
                const optionNiveauBac = document.createElement('option');
                optionNiveauBac.value = 'Niveau Bac';
                optionNiveauBac.textContent = 'Niveau Bac';
                // Insérer après "2ème année bac"
                const deuxiemeAnneeBac = niveauSelect.querySelector('option[value="2ème année bac"]');
                if (deuxiemeAnneeBac && deuxiemeAnneeBac.nextSibling) {
                    niveauSelect.insertBefore(optionNiveauBac, deuxiemeAnneeBac.nextSibling);
                } else {
                    niveauSelect.appendChild(optionNiveauBac);
                }
            }
            if (!bacOption) {
                const optionBac = document.createElement('option');
                optionBac.value = 'Bac';
                optionBac.textContent = 'Bac';
                // Insérer après "Niveau Bac"
                const niveauBac = niveauSelect.querySelector('option[value="Niveau Bac"]');
                if (niveauBac && niveauBac.nextSibling) {
                    niveauSelect.insertBefore(optionBac, niveauBac.nextSibling);
                } else {
                    niveauSelect.appendChild(optionBac);
                }
            }
        } else if (typeSelect.value === 'Conflits d\'ordre juridique') {
            ecoleDiv.classList.add('hidden');
            niveauDiv.classList.add('hidden');
            societeDiv.classList.add('hidden');
            conflitsDiv.classList.remove('hidden');
            
            // Champs non requis pour Conflits d'ordre juridique
            document.getElementById('ecole_id').removeAttribute('required');
            document.getElementById('status').removeAttribute('required');
            document.getElementById('ass_eps').removeAttribute('required');
            document.getElementById('niveau').removeAttribute('required');
            document.getElementById('specialite').removeAttribute('required');
            document.getElementById('genre').removeAttribute('required');
            document.getElementById('societe').removeAttribute('required');
            
            // Supprimer les options "Niveau Bac" et "Bac" si elles existent
            if (niveauSelect.value === 'Niveau Bac' || niveauSelect.value === 'Bac') {
                niveauSelect.value = '';
            }
            if (niveauBacOption) {
                niveauBacOption.remove();
            }
            if (bacOption) {
                bacOption.remove();
            }
        } else {
            ecoleDiv.classList.add('hidden');
            niveauDiv.classList.add('hidden');
            societeDiv.classList.add('hidden');
            conflitsDiv.classList.add('hidden');
            
            // Aucun champ requis
            document.getElementById('ecole_id').removeAttribute('required');
            document.getElementById('status').removeAttribute('required');
            document.getElementById('ass_eps').removeAttribute('required');
            document.getElementById('niveau').removeAttribute('required');
            document.getElementById('specialite').removeAttribute('required');
            document.getElementById('genre').removeAttribute('required');
            // Tous les champs genre sont optionnels pour les autres types
            
            // Supprimer les options "Niveau Bac" et "Bac" si elles existent
            // Réinitialiser la sélection si l'une de ces options était sélectionnée
            if (niveauSelect.value === 'Niveau Bac' || niveauSelect.value === 'Bac') {
                niveauSelect.value = '';
            }
            if (niveauBacOption) {
                niveauBacOption.remove();
            }
            if (bacOption) {
                bacOption.remove();
            }
        }
    }
    
    typeSelect.addEventListener('change', toggleConditionalFields);
    
    // Exécuter au chargement pour gérer le cas où le type est déjà sélectionné
    toggleConditionalFields();

    const assEpsSelect = document.getElementById('ass_eps');
    const nomAssociationDiv = document.getElementById('nom_association_div');

    function toggleNomAssociation() {
        if (!assEpsSelect || !nomAssociationDiv) return;
        if (assEpsSelect.value === 'Association') {
            nomAssociationDiv.classList.remove('hidden');
        } else {
            nomAssociationDiv.classList.add('hidden');
            const input = document.getElementById('nom_association');
            if (input) input.value = '';
        }
    }

    if (assEpsSelect) {
        assEpsSelect.addEventListener('change', toggleNomAssociation);
        toggleNomAssociation();
    }

    const situationSelect = document.getElementById('situation_sociale');
    const situationPrecisionDiv = document.getElementById('situation_sociale_precision_div');
    function toggleSituationPrecision() {
        if (!situationSelect || !situationPrecisionDiv) return;
        const isAutre = situationSelect.value === 'autre';
        situationPrecisionDiv.classList.toggle('hidden', !isAutre);
        const precision = document.getElementById('situation_sociale_precision');
        if (precision) {
            if (isAutre) precision.setAttribute('required', 'required');
            else { precision.removeAttribute('required'); precision.value = ''; }
        }
    }
    if (situationSelect) {
        situationSelect.addEventListener('change', toggleSituationPrecision);
        toggleSituationPrecision();
    }

    // Contrôle doublons CIN (EVO-01)
    const cinInput = document.getElementById('cin');
    const alertBox = document.getElementById('cin-duplicate-alert');
    let cinTimer = null;
    async function checkDuplicate() {
        const cin = (cinInput?.value || '').trim();
        const nom = (document.getElementById('nom')?.value || '').trim();
        const prenom = (document.getElementById('prenom')?.value || '').trim();
        const dateNaissance = document.getElementById('date_naissance')?.value || '';
        if (!cin && !(nom && prenom && dateNaissance)) {
            alertBox?.classList.add('hidden');
            return;
        }
        const params = new URLSearchParams({ cin, nom, prenom, date_naissance: dateNaissance });
        try {
            const res = await fetch(`{{ route('archives.beneficiaires.check-cin') }}?${params.toString()}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();
            if (data.exists) {
                document.getElementById('cin-duplicate-message').textContent = data.message;
                document.getElementById('cin-duplicate-show').href = data.beneficiaire.show_url;
                document.getElementById('cin-duplicate-edit').href = data.beneficiaire.edit_url;
                alertBox.classList.remove('hidden');
            } else {
                alertBox.classList.add('hidden');
            }
        } catch (e) {
            console.error(e);
        }
    }
    ['cin', 'nom', 'prenom', 'date_naissance'].forEach((id) => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('input', () => {
            clearTimeout(cinTimer);
            cinTimer = setTimeout(checkDuplicate, 400);
        });
        el.addEventListener('change', () => {
            clearTimeout(cinTimer);
            cinTimer = setTimeout(checkDuplicate, 200);
        });
    });
    
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