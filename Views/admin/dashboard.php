

{% include 'layouts/header.php' %}

<main class="container-dashboard ">
    <h2>Tableau de bord Administrateur</h2>
    <p>Bienvenue {{ session.username }}. Ici, vous pouvez gérer les utilisateurs, enchères, et plus.</p>

    <ul>
        <li><a href="{{ base }}/admin-users">Voir les utilisateurs</a></li>
        <li><a href="#">Gérer les enchères</a></li>
        <li><a href="#">Consulter les statistiques</a></li>
    </ul>
</main>

{% include 'layouts/footer.php' %}
