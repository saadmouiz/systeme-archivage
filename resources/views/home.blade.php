<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système d'Archivage - Accueil</title>
    <link rel="shortcut icon" href="{{ asset('asset/image copy.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }
        .red-gradient-bg {
            background: linear-gradient(120deg, #991b1b 0%, #b91c1c 100%);
        }
        .dark-red-gradient-bg {
            background: linear-gradient(120deg, #7f1d1d 0%, #991b1b 100%);
        }
        .light-red-gradient-bg {
            background: linear-gradient(120deg, #fecaca 0%, #fca5a5 100%);
        }
        .mobile-menu {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(100%);
        }
        .mobile-menu.active {
            transform: translateX(0);
        }
        .service-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(185, 28, 28, 0.25);
        }
        .wavy-divider {
            position: relative;
            height: 70px;
            overflow: hidden;
        }
        .wavy-divider svg {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100%;
        }
        .animated-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: 0;
        }
        .animated-bg .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(185, 28, 28, 0.1);
            animation: float 15s infinite ease-in-out;
        }
        .animated-bg .circle:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }
        .animated-bg .circle:nth-child(2) {
            width: 400px;
            height: 400px;
            top: 50%;
            right: -200px;
            animation-delay: 3s;
        }
        .animated-bg .circle:nth-child(3) {
            width: 200px;
            height: 200px;
            bottom: -100px;
            left: 30%;
            animation-delay: 7s;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(50px, 50px) rotate(5deg); }
            50% { transform: translate(0, 100px) rotate(0deg); }
            75% { transform: translate(-50px, 50px) rotate(-5deg); }
        }
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #b91c1c;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .cta-button {
            transition: all 0.3s ease;
        }
        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(185, 28, 28, 0.5);
        }
        .logo-img {
            width: auto;
            height: 48px;
            object-fit: contain;
        }
        .mobile-logo-img {
            width: auto;
            height: 40px;
            object-fit: contain;
        }
    </style>
</head>
<body class="light-red-gradient-bg">
    <!-- Animated Background -->
    <div class="animated-bg">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>
    
    <!-- Navigation -->
    <nav class="fixed w-full z-30 bg-white/90 backdrop-blur-lg border-b border-red-200">
        <div class="max-w-7xl mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('asset/hhh.jpeg') }}" alt="Logo Système d'Archivage" class="logo-img rounded-full">
                    <span class="text-xl font-bold text-gray-800">Système d'Archivage</span>
                </div>
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('login') }}" class="cta-button px-6 py-2 red-gradient-bg text-white rounded-full hover:shadow-lg transition-all">
                        Connexion
                    </a>
                </div>
                <button class="md:hidden p-2" onclick="toggleMenu()">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/60 z-40 hidden backdrop-blur-sm" onclick="toggleMenu()"></div>
    <div id="mobile-menu" class="fixed top-0 right-0 w-full max-w-sm h-full bg-white shadow-2xl z-50 mobile-menu">
        <div class="p-8">
            <div class="flex justify-between items-center mb-12">
                <div class="flex items-center gap-3">
                    <span class="text-lg font-bold text-gray-800">Système d'Archivage</span>
                </div>
                <button onclick="toggleMenu()" class="p-2 hover:bg-red-50 rounded-full transition-colors">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
           
            <a href="{{ route('login') }}" class="block w-full px-6 py-3 text-center red-gradient-bg text-white rounded-xl hover:shadow-lg transition-all">
                Connexion
            </a>
        </div>
    </div>

    <!-- Hero Section -->
    <header class="relative min-h-screen flex items-center pt-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid md:grid-cols-5 gap-16 items-center">
                <div class="md:col-span-3 text-center md:text-left">
                    <div class="inline-block px-6 py-2 rounded-full bg-red-100 text-red-700 font-medium mb-6">
                        Initiative sociale pour un avenir meilleur
                    </div>
                    <h2 class="text-5xl md:text-6xl font-bold leading-tight mb-8">
                        Ensemble pour une<br class="hidden md:block">
                        <span class="text-red-600 relative">
                            société inclusive!
                            <svg class="absolute -bottom-3 left-0 w-full" viewBox="0 0 358 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 9C118.957 4.47226 273.957 3.47226 355 3" stroke="#b91c1c" stroke-width="5" stroke-linecap="round"/>
                            </svg>
                        </span>
                    </h2>
                    <p class="text-xl text-gray-600 mb-12 max-w-2xl mx-auto md:mx-0">
                        L'Association Initiative Al Amal s'engage à créer un impact positif et durable pour notre communauté à travers des projets innovants et inclusifs.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="{{ route('login') }}" class="cta-button px-8 py-4 red-gradient-bg text-white rounded-full hover:shadow-lg transition-all text-center group">
                            <span class="inline-flex items-center">
                                <span>Découvrir Nos Services</span>
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </a>
                        <a href="#features" class="px-8 py-4 bg-white text-red-600 border border-red-200 rounded-full hover:bg-red-50 transition-all text-center">
                            En savoir plus
                        </a>
                    </div>
                </div>
                <div class="hidden md:block md:col-span-2">
                    <div class="aspect-square rounded-3xl overflow-hidden dark-red-gradient-bg p-8 flex items-center justify-center text-white">
                        <div class="text-center">
                            <div class="text-6xl font-bold mb-4">8+</div>
                            <div class="text-xl">Années d'expérience dans le domaine social</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Fonctionnalités Principales</h2>
                <p class="text-xl text-gray-600">Un système complet pour la gestion de vos archives</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Archive RH -->
                <div class="service-card bg-white rounded-xl p-6 border border-gray-200 text-center">
                    <div class="bg-red-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Archives RH</h3>
                    <p class="text-gray-600 text-sm">Gestion des dossiers du personnel, contrats et documents RH</p>
                </div>

                <!-- Archive Financière -->
                <div class="service-card bg-white rounded-xl p-6 border border-gray-200 text-center">
                    <div class="bg-[#FEE2E2] flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Archives Financières</h3>
                    <p class="text-gray-600 text-sm">Documents comptables, factures et rapports financiers</p>
                </div>

                <!-- Archive Administrative -->
                <div class="service-card bg-white rounded-xl p-6 border border-gray-200 text-center">
                    <div class="bg-[#FEE2E2] flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Archives Administratives</h3>
                    <p class="text-gray-600 text-sm">Documents administratifs et correspondances officielles</p>
                </div>

                <!-- Gestion Partenaires -->
                <div class="service-card bg-white rounded-xl p-6 border border-gray-200 text-center">
                    <div class="bg-[#FEE2E2] flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Gestion Partenaires</h3>
                    <p class="text-gray-600 text-sm">Suivi des partenaires et conventions de collaboration</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Wave Divider -->
    <div class="wavy-divider">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#ffffff" fill-opacity="1" d="M0,128L48,144C96,160,192,192,288,192C384,192,480,160,576,154.7C672,149,768,171,864,176C960,181,1056,171,1152,154.7C1248,139,1344,117,1392,106.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C960,320,768,320,672,320C576,320,480,320,384,320C288,320,192,320,96,320L48,320L0,320Z"></path>
        </svg>
    </div>
    
    
    <script>
        function toggleMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
            
            mobileMenu.classList.toggle('active');
            
            if (mobileMenu.classList.contains('active')) {
                mobileMenuOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                mobileMenuOverlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }
    </script>
</body>
</html>