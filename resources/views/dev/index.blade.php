@extends('base')

@section('content')
@if($dev)
    <!-- Si $dev existe, afficher le profil -->
    <div class="bg-gray-100 p-6 text-center">
        <h1 class="text-4xl font-bold mb-2">Bienvenue {{ $dev->prenom_dev }} {{ $dev->nom_dev }} !</h1>
        <p class="text-gray-700 text-lg">{{ $dev->specialite_dev }} - Niveau {{ $dev->niveau_experience }}</p>
    </div>

    <!-- Section pour les entreprises qui ont choisi ce dev (à développer plus tard) -->
    <section class="p-6 bg-blue-50">
        <h2 class="text-2xl mb-4">🎯 Missions proposées</h2>
        <div class="text-center py-8 bg-white rounded-lg">
            <p class="text-gray-600">Aucune mission pour le moment.</p>
            <p class="text-gray-500 text-sm">Les entreprises peuvent vous découvrir et vous proposer des missions !</p>
        </div>
    </section>

    <!-- Profil détaillé -->
    <section class="p-6">
        <h2 class="text-2xl mb-4">Mon Profil</h2>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-start space-x-6">
                @if($dev->photo)
                    <img src="{{ asset('storage/' . $dev->photo) }}" alt="Photo de {{ $dev->prenom_dev }}" class="w-32 h-32 rounded-full object-cover">
                @else
                    <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center">
                        <span class="text-gray-500 text-4xl">👤</span>
                    </div>
                @endif
                
                <div class="flex-1">
                    <h3 class="text-xl font-bold mb-2">{{ $dev->prenom_dev }} {{ $dev->nom_dev }}</h3>
                    <p><strong>Email :</strong> {{ $dev->email_dev }}</p>
                    <p><strong>Spécialité :</strong> {{ ucfirst($dev->specialite_dev) }}</p>
                    <p><strong>Niveau :</strong> {{ ucfirst($dev->niveau_experience) }}</p>
                    
                    @if($dev->description)
                        <p class="mt-4"><strong>Description :</strong></p>
                        <p class="text-gray-700">{{ $dev->description }}</p>
                    @endif
                    
                    <div class="mt-4 space-x-4">
                        @if($dev->cv)
                            <a href="{{ asset('storage/' . $dev->cv) }}" target="_blank" class="text-green-600 hover:underline">📄 Voir mon CV</a>
                        @endif
                        
                        @if($dev->portfolio)
                            <a href="{{ asset('storage/' . $dev->portfolio) }}" target="_blank" class="text-blue-600 hover:underline">💼 Voir mon Portfolio</a>
                        @endif
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('devs.edit', $dev->id_dev) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Modifier mon profil</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@else
    <!-- Si $dev est null, afficher message d'erreur -->
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded m-6">
        <h2 class="text-xl font-bold">Problème de connexion</h2>
        <p>Votre session a expiré ou il y a un problème de connexion.</p>
        <a href="{{ route('login') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 inline-block mt-2">Se reconnecter</a>
    </div>
@endif
@endsection