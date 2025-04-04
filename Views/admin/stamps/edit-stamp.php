{% include 'layouts/header-auth.php' %}

<main class="container">
    <h2>Modifier un timbre</h2>

    <form method="POST" enctype="multipart/form-data">
        <label>Nom :</label>
        <input type="text" name="name" value="{{ stamp.name }}">

        <label>Année de création :</label>
        <input type="date" name="creationDate" value="{{ stamp.creationDate|date('Y-m-d') }}">

        <label>Pays :</label>
        <select name="country_id">
            {% for country in countries %}
                <option value="{{ country.id }}" {% if country.id == stamp.country_id %}selected{% endif %}>{{ country.name }}</option>
            {% endfor %}
        </select>

        <label>Condition :</label>
        <select name="condition_id">
            {% for cond in conditions %}
                <option value="{{ cond.id }}" {% if cond.id == stamp.condition_id %}selected{% endif %}>{{ cond.name }}</option>
            {% endfor %}
        </select>

        <label>Catégorie :</label>
        <select name="category_id">
            {% for cat in categories %}
                <option value="{{ cat.id }}" {% if cat.id == stamp.category_id %}selected{% endif %}>{{ cat.name }}</option>
            {% endfor %}
        </select>

        <label>Couleur :</label>
        <select name="color_id">
            {% for color in colors %}
                <option value="{{ color.id }}" {% if color.id == stamp.color_id %}selected{% endif %}>{{ color.name }}</option>
            {% endfor %}
        </select>

        <button type="submit" class="btn success">Enregistrer les modifications</button>
    </form>
</main>

{% include 'layouts/footer-auth.php' %}
