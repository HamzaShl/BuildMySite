    @extends('base')

@section('content')
<div class="bg-gray-100 p-6 text-center">
    <h1 class="text-4xl font-bold mb-2">Modifier le profil de l'entreprise</h1>
    <p class="text-gray-700 text-lg">Mettez à jour les informations de votre entreprise</p>
</div>

<section class="p-6">
    <div class="bg-white p-6 rounded-lg shadow max-w-4xl mx-auto">
        <form action="{{ route('entreprises.update', $entreprise->id_entreprise) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations de l'entreprise -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informations de l'entreprise</h3>
                    
                    <div>
                        <label for="nom_entreprise" class="block text-sm font-medium text-gray-700 mb-1">Nom de l'entreprise *</label>
                        <input type="text" id="nom_entreprise" name="nom_entreprise" value="{{ old('nom_entreprise', $entreprise->nom_entreprise) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('nom_entreprise')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email_entreprise" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" id="email_entreprise" name="email_entreprise" value="{{ old('email_entreprise', $entreprise->email_entreprise) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email_entreprise')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_entreprise" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                        <input type="password" id="password_entreprise" name="password_entreprise"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Laissez vide pour garder le mot de passe actuel">
                        @error('password_entreprise')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Détails de l'entreprise -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Détails de l'entreprise</h3>
                    
                    <div>
                        <label for="taille_entreprise" class="block text-sm font-medium text-gray-700 mb-1">Taille de l'entreprise</label>
<select id="taille_entreprise" name="taille_entreprise"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    <option value="">Sélectionnez la taille</option>
    <option value="micro" {{ old('taille_entreprise', $entreprise->taille_entreprise) == 'micro' ? 'selected' : '' }}>Micro-entreprise (jusqu'à 10 salariés)</option>
    <option value="petite" {{ old('taille_entreprise', $entreprise->taille_entreprise) == 'petite' ? 'selected' : '' }}>Petite entreprise (jusqu'à 50 salariés)</option>
    <option value="moyenne" {{ old('taille_entreprise', $entreprise->taille_entreprise) == 'moyenne' ? 'selected' : '' }}>Moyenne entreprise (jusqu'à 250 salariés)</option>
    <option value="grande" {{ old('taille_entreprise', $entreprise->taille_entreprise) == 'grande' ? 'selected' : '' }}>Grande entreprise (plus de 250 salariés)</option>
</select>
                        @error('taille_entreprise')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="secteur_entreprise" class="block text-sm font-medium text-gray-700 mb-1">Secteur d'activité</label>
                        <select id="secteur_entreprise" name="secteur_entreprise"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Sélectionnez le secteur</option>
                            <option value="tech" {{ old('secteur_entreprise', $entreprise->secteur_entreprise) == 'tech' ? 'selected' : '' }}>Technologie</option>
                            <option value="finance" {{ old('secteur_entreprise', $entreprise->secteur_entreprise) == 'finance' ? 'selected' : '' }}>Finance</option>
                            <option value="ecommerce" {{ old('secteur_entreprise', $entreprise->secteur_entreprise) == 'ecommerce' ? 'selected' : '' }}>E-commerce</option>
                            <option value="sante" {{ old('secteur_entreprise', $entreprise->secteur_entreprise) == 'sante' ? 'selected' : '' }}>Santé</option>
                            <option value="education" {{ old('secteur_entreprise', $entreprise->secteur_entreprise) == 'education' ? 'selected' : '' }}>Éducation</option>
                            <option value="autre" {{ old('secteur_entreprise', $entreprise->secteur_entreprise) == 'autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('secteur_entreprise')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type_freelance" class="block text-sm font-medium text-gray-700 mb-1">Type de développeur recherché</label>
                        <select id="type_freelance" name="type_freelance"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Sélectionnez le type</option>
                            <option value="front" {{ old('type_freelance', $entreprise->type_freelance) == 'front' ? 'selected' : '' }}>Frontend</option>
                            <option value="back" {{ old('type_freelance', $entreprise->type_freelance) == 'back' ? 'selected' : '' }}>Backend</option>
                            <option value="fullstack" {{ old('type_freelance', $entreprise->type_freelance) == 'fullstack' ? 'selected' : '' }}>Fullstack</option>
                        </select>
                        @error('type_freelance')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Boutons -->
            <div class="mt-8 flex justify-between">
                <a href="{{ route('entreprises.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 transition">
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