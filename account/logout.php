<?php
require_once '../session_config.php';

// Détruire toutes les variables de session
session_unset();

// Détruire le cookie de session
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion
header('Location: connexion.php?logout=success');
exit();