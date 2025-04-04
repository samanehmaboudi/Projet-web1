{% include 'layouts/header-auth.php' %} 

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

        <label for="creationDate">Année de création :</label>
        <select name="creationDate" id="creationDate" required>
         {% for year in 1850..2025 %}
            <option value="{{ year }}">{{ year }}</option>
        {% endfor %}
       </select>


        <label for="price">Prix :</label>
        <input type="number" name="price" id="price" step="0.01" required maxlength="255">

        <label for="description">Description :</label>
        <textarea name="description" id="description" rows="4" required placeholder="Décrivez le timbre, son histoire, sa valeur..."></textarea>

        <label for="condition_id">Condition :</label>
<select name="condition_id" id="condition_id" required>
    <option disabled selected>-- Sélectionner une condition --</option>
    {% for cond in conditions %}
        <option value="{{ cond.id }}">{{ cond.name }}</option>
    {% endfor %}
</select>

<label for="country_id">Pays :</label>
<select name="country_id" id="country_id" required>
    <option disabled selected>-- Sélectionner un pays --</option>
    {% for country in countries %}
        <option value="{{ country.id }}">{{ country.name }}</option>
    {% endfor %}
</select>

<label for="category_id">Catégorie :</label>
<select name="category_id" id="category_id" required>
    <option disabled selected>-- Sélectionner une catégorie --</option>
    {% for cat in categories %}
        <option value="{{ cat.id }}">{{ cat.name }}</option>
    {% endfor %}
</select>

<label for="color_id">Couleur :</label>
<select name="color_id" id="color_id" required>
    <option disabled selected>-- Sélectionner une couleur --</option>
    {% for color in colors %}
        <option value="{{ color.id }}">{{ color.name }}</option>
    {% endfor %}
</select>



        <label for="images">Images (vous pouvez en sélectionner plusieurs) :</label>
        <input type="file" name="images[]" id="images" multiple accept="image/*" required>

        <input type="submit" value="Créer le timbre" class="btn btn-primary">
    </form>
</main>

{% include 'layouts/footer-auth.php' %}
