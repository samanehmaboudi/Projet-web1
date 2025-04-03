{% include 'layouts/header.php' %}

<main class="container">
    <h2>Détails du timbre</h2>

    <p><strong>Nom :</strong> {{ stamp.name }}</p>
    <p><strong>Année :</strong> {{ stamp.creationDate|date('Y') }}</p>
    <p><strong>Pays :</strong> {{ stamp.country }}</p>
    <p><strong>Condition :</strong> {{ stamp.condition }}</p>
    <p><strong>Catégorie :</strong> {{ stamp.category }}</p>
    <p><strong>Couleur :</strong> {{ stamp.color }}</p>

    <div class="image-preview">
        {% for image in stamp.images %}
            <img src="{{ asset }}/{{ image.image_url }}" alt="Image timbre" style="max-width:150px;">
        {% endfor %}
    </div>

    <a href="{{ base }}/edit-stamp?id={{ stamp.id }}" class="btn">Modifier</a>
    <a href="{{ base }}/delete-stamp?id={{ stamp.id }}" class="btn danger">Supprimer</a>
</main>

{% include 'layouts/footer.php' %}
