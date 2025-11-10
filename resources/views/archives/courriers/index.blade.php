@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-red-50">
    <div class="container mx-auto px-4 py-12">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-6 lg:mb-0">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-[#FEE2E2] border border-red-300 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                            <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                                Courriers
                            </h1>
                            <p class="text-gray-600 mt-2">Gestion des courriers entrants et sortants</p>
                        </div>
                    </div>
                </div>
                <div class="flex gap-4">
                    @if(request()->routeIs('archives.courriers.arrivants.*'))
                        <a href="{{ route('archives.courriers.arrivants.create') }}" 
                           class="group relative inline-flex items-center px-8 py-4 bg-[#871C1C] border border-red-300 text-white font-semibold rounded-2xl shadow-2xl hover:shadow-red-900/25 transition-all duration-300 hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-900 to-red-700 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-300"></div>
                            <svg class="w-5 h-5 mr-3 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="relative z-10">Nouveau Courrier</span>
                        </a>
                    @else
                        <a href="{{ route('archives.courriers.sortants.create') }}" 
                           class="group relative inline-flex items-center px-8 py-4 bg-[#871C1C] border border-red-300 text-white font-semibold rounded-2xl shadow-2xl hover:shadow-red-900/25 transition-all duration-300 hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-900 to-red-700 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-300"></div>
                            <svg class="w-5 h-5 mr-3 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="relative z-10">Nouveau Courrier</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-2 shadow-xl border border-white/20">
                <div class="flex space-x-2">
                    <a href="{{ route('archives.courriers.arrivants.index') }}" 
                       class="flex-1 flex items-center justify-center py-3 px-4 rounded-xl font-medium text-sm transition-all duration-300 {{ request()->routeIs('archives.courriers.arrivants.*') ? 'bg-[#FEE2E2] border border-red-300 text-red-900 shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Courriers Entrants
                    </a>
                    <a href="{{ route('archives.courriers.sortants.index') }}" 
                       class="flex-1 flex items-center justify-center py-3 px-4 rounded-xl font-medium text-sm transition-all duration-300 {{ request()->routeIs('archives.courriers.sortants.*') ? 'bg-[#FEE2E2] border border-red-300 text-red-900 shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                        </svg>
                        Courriers Sortants
                    </a>
                </div>
            </div>
        </div>

        @yield('courriers-content')
    </div>
</div>
@endsection


