{{ include('layouts/header.php', { title: 'Créer un utilisateur' }) }}

<div class="container">
    <h2>Créer un nouvel utilisateur</h2>

    {% if errors is defined %}
        <div class="error">
            <ul>
                {% for error in errors %}
                    <li>{{ error }}</li>
                {% endfor %}
            </ul>
        </div>
    {% endif %}

    <form method="post">
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" value="{{ user.name|default('') }}">

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="{{ user.email|default('') }}">

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password">

        <label for="privilege_id">Rôle :</label>
        <select name="privilege_id">
            <option value="1">Utilisateur</option>
            <option value="2">Admin</option>
        </select>

        <input type="submit" value="Créer" class="btn">
    </form>
</div>

{{ include('layouts/footer.php') }}
