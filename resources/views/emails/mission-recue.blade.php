<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Nouvelle mission reçue !</title>
</head>
<body>
    <h1>Bonjour {{ $dev->prenom_dev }} {{ $dev->nom_dev }} !</h1>
    <p>Vous avez reçu une nouvelle mission de <strong>{{ $mission->entreprise->nom_entreprise }}</strong></p>
    
    <h2>{{ $mission->titre_mission }}</h2>
    <p>{{ $mission->description_mission }}</p>
    
    <a href="http://127.0.0.1:8000/missions/{{ $mission->id_mission }}">Voir la mission</a>
</body>
</html>