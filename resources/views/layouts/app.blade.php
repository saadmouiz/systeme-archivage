<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIAIS Connect</title>
    <link rel="shortcut icon" href="{{ asset('asset/image copy.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #1d4ed8;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        .nav-link.active {
            color: #1d4ed8;
            font-weight: 500;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            z-index: 10;
            min-width: 10rem;
            padding: 0.5rem 0;
        }
        .dropdown-menu.show {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <img class="h-10 w-auto" src="{{ asset('asset/image copy.png') }}" alt="Logo">
                </div>
                <!-- Hamburger Button -->
                <div class="flex items-center md:hidden">
                    <button id="menu-toggle" class="text-gray-500 hover:text-gray-900 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
                <!-- Navigation Links -->
                <div id="menu" class="hidden md:flex md:space-x-8">
                    <a href="{{ route('dashboard')}}" 
                       class="nav-link inline-flex items-center px-1 pt-1 text-gray-900 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Tableau de Bord
                    </a>
                    <a href="{{route('archives.index')}}" 
                       class="nav-link inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-900 {{ request()->routeIs('archives.*') ? 'active' : '' }}">
                        Archives
                    </a>
                </div>
                <!-- Admin Menu -->
                <div class="hidden md:flex items-center ml-3 relative">
                    <button id="admin-dropdown" class="flex items-center px-4 py-2 bg-red-900 text-white rounded-lg hover:bg-red-900 transition duration-150 ease-in-out">
                        {{ Auth::user()->name }}
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="admin-dropdown-menu" class="dropdown-menu">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white shadow-sm">
            <a href="{{ route('dashboard')}}" 
               class="block px-4 py-2 text-gray-900 hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-100 font-semibold' : '' }}">
                Tableau de Bord
            </a>

            <a href="{{route('archives.index')}}" 
               class="block px-4 py-2 text-gray-900 hover:bg-gray-100 {{ request()->routeIs('archives.*') ? 'bg-gray-100 font-semibold' : '' }}">
                Archives
            </a>
            
            <div class="block px-4 py-2 bg-red-900 text-white">
                {{ Auth::user()->name }}
            </div>
            
            <form method="POST" action="{{ route('logout') }}" class="block px-4 py-2">
                @csrf
                <button type="submit" 
                        class="w-full text-left bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-900">
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>

    <!-- Content -->
    <main class="pt-16 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>
    @stack('scripts')
    <!-- Script -->
    <script>
        // Toggle mobile menu
        document.getElementById('menu-toggle').addEventListener('click', () => {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
        
        // Toggle admin dropdown
        document.getElementById('admin-dropdown').addEventListener('click', () => {
            const dropdownMenu = document.getElementById('admin-dropdown-menu');
            dropdownMenu.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        window.addEventListener('click', (event) => {
            const dropdown = document.getElementById('admin-dropdown');
            const dropdownMenu = document.getElementById('admin-dropdown-menu');
            
            if (!dropdown.contains(event.target) && dropdownMenu.classList.contains('show')) {
                dropdownMenu.classList.remove('show');
            }
        });
    </script>
</body>
</html>