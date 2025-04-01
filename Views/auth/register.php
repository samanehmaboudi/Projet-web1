{{ include('layouts/header-auth.php', { title: 'Inscription' }) }}

<div class="container">
    <h2>{{ 'register-admin' in path ? 'Inscription Admin' : 'Créer un compte' }}</h2>
    <p>
        {{ 'register-admin' in path 
            ? 'Veuillez remplir le formulaire pour créer un compte administrateur.' 
            : 'Veuillez remplir le formulaire pour créer un compte utilisateur.' 
        }}
    </p>

    <form action="{{ path }}" method="post">
        <div class="form-group">
            <label>Nom d'utilisateur</label>
            <input 
                type="text" 
                name="username" 
                class="{{ username_err ? 'input-error' : '' }}" 
                value="{{ username|e }}"
            >
            {% if username_err %}
                <div class="error-message">{{ username_err }}</div>
            {% endif %}
        </div>  

        <div class="form-group">
            <label>Email</label>
            <input 
                type="email" 
                name="email" 
                class="{{ email_err ? 'input-error' : '' }}" 
                value="{{ email|e }}"
            >
            {% if email_err %}
                <div class="error-message">{{ email_err }}</div>
            {% endif %}
        </div>

        <div class="form-group">
            <label>Mot de passe</label>
            <input 
                type="password" 
                name="password" 
                class="{{ password_err ? 'input-error' : '' }}"
            >
            {% if password_err %}
                <div class="error-message">{{ password_err }}</div>
            {% endif %}
        </div>

        <div class="form-group">
            <label>Confirmer le mot de passe</label>
            <input 
                type="password" 
                name="confirm_password" 
                class="{{ confirm_password_err ? 'input-error' : '' }}"
            >
            {% if confirm_password_err %}
                <div class="error-message">{{ confirm_password_err }}</div>
            {% endif %}
        </div>

        <div class="form-group">
            <input type="submit" class="btn" value="S'inscrire">
            <input type="reset" class="btn warning" value="Réinitialiser">
        </div>

        <p>Déjà inscrit ? <a href="{{ base }}/login">Connectez-vous</a>.</p>
    </form>
</div>

{{ include('layouts/footer-auth.php') }}
