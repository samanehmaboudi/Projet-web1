{% include 'layouts/header-auth.php' %}

<main class="admin-promote-container">
    <h2 class="page-title">Promouvoir en administrateur</h2>

    <div class="promote-message">
        <p>Souhaitez-vous vraiment donner le rôle <strong>d’administrateur</strong> à <strong>{{ user.name }}</strong> ?</p>
        <p>Il aura alors accès à l’interface d’administration.</p>

        <form method="post" class="form-promote">
            <input type="hidden" name="id" value="{{ user.id }}">
            <input type="hidden" name="role" value="admin">
            <button type="submit" class="btn btn-success">Oui, promouvoir</button>
            <a href="{{ base }}/admin-users" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</main>

{% include 'layouts/footer-auth.php' %}
