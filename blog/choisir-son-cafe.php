<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir son café - Terre de Café</title>
    <link rel="icon" href="img/favicon.png" type="img/favicon.png">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/blog.css">
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
    <section id="page-header-blog" class="blog-header">
        <h2>Comment choisir son café</h2>
    </section>

    <section id="article-blog" class="section1">
        <div class="blog-content">
            <p class="intro">Trouver le café parfait peut sembler complexe. Voici quelques conseils pour vous guider dans votre choix.</p>

            <div class="conseils">
                <div class="conseils-card">
                    <h3>1. Vos préférences gustatives</h3>
                    <div class="saveur">
                        <div class="saveur-box">
                            <h4>Acidulé et fruité</h4>
                            <p>Cafés d'Afrique : Kenya, Éthiopie</p>
                        </div>
                        <div class="saveur-box">
                            <h4>Doux et sucré</h4>
                            <p>Cafés d'Amérique du Sud, notamment du Brésil</p>
                        </div>
                        <div class="saveur-box">
                            <h4>Corsé et intense</h4>
                            <p>Cafés italiens, torréfaction foncée</p>
                        </div>
                        <div class="saveur-box">
                            <h4>Épicé et aromatique</h4>
                            <p>Cafés marocains, mélanges parfumés</p>
                        </div>
                    </div>
                </div>

                <div class="conseils-card">
                    <h3>2. Choisir entre Arabica et Robusta</h3>
                    <div class="variete">
                        <div class="variete-box">
                            <h4>Arabica</h4>
                            <p>Saveurs subtiles, faible teneur en caféine</p>
                        </div>
                        <div class="variete-box">
                            <h4>Robusta</h4>
                            <p>Plus corsé, riche en caféine, notes terreuses</p>
                        </div>
                    </div>
                </div>

                <div class="conseils-card">
                    <h3>3. Méthode de préparation</h3>
                    <div class="preparation">
                        <div class="preparation-box">
                            <h4>Filtre</h4>
                            <p>Cafés doux et équilibrés</p>
                        </div>
                        <div class="preparation-box">
                            <h4>Espresso</h4>
                            <p>Mélanges intenses, torréfaction foncée</p>
                        </div>
                        <div class="preparation-box">
                            <h4>Presse française</h4>
                            <p>Cafés riches et corsés</p>
                        </div>
                        <div class="preparation-box">
                            <h4>Aéropress/Chemex</h4>
                            <p>Découverte d'arômes délicats</p>
                        </div>
                    </div>
                </div>

                <div class="conseils-card">
                    <h3>4. Comprendre les torréfactions</h3>
                    <div class="torrefaction">
                        <div class="torrefaction-box">
                            <h4>Torréfaction légère</h4>
                            <p>Notes fruitées et florales</p>
                        </div>
                        <div class="torrefaction-box">
                            <h4>Torréfaction moyenne</h4>
                            <p>Équilibre entre acidité et amertume</p>
                        </div>
                        <div class="torrefaction-box">
                            <h4>Torréfaction foncée</h4>
                            <p>Arômes de chocolat et caramel</p>
                        </div>
                    </div>
                </div>

                <div class="conseils-card final-advice">
                    <h3>5. Expérimentez et explorez</h3>
                    <p>Le café est un voyage gustatif personnel. N'hésitez pas à goûter différentes origines, variétés et préparations. Votre café parfait est une découverte continue.</p>
                </div>
            </div>
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
</body>
</html>
