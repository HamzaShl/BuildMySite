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

<nav class="bg-gray-900 text-white p-6 flex justify-between items-center">
    <div class="text-xl font-bold">
        <a href="/" class="">BuildMySite</a>
    </div>

    <div class="flex items-center space-x-4">
        @auth('entreprise')
            <!-- Si une entreprise est connectée -->
            <a href="{{ route('entreprises.edit', Auth::guard('entreprise')->user()->id_entreprise) }}" class="text-white hover:underline">Profil</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-white hover:underline">Déconnexion</button>
            </form>
        @elseauth('dev')
            <!-- Si un dev est connecté -->
            <a href="{{ route('devs.edit', Auth::guard('dev')->user()->id_dev) }}" class="text-white hover:underline">Profil</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-white hover:underline">Déconnexion</button>
            </form>
        @else
            <!-- Si personne n'est connecté -->
            <a href="{{ route('login') }}" class="text-white hover:underline">Connexion</a>
            <a href="{{ route('register') }}" class="text-white hover:underline">Inscription</a>
        @endauth
    </div>
</nav>

<div>
    @yield('content')
</div>

@yield('scripts')

</body>
</html>