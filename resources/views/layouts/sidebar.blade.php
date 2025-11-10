<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Système d\'Archivage')</title>
    <link rel="shortcut icon" href="{{ asset('asset/image copy.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .blue-gradient-bg {
            background: linear-gradient(120deg,rgb(207, 216, 46) 0%, rgb(207, 216, 46) 100%);
        }
        .sidebar-link {
            transition: all 0.3s ease;
        }
        .sidebar-link:hover {
            background-color: rgba(59, 130, 246, 0.1);
            padding-left: 1rem;
        }
        .sidebar-link.active {
            background:#A2140F;
            color: white;
        }
        .sidebar-link.active svg {
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Mobile Menu Toggle Button -->
    <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button" 
            class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-red-900 fixed top-4 left-4 z-50 bg-white shadow-md">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 shadow-xl" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-white border-r border-gray-200 flex flex-col">
            <!-- Logo -->
            <div class="mb-6 pb-4 border-b border-gray-200">
                <div class="flex items-center gap-3 px-3">
                    <img src="{{ asset('asset/hhh.jpeg') }}" alt="Logo" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <h1 class="text-lg font-bold text-gray-800">Système</h1>
                        <p class="text-xs text-gray-500">d'Archivage</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto">
            <ul class="space-y-1 font-medium">
                <!-- PRINCIPAL -->
                <li class="pt-2">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Principal</p>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="sidebar-link flex items-center p-2 text-gray-700 rounded-lg group {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                        </svg>
                        <span class="ml-3">Tableau de Bord</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('archives.index') }}" 
                       class="sidebar-link flex items-center p-2 text-gray-700 rounded-lg group {{ request()->routeIs('archives.index') && !request()->routeIs('archives.*.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                            <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                        </svg>
                        <span class="ml-3">Toutes les Archives</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('statistics') }}" 
                       class="sidebar-link flex items-center p-2 text-gray-700 rounded-lg group {{ request()->routeIs('statistics') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M19 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1ZM2 6v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H2Zm11 3a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0h2a1 1 0 0 1 2 0v1Z"/>
                        </svg>
                        <span class="ml-3">Statistiques</span>
                    </a>
                </li>

                <!-- RESSOURCES HUMAINES -->
                @if(Gate::check('access-rh') || Gate::check('access-employes') || Gate::check('access-pointages'))
                <li class="pt-4 mt-4 border-t border-gray-200">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Ressources Humaines</p>
                </li>
                @endif

                @can('access-rh')
                <li>
                    <a href="{{ route('archives.rh.index') }}" 
                       class="sidebar-link flex items-center p-2 text-gray-700 rounded-lg group {{ request()->routeIs('archives.rh.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                        </svg>
                        <span class="ml-3">Archives RH</span>
                    </a>
                </li>
                @endcan

                <!-- DOCUMENTS -->
                @if(Gate::check('access-administratifs') || Gate::check('access-financiers'))
                <li class="pt-4 mt-4 border-t border-gray-200">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Documents</p>
                </li>
                @endif

                @can('access-administratifs')
                <li>
                    <a href="{{ route('archives.administratifs.index') }}" 
                       class="sidebar-link flex items-center p-2 text-gray-700 rounded-lg group {{ request()->routeIs('archives.administratifs.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                            <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                            <path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z"/>
                        </svg>
                        <span class="ml-3">Administratifs</span>
                    </a>
                </li>
                @endcan

                @can('access-financiers')
                <li>
                    <a href="{{ route('archives.financiers.index') }}" 
                       class="sidebar-link flex items-center p-2 text-gray-700 rounded-lg group {{ request()->routeIs('archives.financiers.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M11.074 4 8.442.408A.95.95 0 0 0 7.014.254L2.926 4h8.148ZM9 13v-1a4 4 0 0 1 4-4h6V6a1 1 0 0 0-1-1H1a1 1 0 0 0-1 1v13a1 1 0 0 0 1 1h17a1 1 0 0 0 1-1v-2h-6a4 4 0 0 1-4-4Z"/>
                            <path d="M19 10h-6a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1Zm-4.5 3.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM12.62 4h2.78L12.539.41a1.086 1.086 0 1 0-1.7 1.352L12.62 4Z"/>
                        </svg>
                        <span class="ml-3">Financiers</span>
                    </a>
                </li>
                @endcan

                @can('access-employes')
                <li>
                    <a href="{{ route('archives.employees.index') }}" 
                       class="sidebar-link flex items-center p-2 text-gray-700 rounded-lg group {{ request()->routeIs('archives.employees.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                        </svg>
                        <span class="ml-3">Employés</span>
                    </a>
                </li>
                @endcan

                @can('access-pointages')
                <li>
                    <a href="{{ route('archives.pointages.index') }}" 
                       class="sidebar-link flex items-center p-2 text-gray-700 rounded-lg group {{ request()->routeIs('archives.pointages.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                        </svg>
                        <span class="ml-3">Pointages</span>
                    </a>
                </li>
                @endcan

                <!-- PARTENARIATS -->
                @if(Gate::check('access-beneficiaires') || Gate::check('access-partenaires'))
                <li class="pt-4 mt-4 border-t border-gray-200">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Partenariats</p>
                </li>
                @endif

                @can('access-beneficiaires')
                <li>
                    <a href="{{ route('archives.beneficiaires.index') }}" 
                       class="sidebar-link flex items-center p-2 text-gray-700 rounded-lg group {{ request()->routeIs('archives.beneficiaires.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                        </svg>
                        <span class="ml-3">Bénéficiaires</span>
                    </a>
                </li>
                @endcan

                @can('access-partenaires')
                <li>
                    <a href="{{ route('archives.partenaires.index') }}" 
                       class="sidebar-link flex items-center p-2 text-gray-700 rounded-lg group {{ request()->routeIs('archives.partenaires.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M19 4h-1a1 1 0 1 0 0 2v11a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1Zm-6 4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1h-2ZM1 19h2a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1H1a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1Zm5-13h2a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1Z"/>
                        </svg>
                        <span class="ml-3">Partenaires</span>
                    </a>
                </li>
                @endcan

                <li>
                    <a href="{{ route('visiteurs.index') }}" 
                       class="sidebar-link flex items-center p-2 text-gray-700 rounded-lg group {{ request()->routeIs('visiteurs.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                        </svg>
                        <span class="ml-3">Visiteurs</span>
                    </a>
                </li>

                <!-- COMMUNICATION -->
                @if(Gate::check('access-communications') || Gate::check('access-evenements'))
                <li class="pt-4 mt-4 border-t border-gray-200">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Communication</p>
                </li>
                @endif

                @can('access-communications')
                <li>
                    <a href="{{ route('archives.communications.index') }}" 
                       class="sidebar-link flex items-center p-2 text-gray-700 rounded-lg group {{ request()->routeIs('archives.communications.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M18 7.5h-.423l-.452-1.09.3-.3a1.5 1.5 0 0 0 0-2.121L16.01 2.575a1.5 1.5 0 0 0-2.121 0l-.3.3-1.089-.452V2A1.5 1.5 0 0 0 11 .5H9A1.5 1.5 0 0 0 7.5 2v.423l-1.09.452-.3-.3a1.5 1.5 0 0 0-2.121 0L2.576 3.99a1.5 1.5 0 0 0 0 2.121l.3.3L2.423 7.5H2A1.5 1.5 0 0 0 .5 9v2A1.5 1.5 0 0 0 2 12.5h.423l.452 1.09-.3.3a1.5 1.5 0 0 0 0 2.121l1.415 1.413a1.5 1.5 0 0 0 2.121 0l.3-.3 1.09.452V18A1.5 1.5 0 0 0 9 19.5h2a1.5 1.5 0 0 0 1.5-1.5v-.423l1.09-.452.3.3a1.5 1.5 0 0 0 2.121 0l1.415-1.414a1.5 1.5 0 0 0 0-2.121l-.3-.3.452-1.09H18a1.5 1.5 0 0 0 1.5-1.5V9A1.5 1.5 0 0 0 18 7.5Zm-8 6a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7Z"/>
                        </svg>
                        <span class="ml-3">Communications</span>
                    </a>
                </li>
                @endcan

                @can('access-evenements')
                <li>
                    <a href="{{ route('archives.evenements.index') }}" 
                       class="sidebar-link flex items-center p-2 text-gray-700 rounded-lg group {{ request()->routeIs('archives.evenements.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm14-7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4Z"/>
                        </svg>
                        <span class="ml-3">Événements</span>
                    </a>
                </li>
                @endcan

                <!-- COURRIERS -->
                @can('access-courriers')
                <li class="pt-4 mt-4 border-t border-gray-200">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Courriers</p>
                </li>
                <li>
                    <a href="{{ route('archives.courriers.arrivants.index') }}" 
                       class="sidebar-link flex items-center p-2 text-gray-700 rounded-lg group {{ request()->routeIs('archives.courriers.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        <span class="ml-3">Courriers</span>
                    </a>
                </li>
                @endcan
            </ul>
            </div>

            <!-- Bottom Section - User Account -->
            <div class="pt-4 mt-4 border-t border-gray-200">
                <!-- User Info -->
                <div class="px-3 py-2 mb-2 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 text-red-900 font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link flex items-center p-2 text-gray-700 rounded-lg group w-full hover:bg-red-50 transition-all">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
                        </svg>
                        <span class="ml-3 font-medium">Déconnexion</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="p-4 sm:ml-64">
        <div class="p-4 rounded-lg">
            @yield('content')
        </div>
    </div>

    @stack('scripts')

    <!-- Toggle Sidebar Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleButton = document.querySelector('[data-drawer-toggle="sidebar"]');
        
        if (toggleButton) {
            toggleButton.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = toggleButton && toggleButton.contains(event.target);
            
            if (!isClickInsideSidebar && !isClickOnToggle && window.innerWidth < 640) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
</body>
</html>


