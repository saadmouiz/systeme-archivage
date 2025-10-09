@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Modifier les informations de l'employé</h1>
            <p class="mt-2 text-sm text-gray-600">Modifiez les informations de {{ $employee->prenom }} {{ $employee->nom }}</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('archives.employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $employee->nom) }}" class="mt-1 focus:ring-red-900 focus:border-red-900 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('nom')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $employee->prenom) }}" class="mt-1 focus:ring-red-900 focus:border-red-900 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('prenom')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="fonction" class="block text-sm font-medium text-gray-700">Fonction</label>
                        <input type="text" name="fonction" id="fonction" value="{{ old('fonction', $employee->fonction) }}" class="mt-1 focus:ring-red-900 focus:border-red-900 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('fonction')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type_contrat" class="block text-sm font-medium text-gray-700">Type de contrat</label>
                        <select name="type_contrat" id="type_contrat" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-red-900 focus:border-red-900 sm:text-sm">
                            <option value="CDI" {{ old('type_contrat', $employee->type_contrat) == 'CDI' ? 'selected' : '' }}>CDI</option>
                            <option value="CDD" {{ old('type_contrat', $employee->type_contrat) == 'CDD' ? 'selected' : '' }}>CDD</option>
                            <option value="Stage" {{ old('type_contrat', $employee->type_contrat) == 'Stage' ? 'selected' : '' }}>Stage</option>
                            <option value="Autre" {{ old('type_contrat', $employee->type_contrat) == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('type_contrat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date_embauche" class="block text-sm font-medium text-gray-700">Date d'embauche</label>
                        <input type="date" name="date_embauche" id="date_embauche" value="{{ old('date_embauche', $employee->date_embauche) }}" class="mt-1 focus:ring-red-900 focus:border-red-900 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('date_embauche')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date_fin_contrat" class="block text-sm font-medium text-gray-700">Date de fin de contrat</label>
                        <input type="date" name="date_fin_contrat" id="date_fin_contrat" value="{{ old('date_fin_contrat', $employee->date_fin_contrat) }}" class="mt-1 focus:ring-red-900 focus:border-red-900 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <p class="mt-1 text-xs text-gray-500">Laisser vide pour les CDI</p>
                        @error('date_fin_contrat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Statut</label>
                        <div class="mt-2">
                            <div class="flex items-center">
                                <input id="actif_oui" name="actif" type="radio" value="1" class="focus:ring-red-900 h-4 w-4 text-red-900 border-gray-300" {{ old('actif', $employee->actif) == '1' ? 'checked' : '' }}>
                                <label for="actif_oui" class="ml-3 block text-sm font-medium text-gray-700">Actif</label>
                            </div>
                            <div class="flex items-center mt-2">
                                <input id="actif_non" name="actif" type="radio" value="0" class="focus:ring-red-900 h-4 w-4 text-red-900 border-gray-300" {{ old('actif', $employee->actif) == '0' ? 'checked' : '' }}>
                                <label for="actif_non" class="ml-3 block text-sm font-medium text-gray-700">Inactif</label>
                            </div>
                        </div>
                        @error('actif')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                        <input type="file" name="photo" id="photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-900 file:text-red-900 hover:file:bg-red-900">
                        @if($employee->photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $employee->photo) }}" alt="Photo de {{ $employee->prenom }} {{ $employee->nom }}" class="h-20 w-20 object-cover rounded-full">
                            </div>
                        @endif
                        <p class="mt-1 text-xs text-gray-500">Format accepté: JPG, PNG. Taille max: 2MB</p>
                        @error('photo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes additionnelles</label>
                    <textarea name="notes" id="notes" rows="3" class="mt-1 focus:ring-red-900 focus:border-red-900 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('notes', $employee->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-8 flex justify-end">
                    <a href="{{ route('archives.employees.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900 mr-3">
                        Annuler
                    </a>
                    <button type="submit" class="bg-red-900 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

