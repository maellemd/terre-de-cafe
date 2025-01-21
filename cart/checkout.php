<?php
require_once '../session_config.php';
require_once '../connect.php';

// Vérifier l'authentification
if (!isset($_SESSION['id'])) {
    header('Location: ../account/connexion.php?redirect=checkout');
    exit();
}

// Récupérer le panier
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

// Récupérer les informations de l'utilisateur
try {
    $stmt = $pdo->prepare("SELECT first_name, last_name, email, phone_number, address FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// Traitement de la commande
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation des données
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    
    if (empty($address) || empty($phone)) {
        $error = "Veuillez remplir tous les champs obligatoires.";
    } else {
        try {
            // Début de la transaction
            $pdo->beginTransaction();
            
            // Caculer le montant total
            $order_date = date('Y-m-d H:i:s');
            $total = array_reduce($_SESSION['cart'], function($sum, $item) {
                return $sum + ($item['price'] * $item['quantity']);
            }, 0);
            
            // Créer un ID de commande unique
            $order_id = uniqid('CMD');
            
            // Préparer les données de la commande pour l'historique
            $order_data = [
                'id' => $order_id,
                'date' => $order_date,
                'total' => $total,
                'status' => 'processing',
                'items' => array_values($_SESSION['cart']),
                'shipping_address' => $address
            ];
            
            // Mettre à jour l'historique des commandes de l'utilisateur
            $stmt = $pdo->prepare("SELECT order_history FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['id']]);
            $current_history = $stmt->fetchColumn();
            
            $order_history = $current_history ? json_decode($current_history, true) : [];
            array_unshift($order_history, $order_data); // Ajouter la nouvelle commande au début
            
            // Mettre à jour l'utilisateur
            $stmt = $pdo->prepare("UPDATE users SET address = ?, phone_number = ?, order_history = ? WHERE id = ?");
            $stmt->execute([$address, $phone, json_encode($order_history), $_SESSION['id']]);
            
            // Valider la transaction
            $pdo->commit();
            
            // Vider le panier
            unset($_SESSION['cart']);
            
            // Rediriger vers la page de confirmation
            header('Location: conf-commande.php?order_id=' . $order_id);
            exit();
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = "Une erreur est survenue lors de la validation de la commande.";
            error_log($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation de commande - Terre de Café</title>
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
            <a href="cart/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <i id="bar" class="fa-solid fa-bars"></i>
        </div>
    </section>
    <section id="page-header-cart" class="cart-header">
        <h2>Mon panier</h2>
    </section>  
    <div class="confirmation-container">
        <?php if (isset($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="order-summary">
            <h2>Récapitulatif de la commande</h2>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <div class="cart-item">
                    <span><?= htmlspecialchars($item['name']) ?></span>
                    <span><?= $item['quantity'] ?> x <?= number_format($item['price'], 2) ?>€</span>
                </div>
            <?php endforeach; ?>
            
            <div class="total-amount">
                Total: <?= number_format(array_reduce($_SESSION['cart'], function($sum, $item) {
                    return $sum + ($item['price'] * $item['quantity']);
                }, 0), 2) ?>€
            </div>
        </div>

        <div class="warning-message">
            <i class="fas fa-info-circle"></i>
            S'agissant d'un site factice, aucun paiement ne sera effectué.
        </div>

        <form class="shipping-form" method="POST" action="">
            <div class="form-group">
                <label for="address">Adresse de livraison *</label>
                <textarea id="address" name="address" required rows="3"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label for="phone">Numéro de téléphone *</label>
                <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>" required>
            </div>

            <button type="submit" class="btn-checkout">Procéder au paiement</button>        
        </form>
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