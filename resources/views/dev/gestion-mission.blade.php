@extends('base')

@section('content')
<div class="bg-gray-100 p-6 text-center">
    <h1 class="text-4xl font-bold mb-2">🔧 Gestion de mission</h1>
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
            <!-- AUCUN DEVIS CRÉÉ -->
            <div class="text-center py-8">
                <div class="mb-4">
                    <span class="text-6xl">📝</span>
                </div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Vous n'avez pas encore créé de devis</h2>
                <p class="text-gray-600 mb-6">Créez un devis pour cette mission maintenant !</p>
                
                <a href="{{ route('devis.create', ['mission_id' => $mission->id_mission]) }}" 
                   class="bg-blue-600 text-white px-8 py-3 rounded hover:bg-blue-700 transition text-lg">
                    ✏️ Créer un devis
                </a>
            </div>

        @elseif($devis->etat_devis === 'en_attente')
            <!-- ✅ DEVIS EN ATTENTE -->
            <div class="text-center py-8">
                <div class="mb-4">
                    <span class="text-6xl">⏳</span>
                </div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Devis envoyé !</h2>
                <p class="text-gray-600 mb-6">En attente de validation par l'entreprise</p>
                
                <div class="flex justify-center space-x-4">
                    <button onclick="location.reload()" 
                            class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
                        🔄 Actualiser
                    </button>
                    
                    <a href="{{ route('devis.edit', $devis->id_devis) }}" 
                       class="bg-orange-500 text-white px-6 py-3 rounded hover:bg-orange-600 transition">
                        ✏️ Modifier le devis
                    </a>
                </div>
            </div>

        @elseif($devis->etat_devis === 'accepte')
            <!-- ✅ DEVIS ACCEPTÉ - GESTION MISSION -->
            <h2 class="text-2xl font-bold mb-6 text-center">🎉 Devis accepté ! Gestion du projet</h2>
            
            <!-- État actuel -->
            <div class="mb-6 text-center">
                <span class="text-lg text-gray-600">État actuel :</span>
                <span class="ml-2 px-4 py-2 rounded-full text-sm font-medium
                    @if($mission->etat_mission === 'en_cours') bg-blue-100 text-blue-800
                    @elseif($mission->etat_mission === 'terminee') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800 @endif">
                    @if($mission->etat_mission === 'en_cours') 🔄 En cours
                    @elseif($mission->etat_mission === 'terminee') ✅ Terminée
                    @else ❌ Annulée @endif
                </span>
            </div>
            
            <!-- Bouton pour changer l'état -->
            @if($mission->etat_mission !== 'terminee')
                <div class="text-center">
                    <form method="POST" action="{{ route('dev.updateEtatMission', $mission->id_mission) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="etat_mission" value="terminee">
                        <button type="submit" 
                                class="bg-green-600 text-white px-8 py-3 rounded hover:bg-green-700 transition text-lg"
                                onclick="return confirm('✅ Marquer la mission comme terminée ?')">
                            ✅ Marquer comme terminée
                        </button>
                    </form>
                </div>
            @else
                <div class="text-center">
                    <div class="bg-green-100 p-4 rounded-lg">
                        <span class="text-green-600 font-bold text-lg">🎊 Mission terminée !</span>
                    </div>
                </div>
            @endif
        @endif

        <!-- Navigation -->
        <div class="mt-8 text-center">
            <a href="{{ route('devs.index') }}" 
               class="bg-gray-500 text-white px-6 py-3 rounded hover:bg-gray-600 transition">
                ← Retour aux missions
            </a>
        </div>
    </div>
</section>
@endsection