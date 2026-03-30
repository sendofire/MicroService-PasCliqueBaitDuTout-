<?php $title = 'Commande confirmee'; ?>

<?php ob_start(); ?>
<h1>Commande confirmee</h1>

<p>Numero: <strong><?php echo htmlspecialchars($commande['numero']); ?></strong></p>
<p>Createur du menu: <?php echo htmlspecialchars($commande['creator']); ?></p>
<p>Quantite: <?php echo (int)$commande['quantite']; ?></p>
<p>Adresse: <?php echo nl2br(htmlspecialchars($commande['adresse'])); ?></p>
<p>Date livraison: <?php echo htmlspecialchars($commande['date_livraison']); ?></p>
<p>Total menu: <?php echo number_format($commande['total_menu'], 2, ',', ' '); ?> EUR</p>
<p>Total commande: <strong><?php echo number_format($commande['total_commande'], 2, ',', ' '); ?> EUR</strong></p>

<p><a href="<?php echo htmlspecialchars(urlFor('/plats')); ?>">Revenir aux plats</a></p>

<?php $content = ob_get_clean(); ?>
<?php require 'layout.php'; ?>

