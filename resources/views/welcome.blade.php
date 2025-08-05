@extends('base')

@section('title', 'Accueil')

@section('content')
    <div class="text-center mt-6 md:mt-10 max-w-5xl mx-auto px-4 md:px-6">
        <!-- ✅ Titre responsive -->
        <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4 md:mb-6">
            Bienvenue sur BuildMySite
        </h1>

        <!-- ✅ Paragraphe responsive -->
        <p class="text-base md:text-lg lg:text-xl xl:text-2xl 
           leading-relaxed text-gray-700 
           mx-2 my-6 md:mx-6 md:my-10 lg:mx-16">
            BuildMySite est une plateforme qui facilite la mise en relation entre
            des développeurs freelances qualifiés et des entreprises à la
            recherche de compétences spécifiques pour leurs projets web.
        </p>

        @guest
            <!-- ✅ Boutons responsive -->
            <div class="mt-6 md:mt-8 flex flex-col sm:flex-row 
                 gap-3 sm:gap-4 justify-center items-center">
                <a href="{{ route('login') }}" 
                   class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 
                   text-white px-6 py-3 rounded-lg text-center 
                   transition-colors duration-200 font-medium">
                    Connexion
                </a>
                <a href="{{ route('register') }}" 
                   class="w-full sm:w-auto bg-green-600 hover:bg-green-700 
                   text-white px-6 py-3 rounded-lg text-center 
                   transition-colors duration-200 font-medium">
                    Inscription
                </a>
            </div>
        @endguest
    </div>
@endsection