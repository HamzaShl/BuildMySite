@extends('base')

@section('content')

<div class="bg-gray-100 p-6 text-center">
    <h1 class="text-4xl font-bold mb-2">Bienvenue {{ $entreprise->nom_entreprise }} !</h1>
    <p class="text-gray-700 text-2xl">Voici la page d'accueil. Vous retrouverez ici tous les développeurs inscrits sur la plateforme.<br> A vous de choisir celui qui vous convient juste en dessous en cliquant sur son profil.</p>
</div>

<!-- ✅ AJOUTER CE BLOC POUR LES MESSAGES -->
@if(session('info'))
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4 mx-6">
        {{ session('info') }}
    </div>
@endif

<section class="p-6">
    <h2 class="text-2xl mb-4">Développeurs disponibles</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($devs as $dev)
        <div class="p-4 border rounded">
            <h3 class="text-lg font-bold">{{ $dev->prenom_dev }} {{ $dev->nom_dev }}</h3>
            <p>Spécialité : {{ $dev->specialite_dev }}</p>
            <p>Niveau : {{ $dev->niveau_experience }}</p>
            
            @if($dev->photo)
                <img src="{{ asset('storage/' . $dev->photo) }}" alt="Photo de profil {{ $dev->prenom_dev }}" class="w-16 h-16 rounded-full mt-2">
            @endif
            
            @if($dev->cv)
                <p><a href="{{ asset('storage/' . $dev->cv) }}" alt="cv de {{ $dev->prenom_dev }}" target="_blank" class="text-blue-600">Voir le CV</a></p>
            @endif
            
            @if($dev->portfolio)
                <p><a href="{{ asset('storage/' . $dev->portfolio) }}" alt="portfolio de {{ $dev->prenom_dev }}" target="_blank" class="text-blue-600">Voir le portfolio</a></p>
            @endif

            <!-- ✅ SECTION COMMENTAIRES AJOUTÉE -->
            @if($dev->commentaires && $dev->commentaires->count() > 0)
                <div class="mt-2 bg-gray-50 p-2 rounded">
                    <p class="text-sm font-bold">💬 {{ $dev->commentaires->count() }} avis</p>
                    @foreach($dev->commentaires->take(1) as $commentaire)
                        <p class="text-xs text-gray-600">"{{ Str::limit($commentaire->titre_commentaire, 40) }}"</p>
                        <p class="text-xs text-gray-500">Par {{ $commentaire->entreprise->nom_entreprise }}</p>
                    @endforeach
                    @if($dev->commentaires->count() > 1)
                        <a href="{{ route('commentaires.show', $dev->id_dev) }}" class="text-blue-500 text-xs hover:underline">Voir tous les avis</a>
                    @endif
                </div>
            @else
                <div class="mt-2 bg-yellow-50 p-2 rounded">
                    <p class="text-yellow-600 text-xs">🆕 Aucun avis pour le moment</p>
                </div>
            @endif
            
            <a href="{{ route('missions.create', ['dev_id' => $dev->id_dev]) }}" class="text-blue-600 hover:underline">Choisir ce dev</a>
        </div>
        @endforeach
    </div>
</section>
@endsection