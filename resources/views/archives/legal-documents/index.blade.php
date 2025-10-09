@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Documents Juridiques</h1>
                <p class="mt-2 text-sm text-gray-600">Gestion des documents légaux</p>
            </div>
            <a href="{{ route('archives.legal-documents.create') }}"
               class="bg-red-900 hover:bg-red-800 text-white px-4 py-2 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau Document
            </a>
        </div>

        <!-- Filtres et statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            @php
                $typeStats = [
                    'permis' => ['label' => 'Permis et Licences', 'color' => 'green', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    'licence' => ['label' => 'Licences', 'color' => 'blue', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    'litige' => ['label' => 'Litiges', 'color' => 'red', 'icon' => 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2M6 7l-3-1'],
                    'propriete_intellectuelle' => ['label' => 'Propriété Intellectuelle', 'color' => 'purple', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z']
                ];
            @endphp

            @foreach($typeStats as $type => $info)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-md p-3 bg-{{ $info['color'] }}-100">
                                <svg class="w-6 h-6 text-{{ $info['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $info['icon'] }}"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500">{{ $info['label'] }}</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ isset($documents) ? $documents->where('type', $type)->count() : 0 }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Liste des documents par type -->
        @foreach($typeStats as $type => $info)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-medium text-gray-900">{{ $info['label'] }}</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    @if(isset($documents) && $documents->where('type', $type)->count() > 0)
                        @foreach($documents->where('type', $type) as $doc)
                            <div class="p-6 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900">
                                        <a href="{{ route('archives.legal-documents.show', ['legal_document' => $doc->id]) }}" class="hover:text-[#0d9488]">

                                                {{ $doc->title }}
                                            </a>
                                        </h3>
                                        <div class="mt-2 flex items-center space-x-4">
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $doc->status_badge_class }}">
                                                {{ ucfirst($doc->status) }}
                                            </span>
                                            @if($doc->reference_number)
                                                <span class="text-sm text-gray-500">
                                                    Réf: {{ $doc->reference_number }}
                                                </span>
                                            @endif
                                            @if($doc->date_expiration)
                                                <span class="text-sm text-gray-500">
                                                    Expire le {{ $doc->date_expiration->format('d/m/Y') }}
                                                </span>
                                            @endif
                                            <span class="text-sm text-gray-500">
                                                {{ $doc->files->count() }} fichier(s)
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                    <a href="{{ route('archives.legal-documents.edit', ['legal_document' => $doc->id]) }}" 
                                    class="text-[#0d9488] hover:text-red-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="p-6 text-center text-gray-500">
                            Aucun document dans cette catégorie.
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection