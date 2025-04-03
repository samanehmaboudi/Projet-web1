{% include 'layouts/header-auth.php' %}

<main class="admin-users-container">
    <h2 class="page-title">Liste des utilisateurs</h2>

    <div class="table-responsive">
        <table class="user-table">
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
                        <td data-label="Nom" class="user-cell">{{ user.name }}</td>
                        <td data-label="Email" class="user-cell">{{ user.email }}</td>
                        <td data-label="Rôle" class="user-cell">{{ user.role }}</td>
                    </tr>
                {% endfor %}
            </tbody>
        </table>
    </div>
</main>

{% include 'layouts/footer-auth.php' %}
