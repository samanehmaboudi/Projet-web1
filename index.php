<?php
// Activer les erreurs PHP
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Auto-chargement des classes + config
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

// Charger les routes définies dans web.php
require_once __DIR__ . '/routes/web.php';

// Exécuter la résolution de la route
\App\Routes\Route::resolve();

