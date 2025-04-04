{% include 'layouts/header-auth.php' %}

<main class="container-dashboard">
    <h2>SuperAdmin — Tableau de bord</h2>
    <p>Bienvenue {{ session.username }} !</p>

    <ul>
        <li><a href="{{ base }}/admin-users">Gérer les utilisateurs</a></li>
        <li><a href="#">Gérer les privilèges</a></li>
        <li><a href="#">Supervision du système</a></li>
    </ul>
</main>

{% include 'layouts/footer-auth.php' %}
