{% include 'layouts/header.php' %}

<main>
    <div class="aaa">

        <div class="filtre-container">
            <h3>Filtrer les timbres</h3>

            <!-- Année d'émission -->
            <div class="filtre-group">
                <label for="filtre-annee">Année d’émission</label>
                <div class="filtre-range">
                    <input type="range" id="filtre-annee" name="filtre-annee" min="1850" max="2024" value="1850">
                    <span>1850</span> - <span>2024</span>
                </div>
            </div>

            <!-- Pays d'origine -->
            <div class="filtre-group">
                <label for="filtre-pays">Pays d'origine</label>
                <select id="filtre-pays" name="filtre-pays">
                    <option value="">recherche</option>
                    <option value="canada">Canada</option>
                    <option value="usa">USA</option>
                    <option value="france">France</option>
                </select>
            </div>

            <!-- Filtrer par Prix -->
            <div class="filtre-group">
                <label for="filtre-prix">Filtrer par Prix</label>
                <div class="filtre-range">
                    <input type="range" id="filtre-prix" name="filtre-prix" min="0" max="7500" value="0">
                    <span>0$</span> - <span>7500$</span>
                </div>
            </div>

            <!-- Catégories -->
            <fieldset class="filtre-section">
                <legend>Catégories</legend>
                <div class="checkbox-group">
                    <label for="filtre-historiques">Historiques</label>
                    <input type="checkbox" id="filtre-historiques">
                </div>
                <div class="checkbox-group">
                    <label for="filtre-modernes">Modernes</label>
                    <input type="checkbox" id="filtre-modernes">
                </div>
                <div class="checkbox-group">
                    <label for="filtre-commemoratifs">Commémoratifs</label>
                    <input type="checkbox" id="filtre-commemoratifs">
                </div>
                <div class="checkbox-group">
                    <label for="filtre-rares">Timbres rares / édition limitée</label>
                    <input type="checkbox" id="filtre-rares">
                </div>
                <div class="checkbox-group">
                    <label for="filtre-animaux">Animaux et nature</label>
                    <input type="checkbox" id="filtre-animaux">
                </div>
            </fieldset>

            <!-- Condition (État du timbre) -->
            <fieldset class="filtre-section">
                <legend>Condition (État du timbre)</legend>
                <div class="checkbox-group">
                    <label for="filtre-neuf">Neuf</label>
                    <input type="checkbox" id="filtre-neuf">
                </div>
                <div class="checkbox-group">
                    <label for="filtre-oblit">Oblit (timbre utilisé)</label>
                    <input type="checkbox" id="filtre-oblit">
                </div>
                <div class="checkbox-group">
                    <label for="filtre-gomme">Avec ou sans gomme</label>
                    <input type="checkbox" id="filtre-gomme">
                </div>
            </fieldset>

            <!-- Popularité -->
            <fieldset class="filtre-section">
                <legend>Popularité</legend>
                <div class="checkbox-group">
                    <label for="filtre-populaires">Les plus populaires</label>
                    <input type="checkbox" id="filtre-populaires">
                </div>
                <div class="checkbox-group">
                    <label for="filtre-nouveautes">Nouveautés</label>
                    <input type="checkbox" id="filtre-nouveautes">
                </div>
                <div class="checkbox-group">
                    <label for="filtre-prix-croissant">Prix croissant / décroissant</label>
                    <input type="checkbox" id="filtre-prix-croissant">
                </div>
            </fieldset>

            <!-- Disponibilité -->
            <fieldset class="filtre-section">
                <legend>Disponibilité</legend>
                <div class="checkbox-group">
                    <label for="filtre-stock">Inclure les articles non en stock</label>
                    <input type="checkbox" id="filtre-stock">
                </div>
            </fieldset>

            <!-- Tranche d'âge -->
            <fieldset class="filtre-section">
                <legend>Tranche d'âge</legend>
                <div class="checkbox-group">
                    <label for="filtre-age">14 ans et plus</label>
                    <input type="checkbox" id="filtre-age">
                </div>
            </fieldset>
        </div>

        <div class="timbres-container">
            <!-- Barre de recherche -->
            <div class="timbres-search-bar">
                <div class="search-box">
                    <label for="recherche-scott" class="visually-hidden">Rechercher par numéro Scott :</label>
                    <input type="text" id="recherche-scott" placeholder="#Scott">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                        <span class="visually-hidden">Rechercher avec le numéro Scott</span>
                    </button>
                </div>
                <div class="search-box">
                    <label for="recherche-annee" class="visually-hidden">Rechercher par année :</label>
                    <input type="text" id="recherche-annee" placeholder="#Année">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                        <span class="visually-hidden">Rechercher avec l'année</span>
                    </button>
                </div>
            </div>

            <div class="banner-devenir-membre">
                <button class="btn-devenir-membre">Devenir Membre</button>
            </div>

            <!-- Pagination -->
            <div class="timbres-pagination">
                <button class="pagination-arrow">
                    <i class="fas fa-chevron-left"></i>
                    <span class="visually-hidden">Page précédente</span>
                </button>
                <span class="page-number">1</span>
                <span class="page-number">2</span>
                <span class="page-number">3</span>
                <span class="dots">...</span>
                <span class="page-number">10</span>
                <button class="pagination-arrow">
                    <i class="fas fa-chevron-right"></i>
                    <span class="visually-hidden">Page suivante</span>
                </button>
            </div>

            <section class="catalogue-container">
                <h2>Collection de Timbres</h2>
                <div class="catalogue-grid">

                {% for stamp in stamps %}
                        <article class="carte">
                            <!-- <a href="{{ base }}/fiche-produit?id={{ stamp.id }}" class="lien-produit">Voir plus de détails</a> -->
                            <figure class="carte-image">
                                <img src="{{ asset }}/{{ stamp.image_url }}" alt="{{ stamp.name }}">
                            </figure>
                            <div class="carte-details">
                                <h3 class="carte-titre">{{ stamp.name }}</h3>
                                <p class="carte-prix">{{ stamp.price | number_format(2, '.', ' ') }} $</p>

                            </div>
                            <nav class="carte-actions">
                                <button aria-label="Ajouter aux favoris"><i class="fa-regular fa-heart"></i></button>
                                <button class="btn-details" onclick="window.location.href='{{ base }}/fiche-produit?id={{ stamp.id }}'">
                                   <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </nav>
                        </article>
                    {% else %}
                        <p>Aucun timbre trouvé.</p>
                    {% endfor %}

                </div>
            </section>
        </div>
    </div>
</main>

{% include 'layouts/footer.php' %}
