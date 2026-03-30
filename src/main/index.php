<?php

session_start();

require_once 'model.php';
require_once 'Controllers.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$scriptDir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/.');

$path = $uri;
if ($scriptDir !== '' && $scriptDir !== '/' && strpos($path, $scriptDir) === 0) {
    $path = substr($path, strlen($scriptDir));
}

$path = '/' . ltrim($path, '/');
if (strpos($path, '/index.php') === 0) {
    $path = substr($path, strlen('/index.php'));
}

$path = '/' . trim($path, '/');
if ($path === '//') {
    $path = '/';
}
if ($path === '/') {
    $path = '/plats';
}

if ($path === '/plats' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    platsAction();
} elseif ($path === '/menu' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    menuAction();
} elseif ($path === '/menu/ajouter' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    menuAddAction();
} elseif ($path === '/menu/retirer' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    menuRemoveAction();
} elseif ($path === '/menu/sauver' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    menuSaveAction();
} elseif ($path === '/commande' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    commandeAction();
} elseif ($path === '/commande/valider' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    commandeValidateAction();
} elseif (in_array($path, array('/annonces', '/login', '/post'), true)) {
    header('HTTP/1.1 410 Gone');
    echo '<html><body><h1>410 - Route obsolete</h1><p>Utilisez <a href="' . htmlspecialchars(urlFor('/plats')) . '">la liste des plats</a>.</p></body></html>';
} else {
    header('HTTP/1.1 404 Not Found');
    echo '<html><body><h1>404 - Page non trouvee</h1></body></html>';
}

?>