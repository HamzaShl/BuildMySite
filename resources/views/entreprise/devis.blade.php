@extends('base')

@section('content')
<div class="bg-gray-100 p-6 text-center">
    <h1 class="text-4xl font-bold mb-2">📋 Suivi de votre mission</h1>
    <p class="text-gray-700 text-lg">{{ $mission->titre_mission }}</p>
</div>

<section class="p-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
            {{ session('info') }}
        </div>
    @endif

    <div class="max-w-4xl mx-auto">
        <!-- Rappel de la mission -->
        <div class="bg-blue-50 p-6 rounded-lg mb-8">
            <h2 class="text-xl font-bold mb-4 text-blue-800">📋 Votre mission :</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <span class="font-medium text-gray-600">Titre :</span>
                    <span class="ml-2">{{ $mission->titre_mission }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Développeur :</span>
                    <span class="ml-2">{{ $mission->dev->prenom_dev }} {{ $mission->dev->nom_dev }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Créée le :</span>
                    <span class="ml-2">{{ $mission->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">État :</span>
                    <span class="ml-2 px-3 py-1 rounded-full text-sm font-medium
                        @if($mission->etat_mission === 'en_cours') bg-blue-100 text-blue-800
                        @elseif($mission->etat_mission === 'terminee') bg-green-100 text-green-800
                        @elseif($mission->etat_mission === 'refusee') bg-red-100 text-red-800
                        @else bg-red-100 text-red-800 @endif">
                        @if($mission->etat_mission === 'en_cours') 🔄 En cours
                        @elseif($mission->etat_mission === 'terminee') ✅ Terminée
                        @elseif($mission->etat_mission === 'refusee') ❌ Refusée
                        @else ❌ Annulée @endif
                    </span>
                </div>
            </div>
            <div class="bg-white p-4 rounded">
                <h4 class="font-medium text-gray-700 mb-2">📝 Description :</h4>
                <p class="text-gray-700">{{ $mission->description_mission }}</p>
            </div>
        </div>

        <!-- État du devis -->
        <div class="bg-white p-8 rounded-lg shadow-lg">
            @if(!$devis)
                @if($mission->etat_mission === 'refusee')
                    <!-- ❌ MISSION REFUSÉE -->
                    <div class="text-center py-12">
                        <div class="mb-4">
                            <span class="text-6xl">❌</span>
                        </div>
                        <h3 class="text-2xl font-bold text-red-800 mb-4">Mission refusée</h3>
                        <p class="text-red-600 text-lg mb-6">
                            Le développeur <strong>{{ $mission->dev->prenom_dev }} {{ $mission->dev->nom_dev }}</strong> 
                            a refusé cette mission.
                        </p>
                        
                        <div class="bg-red-50 p-6 rounded-lg mb-6">
                            <p class="text-red-700">
                                💡 Vous pouvez choisir un autre développeur pour votre projet.
                            </p>
                        </div>
                        
                        <a href="{{ route('devs.index') }}" 
                           class="bg-blue-600 text-white px-8 py-3 rounded hover:bg-blue-700 transition text-lg">
                            👨‍💻 Retour à la liste des développeurs
                        </a>
                    </div>
                @else
                    <!-- ⏳ EN ATTENTE DU DEVIS -->
                    <div class="text-center py-12">
                        <div class="mb-6">
                            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">⏳ Devis en cours de création</h3>
                        <p class="text-gray-600 text-lg mb-2">
                            <strong>{{ $mission->dev->prenom_dev }} {{ $mission->dev->nom_dev }}</strong> 
                            est en train de préparer votre devis.
                        </p>
                        <p class="text-gray-500 mb-6">
                            Vous recevrez une notification dès que le devis sera prêt pour validation.
                        </p>
                        
                        <div class="bg-yellow-50 p-6 rounded-lg mb-6">
                            <h4 class="font-bold text-yellow-800 mb-2">💡 En attendant :</h4>
                            <ul class="text-yellow-700 text-left space-y-2">
                                <li>• Le développeur analyse votre demande</li>
                                <li>• Il évalue la complexité technique</li>
                                <li>• Il prépare un devis personnalisé</li>
                            </ul>
                        </div>
                        
                        <!-- Bouton pour actualiser -->
                        <div class="flex justify-center space-x-4">
                            <button onclick="location.reload()" 
                                    class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
                                🔄 Actualiser la page
                            </button>
                            
                            <a href="{{ route('entreprises.index') }}" 
                               class="bg-gray-500 text-white px-6 py-3 rounded hover:bg-gray-600 transition">
                                ← Retour à l'accueil
                            </a>
                        </div>
                    </div>
                @endif
                
            @else
                <!-- Devis disponible -->
                <h2 class="text-2xl font-bold mb-6 text-gray-800">💰 Proposition de devis reçue :</h2>
                
                <div class="border-2 border-gray-200 rounded-lg p-6 mb-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-gray-800">{{ $devis->titre_devis }}</h3>
                        <span class="px-4 py-2 rounded-full text-sm font-medium
                            @if($devis->etat_devis === 'en_attente') bg-orange-100 text-orange-800
                            @elseif($devis->etat_devis === 'accepte') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            @if($devis->etat_devis === 'en_attente') ⏳ En attente de votre décision
                            @elseif($devis->etat_devis === 'accepte') ✅ Devis accepté
                            @else ❌ Devis refusé @endif
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-green-50 p-4 rounded-lg text-center">
                            <span class="text-sm text-gray-600">💵 Prix proposé :</span>
                            <p class="text-3xl font-bold text-green-600">{{ number_format($devis->prix, 0, ',', ' ') }} €</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg text-center">
                            <span class="text-sm text-gray-600">⏰ Délai de réalisation :</span>
                            <p class="text-xl font-bold text-blue-600">{{ $devis->delai }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="font-bold text-gray-700 mb-3">📝 Description détaillée :</h4>
                        <div class="bg-gray-50 p-4 rounded border-l-4 border-blue-500">
                            <p class="text-gray-700 leading-relaxed">{{ $devis->description_devis }}</p>
                        </div>
                    </div>
                    
                    <div class="text-sm text-gray-500 mb-6">
                        <span class="font-medium">Reçu le :</span> {{ $devis->created_at->format('d/m/Y à H:i') }}
                    </div>
                </div>

                @if($devis->etat_devis === 'en_attente')
                    <!-- Boutons d'action pour devis en attente -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h4 class="text-lg font-bold mb-4 text-center">🤔 Que souhaitez-vous faire ?</h4>
                        
                        <div class="flex flex-col md:flex-row justify-center gap-4">
                            <!-- Bouton Refuser -->
                            <form method="POST" action="{{ route('entreprises.updateDevisAcceptation', $devis->id_devis) }}" class="flex-1">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="refuser">
                                <button type="submit" 
                                        class="w-full bg-red-600 text-white px-8 py-4 rounded-lg hover:bg-red-700 transition text-lg font-medium"
                                        onclick="return confirm('⚠️ Êtes-vous sûr de vouloir refuser ce devis ?\n\n• Le devis sera supprimé\n• Le développeur devra créer un nouveau devis\n• Vous pourrez renégocier les conditions')">
                                    ❌ Refuser le devis
                                    <div class="text-sm opacity-75 mt-1">Le développeur pourra refaire une proposition</div>
                                </button>
                            </form>
                            
                            <!-- Bouton Accepter -->
                            <form method="POST" action="{{ route('entreprises.updateDevisAcceptation', $devis->id_devis) }}" class="flex-1">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="accepter">
                                <button type="submit" 
                                        class="w-full bg-green-600 text-white px-8 py-4 rounded-lg hover:bg-green-700 transition text-lg font-medium">
                                    ✅ Accepter le devis
                                    <div class="text-sm opacity-75 mt-1">Le projet pourra commencer</div>
                                </button>
                            </form>
                        </div>
                        
                        <div class="text-center mt-4">
                            <p class="text-gray-600 text-sm">
                                💬 Des questions ? Contactez <strong>{{ $mission->dev->prenom_dev }} {{ $mission->dev->nom_dev }}</strong> 
                                à l'adresse : <a href="mailto:{{ $mission->dev->email_dev }}" class="text-blue-600 hover:underline">{{ $mission->dev->email_dev }}</a>
                            </p>
                        </div>
                    </div>
                    
                @elseif($devis->etat_devis === 'accepte')
                    <!-- Projet accepté et en cours -->
                    <div class="bg-green-50 p-8 rounded-lg text-center">
                        <div class="mb-4">
                            <span class="text-6xl">🚀</span>
                        </div>
                        <h3 class="text-2xl font-bold text-green-800 mb-4">Projet accepté !</h3>
                        <p class="text-green-700 text-lg mb-2">
                            <strong>{{ $mission->dev->prenom_dev }} {{ $mission->dev->nom_dev }}</strong> 
                            travaille maintenant sur votre projet.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                            <div class="bg-white p-4 rounded">
                                <span class="text-sm text-gray-600">Prix convenu :</span>
                                <p class="font-bold text-green-600 text-xl">{{ number_format($devis->prix, 0, ',', ' ') }} €</p>
                            </div>
                            <div class="bg-white p-4 rounded">
                                <span class="text-sm text-gray-600">Délai prévu :</span>
                                <p class="font-bold text-blue-600 text-xl">{{ $devis->delai }}</p>
                            </div>
                        </div>
                        
                        <!-- ✅ SECTION BOUTON AVIS AJOUTÉE -->
                        @if($mission->etat_mission === 'terminee')
                            <!-- Mission terminée - Bouton avis -->
                            <div class="mt-6 bg-blue-50 p-4 rounded-lg">
                                <h4 class="font-bold text-blue-800 mb-3">🎉 Mission terminée !</h4>
                                <p class="text-blue-700 mb-4">Partagez votre expérience avec ce développeur</p>
                                
                                @php
                                    $avisExistant = App\Models\Commentaire::where('id_entreprise', Auth::guard('entreprise')->user()->id_entreprise)
                                                                         ->where('id_dev', $mission->id_dev)
                                                                         ->exists();
                                @endphp
                                
                                @if($avisExistant)
                                    <span class="text-green-600 font-medium">✅ Vous avez déjà laissé un avis pour ce développeur</span>
                                @else
                                    <a href="{{ route('commentaires.create', $mission->id_dev) }}" 
                                       class="bg-orange-500 text-white px-6 py-3 rounded hover:bg-orange-600 transition">
                                        ⭐ Laisser un avis
                                    </a>
                                @endif
                            </div>
                        @else
                            <p class="text-green-600 text-sm mt-4">
                                Vous serez notifié lors des étapes importantes du développement.
                            </p>
                        @endif
                    </div>
                @endif
            @endif

            <!-- Navigation -->
            <div class="mt-8 text-center">
                <a href="{{ route('entreprises.index') }}" 
                   class="bg-gray-500 text-white px-6 py-3 rounded hover:bg-gray-600 transition">
                    ← Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</section>
@endsection