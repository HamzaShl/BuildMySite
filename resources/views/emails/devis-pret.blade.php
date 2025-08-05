<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Votre devis est prêt !</title>
</head>
<body>
    <h1>Bonjour {{ $entreprise->nom_entreprise }} !</h1>
    <p>Le développeur a terminé votre devis pour : <strong>{{ $devis->titre_devis }}</strong></p>    
    <a href="http://127.0.0.1:8000/liste-devis/{{ $devis->id_mission }}">Voir le devis</a>
</body>
</html>