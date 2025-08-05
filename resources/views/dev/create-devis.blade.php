@extends('base')

@section('content')
<div class="bg-gray-100 p-6 text-center">
    <h1 class="text-4xl font-bold mb-2">💰 Gestion du devis</h1>
    <p class="text-gray-700 text-lg">{{ $mission->titre_mission }}</p>
</div>

<section class="p-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        
        @if(!$devis)
            <!-- ✅ CRÉATION DU DEVIS -->
            <h2 class="text-2xl font-bold mb-6 text-center">📝 Créer votre devis</h2>
            
            <form method="POST" action="{{ route('devis.store') }}">
                @csrf
                <input type="hidden" name="id_mission" value="{{ $mission->id_mission }}">
                
                <!-- Titre du devis -->
                <div class="mb-6">
                    <label for="titre_devis" class="block text-gray-700 text-sm font-bold mb-2">
                        📋 Titre du devis *
                    </label>
                    <input type="text" 
                           id="titre_devis" 
                           name="titre_devis" 
                           value="{{ old('titre_devis') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-blue-500 @error('titre_devis') border-red-500 @enderror"
                           placeholder="Ex: Développement site e-commerce"
                           required>
                    @error('titre_devis')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description_devis" class="block text-gray-700 text-sm font-bold mb-2">
                        📝 Description détaillée *
                    </label>
                    <textarea id="description_devis" 
                              name="description_devis" 
                              rows="6"
                              class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-blue-500 @error('description_devis') border-red-500 @enderror"
                              placeholder="Décrivez en détail ce que vous allez livrer..."
                              required>{{ old('description_devis') }}</textarea>
                    @error('description_devis')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prix -->
                <div class="mb-6">
                    <label for="prix" class="block text-gray-700 text-sm font-bold mb-2">
                        💰 Prix (en euros) *
                    </label>
                    <input type="number" 
                           id="prix" 
                           name="prix" 
                           value="{{ old('prix') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-blue-500 @error('prix') border-red-500 @enderror"
                           placeholder="1500"
                           min="1"
                           required>
                    @error('prix')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Délai -->
                <div class="mb-8">
                    <label for="delai" class="block text-gray-700 text-sm font-bold mb-2">
                        ⏰ Délai de livraison *
                    </label>
                    <input type="text" 
                           id="delai" 
                           name="delai" 
                           value="{{ old('delai') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-blue-500 @error('delai') border-red-500 @enderror"
                           placeholder="Ex: 3 semaines, 1 mois, 15 jours..."
                           required>
                    @error('delai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bouton d'envoi -->
                <div class="text-center">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-8 py-3 rounded hover:bg-blue-700 transition text-lg">
                        ✅ Envoyer le devis
                    </button>
                </div>
            </form>

        @elseif($devis->etat_devis === 'en_attente')
            <!-- ✅ DEVIS EN ATTENTE (pas de modification possible) -->
            <div class="text-center py-8">
                <div class="mb-4">
                    <span class="text-6xl">⏳</span>
                </div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Devis envoyé !</h2>
                <p class="text-gray-600 mb-6">En attente de validation par l'entreprise</p>
                
                <!-- Récap du devis envoyé -->
                <div class="bg-yellow-50 p-6 rounded-lg mb-6">
                    <h4 class="font-bold text-yellow-800 mb-4">📋 Votre proposition :</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <span class="text-sm text-gray-600">Prix :</span>
                            <p class="text-xl font-bold text-green-600">{{ number_format($devis->prix, 0, ',', ' ') }} €</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Délai :</span>
                            <p class="text-lg font-medium">{{ $devis->delai }}</p>
                        </div>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Description :</span>
                        <p class="text-gray-700 mt-2">{{ $devis->description_devis }}</p>
                    </div>
                </div>
                
                <div class="bg-blue-50 p-4 rounded-lg mb-6">
                    <p class="text-blue-700">
                        💡 L'entreprise examine votre proposition. Vous ne pouvez plus la modifier.
                    </p>
                </div>
                
                <button onclick="location.reload()" 
                        class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
                    🔄 Actualiser
                </button>
            </div>

        @elseif($devis->etat_devis === 'accepte')
            <!-- ✅ DEVIS ACCEPTÉ -->
            <div class="text-center py-8">
                <div class="mb-4">
                    <span class="text-6xl">🎉</span>
                </div>
                <h2 class="text-2xl font-bold mb-4 text-green-800">Devis accepté !</h2>
                <p class="text-green-600 mb-6">L'entreprise a validé votre proposition</p>
                
                <a href="{{ route('dev.gestion-mission', ['mission_id' => $mission->id_mission]) }}" 
                   class="bg-green-600 text-white px-8 py-3 rounded hover:bg-green-700 transition">
                    🔧 Gérer le projet
                </a>
            </div>
        @endif

        <!-- Navigation -->
        <div class="mt-8 text-center">
            <a href="{{ route('dev.gestion-mission', ['mission_id' => $mission->id_mission]) }}" 
               class="bg-gray-500 text-white px-6 py-3 rounded hover:bg-gray-600 transition">
                ← Retour à la mission
            </a>
        </div>
    </div>
</section>
@endsection