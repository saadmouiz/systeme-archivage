<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Al Amal</title>
    <link rel="icon" type="image/png" href="{{ asset('asset/image copy.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: 
                radial-gradient(circle at 0% 0%, rgba(220, 38, 38, 0.1), transparent 40%),
                radial-gradient(circle at 100% 100%, rgba(220, 38, 38, 0.1), transparent 40%);
        }
        .glass-morph {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
        }
        .input-background {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="min-h-screen md:h-screen flex flex-col md:flex-row">
    

       <!-- Right Panel - Image -->
       <div class="hidden md:flex w-1/2 h-full bg-gray-200 items-center justify-center p-12">
        <div class="max-w-2xl text-center text-gray-900">
            <img src="{{ asset('asset/image copy.png') }}" alt="Al Amal" class="mx-auto mb-8 w-48">
            <h2 class="text-4xl  font-bold mb-6">Association Initiative Al Amal Pour l'intégration Sociale</h2>
            <p class="text-xl text-gray-900">Ensemble pour un impact social positif et durable</p>
        </div>
    </div>
    <!-- Left Panel - Form -->
    <div class="w-full md:w-1/2 min-h-screen flex items-center justify-center bg-gradient-to-br from-white via-red-50 to-white p-4 md:p-8">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-6 md:mb-10">
                <img src="{{ asset('asset/image copy.png') }}" alt="Logo" class="mx-auto h-16 md:h-20">
            </div>

            <!-- Login Form -->
            <div class="glass-morph rounded-3xl shadow-2xl p-6 md:p-10 border border-white/20">
                <div class="text-center mb-6 md:mb-8">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Bienvenue</h1>
                    <p class="mt-2 text-gray-600">Connectez-vous à votre espace</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-6">
                    @csrf
                    
                    <!-- Email -->
                    <div class="space-y-2">
                        <div class="relative">
                            <input type="email" name="email" required
                                class="peer w-full px-4 md:px-6 py-3 md:py-4 border-2 border-gray-200 rounded-xl input-background placeholder-transparent focus:border-red-500 focus:outline-none transition-all text-sm md:text-base"
                                placeholder="Email"
                                id="email"
                            >
                            <label for="email" 
                                class="absolute left-4 md:left-6 -top-3 text-sm text-gray-600 bg-white px-2 transition-all
                                peer-placeholder-shown:text-base peer-placeholder-shown:top-3 md:peer-placeholder-shown:top-4 peer-placeholder-shown:left-4 md:peer-placeholder-shown:left-6
                                peer-focus:-top-3 peer-focus:left-4 md:peer-focus:left-6 peer-focus:text-sm peer-focus:text-red-500">
                                Email
                            </label>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm ml-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <div class="relative">
                            <input type="password" name="password" required
                                class="peer w-full px-4 md:px-6 py-3 md:py-4 border-2 border-gray-200 rounded-xl input-background placeholder-transparent focus:border-red-500 focus:outline-none transition-all text-sm md:text-base"
                                placeholder="Mot de passe"
                                id="password"
                            >
                            <label for="password" 
                                class="absolute left-4 md:left-6 -top-3 text-sm text-gray-600 bg-white px-2 transition-all
                                peer-placeholder-shown:text-base peer-placeholder-shown:top-3 md:peer-placeholder-shown:top-4 peer-placeholder-shown:left-4 md:peer-placeholder-shown:left-6
                                peer-focus:-top-3 peer-focus:left-4 md:peer-focus:left-6 peer-focus:text-sm peer-focus:text-red-500">
                                Mot de passe
                            </label>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm ml-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember me -->
                    <div class="flex items-center">
                        <label class="flex items-center space-x-2 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="remember" class="peer sr-only">
                                <div class="w-5 h-5 border-2 border-gray-300 rounded group-hover:border-red-500 peer-checked:border-red-500 peer-checked:bg-red-500 transition-all"></div>
                                <svg class="absolute top-0.5 left-0.5 w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-600 group-hover:text-gray-800">Se souvenir de moi</span>
                        </label>
                    </div>

                    <!-- Login button -->
                    <button type="submit"
                        class="w-full py-3 md:py-4 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-xl font-medium
                        hover:shadow-lg hover:shadow-red-500/30 active:scale-[0.98] transition-all duration-200 text-sm md:text-base">
                        Se connecter
                    </button>
                </form>

                <!-- Back link -->
                <div class="mt-6 text-center">
                    <a href="{{route('home')}}" 
                        class="inline-flex items-center gap-2 text-gray-600 hover:text-red-500 transition-colors text-sm md:text-base">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Retour à l'accueil</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

 
</body>
</html>

