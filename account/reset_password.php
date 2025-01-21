<?php
require_once __DIR__ . '/../session_config.php';
require_once '../connect.php';

// Vérifier si le token est présent sinon rediriger vers MDP oublié
    header('Location: forgot_password.php');
    exit();

$error = '';
$success = '';
// Supprimer l'ancien mdp pour le reset et validation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = htmlspecialchars(trim($_POST['new_password']));
    $confirm_new_password = htmlspecialchars(trim($_POST['confirm_new_password']));
    $token = htmlspecialchars($_GET['token']);
// Vérification de sécurité du mot de passe
    if (!empty($new_password) && !empty($confirm_new_password)) {
        if ($new_password !== $confirm_new_password) {
            $error = "Les mots de passe ne correspondent pas.";
        } elseif (strlen($new_password) < 8) {
            $error = "Le mot de passe doit contenir au moins 8 caractères.";
        } elseif (!preg_match('/[A-Z]/', $new_password)) {
            $error = "Le mot de passe doit contenir au moins une lettre majuscule.";
        } elseif (!preg_match('/[a-z]/', $new_password)) {
            $error = "Le mot de passe doit contenir au moins une lettre minuscule.";
        } elseif (!preg_match('/[0-9]/', $new_password)) {
            $error = "Le mot de passe doit contenir au moins un chiffre.";
        } elseif (!preg_match('/[\W_]/', $new_password)) {
            $error = "Le mot de passe doit contenir au moins un caractère spécial.";
        } else {
            try {
                // Vérifier si le token est valide
                $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = :token AND expiry > :now AND used = 0");
                $stmt->execute([
                    'token' => $token,
                    'now' => time()
                ]);
                $reset = $stmt->fetch();
// Hachage du nouveau mot de passe pour le sécuriser
                if ($reset) {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    
                    // Mise à jour du mot de passe
                    $updatePass = $pdo->prepare("UPDATE users SET password_hash = :password_hash WHERE email = :email");
                    $updatePass->execute([
                        'password_hash' => $password_hash,
                        'email' => $reset['email']
                    ]);

                    // Marquer le token comme utilisé et donc invalide
                    $updateToken = $pdo->prepare("UPDATE password_resets SET used = 1 WHERE token = :token");
                    $updateToken->execute(['token' => $token]);

                    $success = "Votre mot de passe a été réinitialisé avec succès.";
                    header("Refresh: 3; url=connexion.php");
                } else {
                    $error = "Le lien de réinitialisation est invalide ou a expiré.";
                }
            } catch (PDOException $e) {
                $error = "Une erreur est survenue. Veuillez réessayer plus tard.";
            }
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe - Terre de Café</title>
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
        <h2>Réinitialisation du mot de passe</h2>
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
                    <label for="new_password">Nouveau mot de passe</label>
                    <input type="password" name="new_password" id="new_password" required>
                    <i class="toggle-password far fa-eye-slash"></i>
                </div>

                <div class="form-group">
                    <label for="confirm_new_password">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="confirm_new_password" id="confirm_new_password" required>
                    <i class="toggle-password far fa-eye-slash"></i>
                </div>

                <div class="form-group">
                    <button type="submit">Réinitialiser le mot de passe</button>
                </div>

                <div class="login-link">
                    <a href="connexion.php">Retour à la connexion</a>
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
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function(e) {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                }
            });
        });
    </script>
</body>
</html>