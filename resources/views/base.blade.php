<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Oswald', sans-serif;
    }
    </style>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title')</title>
</head>
<body>

<!-- Navigation responsive - links restent à droite -->
<nav class="bg-gray-900 text-white p-4 md:p-6 flex justify-between items-start">
    <div class="text-lg md:text-xl font-bold">
        <a href="/" class="">BuildMySite</a>
    </div>

    <div class="flex flex-col sm:flex-row items-end sm:items-center space-y-2 sm:space-y-0 sm:space-x-4 text-right">
        @auth('entreprise')
            <!-- Si une entreprise est connectée -->
            <a href="{{ route('entreprises.edit', Auth::guard('entreprise')->user()->id_entreprise) }}" 
               class="text-white hover:underline text-sm md:text-base">Profil</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-white hover:underline text-sm md:text-base">Déconnexion</button>
            </form>
        @elseauth('dev')
            <!-- Si un dev est connecté -->
            <a href="{{ route('devs.edit', Auth::guard('dev')->user()->id_dev) }}" 
               class="text-white hover:underline text-sm md:text-base">Profil</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-white hover:underline text-sm md:text-base">Déconnexion</button>
            </form>
        @else
            <!-- Si personne n'est connecté -->
            <a href="{{ route('login') }}" class="text-white hover:underline text-sm md:text-base">Connexion</a>
            <a href="{{ route('register') }}" class="text-white hover:underline text-sm md:text-base">Inscription</a>
        @endauth
    </div>
</nav>

<div>
    @yield('content')
</div>

@yield('scripts')

</body>
</html>