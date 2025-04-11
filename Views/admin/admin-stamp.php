<?php include 'layouts/header-auth.php'; ?>

<main class="zone-gestion-timbres">
    <h1 class="titre-gestion">Gestion des Timbres</h1>

    <?php if (isset($_SESSION['flash'])) : ?>
        <div class="message-succes">
            <?= $_SESSION['flash']; unset($_SESSION['flash']); ?>
        </div>
    <?php endif; ?>

    <a href="<?= $_ENV['BASE'] ?? '' ?>/create-stamp" class="bouton-ajout-timbre">➕ Ajouter un nouveau timbre</a>

    <?php if (!empty($stamps)) : ?>
        <table class="tableau-timbres">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Année</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stamps as $timbre) : ?>
                    <tr class="ligne-timbre">
                        <td>
                            <img src="<?= $_ENV['ASSET'] ?? '' ?>/<?= $timbre['image_url']; ?>" alt="<?= $timbre['name']; ?>" class="miniature-timbre">
                        </td>
                        <td><?= htmlspecialchars($timbre['name']); ?></td>
                        <td><?= number_format($timbre['price'], 2, '.', ' ') ?> $</td>
                        <td><?= date('Y', strtotime($timbre['creationDate'])) ?></td>
                        <td>
                            <a href="<?= $_ENV['BASE'] ?? '' ?>/edit-stamp?id=<?= $timbre['id']; ?>" class="lien-modifier">✏️ Modifier</a>
                            <a href="<?= $_ENV['BASE'] ?? '' ?>/delete-stamp?id=<?= $timbre['id']; ?>" class="lien-supprimer" onclick="return confirm('Confirmer la suppression ?');">🗑️ Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p class="aucun-timbre">Aucun timbre enregistré pour le moment.</p>
    <?php endif; ?>
</main>

<?php include 'layouts/footer-auth.php'; ?>
