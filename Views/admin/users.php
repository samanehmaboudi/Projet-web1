{% include 'layouts/header.php' %}

<h2>Gestion des utilisateurs</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        {% if users|length > 0 %}
            {% for user in users %}
                <tr>
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.role|capitalize }}</td>
                    <td>
                        <a href="{{asset}}/make-admin?id={{ user.id }}">Rendre admin</a>
                        <a href="{{asset}}/edit-user?id={{ user.id }}">Modifier</a>
                        <a href="{{asset}}/delete-user?id={{ user.id }}" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                    </td>
                </tr>
            {% endfor %}
        {% else %}
            <tr>
                <td colspan="5">Aucun utilisateur trouvé.</td>
            </tr>
        {% endif %}
    </tbody>
</table>

{% include 'layouts/footer.php' %}
