{% include 'layouts/header-auth.php' %}

<main class="admin-delete-container">
    <h2 class="page-title">Supprimer un utilisateur</h2>

    <div class="delete-message">
        <p>Êtes-vous sûr de vouloir supprimer l'utilisateur <strong>{{ user.name }}</strong> ?</p>
        <p>Cette action est irréversible.</p>

        <form method="post" class="form-delete">
            <input type="hidden" name="id" value="{{ user.id }}">
            <button type="submit" class="btn btn-danger">Oui, supprimer</button>
            <a href="{{ base }}/admin-users" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</main>

{% include 'layouts/footer-auth.php' %}
