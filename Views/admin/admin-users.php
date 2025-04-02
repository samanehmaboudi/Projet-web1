{% include 'layouts/header.php' %}

<div class="container">
    <h2>Liste des utilisateurs</h2>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
            </tr>
        </thead>
        <tbody>
            {% for user in users %}
                <tr>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.role }}</td>
                </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

{% include 'layouts/footer.php' %}
