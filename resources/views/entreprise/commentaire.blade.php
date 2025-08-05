@extends('base')

@section('content')
<div class="bg-gray-100 p-6 text-center">
    <h1 class="text-4xl font-bold mb-2">💬 Laisser un avis</h1>
    <p class="text-gray-700 text-lg">Partagez votre expérience avec {{ $dev->prenom_dev }} {{ $dev->nom_dev }}</p>
</div>

<section class="p-6">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        
        <div class="bg-blue-50 p-4 rounded-lg mb-6">
            <h3 class="font-bold text-blue-800 mb-2">👨‍💻 Développeur concerné :</h3>
            <p class="text-blue-700">{{ $dev->prenom_dev }} {{ $dev->nom_dev }}</p>
            <p class="text-blue-600 text-sm">{{ $dev->specialite_dev }} - {{ $dev->niveau_experience }}</p>
        </div>

        <form method="POST" action="{{ route('commentaires.store') }}">
            @csrf
            <input type="hidden" name="id_dev" value="{{ $dev->id_dev }}">
            
            <div class="mb-6">
                <label for="titre_commentaire" class="block text-sm font-medium text-gray-700 mb-2">
                    📝 Titre de votre avis *
                </label>
                <input type="text" 
                       id="titre_commentaire" 
                       name="titre_commentaire" 
                       required
                       maxlength="255"
                       placeholder="Ex: Excellent travail, très professionnel"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       value="{{ old('titre_commentaire') }}">
                @error('titre_commentaire')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="contenu_commentaire" class="block text-sm font-medium text-gray-700 mb-2">
                    💭 Votre commentaire détaillé *
                </label>
                <textarea id="contenu_commentaire" 
                          name="contenu_commentaire" 
                          required
                          maxlength="1000"
                          rows="6"
                          placeholder="Décrivez votre expérience : qualité du travail, respect des délais, communication..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('contenu_commentaire') }}</textarea>
                @error('contenu_commentaire')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Maximum 1000 caractères</p>
            </div>

            <div class="bg-yellow-50 p-4 rounded-lg mb-6">
                <h4 class="font-bold text-yellow-800 mb-2">⚠️ Important :</h4>
                <ul class="text-yellow-700 text-sm space-y-1">
                    <li>• Votre avis sera public et visible par tous</li>
                    <li>• Soyez constructif et respectueux</li>
                    <li>• Vous ne pourrez pas modifier votre avis après publication</li>
                </ul>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('entreprises.index') }}" 
                   class="bg-gray-500 text-white px-6 py-3 rounded hover:bg-gray-600 transition">
                    ← Annuler
                </a>
                
                <button type="submit" 
                        class="bg-blue-600 text-white px-8 py-3 rounded hover:bg-blue-700 transition">
                    ✅ Publier mon avis
                </button>
            </div>
        </form>
    </div>
</section>
@endsection