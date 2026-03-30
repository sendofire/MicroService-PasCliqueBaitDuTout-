<?php $title = 'Page obsolete'; ?>

<?php ob_start(); ?>
<h1>Page obsolete</h1>
<p>Le flux login/annonces n'est plus utilise.</p>
<p><a href="<?php echo function_exists('urlFor') ? htmlspecialchars(urlFor('/plats')) : 'index.php/plats'; ?>">Aller aux plats</a></p>
<?php $content = ob_get_clean(); ?>

<?php require 'layout.php'; ?>