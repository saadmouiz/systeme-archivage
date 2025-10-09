@extends('layouts.sidebar')

@section('head')
<!-- Solution CSV native - Aucune dépendance externe nécessaire -->
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-8">Nouveau Document Financier</h1>

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

                <form action="{{ route('archives.financiers.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">Titre</label>
                            <input type="text" 
                                   name="titre" 
                                   id="titre" 
                                   class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900 transition-colors"
                                   value="{{ old('titre') }}" 
                                   required>
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type de document</label>
                            <select name="type" 
                                    id="type" 
                                    class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900 transition-colors"
                                    required>
                                <option value="">Sélectionnez un type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Champ conditionnel pour les types de journaux -->
                    <div id="journal-type-field" class="hidden">
                        <div>
                            <label for="journal_type" class="block text-sm font-medium text-gray-700 mb-2">Type de journal</label>
                            <select name="journal_type" 
                                    id="journal_type" 
                                    class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900 transition-colors">
                                <option value="">Sélectionnez un type de journal</option>
                                <option value="Journal des achats" {{ old('journal_type') == 'Journal des achats' ? 'selected' : '' }}>Journal des achats</option>
                                <option value="Journal des ventes" {{ old('journal_type') == 'Journal des ventes' ? 'selected' : '' }}>Journal des ventes</option>
                                <option value="Journal de trésorerie" {{ old('journal_type') == 'Journal de trésorerie' ? 'selected' : '' }}>Journal de trésorerie</option>
                                <option value="Journal des opérations diverses" {{ old('journal_type') == 'Journal des opérations diverses' ? 'selected' : '' }}>Journal des opérations diverses</option>
                                <option value="Journal des encaissements" {{ old('journal_type') == 'Journal des encaissements' ? 'selected' : '' }}>Journal des encaissements</option>
                                <option value="Journal des paiements en espèces" {{ old('journal_type') == 'Journal des paiements en espèces' ? 'selected' : '' }}>Journal des paiements en espèces</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="montant" class="block text-sm font-medium text-gray-700 mb-2">Montant (DH)</label>
                        <input type="number" 
                               name="montant" 
                               id="montant" 
                               step="0.01" 
                               class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900 transition-colors"
                               value="{{ old('montant') }}">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="date_document" class="block text-sm font-medium text-gray-700 mb-2">Date du document</label>
                            <input type="date" 
                                   name="date_document" 
                                   id="date_document" 
                                   class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900 transition-colors"
                                   value="{{ old('date_document') }}"
                                   required>
                        </div>

                        <div>
                            <label for="annee_financiere" class="block text-sm font-medium text-gray-700 mb-2">Année financière</label>
                            <select name="annee_financiere" 
                                    id="annee_financiere" 
                                    class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900 transition-colors"
                                    required>
                                <option value="">Sélectionnez une année</option>
                                @foreach($annees as $annee)
                                    <option value="{{ $annee }}" {{ old('annee_financiere') == $annee ? 'selected' : '' }}>
                                        {{ $annee }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                        <select name="statut" 
                                id="statut" 
                                class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900 transition-colors"
                                required>
                            <option value="">Sélectionnez un statut</option>
                            @foreach($statuts as $key => $value)
                                <option value="{{ $key }}" {{ old('statut') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="5" 
                                  class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900 transition-colors resize-none">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Document</label>
                        
                        <!-- Bouton pour ouvrir Excel directement -->
                        <div class="mb-4">
                            <button type="button" 
                                    id="open-excel-btn"
                                    class="inline-flex items-center px-4 py-2 bg-red-900 text-white rounded-md hover:bg-red-900 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Ajouter document Excel
                            </button>
                            <p class="text-xs text-gray-500 mt-1">Cliquez pour ouvrir l'éditeur Excel intégré. Éditez directement dans le navigateur et sauvegardez automatiquement.</p>
                        </div>
                        
                        <div class="mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-gray-300 border-dashed rounded-lg hover:border-red-900 transition-colors">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-16 w-16 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" 
                                          stroke-width="2" 
                                          stroke-linecap="round" 
                                          stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="fichier" class="relative cursor-pointer bg-white rounded-md font-medium text-red-900 hover:text-red-900 hover:underline">
                                        <span>Téléverser un fichier</span>
                                        <input id="fichier" 
                                               name="fichier" 
                                               type="file" 
                                               class="sr-only"
                                               accept=".pdf,.doc,.docx,.xls,.xlsx,.csv"
                                               required>
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX, XLS, XLSX, CSV jusqu'à 10MB</p>
                            </div>
                        </div>
                        
                        <!-- Zone de prévisualisation du fichier -->
                        <div id="file-preview" class="hidden mt-4 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <svg class="w-8 h-8 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900" id="file-name"></p>
                                    <p class="text-xs text-gray-500" id="file-size"></p>
                                </div>
                                <button type="button" id="remove-file" class="ml-auto text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('archives.financiers.index') }}" 
                           class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-lg text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-lg text-white bg-red-900 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900 transition-colors">
                            Créer le document
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour l'éditeur Excel -->
<div id="excel-editor-modal" class="fixed inset-0 bg-black bg-opacity-60 overflow-y-auto h-full w-full hidden z-50 backdrop-blur-sm">
    <div class="relative top-8 mx-auto p-0 w-[95%] h-[90%] shadow-2xl rounded-xl bg-white overflow-hidden">
        <!-- Header du modal -->
        <div class="bg-gradient-to-r from-slate-800 to-slate-900 text-white px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-[#FEE2E2] flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Éditeur Excel</h3>
                        <p class="text-sm text-slate-300">Créez et modifiez vos documents financiers</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button id="save-excel-btn" class="inline-flex items-center px-6 py-3 bg-red-900 text-white font-medium rounded-lg hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-900 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Enregistrer Document
                    </button>
                    <button id="new-excel-document" class="inline-flex items-center px-6 py-3 bg-red-900 text-white font-medium rounded-lg hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-900 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Nouveau Document
                    </button>
                    <button id="close-excel-editor" class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-900 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Fermer Document
                    </button>
                </div>
            </div>
        </div>
        
        <div id="excel-editor" style="height: calc(100% - 60px); overflow: auto;" class="bg-gray-50">
            <!-- Header avec toolbar -->
            <div class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-xl font-bold text-gray-900">Document Financier</h4>
                        <p class="text-sm text-gray-500 mt-1">Éditeur Excel intégré - Modifiez vos données en temps réel</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-red-900 rounded-full"></div>
                            <span>En ligne</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="bg-slate-100 border-b border-gray-300 px-6 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <button id="add-row-btn" class="inline-flex items-center px-4 py-2 bg-red-900 text-white text-sm font-medium rounded-lg hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-900 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Ajouter une ligne
                        </button>
                        <button id="add-col-btn" class="inline-flex items-center px-4 py-2 bg-red-900 text-white text-sm font-medium rounded-lg hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-900 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Ajouter une colonne
                        </button>
                        <div class="h-6 w-px bg-gray-400"></div>
                        <button id="clear-table-btn" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-900 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Effacer tout
                        </button>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-slate-700 font-medium">
                        <span id="cell-count">0 cellules</span>
                        <span class="text-slate-400">•</span>
                        <span id="row-count">0 lignes</span>
                        <span class="text-slate-400">•</span>
                        <span id="col-count">0 colonnes</span>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="flex-1 overflow-auto bg-white">
                <div class="overflow-x-auto">
                    <table id="excel-table" class="min-w-full">
                        <thead id="excel-thead" class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <!-- Les colonnes seront générées dynamiquement -->
                            </tr>
                        </thead>
                        <tbody id="excel-tbody" class="bg-white divide-y divide-gray-200">
                            <!-- Les lignes seront générées dynamiquement -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const journalTypeField = document.getElementById('journal-type-field');
    const journalTypeSelect = document.getElementById('journal_type');
    const fileInput = document.getElementById('fichier');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const removeFileBtn = document.getElementById('remove-file');

    function toggleJournalTypeField() {
        if (typeSelect.value === 'Journaux') {
            journalTypeField.classList.remove('hidden');
            journalTypeSelect.required = true;
        } else {
            journalTypeField.classList.add('hidden');
            journalTypeSelect.required = false;
            journalTypeSelect.value = '';
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function showFilePreview(file) {
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        filePreview.classList.remove('hidden');
    }

    function hideFilePreview() {
        filePreview.classList.add('hidden');
        fileInput.value = '';
    }

    // Vérifier l'état initial au chargement de la page
    toggleJournalTypeField();

    // Écouter les changements sur le select de type
    typeSelect.addEventListener('change', toggleJournalTypeField);

    // Gérer la sélection de fichier
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            showFilePreview(file);
        }
    });

    // Gérer le drag and drop
    const dropZone = fileInput.closest('.border-dashed');
    
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('border-red-900', 'bg-red-900');
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-red-900', 'bg-red-900');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-red-900', 'bg-red-900');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            // Vérifier le type de fichier
            const allowedTypes = ['.pdf', '.doc', '.docx', '.xls', '.xlsx', '.csv'];
            const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
            
            if (allowedTypes.includes(fileExtension)) {
                fileInput.files = files;
                showFilePreview(file);
            } else {
                alert('Type de fichier non autorisé. Veuillez sélectionner un fichier PDF, DOC, DOCX, XLS, XLSX ou CSV.');
            }
        }
    });

    // Gérer la suppression de fichier
    removeFileBtn.addEventListener('click', hideFilePreview);

    // Gérer l'éditeur Excel simple
    const openExcelBtn = document.getElementById('open-excel-btn');
    const excelModal = document.getElementById('excel-editor-modal');
    const closeExcelBtn = document.getElementById('close-excel-editor');
    const saveExcelBtn = document.getElementById('save-excel-btn');
    const addRowBtn = document.getElementById('add-row-btn');
    const addColBtn = document.getElementById('add-col-btn');
    const clearTableBtn = document.getElementById('clear-table-btn');
    const excelTbody = document.getElementById('excel-tbody');
    const excelThead = document.getElementById('excel-thead');
    
    let columnCount = 9; // Commencer avec 9 colonnes par défaut

    openExcelBtn.addEventListener('click', function() {
        // Ouvrir le modal
        excelModal.classList.remove('hidden');
        
        // Initialiser le tableau
        initExcelTable();
    });

    closeExcelBtn.addEventListener('click', function() {
        // Fermer le modal
        excelModal.classList.add('hidden');
    });

    // Nouveau document Excel (vider le tableau)
    document.getElementById('new-excel-document').addEventListener('click', function() {
        if (confirm('Êtes-vous sûr de vouloir créer un nouveau document ? Toutes les données actuelles seront perdues.')) {
            // Vider le tableau
            excelTbody.innerHTML = '';
            columnCount = 9;
            
            // Réinitialiser avec 9 colonnes vides et 5 lignes vides
            initExcelTable();
            
            // Afficher un message de confirmation
            const successMessage = document.createElement('div');
            successMessage.className = 'fixed top-4 right-4 bg-red-900 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center space-x-2 animate-pulse';
            successMessage.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span>Nouveau document créé !</span>
            `;
            document.body.appendChild(successMessage);
            
            // Supprimer le message après 3 secondes
            setTimeout(() => {
                if (successMessage.parentNode) {
                    successMessage.parentNode.removeChild(successMessage);
                }
            }, 3000);
        }
    });

    saveExcelBtn.addEventListener('click', function() {
        saveExcelFile();
    });

    addRowBtn.addEventListener('click', function() {
        addTableRow();
    });

    addColBtn.addEventListener('click', function() {
        addTableColumn();
    });

    clearTableBtn.addEventListener('click', function() {
        if (confirm('Êtes-vous sûr de vouloir effacer toutes les données ?')) {
            clearTable();
        }
    });

    function initExcelTable() {
        // Commencer avec 9 colonnes par défaut
        columnCount = 9;
        updateColumnHeaders();
        
        // Ajouter quelques lignes vides
        for (let i = 0; i < 5; i++) {
            addTableRow();
        }
        updateStats();
    }

    function addTableRow() {
        const row = document.createElement('tr');
        row.className = 'hover:bg-slate-50 group relative border-b border-gray-100 transition-colors duration-150';
        
        let rowHTML = '';
        for (let i = 0; i < columnCount; i++) {
            rowHTML += `
                <td class="px-4 py-3 border-r border-gray-200 bg-gray-50">
                    <input type="text" class="w-full border-none outline-none text-sm text-gray-800 placeholder-gray-500 bg-gray-100 focus:bg-white focus:ring-2 focus:ring-red-900 focus:rounded-md px-2 py-1 transition-all duration-200" placeholder="">
                </td>
            `;
        }
        
        // Ajouter le bouton de suppression de ligne
        rowHTML += `
            <td class="w-12 p-0 relative bg-gray-50">
                <button onclick="deleteRow(this)" class="absolute -left-8 top-1/2 transform -translate-y-1/2 bg-red-500 text-white rounded-full w-6 h-6 text-xs opacity-0 group-hover:opacity-100 transition-all duration-200 hover:bg-red-600 hover:scale-110 shadow-lg" title="Supprimer cette ligne">
                    <svg class="w-3 h-3 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </td>
        `;
        
        row.innerHTML = rowHTML;
        excelTbody.appendChild(row);
        updateStats();
    }

    function addTableColumn() {
        columnCount++;
        updateColumnHeaders();
        updateAllRows();
        updateStats();
    }

    function updateColumnHeaders() {
        const headerRow = excelThead.querySelector('tr');
        headerRow.innerHTML = '';
        
        for (let i = 0; i < columnCount; i++) {
            headerRow.innerHTML += `
                <th class="bg-[#FEE2E2] border border-red-300 text-white px-4 py-3 text-center font-semibold min-w-[140px] relative group border-r border-red-900">
                    <div class="flex items-center justify-center">
                        <input type="text" value="" class="w-full border-none outline-none text-center font-semibold bg-transparent text-white placeholder-blue-200 focus:bg-red-900 focus:rounded px-2 py-1 transition-all duration-200" placeholder="Colonne ${i + 1}">
                        <button onclick="deleteColumn(${i})" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 text-xs opacity-0 group-hover:opacity-100 transition-all duration-200 hover:bg-red-600 hover:scale-110 shadow-lg" title="Supprimer cette colonne">
                            <svg class="w-3 h-3 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </th>
            `;
        }
    }

    function updateAllRows() {
        const rows = excelTbody.querySelectorAll('tr');
        rows.forEach(row => {
            const currentCells = row.querySelectorAll('td');
            const currentCellCount = currentCells.length;
            
            // Ajouter des cellules si nécessaire
            for (let i = currentCellCount - 1; i < columnCount; i++) {
                const newCell = document.createElement('td');
                newCell.className = 'px-4 py-3 border-r border-gray-200 bg-gray-50';
                newCell.innerHTML = `<input type="text" class="w-full border-none outline-none text-sm text-gray-800 placeholder-gray-500 bg-gray-100 focus:bg-white focus:ring-2 focus:ring-red-900 focus:rounded-md px-2 py-1 transition-all duration-200" placeholder="">`;
                // Insérer avant le bouton de suppression de ligne
                const deleteButtonCell = row.querySelector('td:last-child');
                if (deleteButtonCell) {
                    row.insertBefore(newCell, deleteButtonCell);
                } else {
                    row.appendChild(newCell);
                }
            }
            
            // Supprimer des cellules si nécessaire (en gardant le bouton de suppression)
            const dataCells = row.querySelectorAll('td:not(:last-child)');
            for (let i = dataCells.length - 1; i >= columnCount; i--) {
                const cell = dataCells[i];
                if (cell) {
                    cell.remove();
                }
            }
        });
        updateStats();
    }

    function getColumnLetter(columnNumber) {
        let result = '';
        while (columnNumber > 0) {
            columnNumber--;
            result = String.fromCharCode(65 + (columnNumber % 26)) + result;
            columnNumber = Math.floor(columnNumber / 26);
        }
        return result;
    }

    function clearTable() {
        excelTbody.innerHTML = '';
        initExcelTable();
    }

    function updateStats() {
        const rows = excelTbody.querySelectorAll('tr');
        const dataCells = document.querySelectorAll('tbody td:not(:last-child)');
        const cellCount = dataCells.length;
        const rowCount = rows.length;
        
        document.getElementById('cell-count').textContent = `${cellCount} cellules`;
        document.getElementById('row-count').textContent = `${rowCount} lignes`;
        document.getElementById('col-count').textContent = `${columnCount} colonnes`;
    }

    // Fonction pour supprimer une colonne
    window.deleteColumn = function(columnIndex) {
        if (columnCount <= 1) {
            alert('Impossible de supprimer la dernière colonne. Le tableau doit avoir au moins une colonne.');
            return;
        }
        
        if (confirm('Êtes-vous sûr de vouloir supprimer cette colonne ?')) {
            columnCount--;
            updateColumnHeaders();
            updateAllRows();
            updateStats();
        }
    }

    // Fonction pour supprimer une ligne
    window.deleteRow = function(button) {
        const row = button.closest('tr');
        const totalRows = excelTbody.querySelectorAll('tr').length;
        
        if (totalRows <= 1) {
            alert('Impossible de supprimer la dernière ligne. Le tableau doit avoir au moins une ligne.');
            return;
        }
        
        if (confirm('Êtes-vous sûr de vouloir supprimer cette ligne ?')) {
            row.remove();
            updateStats();
        }
    }

    function saveExcelFile() {
        console.log('Début de la sauvegarde du document...');
        
        // Collecter les données du tableau
        const rows = excelTbody.querySelectorAll('tr');
        const data = [];
        
        // En-têtes (récupérer depuis les inputs des en-têtes)
        const headerInputs = excelThead.querySelectorAll('input');
        const headers = Array.from(headerInputs).map((input, index) => input.value || `Colonne ${index + 1}`);
        data.push(headers);
        
        // Données (exclure la colonne des boutons de suppression)
        rows.forEach(row => {
            const dataCells = row.querySelectorAll('td:not(:last-child)');
            const inputs = Array.from(dataCells).map(cell => cell.querySelector('input'));
            const rowData = inputs.map(input => input ? input.value || '' : '');
            data.push(rowData);
        });

        console.log('Données collectées:', data);

        // Vérifier s'il y a des données
        const hasData = data.some((row, index) => index > 0 && row.some(cell => cell.trim() !== ''));
        if (!hasData) {
            alert('Veuillez saisir au moins une ligne de données avant de sauvegarder.');
            return;
        }

        try {
            // Créer un fichier Excel (.xlsx) en utilisant une approche plus simple
            // Créer un fichier HTML avec namespace Excel qui s'ouvre correctement dans Excel
            
            let htmlContent = '<!DOCTYPE html>' +
'<html xmlns:o="urn:schemas-microsoft-com:office:office"' +
' xmlns:x="urn:schemas-microsoft-com:office:excel"' +
' xmlns="http://www.w3.org/TR/REC-html40">' +
'<head>' +
'<meta charset="UTF-8">' +
'<meta name="ProgId" content="Excel.Sheet">' +
'<meta name="Generator" content="Microsoft Excel 11">' +
'<style>' +
'table { border-collapse: collapse; width: 100%; }' +
'td, th { border: 1px solid #000; padding: 8px; text-align: left; }' +
'th { background-color: #E0E0E0; font-weight: bold; }' +
'</style>' +
'</head>' +
'<body>' +
'<table>';

            // Ajouter les en-têtes
            if (data.length > 0) {
                htmlContent += '<thead><tr>';
                data[0].forEach(header => {
                    const escapedHeader = (header || '').toString()
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;');
                    htmlContent += '<th>' + escapedHeader + '</th>';
                });
                htmlContent += '</tr></thead>';
            }

            // Ajouter les données
            htmlContent += '<tbody>';
            for (let i = 1; i < data.length; i++) {
                htmlContent += '<tr>';
                data[i].forEach(cell => {
                    const cellValue = (cell || '').toString()
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;');
                    htmlContent += '<td>' + cellValue + '</td>';
                });
                htmlContent += '</tr>';
            }
            htmlContent += '</tbody></table></body></html>';

            // Créer un nom de fichier unique
            const timestamp = new Date().toISOString().replace(/[:.]/g, '-').slice(0, 19);
            const filename = `document_financier_${timestamp}.xls`;
            
            console.log('Fichier Excel créé:', filename);
            
            // Créer le fichier Excel (HTML avec namespace Excel)
            const blob = new Blob([htmlContent], { type: 'application/vnd.ms-excel' });
            const file = new File([blob], filename, { type: 'application/vnd.ms-excel' });
            
            // Appeler la fonction d'ajout de fichier
            if (typeof addExcelFile === 'function') {
                addExcelFile(file);
                console.log('Fichier Excel ajouté au formulaire');
            } else {
                console.error('Fonction addExcelFile non trouvée');
            }
            
            // NE PAS fermer le modal - laisser l'éditeur ouvert pour modifications
            // excelModal.classList.add('hidden');
            console.log('Modal reste ouvert pour modifications');
            
            // NE PAS nettoyer le tableau - garder les données pour modifications
            // excelTbody.innerHTML = '';
            // columnCount = 9;
            
            // Afficher un message de succès plus visible
            const successMessage = document.createElement('div');
            successMessage.className = 'fixed top-4 right-4 bg-red-900 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center space-x-2 animate-pulse';
            successMessage.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Document Excel sauvegardé ! L'éditeur reste ouvert pour modifications.</span>
            `;
            document.body.appendChild(successMessage);
            console.log('Message de succès affiché');
            
            // Supprimer le message après 3 secondes
            setTimeout(() => {
                successMessage.remove();
            }, 3000);
            
            // Faire défiler vers le haut de la page pour voir le fichier ajouté
            window.scrollTo({ top: 0, behavior: 'smooth' });
            console.log('Scroll vers le haut effectué');
            
        } catch (error) {
            console.error('Erreur lors de la création du fichier Excel:', error);
            alert('Erreur lors de la création du fichier Excel: ' + error.message + '. Veuillez recharger la page et réessayer.');
        }
    }

    // Détecter les fichiers Excel ajoutés automatiquement
    // Cette fonction sera appelée quand l'utilisateur sauvegarde un fichier Excel
    window.addExcelFile = function(file) {
        if (file) {
            console.log('Ajout du fichier Excel:', file.name);
            
            // Créer un objet FileList simulé
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
            
            // Afficher l'aperçu du fichier
            if (typeof showFilePreview === 'function') {
                showFilePreview(file);
            } else {
                console.error('Fonction showFilePreview non trouvée');
                // Afficher un aperçu basique
                const filePreview = document.getElementById('file-preview');
                if (filePreview) {
                    filePreview.innerHTML = `
                        <div class="flex items-center space-x-3 p-3 bg-[#FEE2E2] border border-red-300 rounded-lg">
                            <svg class="w-8 h-8 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">${file.name}</p>
                                <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(1)} KB</p>
                            </div>
                            <button type="button" onclick="removeFile()" class="text-red-600 hover:text-red-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    `;
                    filePreview.classList.remove('hidden');
                }
            }
        }
    };
});
</script>
@endsection
