@extends('base')

@section('title', "Inscription")

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            <strong class="font-bold">Succès !</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('registration.register') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full border p-2 rounded" value="{{ old('email') }}">
            @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Mot de passe -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
            <input type="password" name="password" id="password" class="w-full border p-2 rounded">
            @error('password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Confirmation -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border p-2 rounded">
        </div>

        <!-- Sélection type -->
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Vous êtes :</label>
            <select name="type" id="type" class="w-full border p-2 rounded">
                <option value="">-- Choisir --</option>
                <option value="dev" {{ old('type') === 'dev' ? 'selected' : '' }}>Développeur</option>
                <option value="entreprise" {{ old('type') === 'entreprise' ? 'selected' : '' }}>Entreprise</option>
            </select>
            @error('type')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Formulaire DEV -->
        <div id="dev-form" style="hidden">
            <h2 class="text-lg font-medium mt-4 mb-2">Informations Développeur</h2>

            <input type="text" name="nom_dev" placeholder="Nom" class="w-full border p-2 rounded mb-2" value="{{ old('nom_dev') }}">
            <input type="text" name="prenom_dev" placeholder="Prénom" class="w-full border p-2 rounded mb-2" value="{{ old('prenom_dev') }}">
            <select name="niveau_experience" class="w-full border p-2 rounded mb-2">
    <option value="">-- Niveau d'expérience --</option>
    <option value="junior" {{ old('niveau_experience') == 'junior' ? 'selected' : '' }}>Junior (entre 0 et 4 ans d'éxperience)</option>
    <option value="confirme" {{ old('niveau_experience') == 'confirme' ? 'selected' : '' }}>Confirmé (entre 5 et 9 ans d'expérience)</option>
    <option value="senior" {{ old('niveau_experience') == 'senior' ? 'selected' : '' }}>Senior (au dessus de 10 ans d'éxperience)</option>
</select>
            <select name="specialite_dev" class="w-full border p-2 rounded mb-2">
                <option value="">-- Spécialité --</option>
                <option value="front">Front</option>
                <option value="back">Back</option>
                <option value="fullstack">Fullstack</option>
            </select>
            <textarea name="description" placeholder="Description" class="w-full border p-2 rounded mb-2">{{ old('description') }}</textarea>
            <label>Photo de profil :</label>
            <input type="file" name="photo" class="w-full border p-2 rounded mb-2">
            <label>CV :</label>
            <input type="file" name="cv" class="w-full border p-2 rounded mb-2">
            <label>Portfolio :</label>
            <input type="file" name="portfolio" class="w-full border p-2 rounded mb-2">
        </div>

        <!-- Formulaire ENTREPRISE -->
        <div id="entreprise-form" style="hidden">
            <h2 class="text-lg font-medium mt-4 mb-2">Informations Entreprise</h2>

            <input type="text" name="nom_entreprise" placeholder="Nom de l'entreprise" class="w-full border p-2 rounded mb-2" value="{{ old('nom_entreprise') }}">
<select name="taille_entreprise" class="w-full border p-2 rounded mb-2">
    <option value="">-- Taille de l'entreprise --</option>
    <option value="micro" {{ old('taille_entreprise') == 'micro' ? 'selected' : '' }}>Micro-entreprise (jusqu'à 10 salariés)</option>
    <option value="petite" {{ old('taille_entreprise') == 'petite' ? 'selected' : '' }}>Petites entreprise (jusqu'à 50 salariés)</option>
    <option value="moyenne" {{ old('taille_entreprise') == 'moyenne' ? 'selected' : '' }}>Moyennes entreprise (jusqu'à 250 salariés)</option>
    <option value="grande" {{ old('taille_entreprise') == 'grande' ? 'selected' : '' }}>Grandes entreprise (plus de 250 salariés)</option>
</select>
@error('taille_entreprise')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror

@error('taille_entreprise')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror

@error('taille_entreprise')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
             <select name="secteur_entreprise" class="w-full border p-2 rounded mb-2">
        <option value="">-- Secteur d'activité --</option>
        <option value="tech" {{ old('secteur_entreprise') == 'tech' ? 'selected' : '' }}>Technologie</option>
        <option value="finance" {{ old('secteur_entreprise') == 'finance' ? 'selected' : '' }}>Finance</option>
        <option value="ecommerce" {{ old('secteur_entreprise') == 'ecommerce' ? 'selected' : '' }}>E-commerce</option>
        <option value="sante" {{ old('secteur_entreprise') == 'sante' ? 'selected' : '' }}>Santé</option>
        <option value="education" {{ old('secteur_entreprise') == 'education' ? 'selected' : '' }}>Éducation</option>
        <option value="autre" {{ old('secteur_entreprise') == 'autre' ? 'selected' : '' }}>Autre</option>
    </select>
    @error('secteur_entreprise')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
         <select name="type_freelance" class="w-full border p-2 rounded mb-2">
        <option value="">-- Type de freelance recherché --</option>
        <option value="front" {{ old('type_freelance') == 'front' ? 'selected' : '' }}>Front</option>
        <option value="back" {{ old('type_freelance') == 'back' ? 'selected' : '' }}>Back</option>
        <option value="fullstack" {{ old('type_freelance') == 'fullstack' ? 'selected' : '' }}>Fullstack</option>
    </select>
    @error('type_freelance')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Bouton -->
        <button type="submit" class="w-full bg-purple-700 text-white py-2 rounded hover:bg-purple-600">
            S'inscrire
        </button>

        <p class="text-center mt-4">
            Déjà un compte ?
            <a href="{{ route('login') }}" class="text-purple-700 hover:underline">Se connecter</a>
        </p>
    </form>
</div>
@endsection

@vite('resources/js/register.js')
