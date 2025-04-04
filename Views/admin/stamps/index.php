{% include 'layouts/header-auth.php' %}

<main class="admin-stamp-container">
    <h2 class="admin-title">Gestion des Timbres</h2>

    <div class="table-container">
        <table class="table-stamps">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Année</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {% for stamp in stamps %}
                    <tr>
                        <td>{{ stamp.id }}</td>
                        <td>{{ stamp.name }}</td>
                        <td>{{ stamp.creationDate|date("Y") }}</td>
                        <td>
                            <img src="{{ asset }}/{{ stamp.image_url }}" alt="{{ stamp.name }}" class="thumbnail">
                        </td>
                        <td>
                            <a href="{{ base }}/show-stamp?id={{ stamp.id }}" class="btn small">Voir</a>
                            <a href="{{ base }}/edit-stamp?id={{ stamp.id }}" class="btn small">Modifier</a>
                            <a href="{{ base }}/delete-stamp?id={{ stamp.id }}" class="btn small red" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                        </td>
                    </tr>
                {% else %}
                    <tr>
                        <td colspan="5">Aucun timbre trouvé.</td>
                    </tr>
                {% endfor %}
            </tbody>
        </table>
    </div>
</main>

{% include 'layouts/footer-auth.php' %}
