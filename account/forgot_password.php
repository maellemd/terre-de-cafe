<?php
require_once __DIR__ . '/../session_config.php';
require_once '../connect.php';
// Initialisation des msg
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));

    if (!empty($email)) {
        try {
            // Vérifier si l'email existe
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user) {
                // Générer un token unique
                $token = bin2hex(random_bytes(32));
                $expiry = time() + 3600; // valide pdt 1h

                // Supprimer les anciens tokens non utilisés pour cet email
                $deleteStmt = $pdo->prepare("DELETE FROM password_resets WHERE email = :email AND used = 0");
                $deleteStmt->execute(['email' => $email]);

                // Création du nouveau token
                $insertStmt = $pdo->prepare("INSERT INTO password_resets (email, token, expiry) VALUES (:email, :token, :expiry)");
                $insertStmt->execute([
                    'email' => $email,
                    'token' => $token,
                    'expiry' => $expiry
                ]);

                // En condition réelle, ajouter une fonctionnalité pour envoyer un mail avec le lien de réinitialisation
              
                if (mail($to, $subject, $message, $headers)) {
                    $success = "Un email avec les instructions a été envoyé à votre adresse.";
                } else {
                    $error = "Erreur lors de l'envoi de l'email. Veuillez réessayer plus tard.";
                }
            } else {
                $success = "Si cette adresse email est associée à un compte, vous recevrez un email avec les instructions.";
            }
        } catch (PDOException $e) {
            $error = "Une erreur est survenue. Veuillez réessayer plus tard.";
        }
    } else {
        $error = "Veuillez entrer une adresse email.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - Terre de Café</title>
    <link rel="icon" href="../img/favicon.png" type="img/favicon.png">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/inscription.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - Terre de Café</title>
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
        <h2>Mot de passe oublié</h2>
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
                    <label for="email">Adresse email</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="form-group">
                    <button type="submit">Réinitialiser mon mot de passe</button>
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
    <script src="https://kit.fontawesome.com/79a4c85e07.js" crossorigin="anonymous"></script></body>
</html>