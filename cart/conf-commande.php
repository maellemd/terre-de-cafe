<?php
require_once '../session_config.php';
require_once '../connect.php';

// Vérifier si la commande demandé existe
if (!isset($_GET['order_id'])) {
    header('Location: ../shop.php');
    exit();
}

$order_id = $_GET['order_id'];
// Pour récupérer l'historique des commandes générales
try {
    $stmt = $pdo->prepare("SELECT order_history FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['id']]);
    $order_history = json_decode($stmt->fetchColumn(), true);

    // Recherche de la commande demandée
    $order = null;
    foreach ($order_history as $hist_order) {
        if ($hist_order['id'] === $order_id) {
            $order = $hist_order;
            break;
        }
    }
    // Redirection si la commande n'est pas trouvé
    if (!$order) {
        header('Location: ../shop.php');
        exit();
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande - Terre de Café</title>
    <link rel="icon" href="../img/favicon.png" type="img/favicon.png">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="confirmation-page">
    <section id="header">
        <a href="../index.php"><img src="../img/logo-header.png" class="logo" alt=""></a>
        <div> 
            <nav>
                <ul id="navbar">
                    <li><a href="../index.php">Accueil</a></li>
                    <li><a href="#" data-account-link>Compte</a></li>
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

    <div class="confirmation-container">
        <i class="fas fa-check-circle success-icon"></i>
        <h1>Commande confirmée !</h1>
        <p>Merci pour votre commande. Votre numéro de commande est : <strong><?= htmlspecialchars($order_id) ?></strong></p>
        
        <div class="order-details">
            <h2>Détails de la commande</h2>
            <p><strong>Date :</strong> <?= date('d/m/Y H:i', strtotime($order['date'])) ?></p>
            <p><strong>Statut :</strong> En cours de traitement</p>
            <p><strong>Montant total :</strong> <?= number_format($order['total'], 2) ?>€</p>
            <p><strong>Adresse de livraison :</strong><br><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
        </div>

        <div class="actions">
            <a href="../account/account.php" class="btn">Voir mes commandes</a>
            <a href="../shop.php" class="btn">Continuer mes achats</a>
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
</body>
</html>