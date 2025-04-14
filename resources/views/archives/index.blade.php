@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Archives</h1>
                <p class="mt-2 text-sm text-gray-600">Gestion des documents archivés</p>
            </div>
        </div>

        <!-- Navigation par catégories - affiche uniquement les catégories accessibles -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 mb-8">
            @foreach($accessibleCategories as $category)
                <a href="{{ 
                    match($category) {
                        'employes' => route('archives.employees.index'),
                        'administratifs' => route('archives.administratifs.index'),
                        'partenaires' => route('archives.partenaires.index'),
                        'financiers' => route('archives.financiers.index'),
                        'beneficiaires' => route('archives.beneficiaires.index'),
                        'communication' => route('archives.communications.index'),
                        'rh' => route('archives.rh.index'),
                        'pointages'=> route('archives.pointages.index'),
                        'evenements' => route('archives.evenements.index'),  
                        default => route('archives.index')
                    }
                }}"
                class="relative group">
                    <div class="h-full bg-white rounded-xl shadow-sm p-6 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg border-2 {{ 
                        $category === 'rh' 
                            ? (request()->routeIs('archives.rh.*') ? 'border-blue-500' : 'border-transparent')
                            : (request()->routeIs('archives.' . strtolower($category) . '*') ? 'border-blue-500' : 'border-transparent') 
                    }}">
                        <!-- Icône spécifique à chaque catégorie -->
                        <div class="flex justify-center mb-4">
                            <div class="p-3 rounded-full {{ 
                               match($category) {
    'administratifs' => 'bg-blue-100 text-blue-600',
    'beneficiaires' => 'bg-green-100 text-green-600',
    'partenaires' => 'bg-purple-100 text-purple-600',
    'projets' => 'bg-yellow-100 text-yellow-600',
    'financiers' => 'bg-red-100 text-red-600',
    'communication' => 'bg-indigo-100 text-indigo-600',
    'juridiques' => 'bg-gray-100 text-gray-600',
    'employes' => 'bg-pink-100 text-pink-600',
    'evenements' => 'bg-orange-100 text-orange-600',
    'pointages' => 'bg-amber-100 text-amber-600',  
    'rh' => 'bg-teal-100 text-teal-600',
    default => 'bg-gray-100 text-gray-600'
}
                            }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @switch($category)
    @case('administratifs')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        @break
    @case('beneficiaires')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        @break
    @case('partenaires')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        @break
    @case('projets')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        @break
    @case('financiers')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        @break

        @case('pointages')
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
    @break
    
    @case('communication')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        @break
    @case('juridiques')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2M6 7l-3-1"/>
        @break
    @case('employes')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        @break
    @case('evenements')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        @break
    @case('rh')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        @break
    @default
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
@endswitch
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-center font-medium text-gray-900">{{ $category === 'rh' ? 'RH' : ucfirst($category) }}</h3>
                        <div class="absolute inset-0 rounded-xl transition duration-300 ease-in-out group-hover:bg-black group-hover:bg-opacity-5"></div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Message si aucune archive n'est disponible -->
        @if($archives->isEmpty())
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Aucune archive disponible</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Accédez aux catégories spécifiques pour visualiser ou ajouter des documents.
                </p>
            </div>
        @else
            <!-- Liste des archives -->
            <div class="bg-white rounded-xl shadow-lg p-6 divide-y divide-gray-200">
                @foreach($archives->groupBy('category') as $category => $categoryArchives)
                    <div class="py-6 first:pt-0 last:pb-0">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <span class="mr-3">{{ ucfirst($category) }}</span>
                            <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                                {{ $categoryArchives->count() }}
                            </span>
                        </h2>
                        
                        <div class="space-y-4">
                            @foreach($categoryArchives as $archive)
                                <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition duration-200">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-grow">
                                            <h3 class="font-medium text-lg text-gray-900">{{ $archive->title }}</h3>
                                            <p class="text-sm text-gray-600 mt-1">{{ $archive->sub_category }}</p>
                                            <p class="mt-2 text-gray-700">{{ $archive->description }}</p>
                                            
                                            @if($archive->files)
                                                <div class="mt-4 flex flex-wrap gap-2">
                                                    @foreach($archive->files as $file)
                                                        <a href="{{ Storage::url($file) }}" 
                                                        class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200"
                                                        target="_blank">
                                                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                            </svg>
                                                            Document {{ $loop->iteration }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="ml-4 flex flex-col items-end">
                                            <span class="text-sm text-gray-500">
                                                {{ $archive->created_at->format('d/m/Y') }}
                                            </span>
                                            <span class="mt-2 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $archive->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection