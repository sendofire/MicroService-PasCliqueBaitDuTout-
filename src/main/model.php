<?php

require_once 'config.php';

function apiRequest($method, $baseUrl, $path, $payload = null)
{
    $url = rtrim($baseUrl, '/') . '/' . ltrim($path, '/');

    $headers = array('Accept: application/json');
    $options = array(
        'http' => array(
            'method' => strtoupper($method),
            'ignore_errors' => true,
            'timeout' => API_TIMEOUT_SECONDS,
        ),
    );

    if ($payload !== null) {
        $headers[] = 'Content-Type: application/json';
        $options['http']['content'] = json_encode($payload);
    }

    $options['http']['header'] = implode("\r\n", $headers);

    $context = stream_context_create($options);
    $raw = @file_get_contents($url, false, $context);

    $statusCode = 0;
    if (isset($http_response_header[0]) && preg_match('/\s(\d{3})\s/', $http_response_header[0], $matches)) {
        $statusCode = (int)$matches[1];
    }

    $decoded = null;
    if ($raw !== false && $raw !== '') {
        $decoded = json_decode($raw, true);
    }

    if ($statusCode >= 400 || $statusCode === 0) {
        $errorMessage = 'Erreur API (' . $statusCode . ')';
        if (is_array($decoded) && isset($decoded['message'])) {
            $errorMessage .= ': ' . $decoded['message'];
        }
        throw new RuntimeException($errorMessage);
    }

    return $decoded;
}

function getAllPlats()
{
    $plats = apiRequest('GET', PLATS_UTILISATEURS_API_BASE, '/plats');
    return is_array($plats) ? $plats : array();
}

function getAllUtilisateurs()
{
    $utilisateurs = apiRequest('GET', PLATS_UTILISATEURS_API_BASE, '/utilisateurs');
    return is_array($utilisateurs) ? $utilisateurs : array();
}

function getAllMenus()
{
    $menus = apiRequest('GET', MENUS_API_BASE, '/menus');
    return is_array($menus) ? $menus : array();
}

function getMenuById($id)
{
    if ($id <= 0) {
        return null;
    }
    return apiRequest('GET', MENUS_API_BASE, '/menus/' . (int)$id);
}

function createMenu($nom, $createurId)
{
    return apiRequest('POST', MENUS_API_BASE, '/menus', array(
        'nom' => $nom,
        'createurId' => (int)$createurId,
    ));
}

function addPlatToMenu($menuId, $platId)
{
    return apiRequest('PUT', MENUS_API_BASE, '/menus/' . (int)$menuId . '/plats/' . (int)$platId);
}

function removePlatFromMenu($menuId, $platId)
{
    return apiRequest('DELETE', MENUS_API_BASE, '/menus/' . (int)$menuId . '/plats/' . (int)$platId);
}

function setCurrentMenuId($menuId)
{
    $_SESSION['current_menu_id'] = (int)$menuId;
}

function getCurrentMenuId()
{
    return isset($_SESSION['current_menu_id']) ? (int)$_SESSION['current_menu_id'] : 0;
}

function getCurrentMenu()
{
    $menuId = getCurrentMenuId();
    if ($menuId <= 0) {
        return null;
    }

    try {
        return getMenuById($menuId);
    } catch (RuntimeException $e) {
        return null;
    }
}

function createCommande($abonneId, $adresseLivraison, $dateLivraison, $menuId, $quantite)
{
    return apiRequest('POST', COMMANDES_API_BASE, '/commandes', array(
        'abonneId' => (int)$abonneId,
        'adresseLivraison' => $adresseLivraison,
        'dateLivraison' => $dateLivraison,
        'lignes' => array(
            array(
                'menuId' => (int)$menuId,
                'quantite' => (int)$quantite,
            ),
        ),
    ));
}

?>