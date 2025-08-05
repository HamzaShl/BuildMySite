@extends('base')

@section('title', "Inscription")

@section('content')
<div class="min-h-screen flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-6">
        
        <!-- Message de succès responsive -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">
                            Succès !
                        </h3>
                        <div class="mt-2 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- En-tête responsive -->
        <div class="text-center">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                Créer un compte
            </h1>
            <p class="mt-2 text-sm md:text-base text-gray-600">
                Rejoignez BuildMySite dès aujourd'hui
            </p>
        </div>

        <!-- Formulaire principal responsive -->
        <div class="bg-white py-6 px-4 sm:px-6 lg:px-8 rounded-lg shadow-md">
            <form method="POST" action="{{ route('registration.register') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Champs communs responsive -->
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" 
                               value="{{ old('email') }}"
                               class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        @error('email')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                            <input type="password" name="password" id="password" 
                                   class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                            @error('password')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Vous êtes :</label>
                        <select name="type" id="type" 
                                class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                            <option value="">-- Choisir --</option>
                            <option value="dev" {{ old('type') === 'dev' ? 'selected' : '' }}>Développeur</option>
                            <option value="entreprise" {{ old('type') === 'entreprise' ? 'selected' : '' }}>Entreprise</option>
                        </select>
                        @error('type')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                    </div>
                </div>

                <!-- Formulaire DEV responsive -->
                <div id="dev-form" class="hidden space-y-4">
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informations Développeur</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="nom_dev" class="block text-sm font-medium text-gray-700">Nom</label>
                                <input type="text" name="nom_dev" id="nom_dev" 
                                       value="{{ old('nom_dev') }}"
                                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                @error('nom_dev')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label for="prenom_dev" class="block text-sm font-medium text-gray-700">Prénom</label>
                                <input type="text" name="prenom_dev" id="prenom_dev" 
                                       value="{{ old('prenom_dev') }}"
                                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                @error('prenom_dev')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="niveau_experience" class="block text-sm font-medium text-gray-700">Niveau</label>
                                <select name="niveau_experience" id="niveau_experience" 
                                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                    <option value="">-- Niveau d'expérience --</option>
                                    <option value="junior" {{ old('niveau_experience') == 'junior' ? 'selected' : '' }}>
                                        Junior (0-4 ans)
                                    </option>
                                    <option value="confirme" {{ old('niveau_experience') == 'confirme' ? 'selected' : '' }}>
                                        Confirmé (5-9 ans)
                                    </option>
                                    <option value="senior" {{ old('niveau_experience') == 'senior' ? 'selected' : '' }}>
                                        Senior (10+ ans)
                                    </option>
                                </select>
                                @error('niveau_experience')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label for="specialite_dev" class="block text-sm font-medium text-gray-700">Spécialité</label>
                                <select name="specialite_dev" id="specialite_dev" 
                                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                    <option value="">-- Spécialité --</option>
                                    <option value="front" {{ old('specialite_dev') == 'front' ? 'selected' : '' }}>Frontend</option>
                                    <option value="back" {{ old('specialite_dev') == 'back' ? 'selected' : '' }}>Backend</option>
                                    <option value="fullstack" {{ old('specialite_dev') == 'fullstack' ? 'selected' : '' }}>Full Stack</option>
                                </select>
                                @error('specialite_dev')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" 
                                      placeholder="Décrivez votre expérience et vos compétences..."
                                      class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">{{ old('description') }}</textarea>
                            @error('description')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                        </div>

                        <!-- Fichiers responsive -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                                <input type="file" name="photo" id="photo" accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                @error('photo')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label for="cv" class="block text-sm font-medium text-gray-700">CV</label>
                                <input type="file" name="cv" id="cv" accept=".pdf,.doc,.docx"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                @error('cv')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label for="portfolio" class="block text-sm font-medium text-gray-700">Portfolio</label>
                                <input type="file" name="portfolio" id="portfolio" accept=".pdf,.zip"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                @error('portfolio')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulaire ENTREPRISE responsive -->
                <div id="entreprise-form" class="hidden space-y-4">
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informations Entreprise</h3>
                        
                        <div>
                            <label for="nom_entreprise" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                            <input type="text" name="nom_entreprise" id="nom_entreprise" 
                                   value="{{ old('nom_entreprise') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                            @error('nom_entreprise')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="taille_entreprise" class="block text-sm font-medium text-gray-700">Taille</label>
                                <select name="taille_entreprise" id="taille_entreprise" 
                                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                    <option value="">-- Taille --</option>
                                    <option value="micro" {{ old('taille_entreprise') == 'micro' ? 'selected' : '' }}>
                                        Micro (≤10 salariés)
                                    </option>
                                    <option value="petite" {{ old('taille_entreprise') == 'petite' ? 'selected' : '' }}>
                                        Petite (≤50 salariés)
                                    </option>
                                    <option value="moyenne" {{ old('taille_entreprise') == 'moyenne' ? 'selected' : '' }}>
                                        Moyenne (≤250 salariés)
                                    </option>
                                    <option value="grande" {{ old('taille_entreprise') == 'grande' ? 'selected' : '' }}>
                                        Grande (250+ salariés)
                                    </option>
                                </select>
                                @error('taille_entreprise')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label for="secteur_entreprise" class="block text-sm font-medium text-gray-700">Secteur</label>
                                <select name="secteur_entreprise" id="secteur_entreprise" 
                                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                    <option value="">-- Secteur --</option>
                                    <option value="tech" {{ old('secteur_entreprise') == 'tech' ? 'selected' : '' }}>Technologie</option>
                                    <option value="finance" {{ old('secteur_entreprise') == 'finance' ? 'selected' : '' }}>Finance</option>
                                    <option value="ecommerce" {{ old('secteur_entreprise') == 'ecommerce' ? 'selected' : '' }}>E-commerce</option>
                                    <option value="sante" {{ old('secteur_entreprise') == 'sante' ? 'selected' : '' }}>Santé</option>
                                    <option value="education" {{ old('secteur_entreprise') == 'education' ? 'selected' : '' }}>Éducation</option>
                                    <option value="autre" {{ old('secteur_entreprise') == 'autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('secteur_entreprise')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div>
                            <label for="type_freelance" class="block text-sm font-medium text-gray-700">Type de freelance recherché</label>
                            <select name="type_freelance" id="type_freelance" 
                                    class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                <option value="">-- Type recherché --</option>
                                <option value="front" {{ old('type_freelance') == 'front' ? 'selected' : '' }}>Frontend</option>
                                <option value="back" {{ old('type_freelance') == 'back' ? 'selected' : '' }}>Backend</option>
                                <option value="fullstack" {{ old('type_freelance') == 'fullstack' ? 'selected' : '' }}>Full Stack</option>
                            </select>
                            @error('type_freelance')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="w-full bg-purple-700 hover:bg-purple-600 text-white px-4 py-3 md:px-6 md:py-3 rounded-lg text-sm md:text-base font-medium transition-colors duration-200">
                        S'inscrire
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-sm md:text-base text-gray-600">
                        Déjà un compte ?
                        <a href="{{ route('login') }}" class="font-medium text-purple-700 hover:text-purple-500">
                            Se connecter
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

@vite('resources/js/register.js')
@endsection