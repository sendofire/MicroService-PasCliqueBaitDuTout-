<?php

function appBasePath()
{
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
    $base = rtrim(str_replace('\\', '/', dirname($scriptName)), '/.');
    return $base === '/' ? '' : $base;
}

function urlFor($path)
{
    $normalizedPath = '/' . ltrim($path, '/');
    return appBasePath() . '/index.php' . $normalizedPath;
}

function redirectTo($path)
{
    header('Location: ' . urlFor($path));
    exit;
}

function setFlash($key, $message)
{
    $_SESSION['flash_' . $key] = $message;
}

function getFlash($key)
{
    $flashKey = 'flash_' . $key;
    $message = isset($_SESSION[$flashKey]) ? $_SESSION[$flashKey] : '';
    unset($_SESSION[$flashKey]);
    return $message;
}

function platsAction()
{
    $title = 'Plats disponibles';
    $error = '';
    $plats = array();

    try {
        $plats = getAllPlats();
    } catch (RuntimeException $e) {
        $error = $e->getMessage();
    }

    require 'View/plats.php';
}

function menuAction()
{
    $title = 'Composition du menu';
    $error = getFlash('error');
    $success = getFlash('success');

    $menus = array();
    $plats = array();
    $utilisateurs = array();
    $currentMenu = null;

    try {
        $menus = getAllMenus();
        $plats = getAllPlats();
        $utilisateurs = getAllUtilisateurs();
        $currentMenu = getCurrentMenu();
    } catch (RuntimeException $e) {
        if ($error === '') {
            $error = $e->getMessage();
        }
    }

    require 'View/menu.php';
}

function menuSelectAction()
{
    $menuId = isset($_POST['menu_id']) ? (int)$_POST['menu_id'] : 0;
    if ($menuId <= 0) {
        setFlash('error', 'Selection de menu invalide.');
        redirectTo('/menu');
    }

    setCurrentMenuId($menuId);
    redirectTo('/menu');
}

function menuCreateAction()
{
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $createurId = isset($_POST['createur_id']) ? (int)$_POST['createur_id'] : 0;

    if ($nom === '' || $createurId <= 0) {
        setFlash('error', 'Nom du menu et createur obligatoires.');
        redirectTo('/menu');
    }

    try {
        $menu = createMenu($nom, $createurId);
        if (isset($menu['id'])) {
            setCurrentMenuId((int)$menu['id']);
        }
        setFlash('success', 'Menu cree avec succes.');
    } catch (RuntimeException $e) {
        setFlash('error', $e->getMessage());
    }

    redirectTo('/menu');
}

function menuAddAction()
{
    $menuId = getCurrentMenuId();
    $platId = isset($_POST['plat_id']) ? (int)$_POST['plat_id'] : 0;

    if ($menuId <= 0 || $platId <= 0) {
        setFlash('error', 'Selection menu/plat invalide.');
        redirectTo('/menu');
    }

    try {
        addPlatToMenu($menuId, $platId);
        setFlash('success', 'Plat ajoute au menu.');
    } catch (RuntimeException $e) {
        setFlash('error', $e->getMessage());
    }

    redirectTo('/menu');
}

function menuRemoveAction()
{
    $menuId = getCurrentMenuId();
    $platId = isset($_POST['plat_id']) ? (int)$_POST['plat_id'] : 0;

    if ($menuId <= 0 || $platId <= 0) {
        setFlash('error', 'Selection menu/plat invalide.');
        redirectTo('/menu');
    }

    try {
        removePlatFromMenu($menuId, $platId);
        setFlash('success', 'Plat retire du menu.');
    } catch (RuntimeException $e) {
        setFlash('error', $e->getMessage());
    }

    redirectTo('/menu');
}

function commandeAction()
{
    $title = 'Commande';
    $error = getFlash('error');
    $menu = getCurrentMenu();
    $utilisateurs = array();

    try {
        $utilisateurs = getAllUtilisateurs();
    } catch (RuntimeException $e) {
        if ($error === '') {
            $error = $e->getMessage();
        }
    }

    require 'View/commande.php';
}

function commandeValidateAction()
{
    $menuId = getCurrentMenuId();
    $abonneId = isset($_POST['abonne_id']) ? (int)$_POST['abonne_id'] : 0;
    $quantite = isset($_POST['quantite']) ? (int)$_POST['quantite'] : 0;
    $adresse = isset($_POST['adresse']) ? trim($_POST['adresse']) : '';
    $dateLivraison = isset($_POST['date_livraison']) ? trim($_POST['date_livraison']) : '';

    if ($menuId <= 0 || $abonneId <= 0 || $quantite <= 0 || $adresse === '' || $dateLivraison === '') {
        setFlash('error', 'Tous les champs de commande sont obligatoires.');
        redirectTo('/commande');
    }

    try {
        $commande = createCommande($abonneId, $adresse, $dateLivraison, $menuId, $quantite);
    } catch (RuntimeException $e) {
        setFlash('error', $e->getMessage());
        redirectTo('/commande');
    }

    $title = 'Commande confirmee';
    require 'View/confirmation.php';
}

?>