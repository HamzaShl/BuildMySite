<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Bienvenue sur BuildMySite !</title>
</head>
<body>
    <h1>Bonjour {{ $user['name'] }}</h1>
    <h2>Merci de vous être inscrit sur BuildMySite</h2>
    <p>Votre compte a bien été créé. Vous pouvez dès maintenant : <br>
- Mettre à jour votre profil<br>
- Découvrir les développeurs disponibles (si vous êtes une entreprise)<br>
- Répondre aux projets proposés (si vous êtes un développeur)</p>
    <a href="http://127.0.0.1:8000/login">Accéder au site</a>
    <p>Si vous avez des questions, n'hésitez pas à nous contacter à tout moment.
    </p>
    <p>À très bientôt, <br>
    L’équipe BuildMySite <p>
</body>
</html>