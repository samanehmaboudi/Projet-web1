{% include 'layouts/header.php' %}

<main class="admin-edit-container">
    <h2 class="page-title">Modifier l'utilisateur</h2>

    <form method="post" class="form-edit-user">
        <div class="form-group">
            <label for="name">Nom :</label>
            <input type="text" name="name" id="name" value="{{ user.name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" value="{{ user.email }}" required>
        </div>

        <div class="form-group">
            <label for="role">Rôle :</label>
            <select name="role" id="role" required>
                {% for p in privileges %}
                    <option value="{{ p.id }}" {% if user.privilege_id == p.id %}selected{% endif %}>
                        {{ p.privilege }}
                    </option>
                {% endfor %}
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Sauvegarder</button>
            <a href="{{ base }}/admin-users" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</main>

{% include 'layouts/footer.php' %}
