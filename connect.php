<?php
// Afficher les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Charger l'autoload de Composer
require 'vendor/autoload.php';

// Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
try {
        // Configuration de la connexion PDO avec options de sécurité
        $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4;port=" . $_ENV['DB_PORT'];
        $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Gestion des erreurs en mode exception
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Format de récupération par défaut
        PDO::ATTR_EMULATE_PREPARES => false, // Désactivation de l'émulation des requêtes préparées
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4" // Forcer l'encodage UTF-8
    ];
    
    $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $options);
} catch (PDOException $e) {
    error_log("Erreur de connexion PDO: " . $e->getMessage());
    die("Erreur de connexion à la base de données. Veuillez réessayer plus tard.");
}