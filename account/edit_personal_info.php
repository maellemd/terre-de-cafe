<?php
require_once __DIR__ . '/../session_config.php';
require_once '../connect.php';
require_once 'auth.php';

// Vérification de l'authentification
requireAuth();

$error = '';
$success = '';

try {
    // Récupération des informations actuelles
    $stmt = $pdo->prepare("SELECT first_name, last_name, phone_number, address FROM users WHERE id = :id");
    $stmt->execute(['id' => $_SESSION['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifie si l'utilisateur existe
    if (!$user) {
        session_destroy();
        header('Location: connexion.php');
        exit();
    }
} catch (PDOException $e) {
    $error = "Erreur lors de la récupération des données.";
    error_log("Erreur DB - Edition profil : " . $e->getMessage());
}
// Mise à jour des données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $phone_number = htmlspecialchars(trim($_POST['phone_number']));
    $address = htmlspecialchars(trim($_POST['address']));

    try {
        $updateStmt = $pdo->prepare("
            UPDATE users 
            SET first_name = :first_name, 
                last_name = :last_name, 
                phone_number = :phone_number, 
                address = :address 
            WHERE id = :id
        ");
        
        $updateStmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone_number' => $phone_number,
            'address' => $address,
            'id' => $_SESSION['id']
        ]);

        $success = "Vos informations ont été mises à jour avec succès.";
        
        // Mettre à jour les données de l'utilisateur pour l'affichage
        $user['first_name'] = $first_name;
        $user['last_name'] = $last_name;
        $user['phone_number'] = $phone_number;
        $user['address'] = $address;
        
    } catch (PDOException $e) {
        $error = "Erreur lors de la mise à jour des informations.";
        error_log("Erreur DB - Mise à jour profil : " . $e->getMessage());
    }
}
// Fonction de nettoyage des données
function sanitizeOutput($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mes informations - Terre de Café</title>
    <link rel="icon" href="../img/favicon.png" type="img/favicon.png">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/inscription.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <section id="header">
        <a href="../index.php"><img src="../img/logo-header.png" class="logo" alt=""></a>
        <div>
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
        </div>
        <div id="mobile">
            <a href="../cart/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <i id="bar" class="fa-solid fa-bars"></i>
        </div>
    </section>

    <section id="page-header-account">
        <h2>Modifier mes informations</h2>
    </section>

    <section class="inscription-section">
        <div class="form-container">
            <?php if (!empty($error)) : ?>
                <div class="error-message" style="color: red; margin-bottom: 20px; text-align: center;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)) : ?>
                <div class="success-message" style="color: green; margin-bottom: 20px; text-align: center;">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label for="first_name">Prénom</label>
                    <input type="text" name="first_name" id="first_name" value="<?= sanitizeOutput($user['first_name']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Nom</label>
                    <input type="text" name="last_name" id="last_name" value="<?= sanitizeOutput($user['last_name']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">Numéro de téléphone</label>
                    <input type="tel" name="phone_number" id="phone_number" value="<?= sanitizeOutput($user['phone_number']) ?>">
                </div>

                <div class="form-group">
                    <label for="address">Adresse</label>
                    <textarea name="address" id="address" rows="3" class="form-control"><?= sanitizeOutput($user['address']) ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit">Sauvegarder les modifications</button>
                </div>

                <div class="login-link">
                    <a href="account.php">Retour à mon compte</a>
                </div>
            </form>
        </div>
    </section>

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