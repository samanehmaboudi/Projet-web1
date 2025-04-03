{% include 'layouts/header.php' %} 

<main class="container">
    <h2>Ajouter un nouveau timbre</h2>

    {% if errors is defined %}
        <div class="error">
            <ul>
                {% for error in errors %}
                    <li>{{ error }}</li>
                {% endfor %}
            </ul>
        </div>
    {% endif %}

    <form method="post" enctype="multipart/form-data" class="form-ajout-timbre">
        <label for="name">Nom du timbre :</label>
        <input type="text" name="name" id="name" required>

        <label for="creationDate">Date de création :</label>
        <input type="date" name="creationDate" id="creationDate" required>

        <label for="price">Prix :</label>
        <input type="number" name="price" id="price" step="0.01" required>

        <label for="description">Description :</label>
        <textarea name="description" id="description" rows="4" required placeholder="Décrivez le timbre, son histoire, sa valeur..."></textarea>

        <label for="condition_id">Condition :</label>
        <select name="condition_id" id="condition_id" required>
            {% for cond in conditions %}
                <option value="{{ cond.id }}">{{ cond.name }}</option>
            {% endfor %}
        </select>

        <label for="country_id">Pays :</label>
        <select name="country_id" id="country_id" required>
            {% for country in countries %}
                <option value="{{ country.id }}">{{ country.name }}</option>
            {% endfor %}
        </select>

        <label for="category_id">Catégorie :</label>
        <select name="category_id" id="category_id" required>
            {% for cat in categories %}
                <option value="{{ cat.id }}">{{ cat.name }}</option>
            {% endfor %}
        </select>

        <label for="color_id">Couleur :</label>
        <select name="color_id" id="color_id" required>
            {% for color in colors %}
                <option value="{{ color.id }}">{{ color.name }}</option>
            {% endfor %}
        </select>

        <label for="images">Images (vous pouvez en sélectionner plusieurs) :</label>
        <input type="file" name="images[]" id="images" multiple accept="image/*" required>

        <input type="submit" value="Créer le timbre" class="btn btn-primary">
    </form>
</main>

{% include 'layouts/footer.php' %}
