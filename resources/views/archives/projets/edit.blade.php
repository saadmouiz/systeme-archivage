<!-- resources/views/projets/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-medium text-gray-900">
                    Modifier le projet
                </h2>
            </div>
            
            <form action="{{ route('archives.projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informations de base -->
                    <div class="space-y-6">
                        <div>
                            <label for="titre" class="block text-sm font-medium text-gray-700">Titre du projet</label>
                            <input type="text" name="titre" id="titre" value="{{ old('titre', $project->titre) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                            @error('titre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="objectifs" class="block text-sm font-medium text-gray-700">Objectifs</label>
                            <textarea name="objectifs" id="objectifs" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">{{ old('objectifs', $project->objectifs) }}</textarea>
                            @error('objectifs')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Champs pour les résultats et l'impact (visible si projet en cours ou terminé) -->
                        @if(in_array($project->statut, ['en_cours', 'termine']))
                        <div>
                            <label for="resultats" class="block text-sm font-medium text-gray-700">Résultats obtenus</label>
                            <textarea name="resultats" id="resultats" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">{{ old('resultats', $project->resultats) }}</textarea>
                        </div>

                        <div>
                            <label for="impact" class="block text-sm font-medium text-gray-700">Impact du projet</label>
                            <textarea name="impact" id="impact" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">{{ old('impact', $project->impact) }}</textarea>
                        </div>
                        @endif
                    </div>

                    <!-- Détails et statut -->
                    <div class="space-y-6">
                        <div>
                            <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                            <select name="statut" id="statut"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                                <option value="planifie" {{ old('statut', $project->statut) === 'planifie' ? 'selected' : '' }}>Planifié</option>
                                <option value="en_cours" {{ old('statut', $project->statut) === 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="termine" {{ old('statut', $project->statut) === 'termine' ? 'selected' : '' }}>Terminé</option>
                            </select>
                        </div>

                        <div>
                            <label for="beneficiaires_cibles" class="block text-sm font-medium text-gray-700">Bénéficiaires ciblés</label>
                            <textarea name="beneficiaires_cibles" id="beneficiaires_cibles" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">{{ old('beneficiaires_cibles', $project->beneficiaires_cibles) }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de début</label>
                                <input type="date" name="date_debut" id="date_debut" 
                                       value="{{ old('date_debut', $project->date_debut ? $project->date_debut->format('Y-m-d') : '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                            </div>
                            <div>
                                <label for="date_fin" class="block text-sm font-medium text-gray-700">Date de fin prévue</label>
                                <input type="date" name="date_fin" id="date_fin" 
                                       value="{{ old('date_fin', $project->date_fin ? $project->date_fin->format('Y-m-d') : '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="budget_previsionnel" class="block text-sm font-medium text-gray-700">Budget prévisionnel</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" step="0.01" name="budget_previsionnel" id="budget_previsionnel"
                                           value="{{ old('budget_previsionnel', $project->budget_previsionnel) }}"
                                           class="block w-full pr-12 rounded-md border-gray-300 focus:border-[#0d9488] focus:ring-[#0d9488]">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">€</span>
                                    </div>
                                </div>
                            </div>
                            
                            @if($project->statut !== 'planifie')
                            <div>
                                <label for="budget_reel" class="block text-sm font-medium text-gray-700">Budget réel</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" step="0.01" name="budget_reel" id="budget_reel"
                                           value="{{ old('budget_reel', $project->budget_reel) }}"
                                           class="block w-full pr-12 rounded-md border-gray-300 focus:border-[#0d9488] focus:ring-[#0d9488]">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">€</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        @if($project->statut !== 'planifie')
                        <div>
                            <label for="nombre_beneficiaires" class="block text-sm font-medium text-gray-700">Nombre de bénéficiaires atteints</label>
                            <input type="number" name="nombre_beneficiaires" id="nombre_beneficiaires"
                                   value="{{ old('nombre_beneficiaires', $project->nombre_beneficiaires) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Documents -->
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Documents du projet</h3>
                    
                    <!-- Documents existants -->
                    @if($project->documents->count() > 0)
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Documents actuels</h4>
                        <ul class="divide-y divide-gray-200">
                            @foreach($project->documents as $document)
                            <li class="py-3 flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ $document->titre }}</span>
                                <div class="flex items-center space-x-3">
                                    <a href="{{ $document->fichier_url }}" 
                                       class="text-sm text-[#0d9488] hover:text-green-700"
                                       target="_blank">Voir</a>
                                    <button type="button" 
                                            onclick="if(confirm('Supprimer ce document ?')) document.getElementById('delete-document-{{ $document->id }}').submit();"
                                            class="text-sm text-red-600 hover:text-red-700">
                                        Supprimer
                                    </button>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Ajout de nouveaux documents -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ajouter des documents</label>
                        <div class="mt-1">
                            <input type="file" name="documents[]" multiple
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#0d9488] file:text-white hover:file:bg-green-700">
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Formats acceptés : PDF, Word, Excel, Images.
                        </p>
                    </div>
                </div>

                <div class="mt-8 border-t pt-6 flex justify-end space-x-4">
                    <a href="{{ route('archives.projects.show', $project) }}"
                       class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
                        Annuler
                    </a>
                    <button type="submit"
                            class="bg-[#0d9488] py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
                        Mettre à jour
                    </button>
                </div>
            </form>

            <!-- Formulaires de suppression des documents -->
            @foreach($project->documents as $document)
            <form id="delete-document-{{ $document->id }}" 
                  action="{{ route('archives.projects.deleteDocument', [$project, $document]) }}" 
                  method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
            @endforeach
        </div>
    </div>
</div>
@endsection