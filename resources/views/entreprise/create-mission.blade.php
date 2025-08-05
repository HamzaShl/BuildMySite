@extends('base')

@section('title', "Créer une mission")

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-center text-purple-700">Créer une mission pour {{ $dev->prenom_dev }} {{ $dev->nom_dev }}</h1>

    <!-- Infos du dev choisi -->
    <div class="bg-blue-50 p-4 rounded-lg mb-6">
        <div class="flex items-center space-x-4">
            @if($dev->photo)
                <img src="{{ asset('storage/' . $dev->photo) }}" alt="Photo de {{ $dev->prenom_dev }}" class="w-16 h-16 rounded-full object-cover">
            @endif
            <div>
                <h3 class="font-bold text-lg">{{ $dev->prenom_dev }} {{ $dev->nom_dev }}</h3>
                <p class="text-gray-600">{{ ucfirst($dev->specialite_dev) }} - {{ ucfirst($dev->niveau_experience) }}</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            <strong class="font-bold">Succès !</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('missions.store') }}" class="space-y-6">
        @csrf
        
        <!-- Champ caché pour l'ID du dev -->
        <input type="hidden" name="id_dev" value="{{ $dev->id_dev }}">

        <!-- Titre de la mission -->
        <div>
            <label for="titre_mission" class="block text-sm font-medium text-gray-700 mb-2">
                Titre de la mission *
            </label>
            <input 
                type="text" 
                name="titre_mission" 
                id="titre_mission" 
                class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                placeholder="Ex: Développement d'un site e-commerce"
                value="{{ old('titre_mission') }}"
                required
            >
            @error('titre_mission')
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Description de la mission -->
        <div>
            <label for="description_mission" class="block text-sm font-medium text-gray-700 mb-2">
                Description détaillée de la mission *
            </label>
            <textarea 
                name="description_mission" 
                id="description_mission" 
                rows="8"
                class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                placeholder="Décrivez en détail votre projet :
- Objectifs du projet
- Technologies souhaitées  
- Fonctionnalités attendues
- Délais approximatifs
- Budget indicatif
- Contraintes particulières"
                required
            >{{ old('description_mission') }}</textarea>
            @error('description_mission')
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Boutons -->
        <div class="flex space-x-4 pt-4">
            <button 
                type="submit" 
                class="flex-1 bg-purple-700 text-white py-3 px-6 rounded-lg hover:bg-purple-600 transition duration-200 font-medium"
            >
                📨 Envoyer la mission à {{ $dev->prenom_dev }}
            </button>
            
            <a 
                href="{{ route('entreprises.index') }}" 
                class="flex-1 bg-gray-300 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-400 transition duration-200 font-medium text-center"
            >
                ❌ Annuler
            </a>
        </div>
    </form>
</div>
@endsection