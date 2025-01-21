<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../session_config.php';
require_once __DIR__ . '/../connect.php';

// Initialiser $error et $logoutMessage avant le bloc conditionnel
$error = '';
$logoutMessage = isset($_GET['logout']) && $_GET['logout'] == 'success' ? "Vous avez été déconnecté avec succès" : "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyage des données
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (!empty($email) && !empty($password)) {
        try {
            // Vérification des identifiants
            $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe haché
            if ($user && password_verify($password, $user['password_hash'])) {
                // Débogage
                error_log("Login successful for user: " . $user['id']);
                
                // Enregistrer l'ID utilisateur dans la session
                $_SESSION['id'] = $user['id'];
                $_SESSION['last_activity'] = time();
                $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
                
                // Renouveler le cookie de session
                session_regenerate_id(true);
                
                // Redirection selon le contexte
                if (isset($_GET['redirect']) && $_GET['redirect'] === 'checkout') {
                    header('Location: ../cart/checkout.php');
                } else {
                    header('Location: account.php');
                }
                exit();
            } else {
                $error = "Identifiants incorrects.";
            }
        } catch (PDOException $e) {
            $error = "Erreur lors de la connexion : " . $e->getMessage();
            error_log("Connexion error: " . $e->getMessage());
        }
    } else {
        $error = "Tous les champs sont obligatoires.";
    }
} ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Me connecter - Terre de Café</title>
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
    <h2>Me connecter</h2>
</section>
    <section class="inscription-section">
        <div class="form-container">
            <?php if (!empty($error)) : ?>
                <div class="error-message" style="color: red; margin-bottom: 20px; text-align: center;">
                    <?= htmlspecialchars($error) ?> 
                </div>
            <?php endif; ?>

            <?php if (!empty($logoutMessage)) : ?>
                <div id="logout-message" class="success-message" style="color: green; margin-bottom: 20px; text-align: center;">
                    <?= htmlspecialchars($logoutMessage) ?> 
                </div>
            <?php endif; ?>

            <form action="connexion.php" class="connexion-form" method="post">
                <div class="form-group">
                    <label for="email">Adresse email *</label> 
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="form-group">
    <label for="password">Mot de passe *</label> 
    <div class="password-container">
        <input type="password" name="password" id="password" required>
        <i class="toggle-password far fa-eye-slash"></i>
    </div>
</div>

                <div class="form-group">
                    <button type="submit" name="connexion" value="Connexion">Se connecter</button>
                </div>
                <div class="forgot-password-link">
        <a href="forgot_password.php" class="forgot-password-link">Mot de passe oublié ?</a> 
    </div>
    <div class="login-link">
        Pas encore de compte ? <a href="inscription.php">Créer un compte</a>
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
<script src="https://kit.fontawesome.com/79a4c85e07.js" crossorigin="anonymous"></script>
    <script>
        // Visibilité du mot de passe
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.querySelector('#password');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
    });
</script>
</body>
</html>