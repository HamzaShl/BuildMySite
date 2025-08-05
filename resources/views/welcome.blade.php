@extends('base')

@section('title', 'Accueil')

@section('content')
    <div class="text-center mt-10 max-w-3xl mx-auto px-4">
        <h1 class="text-6xl font-bold mb-6">Bienvenue sur BuildMySite</h1>

        <p class="text-2xl leading-relaxed text-gray-700 m-20">
            BuildMySite est une plateforme qui facilite la mise en relation entre 
            des développeurs freelances qualifiés et des entreprises à la recherche 
            de compétences spécifiques pour leurs projets web.<br> Que vous soyez une entreprise 
            à la recherche d’un développeur front-end, back-end ou fullstack, ou un freelance 
            en quête de missions pertinentes, notre site vous permet de collaborer de manière 
            simple, rapide et sécurisée.
        </p>

        @guest
            <div class="mt-8 space-x-4">
                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Connexion
                </a>
                <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Inscription
                </a>
            </div>
        @endguest
    </div>
@endsection
