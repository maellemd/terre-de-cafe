<?php
require_once __DIR__ . '/../session_config.php';
require_once '../connect.php';

// Vérification de l'authentification
if (isset($_SESSION['id'])) {
    header('Location: account.php');
    exit();
}
// Initialisation des msg
$message = "";

// Génération d'un token unique pour chaque formulaire
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// Création du compte
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirmPassword = htmlspecialchars(trim($_POST['confirm_password']));
        // Vérification du token 
    $csrfToken = $_POST['csrf_token'] ?? '';
    if ($csrfToken !== $_SESSION['csrf_token']) {
        die("Requête invalide.");
    }

    if (!empty($email) && !empty($password) && !empty($confirmPassword)) {
        if ($password !== $confirmPassword) {
            $message = "Les mots de passe ne correspondent pas.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Adresse email invalide.";
        } elseif (strlen($password) < 8) {
            $message = "Le mot de passe doit contenir au moins 8 caractères.";
        } elseif (!preg_match('/[A-Z]/', $password)) {
            $message = "Le mot de passe doit contenir au moins une lettre majuscule.";
        } elseif (!preg_match('/[a-z]/', $password)) {
            $message = "Le mot de passe doit contenir au moins une lettre minuscule.";
        } elseif (!preg_match('/[0-9]/', $password)) {
            $message = "Le mot de passe doit contenir au moins un chiffre.";
        } elseif (!preg_match('/[\W_]/', $password)) {
            $message = "Le mot de passe doit contenir au moins un caractère spécial (par exemple : !, @, #).";
        } else {
            try {
                // Vérifie si l'email existe déjà
                $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $message = "Cette adresse email est déjà utilisée.";
                } else {
                    // Hachage du mot de passe
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                    // Insérer le nouvel utilisateur dans la base de données
                    $insertStmt = $pdo->prepare("INSERT INTO users (email, password_hash) VALUES (:email, :password_hash)");
                    $insertStmt->execute([
                        'email' => $email,
                        'password_hash' => $passwordHash
                    ]);

                    // Configurer la session pour l'utilisateur
                    $userId = $pdo->lastInsertId();
                    $_SESSION['id'] = $userId;
                    $_SESSION['last_activity'] = time();
                    $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];

                    $_SESSION['registration_success'] = "Inscription réussie!";
                    header('Location: account.php');
                    exit();
                }
            } catch (PDOException $e) {
                error_log("Erreur d'inscription: " . $e->getMessage());
                $message = "Une erreur est survenue. Veuillez réessayer plus tard.";
            }
        }
    } else {
        $message = "Tous les champs sont obligatoires.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer mon compte - Terre de Café</title>
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
        <h2>Créer un compte</h2>
    </section>

    <section class="inscription-section">
        <div class="form-container">
            <?php if (!empty($message)) : ?>
                <div class="error-message" style="color: red; margin-bottom: 20px; text-align: center;">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <form action="inscription.php" method="post">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" name="email" id="email" maxlength="255" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe *</label> 
                    <div class="password-container">
                        <input type="password" name="password" id="password" maxlength="128" required>
                        <i class="toggle-password far fa-eye-slash"></i>
                    </div>
                    <div id="password-requirements" style="display: none; font-size: 0.9em; color: #666; margin-top: 5px;">
                        <ul>
                            <li id="length" class="invalid">Au moins 8 caractères</li>
                            <li id="uppercase" class="invalid">Au moins une lettre majuscule</li>
                            <li id="lowercase" class="invalid">Au moins une lettre minuscule</li>
                            <li id="number" class="invalid">Au moins un chiffre</li>
                            <li id="special" class="invalid">Au moins un caractère spécial (par exemple : !, @, #)</li>
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmez le mot de passe</label>
                    <input type="password" name="confirm_password" id="confirm_password" maxlength="128" required>
                </div>

                <div class="form-group">
                    <button type="submit" name="inscription" value="Inscription">Créer mon compte</button>
                </div>

                <div class="login-link">
                    Déjà un compte ? <a href="connexion.php">Connectez-vous</a>
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
        <img src="../img/logo-header.png" alt="Paiement">
    </div>
</footer>
<div class="copyright">
    <p>© 2024 Terre de Café - Tous droits reservés</p>
</div>
<script src="../script.js"></script>
    <script src="https://kit.fontawesome.com/79a4c85e07.js" crossorigin="anonymous"></script>
</body>
</html>
<script>
     // Scripts pour la validation du mot de passe
     const passwordField = document.getElementById('password');
        const passwordRequirements = document.getElementById('password-requirements');
        const requirements = document.querySelectorAll('#password-requirements li');

        passwordField.addEventListener('focus', () => {
            passwordRequirements.style.display = 'block';
        });

        passwordField.addEventListener('blur', () => {
            passwordRequirements.style.display = 'none';
        });
        
        passwordField.addEventListener('input', () => {
            const password = passwordField.value;
            
            const validations = [
                { test: password.length >= 8, index: 0 },
                { test: /[A-Z]/.test(password), index: 1 },
                { test: /[a-z]/.test(password), index: 2 },
                { test: /[0-9]/.test(password), index: 3 },
                { test: /[\W_]/.test(password), index: 4 }
            ];

            validations.forEach(({test, index}) => {
                requirements[index].classList.toggle('valid', test);
                requirements[index].classList.toggle('invalid', !test);
            });
        });

        // Toggle password visibility
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