<?php

function getAllPlats()
{
}

function getPlatById($id)
{
    $plats = getAllPlats();
    return isset($plats[$id]) ? $plats[$id] : null;
}

function initMenuSession()
{
    if (!isset($_SESSION['menu'])) {
        $_SESSION['menu'] = array(
            'creator' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'items' => array()
        );
    }
}

function addPlatToMenu($platId)
{
    initMenuSession();
    $plat = getPlatById($platId);
    if ($plat === null) {
        return;
    }

    if (!isset($_SESSION['menu']['items'][$platId])) {
        $_SESSION['menu']['items'][$platId] = 0;
    }
    $_SESSION['menu']['items'][$platId]++;
    $_SESSION['menu']['updated_at'] = date('Y-m-d H:i:s');
}

function removePlatFromMenu($platId)
{
    initMenuSession();
    if (!isset($_SESSION['menu']['items'][$platId])) {
        return;
    }

    $_SESSION['menu']['items'][$platId]--;
    if ($_SESSION['menu']['items'][$platId] <= 0) {
        unset($_SESSION['menu']['items'][$platId]);
    }
    $_SESSION['menu']['updated_at'] = date('Y-m-d H:i:s');
}

function setMenuCreator($creator)
{
    initMenuSession();
    $_SESSION['menu']['creator'] = $creator;
    $_SESSION['menu']['updated_at'] = date('Y-m-d H:i:s');
}

function getMenuMeta()
{
    initMenuSession();
    return $_SESSION['menu'];
}

function getMenuItemsDetailed()
{
    initMenuSession();

    $rows = array();
    foreach ($_SESSION['menu']['items'] as $platId => $qty) {
        $plat = getPlatById((int)$platId);
        if ($plat === null) {
            continue;
        }

        $rows[] = array(
            'id' => $plat['id'],
            'nom' => $plat['nom'],
            'prix' => $plat['prix'],
            'quantite' => $qty,
            'sous_total' => $qty * $plat['prix']
        );
    }

    return $rows;
}

function getMenuTotal()
{
    $total = 0.0;
    $rows = getMenuItemsDetailed();
    foreach ($rows as $row) {
        $total += $row['sous_total'];
    }
    return $total;
}

function createCommande($quantite, $adresse, $dateLivraison)
{
    $totalMenu = getMenuTotal();
    $totalCommande = $totalMenu * $quantite;

    return array(
        'numero' => 'CMD-' . date('Ymd-His'),
        'creator' => isset($_SESSION['menu']['creator']) ? $_SESSION['menu']['creator'] : '',
        'quantite' => $quantite,
        'adresse' => $adresse,
        'date_livraison' => $dateLivraison,
        'total_menu' => $totalMenu,
        'total_commande' => $totalCommande,
        'date_commande' => date('Y-m-d H:i:s')
    );
}

?>