<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A propos - Terre de Café</title>
    <link rel="icon" href="img/favicon.png" type="img/favicon.png">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <section id="header">
        <a href="index.php"><img src="img/logo-header.png" class="logo" alt=""></a>
        <div>
            <nav>
                <ul id="navbar">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#" data-account-link>Compte</a></li>
                    <li><a href="shop.php">Commander</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a class="active" href="about.php">A propos</a></li>
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

    <section id="page-header-about" class="about-header">
        <h2>Notre passion pour le café</h2>
    </section>

    <section id="about-story" class="section1">
        <div class="story-container">
            <div class="story-text">
                <h2>L'histoire de Terre de Café</h2>
                <p class="highlight-text">Une aventure née de la passion pour le café d'exception</p>
                <div class="story-content">
                    <p>Terre de Café est né d'une envie simple mais profonde : créer un pont entre les producteurs de café
                        d'exception et les amateurs en quête d'authenticité.</p>
                    <p>Notre voyage a commencé au Brésil, où nous avons découvert des fermes cultivant des grains
                        remarquables. Cette passion nous a menés au Kenya et à la Nouvelle-Orléans, explorant des traditions
                        uniques.</p>
                    <p>Aujourd'hui, notre sélection inclut également l'Italie, patrie du café espresso, chaque origine
                        racontant une partie de notre amour pour le café.</p>
                </div>
            </div>
            <div class="story-image">
                <img src="img/cafe1.jpg" alt="Notre histoire">
            </div>
        </div>
    </section>

    <section id="team" class="section1">
        <h2>Notre équipe passionnée</h2>
        <p class="highlight-text">Des experts dévoués à l'excellence du café</p>
        
        <div class="team-container">
            <div class="team-member">
                <div class="member-image">
                    <img src="img/lucas.jpg" alt="Lucas">
                </div>
                <div class="member-info">
                    <h3>Lucas</h3>
                    <span class="role">Sourceur de café</span>
                    <p>Aventurier des goûts et explorateur des origines, Lucas parcourt les terres caféicoles pour dénicher
                        les meilleures plantations du Brésil au Kenya.</p>
                </div>
            </div>

            <div class="team-member">
                <div class="member-image">
                    <img src="img/sophie.jpg" alt="Sophie">
                </div>
                <div class="member-info">
                    <h3>Sophie</h3>
                    <span class="role">Barista experte</span>
                    <p>Barista passionnée, Sophie révèle tout le potentiel des sélections, guidant les amateurs dans l'art
                        de préparer et déguster un café parfait.</p>
                </div>
            </div>

            <div class="team-member">
                <div class="member-image">
                    <img src="img/julien.jpg" alt="Julien">
                </div>
                <div class="member-info">
                    <h3>Julien</h3>
                    <span class="role">Maître torréfacteur</span>
                    <p>Torréfacteur d'exception, Julien transforme les grains en élixirs uniques, sublimant les 
                        caractéristiques de chaque terroir.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="values" class="section1">
        <h2>Nos valeurs</h2>
        <div class="values-container">
            <div class="value-card">
                <i class="fas fa-leaf"></i>
                <h3>Développement durable</h3>
                <p>Engagement pour une culture respectueuse de l'environnement et des écosystèmes locaux.</p>
            </div>
            <div class="value-card">
                <i class="fas fa-handshake"></i>
                <h3>Commerce équitable</h3>
                <p>Partenariats justes et durables avec nos producteurs pour un café éthique.</p>
            </div>
            <div class="value-card">
                <i class="fas fa-award"></i>
                <h3>Excellence</h3>
                <p>Recherche constante de la meilleure qualité à chaque étape de la production.</p>
            </div>
        </div>
    </section>
    <div class="freepik">
       <a href="http://www.freepik.com/">Images by Freepik</a>
    </div>

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
</body>
</html>