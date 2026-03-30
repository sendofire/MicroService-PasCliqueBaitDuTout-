<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?php echo $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
<nav>
    <a href="<?php echo htmlspecialchars(urlFor('/plats')); ?>">Plats</a> |
    <a href="<?php echo htmlspecialchars(urlFor('/menu')); ?>">Composer menu</a> |
    <a href="<?php echo htmlspecialchars(urlFor('/commande')); ?>">Commander</a>
</nav>
<hr />
<?php echo $content; ?>
</body>
</html>