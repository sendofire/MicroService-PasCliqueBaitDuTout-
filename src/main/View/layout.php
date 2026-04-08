<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?php echo $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo htmlspecialchars(urlFor('/style.css')); ?>" />
</head>
<body>
<nav>
    <a href="<?php echo htmlspecialchars(urlFor('/plats')); ?>">🍽️ Plats</a>
    <a href="<?php echo htmlspecialchars(urlFor('/menu')); ?>">📋 Composer menu</a>
    <a href="<?php echo htmlspecialchars(urlFor('/commande')); ?>">🛒 Commander</a>
</nav>

<main>
    <?php echo $content; ?>
</main>

<footer>
    <p>&copy; 2026 PasCliqueBaitDuTout - Microservice IHM</p>
</footer>
</body>
</html>