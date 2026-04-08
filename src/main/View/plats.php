<?php
$title = 'Plats disponibles';
$error = isset($error) ? $error : '';
$plats = isset($plats) && is_array($plats) ? $plats : array();
?>

<?php ob_start(); ?>
<h1>🍽️ Liste des plats disponibles</h1>

<?php if ($error !== '') : ?>
    <div class="alert alert-error">
        <strong>Erreur :</strong> <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if (count($plats) === 0) : ?>
    <p>Aucun plat disponible.</p>
<?php else : ?>
    <div class="card-grid">
        <?php foreach ($plats as $plat) : ?>
            <div class="card">
                <div class="card-title">
                    <?php echo htmlspecialchars($plat['nom']); ?>
                </div>
                <div class="card-description">
                    <?php echo htmlspecialchars($plat['description']); ?>
                </div>
                <div class="card-price">
                    💰 <?php echo number_format((float)$plat['prix'], 2, ',', ' '); ?> EUR
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<hr class="divider" />
<p>
    <a href="<?php echo htmlspecialchars(urlFor('/menu')); ?>" class="btn btn-success">
        Composer ou modifier un menu →
    </a>
</p>

<?php $content = ob_get_clean(); ?>
<?php require 'layout.php'; ?>
