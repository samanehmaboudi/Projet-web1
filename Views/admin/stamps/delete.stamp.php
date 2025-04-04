{% include 'layouts/header-auth.php' %}

<main class="container">
    <h2>Supprimer un timbre</h2>

    <p>Êtes-vous sûr de vouloir supprimer le timbre <strong>{{ stamp.name }}</strong> ?</p>

    <form method="POST">
        <button type="submit" class="btn danger">Oui, supprimer</button>
        <a href="{{ base }}/admin-stamp" class="btn">Annuler</a>
    </form>
</main>

{% include 'layouts/footer-auth.php' %}
