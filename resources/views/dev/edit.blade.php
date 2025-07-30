@extends('base')

@section('content')
<div class="bg-gray-100 p-6 text-center">
    <h1 class="text-4xl font-bold mb-2">Modifier mon profil développeur</h1>
    <p class="text-gray-700 text-lg">Mettez à jour vos informations</p>
</div>

<section class="p-6">
    <div class="bg-white p-6 rounded-lg shadow max-w-4xl mx-auto">
        <form action="{{ route('devs.update', $dev->id_dev) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations personnelles -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informations personnelles</h3>
                    
                    <div>
                        <label for="nom_dev" class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                        <input type="text" id="nom_dev" name="nom_dev" value="{{ old('nom_dev', $dev->nom_dev) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('nom_dev')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="prenom_dev" class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                        <input type="text" id="prenom_dev" name="prenom_dev" value="{{ old('prenom_dev', $dev->prenom_dev) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('prenom_dev')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email_dev" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" id="email_dev" name="email_dev" value="{{ old('email_dev', $dev->email_dev) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email_dev')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_dev" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                        <input type="password" id="password_dev" name="password_dev"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Laissez vide pour garder le mot de passe actuel">
                        @error('password_dev')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Informations professionnelles -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informations professionnelles</h3>
                    
                    <div>
    <label for="niveau_experience" class="block text-sm font-medium text-gray-700 mb-1">Niveau d'expérience *</label>
    <select id="niveau_experience" name="niveau_experience" required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">Sélectionnez votre niveau</option>
        <option value="junior" {{ old('niveau_experience', $dev->niveau_experience) == 'junior' ? 'selected' : '' }}>Junior</option>
        <option value="confirme" {{ old('niveau_experience', $dev->niveau_experience) == 'confirme' ? 'selected' : '' }}>Confirmé</option>
        <option value="senior" {{ old('niveau_experience', $dev->niveau_experience) == 'senior' ? 'selected' : '' }}>Senior</option>
    </select>
    @error('niveau_experience')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

                    <div>
                        <label for="specialite_dev" class="block text-sm font-medium text-gray-700 mb-1">Spécialité *</label>
                        <select id="specialite_dev" name="specialite_dev" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Sélectionnez votre spécialité</option>
                            <option value="front" {{ old('specialite_dev', $dev->specialite_dev) == 'front' ? 'selected' : '' }}>Frontend</option>
                            <option value="back" {{ old('specialite_dev', $dev->specialite_dev) == 'back' ? 'selected' : '' }}>Backend</option>
                            <option value="fullstack" {{ old('specialite_dev', $dev->specialite_dev) == 'fullstack' ? 'selected' : '' }}>Fullstack</option>
                        </select>
                        @error('specialite_dev')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="description" name="description" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Présentez-vous en quelques mots...">{{ old('description', $dev->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Fichiers -->
            <div class="mt-6 space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Documents et fichiers</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Photo de profil</label>
                        @if($dev->photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $dev->photo) }}" alt="Photo actuelle" class="w-20 h-20 rounded-full object-cover">
                                <p class="text-xs text-gray-500">Photo actuelle</p>
                            </div>
                        @endif
                        <input type="file" id="photo" name="photo" accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('photo')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

        <div>
     <label for="cv" class="block text-sm font-medium text-gray-700 mb-1">CV</label>
    @if($dev->cv)
        <div class="mb-2" id="cv-section">
            <a href="{{ asset('storage/' . $dev->cv) }}" target="_blank" class="text-blue-600 hover:underline text-sm">📄 Voir le CV actuel</a>
            <button type="button" onclick="deleteFile('cv', '{{ $dev->id_dev }}')" 
                    class="ml-4 bg-red-600 text-white px-3 py-1 text-xs rounded hover:bg-red-700 transition">
                🗑️ Supprimer le CV
            </button>
        </div>
    @endif
    <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx"
           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    @error('cv')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="portfolio" class="block text-sm font-medium text-gray-700 mb-1">Portfolio</label>
    @if($dev->portfolio)
        <div class="mb-2" id="portfolio-section">
            <a href="{{ asset('storage/' . $dev->portfolio) }}" target="_blank" class="text-blue-600 hover:underline text-sm">💼 Voir le portfolio actuel</a>
            <button type="button" onclick="deleteFile('portfolio', '{{ $dev->id_dev }}')" 
                    class="ml-4 bg-red-600 text-white px-3 py-1 text-xs rounded hover:bg-red-700 transition">
                🗑️ Supprimer le portfolio
            </button>
        </div>
    @endif
    <input type="file" id="portfolio" name="portfolio" accept=".pdf,.zip"
           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    @error('portfolio')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
                </div>
            </div>

            <!-- Boutons -->
            <div class="mt-8 flex justify-between">
                <a href="{{ route('devs.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 transition">
                    ← Retour au profil
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    💾 Sauvegarder les modifications
                </button>
            </div>
        </form>
    </div>
</section>
@endsection