{% include 'layouts/header.php' %}

<main>
    <div class="contenu-principal">
        <header class="titre-produit">
            <h1>{{ stamp.name }}</h1>
        </header>

        <div class="container">
            <aside class="image-container">
                <div class="galerie-images">
                    <i class="fa-solid fa-heart icone-coeur"></i>
                    <div class="miniatures">
                        {% for img in stamp.images %}
                        <img src="{{ asset }}/{{ img.image_url }}" alt="Miniature">
                        {% endfor %}
                    </div>
                    {% set main = stamp.images[0] %}
                    <figure class="image-principale">
                        <img src="{{ asset }}/{{ main.image_url }}" alt="{{ stamp.name }}">
                        <figcaption>{{ stamp.name }} - État impeccable</figcaption>
                    </figure>
                </div>

                <section class="description">
                    <h2>Description</h2>
                    <p class="description-encher">
                        Ce timbre <strong>{{ stamp.name }}</strong>, émis en <strong>{{ stamp.creationDate|date("Y") }}</strong>, est un véritable bijou pour les collectionneurs. <br><br>
                        <strong>Condition :</strong> {{ stamp.condition_name }}<br>
                        <strong>Catégorie :</strong> {{ stamp.category_name }}<br>
                        <strong>Pays :</strong> {{ stamp.country_name }}<br>
                        <strong>Couleur :</strong> {{ stamp.color_name }}<br>
                    </p>
                </section>

                <div id="form-mise-zone">
                    {% if user %}
                    <form method="POST" action="{{ base }}/enchere/miser" class="form-mise">
                        <input type="hidden" name="auction_id" value="{{ stamp.auction_id }}">
                        <label for="amount">💵 Votre mise (min. {{ minimum_bid }} $) :</label>
                        <input type="number" name="amount" step="0.01" min="{{ minimum_bid }}" required>
                        <button type="submit">✅ Placer ma mise</button>
                    </form>
                    {% else %}
                    <p class="alert">⚠️ Connectez-vous pour pouvoir miser.</p>
                    <a href="{{ base }}/login" class="btn-connect">Se connecter</a>
                    {% endif %}
                </div>

                {% if bids %}
                <div class="historique-mises">
                    <h3>💬 Mises récentes</h3>
                    <ul>
                        {% for bid in bids %}
                        <li>{{ bid.user_name }} a misé {{ bid.amount }} $ le {{ bid.date|date("d/m/Y H:i") }}</li>
                        {% endfor %}
                    </ul>
                </div>
                {% else %}
                <p>Aucune mise pour l’instant. Soyez le premier à miser !</p>
                {% endif %}

            </aside>

            <article class="details-produit">
                <h2>Détails du produit</h2>
                <div class="cote-a-cote">
                    <section class="informations">
                        <h3>Caractéristiques du produit</h3>
                        <p><strong>Pays :</strong> {{ stamp.country_name }}</p>
                        <p><strong>État :</strong> {{ stamp.condition_name }}</p>
                        <p><strong>Catégorie :</strong> {{ stamp.category_name }}</p>
                        <p><strong>Couleur :</strong> {{ stamp.color_name }}</p>
                        <p><strong>Année d'émission :</strong> {{ stamp.creationDate|date("Y") }}</p>
                        <button class="btn-ouvrir-formulaire" onclick="document.getElementById('form-mise-zone').scrollIntoView({behavior: 'smooth'})">
                            Miser Maintenant
                        </button>
                        <p class="prix-important"><strong> de départ :</strong> <span>${{ stamp.price }}</span></p>

                    </section>

                    <section class="info-livraison">
                        <h3>Livraison et paiement</h3>
                        <p><strong>Livraison :</strong> Livraison gratuite à partir de 50,00$</p>
                        <p>Retrait GRATUIT en magasin le lundi prochain.</p>
                        <p><strong>Transaction sécurisée</strong></p>
                        <div class="icones-paiement">
                            <i class="fab fa-cc-mastercard mastercard"></i>
                            <i class="fab fa-cc-visa visa"></i>
                            <i class="fab fa-cc-paypal paypal"></i>
                        </div>
                    </section>
                </div>
            </article>
        </div>
    </div>
    <section class="produits-relies">
        <h2>Produits similaires</h2>
        <div class="liste-produits">
            {% for related in relatedStamps %}
            <article class="carte-produit">
                <div class="image-produit">
                    <img src="{{ asset }}/{{ related.image_url }}" alt="{{ related.name }}">
                </div>
                <div class="details-produit">
                    <h3>{{ related.name }}</h3>
                    <a href="{{ base }}/fiche-produit&id={{ related.id }}" class="btn-voir-plus">
                        Voir ce timbre
                    </a>

                    <nav class="carte-actions">
                        <button aria-label="Ajouter aux favoris"><i class="fa-regular fa-heart"></i></button>
                        <button aria-label="Voir plus de détails"><i class="fa-solid fa-arrow-right"></i></button>
                    </nav>
                </div>
            </article>
            {% endfor %}
        </div>
    </section>


</main>

{% include 'layouts/footer.php' %}