<?php $title = 'Plats disponibles'; ?>

<?php ob_start(); ?>
<h1>Liste des plats</h1>

<?php foreach ($plats as $plat) : ?>
    <div style="margin-bottom:10px; padding:8px; border:1px solid #ccc;">
        <strong><?php echo htmlspecialchars($plat['nom']); ?></strong><br />
        <?php echo htmlspecialchars($plat['description']); ?><br />
        Prix: <?php echo number_format($plat['prix'], 2, ',', ' '); ?> EUR

        <form method="post" action="<?php echo htmlspecialchars(urlFor('/menu/ajouter')); ?>" style="margin-top:6px;">
            <input type="hidden" name="plat_id" value="<?php echo (int)$plat['id']; ?>" />
            <button type="submit">Ajouter au menu</button>
        </form>
    </div>
<?php endforeach; ?>

<?php $content = ob_get_clean(); ?>
<?php require 'layout.php'; ?>

