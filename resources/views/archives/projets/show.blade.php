@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $project->title }}</h1>
                        <div class="mt-2 flex items-center">
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $project->status_badge_class }}">
                                {{ ucfirst($project->status) }}
                            </span>
                            @if($project->start_date)
                                <span class="ml-4 text-sm text-gray-500">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $project->start_date->format('d/m/Y') }} - {{ $project->end_date ? $project->end_date->format('d/m/Y') : 'Non définie' }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('archives.projects.edit', $project) }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Modifier
                        </a>
                        <form action="{{ route('archives.projects.destroy', $project) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Informations principales -->
            <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Colonne de gauche -->
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Description</h3>
                        <p class="mt-2 text-gray-600">{{ $project->description }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Objectifs</h3>
                        <div class="mt-2 prose prose-sm text-gray-600">
                            {{ $project->objectives }}
                        </div>
                    </div>

                    @if($project->target_beneficiaries)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Bénéficiaires ciblés</h3>
                        <div class="mt-2 prose prose-sm text-gray-600">
                            {{ $project->target_beneficiaries }}
                        </div>
                    </div>
                    @endif

                    @if($project->results)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Résultats</h3>
                        <div class="mt-2 prose prose-sm text-gray-600">
                            {{ $project->results }}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Colonne de droite -->
                <div class="space-y-6">
                    <!-- Progression -->
                    @if($project->status === 'en cours')
                    <div class="bg-white rounded-lg border p-4">
                        <h4 class="text-sm font-medium text-gray-900">Progression</h4>
                        <div class="mt-2">
                            <div class="relative pt-1">
                                <div class="flex mb-2 items-center justify-between">
                                    <div>
                                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-red-900 bg-red-900">
                                            {{ $project->progression }}%
                                        </span>
                                    </div>
                                </div>
                                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-red-900">
                                    <div style="width:{{ $project->progression }}%" 
                                         class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-900">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Budget -->
                    <div class="bg-white rounded-lg border p-4">
                        <h4 class="text-sm font-medium text-gray-900">Informations financières</h4>
                        <dl class="mt-3 space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Budget prévisionnel</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    {{ number_format($project->estimated_budget, 2, ',', ' ') }} €
                                </dd>
                            </div>
                            @if($project->actual_budget)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Budget réel</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    {{ number_format($project->actual_budget, 2, ',', ' ') }} €
                                </dd>
                            </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Documents -->
                    @if($project->documents->count() > 0)
                    <div class="bg-white rounded-lg border p-4">
                        <h4 class="text-sm font-medium text-gray-900">Documents</h4>
                        <ul class="mt-3 divide-y divide-gray-200">
                            @foreach($project->documents as $document)
                            <li class="py-3 flex justify-between items-center">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="ml-2 flex-1 w-0 truncate text-sm text-gray-500">
                                        {{ $document->title }}
                                    </span>
                                </div>
                                <div class="ml-4 flex-shrink-0 flex items-center space-x-3">
                                    <a href="{{ $document->file_url }}" target="_blank"
                                       class="text-sm font-medium text-[#0d9488] hover:text-red-900">
                                        Télécharger
                                    </a>
                                    <form action="{{ route('archives.projects.deleteDocument', [$project, $document]) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')"
                                                class="text-sm font-medium text-red-600 hover:text-red-700">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Indicateurs de performance -->
                    @if($project->performance_indicators)
                    <div class="bg-white rounded-lg border p-4">
                        <h4 class="text-sm font-medium text-gray-900">Indicateurs de performance</h4>
                        <div class="mt-3 space-y-3">
                            @foreach($project->performance_indicators as $indicateur => $valeur)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">{{ $indicateur }}</span>
                                <span class="text-sm font-medium text-gray-900">{{ $valeur }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Autres informations -->
                    @if($project->beneficiaries_count)
                    <div class="bg-white rounded-lg border p-4">
                        <h4 class="text-sm font-medium text-gray-900">Statistiques</h4>
                        <dl class="mt-3 space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Nombre de bénéficiaires</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    {{ number_format($project->beneficiaries_count, 0, ',', ' ') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Notes -->
            @if($project->notes)
            <div class="px-6 py-4 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Notes et observations</h3>
                <div class="mt-4 prose prose-sm text-gray-600">
                    {{ $project->notes }}
                </div>
            </div>
            @endif

            <!-- Étude de faisabilité -->
            @if($project->feasibility_study)
            <div class="px-6 py-4 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Étude de faisabilité</h3>
                <div class="mt-4 prose prose-sm text-gray-600">
                    {!! nl2br(e($project->feasibility_study)) !!}
                </div>
            </div>
            @endif

            <!-- Impact -->
            @if($project->impact)
            <div class="px-6 py-4 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Impact du projet</h3>
                <div class="mt-4 prose prose-sm text-gray-600">
                    {!! nl2br(e($project->impact)) !!}
                </div>
            </div>
            @endif
        </div>

        <!-- Historique des modifications -->
       <!-- Historique des modifications -->
<div class="mt-8 bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Historique des modifications</h3>
    </div>
    <div class="divide-y divide-gray-200">
        <div class="px-6 py-4">
            @if($project->created_at)
                <div class="flex items-center text-sm text-gray-500">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Créé le {{ $project->created_at->format('d/m/Y à H:i') }}
                </div>
            @endif
            
            @if($project->updated_at && $project->created_at && $project->updated_at != $project->created_at)
                <div class="flex items-center text-sm text-gray-500 mt-2">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Dernière modification le {{ $project->updated_at->format('d/m/Y à H:i') }}
                </div>
            @endif
        </div>
    </div>
</div>
    </div>
</div>
@endsection