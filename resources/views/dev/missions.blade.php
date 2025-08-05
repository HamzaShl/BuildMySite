@extends('base')

@section('content')
<div class="bg-gray-100 p-6 text-center">
    <h1 class="text-4xl font-bold mb-2">Détails de la mission</h1>
    <p class="text-gray-700 text-lg">Proposée par {{ $mission->entreprise->nom_entreprise }}</p>
</div>

<section class="p-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
        <!-- En-tête mission -->
        <div class="border-b pb-6 mb-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-3">{{ $mission->titre_mission }}</h2>
            
            <div class="flex items-center space-x-6 text-sm text-gray-600">
                <span class="flex items-center">
                    <span class="font-medium">Entreprise :</span>
                    <span class="ml-2">{{ $mission->entreprise->nom_entreprise }}</span>
                </span>
                <span class="flex items-center">
                    <span class="font-medium">Date :</span>
                    <span class="ml-2">{{ $mission->created_at->format('d/m/Y à H:i') }}</span>
                </span>
            </div>
            
            <div class="mt-4">
                <span class="px-4 py-2 rounded-full text-sm font-medium
                    @if($mission->etat_mission === 'en_cours') bg-blue-100 text-blue-800
                    @elseif($mission->etat_mission === 'acceptee') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800 @endif">
                    @if($mission->etat_mission === 'en_cours') 🕐 En attente de votre réponse
                    @elseif($mission->etat_mission === 'acceptee') ✅ Mission acceptée
                    @else ❌ Mission refusée @endif
                </span>
            </div>
        </div>

        <!-- Description détaillée -->
        <div class="mb-8">
            <h3 class="text-xl font-bold mb-4 text-gray-800">📋 Description du projet :</h3>
            <div class="bg-gray-50 p-6 rounded-lg">
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $mission->description_mission }}</p>
            </div>
        </div>

        <!-- Informations entreprise -->
        <div class="mb-8 bg-blue-50 p-6 rounded-lg">
            <h3 class="text-xl font-bold mb-4 text-blue-800">🏢 À propos de l'entreprise :</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-600">Nom :</span>
                    <span class="ml-2">{{ $mission->entreprise->nom_entreprise }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Secteur :</span>
                    <span class="ml-2">{{ $mission->entreprise->secteur_entreprise ?? 'Non précisé' }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Taille :</span>
                    <span class="ml-2">{{ $mission->entreprise->taille_entreprise ?? 'Non précisé' }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Type recherché :</span>
                    <span class="ml-2">{{ ucfirst($mission->entreprise->type_freelance ?? 'Non précisé') }}</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center pt-6 border-t">
            <a href="{{ route('devs.index') }}" 
               class="bg-gray-500 text-white px-6 py-3 rounded hover:bg-gray-600 transition">
                ← Retour à mes missions
            </a>

            @if($mission->etat_mission === 'en_cours')
                <div class="flex space-x-4">
                    <!-- Bouton Refuser -->
                    <form method="POST" action="{{ route('missions.updateAcceptation', $mission->id_mission) }}" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="action" value="refuser">
                        <button type="submit" 
                                class="bg-red-600 text-white px-6 py-3 rounded hover:bg-red-700 transition"
                                onclick="return confirm('⚠️ Êtes-vous sûr de vouloir refuser cette mission ?\n\nCette action supprimera définitivement la mission.')">
                            ❌ Refuser la mission
                        </button>
                    </form>
                    
                    <!-- Bouton Accepter -->
                    <form method="POST" action="{{ route('missions.updateAcceptation', $mission->id_mission) }}" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="action" value="accepter">
                        <button type="submit" 
                                class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 transition">
                            ✅ Accepter et créer un devis
                        </button>
                    </form>
                </div>
            @elseif($mission->etat_mission === 'acceptee')
                <a href="{{ route('devis.create', ['mission_id' => $mission->id_mission]) }}" 
                   class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
                    💰 Voir/Créer le devis
                </a>
            @else
                <span class="text-red-600 font-medium">Mission refusée</span>
            @endif
        </div>
    </div>
</section>
@endsection