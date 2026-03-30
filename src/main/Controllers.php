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

function platsAction()
{
    $title = 'Plats disponibles';
    $plats = getAllPlats();
    require 'view/plats.php';
}

function menuAction()
{
    $title = 'Composition du menu';
    $items = getMenuItemsDetailed();
    $menu = getMenuMeta();
    $total = getMenuTotal();
    require 'view/menu.php';
}

function menuAddAction()
{
    $platId = isset($_POST['plat_id']) ? intval($_POST['plat_id']) : 0;
    addPlatToMenu($platId);
    redirectTo('/menu');
}

function menuRemoveAction()
{
    $platId = isset($_POST['plat_id']) ? intval($_POST['plat_id']) : 0;
    removePlatFromMenu($platId);
    redirectTo('/menu');
}

function menuSaveAction()
{
    $creator = isset($_POST['creator']) ? trim($_POST['creator']) : '';
    setMenuCreator($creator);
    redirectTo('/menu');
}

function commandeAction()
{
    $title = 'Commande';
    $menuItems = getMenuItemsDetailed();
    $menuTotal = getMenuTotal();
    $error = isset($_SESSION['commande_error']) ? $_SESSION['commande_error'] : '';
    unset($_SESSION['commande_error']);
    require 'view/commande.php';
}

function commandeValidateAction()
{
    $qty = isset($_POST['quantite']) ? intval($_POST['quantite']) : 0;
    $address = isset($_POST['adresse']) ? trim($_POST['adresse']) : '';
    $date = isset($_POST['date_livraison']) ? trim($_POST['date_livraison']) : '';

    if ($qty <= 0 || $address === '' || $date === '' || getMenuTotal() <= 0) {
        $_SESSION['commande_error'] = 'Merci de remplir tous les champs et de creer un menu non vide.';
        redirectTo('/commande');
    }

    $commande = createCommande($qty, $address, $date);
    $title = 'Commande confirmee';
    require 'view/confirmation.php';
}

?>