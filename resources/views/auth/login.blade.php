@extends('base')

@section('title', 'Connexion')

    @section('content')
    <div class="min-h-screen flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-6">
            
            <!-- En-tête responsive -->
            <div class="text-center">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                    Connexion
                </h1>
                <p class="mt-2 text-sm md:text-base text-gray-600">
                    Accédez à votre espace BuildMySite
                </p>
            </div>

            <!-- Formulaire responsive -->
            <div class="bg-white p-4 md:p-6 lg:p-8 rounded-lg shadow-md">
                <form method="POST" action="{{ route('login.submit') }}" class="space-y-4 md:space-y-6">
                    @csrf

                    <!-- Email responsive -->
                    <div>
                        <label for="email" class="block text-sm md:text-base font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email" name="email" id="email" 
                               value="{{ old('email') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 md:px-4 md:py-3 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        @error('email')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                    </div>

                    <!-- Password responsive -->
                    <div>
                        <label for="password" class="block text-sm md:text-base font-medium text-gray-700 mb-2">
                            Mot de passe
                        </label>
                        <input type="password" name="password" id="password" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 md:px-4 md:py-3 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        @error('password')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                    </div>

                    <!-- Bouton responsive -->
                    <button type="submit" 
                            class="w-full bg-purple-700 hover:bg-purple-600 text-white px-4 py-3 md:px-6 md:py-3 rounded-lg text-sm md:text-base font-medium transition-colors duration-200">
                        Se connecter
                    </button>
                </form>

                <!-- Lien inscription responsive -->
                <div class="mt-4 md:mt-6 text-center">
                    <p class="text-sm md:text-base text-gray-600">
                        Pas encore de compte ?
                        <a href="{{ route('register') }}" 
                           class="text-purple-700 hover:text-purple-500 font-medium transition-colors">
                            S'inscrire
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection