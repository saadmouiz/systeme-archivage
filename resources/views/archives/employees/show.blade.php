@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Détails de l'employé</h1>
                <p class="mt-2 text-sm text-gray-600">Informations complètes sur l'employé</p>
            </div>
            <div>
                <a href="{{ route('archives.employees.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg mr-2">
                    Retour à la liste
                </a>
                <a href="{{ route('archives.employees.edit', $employee->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg">
                    Modifier
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/3 bg-gray-50 p-6 flex flex-col items-center justify-center">
                    @if($employee->photo)
                        <img src="{{ asset('storage/'.$employee->photo) }}" alt="{{ $employee->nom }}" class="h-48 w-48 rounded-full object-cover">
                    @else
                        <div class="h-48 w-48 rounded-full bg-gray-200 flex items-center justify-center">
                            <span class="text-4xl text-gray-500">{{ substr($employee->prenom, 0, 1) . substr($employee->nom, 0, 1) }}</span>
                        </div>
                    @endif
                    <div class="mt-4 text-center">
                        <h2 class="text-xl font-semibold text-gray-900">{{ $employee->prenom }} {{ $employee->nom }}</h2>
                        <p class="text-gray-600">{{ $employee->fonction }}</p>
                    </div>
                </div>
                <div class="md:w-2/3 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Type de contrat</h3>
                            <p class="mt-1 text-gray-900">{{ $employee->type_contrat }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</h3>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $employee->actif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $employee->actif ? 'Actif' : 'Inactif' }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'embauche</h3>
                            <p class="mt-1 text-gray-900">{{ $employee->date_embauche ? date('d/m/Y', strtotime($employee->date_embauche)) : 'Non spécifiée' }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Date de fin de contrat</h3>
                            <p class="mt-1 text-gray-900">{{ $employee->date_fin_contrat ? date('d/m/Y', strtotime($employee->date_fin_contrat)) : 'Non applicable' }}</p>
                        </div>
                    </div>

                    @if($employee->notes)
                        <div class="mt-6">
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</h3>
                            <div class="mt-2 p-3 bg-gray-50 rounded-md text-gray-700">
                                {{ $employee->notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection