<?php
require_once '../session_config.php';
require_once '../connect.php';
require_once 'auth.php';

// Vérification de l'authentification
requireAuth();

// Vérification de l'ID de commande
if (!isset($_GET['id'])) {
    header('Location: account.php');
    exit();
}

$order_id = $_GET['id'];

try {
    // Récupération de l'historique des commandes de l'utilisateur
    $stmt = $pdo->prepare("SELECT order_history FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['id']]);
    $order_history = json_decode($stmt->fetchColumn(), true);
    
    // Recherche de la commande que l'on demande
    $order = null;
    foreach ($order_history as $hist_order) {
        if ($hist_order['id'] === $order_id) {
            $order = $hist_order;
            break;
        }
    }
    
    if (!$order) {
        header('Location: account.php');
        exit();
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
// Pour traduire le statut de commande EN de la DB vers FR pour le client
function translateOrderStatus($status) {
    $translations = [
        'pending' => 'En attente',
        'processing' => 'En cours de traitement',
        'shipped' => 'Expédiée',
        'delivered' => 'Livrée',
        'cancelled' => 'Annulée'
    ];
    return $translations[$status] ?? $status;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la commande - Terre de Café</title>
    <link rel="icon" href="../img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/account.css">
    <link rel="stylesheet" href="../styles/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <section id="header">
        <a href="../index.php"><img src="../img/logo-header.png" class="logo" alt=""></a>
        <div> 
            <nav>
                <ul id="navbar">
                    <li><a href="../index.php">Accueil</a></li>
                    <li><a href="#" data-account-link class="active">Compte</a></li>
                    <li><a href="../shop.php">Commander</a></li>
                    <li><a href="../blog.php">Blog</a></li>
                    <li><a href="../about.php">A propos</a></li>
                    <li><a href="../contact.php">Contact</a></li>
                    <li id="shopping-bag"><a href="../cart/cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                    <a href="#" id="close"><i class="fa-regular fa-circle-xmark"></i></a>
                </ul>
            </nav>
        </div>
        <div id="mobile">
            <a href="../cart/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <i id="bar" class="fa-solid fa-bars"></i>
        </div>
    </section>

    <section class="account-hero">
        <div class="hero-content">
            <h2>Détails de la commande</h2>
        </div>
    </section>

    <div class="confirmation-container">
        <div class="order-details">
            <div class="order-header">
                <h2>Commande #<?= htmlspecialchars($order_id) ?></h2>
                <span class="order-status <?= strtolower($order['status']) ?>">
                    <?= translateOrderStatus($order['status']) ?>
                </span>
            </div>

            <div class="order-info-grid">
                <div class="info-section">
                    <h3><i class="fas fa-calendar"></i> Date de commande</h3>
                    <p><?= date('d/m/Y à H:i', strtotime($order['date'])) ?></p>
                </div>

                <div class="info-section">
                    <h3><i class="fas fa-map-marker-alt"></i> Adresse de livraison</h3>
                    <p><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
                </div>

                <div class="items-section">
                    <h3><i class="fas fa-shopping-basket"></i> Articles commandés</h3>
                    <?php foreach ($order['items'] as $item): ?>
                        <div class="order-item">
                            <div class="item-details">
                                <span class="item-name"><?= htmlspecialchars($item['name']) ?></span>
                                <span class="item-packaging"><?= $item['packaging'] ?>g</span>
                            </div>
                            <div class="item-quantity"><?= $item['quantity'] ?> x <?= number_format($item['price'], 2) ?>€</div>
                            <div class="item-total"><?= number_format($item['price'] * $item['quantity'], 2) ?>€</div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="total-section">
                    <div class="total-row">
                        <span>Total de la commande :</span>
                        <span class="total-amount"><?= number_format($order['total'], 2) ?>€</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="back-button-container">
    <a href="account.php" class="back-button">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>
    </div>

    <footer class="section1">
    <div class="col">
        <h4>Contact</h4>
        <p><strong>Email:</strong> terre-de-cafe@email.com</p>
        <p><strong>Phone:</strong> +33 123 456 789</p>
        <div class="follow">
            <h4>Suivez-nous</h4>
            <div class="icon">
                <i class="fab fa-facebook-f"></i>
                <i class="fab fa-twitter"></i>
                <i class="fab fa-instagram"></i>
                <i class="fab fa-pinterest-p"></i>
                <i class="fab fa-youtube"></i>
            </div>
        </div>
    </div>
    <div class="col">
        <h4>A propos</h4>
        <a href="../about.php">A propos de nous</a>
        <a href="../blog.php">Blog</a>
        <a href="#">Conditions de ventes</a>        
        <a href="#">Politique de confidentialité</a>
    </div>
    <div class="col">
        <h4>Mon compte</h4>
        <a href="#" data-account-link>Compte</a>        
        <a href="#" data-account-link>Suivre mes commandes</a>        
        <a href="#">F.A.Q</a>
    </div>    
    <div class="col install">
        <p>Paiement sécurisé</p>
        <img src="../img/paypal-1.png" alt="Paiement">
    </div>
</footer>
<div class="copyright">
    <p>© 2024 Terre de Café - Tous droits reservés</p>
</div>

<script src="../script.js"></script>
    <script src="https://kit.fontawesome.com/79a4c85e07.js" crossorigin="anonymous"></script></body>
</html>