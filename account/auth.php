<?php
require_once __DIR__ . '/../session_config.php';

// Vérifier l'authentification
function checkAuth() {
    if (!isset($_SESSION['id']) || 
        !isset($_SESSION['last_activity']) || 
        !isset($_SESSION['user_ip'])) {
        return false;
    }

    // Vérifier si la session n'a pas expiré (7 jours)
    if (time() - $_SESSION['last_activity'] > 604800) {
        return false;
    }

    // Vérifier si l'IP correspond au dernier enregistrement (sécurité contre détournement de session)
    if ($_SESSION['user_ip'] !== $_SERVER['REMOTE_ADDR']) {
        return false;
    }

    return true;
}
// Pour les pages qui nécessitent une authentification pour y avoir accès
function requireAuth() {
    if (!checkAuth()) {
        // Nettoyer la session
        session_unset();
        session_destroy();
        
        // Rediriger vers la connexion
        header('Location: connexion.php?error=auth_required');
        exit();
    }
}