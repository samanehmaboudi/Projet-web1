{# views/auth/login.php #}
{{ include('layouts/header-auth.php', { title: 'Connexion' }) }}

<div class="container">
    <h2>Connexion</h2>
    <p>Veuillez entrer vos identifiants pour vous connecter.</p>

    {# Message flash après inscription ou déconnexion #}
    {% if session.flash %}
        <div class="alert alert-success">{{ session.flash }}</div>
    {% endif %}

    {% if logout_success %}
        <div class="success-message">{{ logout_success }}</div>
    {% endif %}

    {% if login_err %}
        <div class="error-message">{{ login_err }}</div>
    {% endif %}
{{path}}
    <form action="{{ base }}/login" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="{{ email_err ? 'input-error' : '' }}" 
                value="{{ email|e }}"
                autocomplete="email"
            >
            {% if email_err %}
                <div class="error-message">{{ email_err }}</div>
            {% endif %}
        </div>    

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="{{ password_err ? 'input-error' : '' }}"
                autocomplete="current-password"
            >
            {% if password_err %}
                <div class="error-message">{{ password_err }}</div>
            {% endif %}
        </div>

        <div class="form-group">
            <input type="submit" class="btn" value="Connexion">
        </div>

        <p>Pas encore de compte ? <a href="{{ base }}/register">Inscrivez-vous</a>.</p>
    </form>
</div>

{{ include('layouts/footer-auth.php') }}
