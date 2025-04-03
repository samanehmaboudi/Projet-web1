<!DOCTYPE html> 
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ title|default('Authentification') }}</title>
    <link rel="stylesheet" href="{{ asset }}/assets/css/auth.css">
    <link rel="stylesheet" href="{{ asset }}/assets/css/admin.css">
</head>
<body>

<nav>
    <ul class="nav-auth">
        <li><a href="{{ base }}/accueil">Accueil</a></li>
        <li><a href="{{ base }}/catalogue">Catalogue</a></li>
        <li><a href="{{ base }}/login">Connexion</a></li>
        <li><a href="{{ base }}/register">Inscription</a></li>
    </ul>
</nav>

<main>
