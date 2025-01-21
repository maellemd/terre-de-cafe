<?php
require '../connect.php';
require '../session_config.php';

// Vérifier si les données nécessaires sont présentes
if (!isset($_POST['id']) || !isset($_POST['quantity']) || !isset($_POST['packaging'])) {
    die("Données manquantes");
}

// Récupérer et valider les données
$product_id = (int)$_POST['id'];
$quantity = (int)$_POST['quantity'];
$packaging = htmlspecialchars($_POST['packaging']);

// Valider la quantité
if ($quantity <= 0 || $quantity > 10) {
    die("Quantité invalide");
}

// Récupérer les informations du produit depuis la base de données
try {
    $stmt = $pdo->prepare("SELECT name, price FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    
    if (!$product) {
        die("Produit non trouvé");
    }
    
    // Initialiser le panier s'il n'existe pas
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Créer une clé unique pour le produit incluant le conditionnement
    $cart_key = $product_id . '-' . $packaging;
    
    // Ajouter ou mettre à jour le produit dans le panier
    if (isset($_SESSION['cart'][$cart_key])) {
        $_SESSION['cart'][$cart_key]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$cart_key] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'packaging' => $packaging
        ];
    }
    
    // Rediriger vers le panier
    header('Location: cart.php');
    exit();
    
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}