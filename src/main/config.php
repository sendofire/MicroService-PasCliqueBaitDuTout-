<?php
/**
 * Configuration IHM.
 *
 * Peut etre surcharge via variables d'environnement:
 * - PLATS_UTILISATEURS_API_BASE
 * - MENUS_API_BASE
 * - COMMANDES_API_BASE
 */

define('PLATS_UTILISATEURS_API_BASE', getenv('PLATS_UTILISATEURS_API_BASE') ?: 'http://localhost:3003');
define('MENUS_API_BASE', getenv('MENUS_API_BASE') ?: 'http://localhost:3002');
define('COMMANDES_API_BASE', getenv('COMMANDES_API_BASE') ?: 'http://localhost:3001');
define('API_TIMEOUT_SECONDS', 8);

?>