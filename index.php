<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Terre de Café - Découvrez nos cafés d'exception et notre engagement pour un café durable et authentique">
    <meta name="keywords" content="café, coffee shop, café bio, café durable, expresso, terre de café">
    <title>Accueil - Terre de Café</title>
    <link rel="icon" href="img/favicon.png" type="img/favicon.png">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <section id="header">
        <a href="index.php"><img src="img/logo-header.png" class="logo" alt="Logo Terre de Café"></a>
        <div>
            <nav>
                <ul id="navbar">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#" data-account-link>Compte</a></li>
                    <li><a href="shop.php">Commander</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="about.php">A propos</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li id="shopping-bag"><a href="cart/cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                    <a href="#" id="close"><i class="fa-regular fa-circle-xmark"></i></a>
                </ul>
            </nav>
        </div>
        <div id="mobile">
            <a href="cart/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <i id="bar" class="fa-solid fa-bars"></i>
        </div>
    </section>

    <section id="hero">
        <h4>Terre de Café</h4>
        <h2>Des saveurs authentiques <br>
            et un engagement durable</h2>
        <button class="button" onclick="window.location.href='shop.php';">Commander maintenant</button>
    </section>

    <section id="process" class="section1">
        <h2 class="h2-center-it">Le processus de fabrication de votre expresso</h2><br>
        <div class="processus">
            <div class="processus-box">
                <img src="/img/cerise-de-cafe.jpg" alt="Récolte de la cerise de café">
                <h6>Récolte de la cerise de café</h6>
            </div>
            <div class="processus-box">
                <img src="img/extraction-cafe.jpg" alt="Extraction des grains de café">
                <h6>Extraction des grains de café</h6>
            </div>
            <div class="processus-box">
                <img src="img/sechage-cafe.jpg" alt="Séchage des grains de café">
                <h6>Séchage des grains de café</h6>
            </div>
            <div class="processus-box">
                <img src="img/torrefaction.png" alt="La torrefaction">
                <h6>La torrefaction</h6>
            </div>
            <div class="processus-box">
                <img src="img/cafe-moulu.jpeg" alt="La mouture du café">
                <h6>La mouture du café</h6>
            </div>
        </div>
    </section>

    <section id="banner" class="section1">
        <h2>10% de remise pour les nouveaux clients</h2>
        <button class="btn-newsletter"><a class="btn-news" href="shop.php">Commander maintenant</a></button>
    </section>

    <section id="newsletter" class="section1 section2">
        <div class="newstext">
            <h4>S'inscrire à notre newsletter</h4>
            <h6>Et bénéficier de -5% (cumulable avec l'offre pour les nouveaux clients)</h6>
            <p>Recevez des nouvelles et des offres exclusives par email</p>
        </div>
        <div class="form">
            <input type="text" placeholder="Votre adresse email">
            <button class="btn-newsletter">S'inscrire</button>
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
            <a href="about.php">A propos de nous</a>
            <a href="blog.php">Blog</a>
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
            <img src="img/paypal-1.png" alt="Paiement">
        </div>
    </footer>
    
    <div class="copyright">
        <p>© 2024 Terre de Café - Tous droits reservés</p>
    </div>

    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/79a4c85e07.js" crossorigin="anonymous"></script>
 
    <!-- Gestion des erreurs pour le chargement des scripts -->
    <script>
        window.addEventListener('error', function(e) {
            console.error('Erreur de chargement:', e.message);
        }, true); 
    </script>
</body>
</html>