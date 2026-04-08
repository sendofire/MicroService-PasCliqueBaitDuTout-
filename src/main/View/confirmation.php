<?php $title = 'Commande confirmée'; ?>

<?php ob_start(); ?>
<h1>Commande confirmée !</h1>

<div class="alert alert-success">
    <strong>Votre commande a été enregistrée avec succès !</strong>
</div>

<div class="info-box">
    <p><strong>ID commande :</strong> #<?php echo isset($commande['id']) ? (int)$commande['id'] : 0; ?></p>
    <p><strong>Abonné ID :</strong> <?php echo isset($commande['abonneId']) ? (int)$commande['abonneId'] : 0; ?></p>
    <p><strong>Date commande :</strong> <?php echo htmlspecialchars(isset($commande['dateCommande']) ? $commande['dateCommande'] : 'N/A'); ?></p>
    <p><strong>Adresse livraison :</strong> <?php echo nl2br(htmlspecialchars(isset($commande['adresseLivraison']) ? $commande['adresseLivraison'] : '')); ?></p>
    <p><strong>Date livraison :</strong> <?php echo htmlspecialchars(isset($commande['dateLivraison']) ? $commande['dateLivraison'] : 'N/A'); ?></p>
</div>

<?php $lignes = isset($commande['lignes']) && is_array($commande['lignes']) ? $commande['lignes'] : array(); ?>
<?php if (count($lignes) > 0) : ?>
    <h2>📦 Détail de votre commande</h2>
    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Prix ligne</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lignes as $ligne) : ?>
                <tr>
                    <td><?php echo htmlspecialchars(isset($ligne['menuNom']) ? $ligne['menuNom'] : ('Menu #' . (int)$ligne['menuId'])); ?></td>
                    <td><?php echo (int)$ligne['quantite']; ?></td>
                    <td><?php echo isset($ligne['prixUnitaire']) ? number_format((float)$ligne['prixUnitaire'], 2, ',', ' ') . ' EUR' : '-'; ?></td>
                    <td><?php echo isset($ligne['prixLigne']) ? number_format((float)$ligne['prixLigne'], 2, ',', ' ') . ' EUR' : '-'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<div class="info-box" style="margin-top: 1.5rem;">
    <p style="font-size: 1.2rem;"><strong>💰 Total commande :</strong> <span style="color: var(--accent-color); font-weight: bold; font-size: 1.3rem;"><?php echo number_format((float)(isset($commande['prixTotal']) ? $commande['prixTotal'] : 0), 2, ',', ' '); ?> EUR</span></p>
</div>

<hr class="divider" />
<p>
    <a href="<?php echo htmlspecialchars(urlFor('/plats')); ?>" class="btn btn-success">
        ← Revenir à la liste des plats
    </a>
</p>

<?php $content = ob_get_clean(); ?>
<?php require 'layout.php'; ?>
