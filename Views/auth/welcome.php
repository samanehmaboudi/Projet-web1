{{ include('layouts/header-auth.php', { title: 'Bienvenue sur Lord Stampee' }) }}

<div class="container">
    <h1>Bonjour <b>{{ session.username|e }}</b>, bienvenue sur notre site !</h1>

    {% if session.privilege == 'admin' %}
        <p class="admin-message">Vous êtes un <strong>Administrateur</strong> 🎩</p>
    {% else %}
        <p class="user-message">Vous êtes un utilisateur régulier.</p>
    {% endif %}

    <div style="margin-top: 20px;">
        <a href="{{ base }}/reset-password" class="btn warning">Réinitialiser le mot de passe</a>
        <a href="{{ base }}/logout" class="btn danger">Se déconnecter</a>
        <a href="{{ base }}/accueil" class="btn-accueil">Page d’accueil</a>
    </div>
</div>

{{ include('layouts/footer-auth.php') }}
