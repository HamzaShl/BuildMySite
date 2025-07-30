@extends('base')

@section('content')

<div class="bg-gray-100 p-6 text-center">
    <h1 class="text-4xl font-bold mb-2">Bienvenue {{ $entreprise->nom_entreprise }} !</h1>
    <p class="text-gray-700 text-2xl">Voici la page d'accueil. Vous retrouverez ici tous les développeurs inscrits sur la plateforme.<br> A vous de choisir celui qui vous convient juste en dessous en cliquant sur son profil.</p>
</div>  
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
            <a href="#" class="text-blue-600 hover:underline">Choisir ce dev</a>
        </div>
        @endforeach
    </div>
</section>
@endsection
