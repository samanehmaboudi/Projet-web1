{{ include('layouts/header-auth.php', { title: 'Réinitialisation du mot de passe' }) }}

<div class="container">
    <h2>Réinitialiser votre mot de passe</h2>
    <p>Entrez votre email pour recevoir un lien de réinitialisation.</p>

    {% if reset_success %}
        <div class="success-message">{{ reset_success }}</div>
    {% endif %}

    <form action="{{ path }}" method="post">
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
            <input type="submit" class="btn" value="Envoyer">
        </div>
    </form>
</div>

{{ include('layouts/footer-auth.php') }}
