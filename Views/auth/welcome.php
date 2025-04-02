{{ include('layouts/header-auth.php', { title: 'Bienvenue sur Lord Stampee' }) }} 

<div class="container">

    {% if session.privilege == 'admin' %}
        <div class="admin-banner">
            <strong>Bienvenue Administrateur</strong> {{ session.username|e }} !
            <p>Vous avez accès à toutes les fonctionnalités d'administration.</p>
            <a href="{{ base }}/dashboard" class="btn btn-admin">Accéder au Tableau de bord</a>
        </div>
    {% else %}
        <h1>Bonjour <b>{{ session.username|e }}</b>, bienvenue sur notre site !</h1>
        <p class="user-message">Vous êtes un utilisateur régulier.</p>
    {% endif %}

    <div >
        <a href="{{ base }}/reset-password" class="btn warning">Réinitialiser le mot de passe</a>
        <a href="{{ base }}/logout" class="btn danger">Se déconnecter</a>
    </div>

</div>

{{ include('layouts/footer-auth.php') }}
