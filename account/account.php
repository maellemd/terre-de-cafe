<?php
require_once '../session_config.php';
require_once '../connect.php';
require_once 'auth.php';

// Vérification de l'authentification
requireAuth();

// Initialisation des variables
$user = [
    'id' => '',
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'phone_number' => '',
    'address' => '',
    'order_history' => ''
];

$error = '';
$success = '';

try {
    // Récupération des informations utilisateur
    $stmt = $pdo->prepare("
        SELECT id, email, first_name, last_name, phone_number, address, order_history 
        FROM users 
        WHERE id = :id
    ");
    $stmt->execute(['id' => $_SESSION['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        session_destroy();
        header('Location: connexion.php');
        exit();
    }

    // Traitement de l'historique des commandes
    $orders = [];
    if (!empty($user['order_history'])) {
        $orders = json_decode($user['order_history'], true) ?? [];
    }
} catch (PDOException $e) {
    $error = "Une erreur est survenue lors de la récupération de vos informations.";
    error_log("Erreur DB - Compte utilisateur : " . $e->getMessage());
}

// Fonctions pour la sécurité et le formatage
function sanitizeOutput($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function formatDate($date) {
    return date('d/m/Y à H:i', strtotime($date));
}
// Fonction pour traduire le statut de commande EN de la DB vers FR pour le client
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte - Terre de Café</title>
    <link rel="icon" href="../img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/account.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <section id="header">
    <a href="../index.php"><img src="../img/logo-header.png" class="logo" alt=""></a>
    <div>
        <ul id="navbar">
            <li><a href="../index.php">Accueil</a></li>
            <li><a href="#" class="active">Compte</a></li>
            <li><a href="../shop.php">Commander</a></li>
            <li><a href="../blog.php">Blog</a></li>
            <li><a href="../about.php">A propos</a></li>
            <li><a href="../contact.php">Contact</a></li>
            <li id="shopping-bag">
                <a href="../cart/cart.php">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <?php if (isset($_SESSION['cart_count']) && $_SESSION['cart_count'] > 0): ?>
                        <span class="cart-count"><?= $_SESSION['cart_count'] ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <a href="#" id="close"><i class="fa-regular fa-circle-xmark"></i></a>
        </ul>
    </div>
    <div id="mobile">
        <a href="../cart/cart.php" class="mobile-cart">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>
        <button class="menu-toggle">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</section>

    <!-- Contenu principal -->
    <main class="account-page">
        <section class="account-hero">
            <div class="hero-content">
                <h2>Mon Compte</h2>
            </div>
        </section>

        <section class="account-dashboard">
            <div class="dashboard-container">
                <?php if (!empty($error)): ?>
                    <div class="status-message error">
                        <i class="fas fa-exclamation-circle"></i>
                        <p><?= sanitizeOutput($error) ?></p>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($success)): ?>
                    <div class="status-message success">
                        <i class="fas fa-check-circle"></i>
                        <p><?= sanitizeOutput($success) ?></p>
                    </div>
                <?php endif; ?>
                <div class="dashboard-card user-info">
                    <div class="card-header">
                        <h2>
                            <i class="fas fa-user"></i>
                            Mes informations personnelles
                        </h2>
                        <a href="edit_personal_info.php" class="edit-button" title="Modifier mes informations">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                    <div class="card-content">
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Prénom</span>
                                <span class="info-value"><?= sanitizeOutput($user['first_name']) ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Nom</span>
                                <span class="info-value"><?= sanitizeOutput($user['last_name']) ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Email</span>
                                <span class="info-value"><?= sanitizeOutput($user['email']) ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Téléphone</span>
                                <span class="info-value">
                                    <?= $user['phone_number'] ? sanitizeOutput($user['phone_number']) : '<em>Non renseigné</em>' ?>
                                </span>
                            </div>
                            <div class="info-item full-width">
                                <span class="info-label">Adresse de livraison</span>
                                <span class="info-value address">
                                    <?= $user['address'] ? sanitizeOutput($user['address']) : '<em>Non renseignée</em>' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card order-history">
                    <div class="card-header">
                        <h2>
                            <i class="fas fa-shopping-bag"></i>
                            Historique des commandes
                        </h2>
                    </div>
                    <div class="card-content">
                        <?php if (!empty($orders) && is_array($orders)): ?>
                            <div class="orders-grid">
                                <?php foreach ($orders as $order): ?>
                                    <div class="order-card">
                                        <div class="order-header">
                                            <span class="order-number">
                                                Commande #<?= sanitizeOutput($order['id'] ?? 'N/A') ?>
                                            </span>
                                            <span class="order-status <?= strtolower(sanitizeOutput($order['status'] ?? '')) ?>">
                                                <?= translateOrderStatus($order['status'] ?? '') ?>
                                            </span>
                                        </div>
                                        <div class="order-details">
                                            <div class="order-info">
                                                <i class="far fa-calendar"></i>
                                                <span><?= isset($order['date']) ? formatDate($order['date']) : 'Date non disponible' ?></span>
                                            </div>
                                            <?php if (isset($order['total'])): ?>
                                                <div class="order-info">
                                                    <i class="fas fa-euro-sign"></i>
                                                    <span><?= number_format($order['total'], 2, ',', ' ') ?> €</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="order-actions">
                                            <a href="order-details.php?id=<?= sanitizeOutput($order['id'] ?? '') ?>" 
                                               class="btn btn-outline">
                                                Voir les détails
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-shopping-cart"></i>
                                <p>Vous n'avez pas encore passé de commande</p>
                                <a href="../shop.php" class="btn btn-primary">Découvrir nos produits</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Actions du compte -->
                <div class="account-actions">
                    <button class="btn btn-outline" onclick="window.location.href='reset_password.php'">
                        <i class="fas fa-lock"></i>
                        Changer mon mot de passe
                    </button>
                    <button class="btn btn-danger" onclick="window.location.href = 'logout.php'">
                        <i class="fas fa-sign-out-alt"></i>
                        Se déconnecter
                    </button>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
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

    <!-- Scripts -->
    <script src="../script.js"></script>
    <script src="https://kit.fontawesome.com/79a4c85e07.js" crossorigin="anonymous"></script>
</body>
</html>
