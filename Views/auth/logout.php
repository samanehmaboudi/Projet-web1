{{ include('layouts/header-auth.php', { title: 'Déconnexion' }) }}

<div class="container">
    <h1>Vous avez été déconnecté</h1>
    <p>Merci d'avoir utilisé <strong>Lord Stampee</strong>.</p>
    <a href="{{ base }}/login" class="btn">Se reconnecter</a>
</div>

{{ include('layouts/footer-auth.php') }}
