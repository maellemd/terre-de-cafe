<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog - Terre de Café</title>
  <link rel="icon" href="img/favicon.png" type="img/favicon.png">
  <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/blog.css">
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
<section id="page-header-blog" class="blog-header">
    <h2>En savoir plus sur le café</h2>
</section>
<section id="blog">
    <div class="blog-box">
        <div class="blog-img">
            <img src="img/blog/blog1.jpg" width="100%" alt="processus de fabrication du café">
        </div>
        <div class="blog-details">
            <h4>Le processus de fabrication de votre café</h4>
            <p>Du cafeier à votre tasse</p>
            <a href="blog/processus.php">LIRE PLUS</a>
        </div>
    </div>
    <div class="blog-box">
        <div class="blog-img">
            <img src="img/blog/blog2.jpg" width="100%" alt="différents types de café">
        </div>
        <div class="blog-details">
            <h4>Comment choisir votre café ?</h4>
            <p>Nos conseils pour choisir le café qui vous correspond</p>
            <a href="blog/choisir-son-cafe.php">LIRE PLUS</a>
        </div>
    </div>
    <div class="blog-box">
        <div class="blog-img">
            <img src="img/blog/blog3.jpg" width="100%" alt="différences entre les cafés">
        </div>
        <div class="blog-details">
            <h4>Comprendre les différences entre les cafés</h4>
            <p>Qu'ont-ils de si différents ?</p>
            <a href="blog/differences.php">LIRE PLUS</a>
        </div>
    </div>
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
        <img src="../img/paypal-1.png" alt="Paiement">
    </div>
</footer>
<div class="copyright">
    <p>© 2024 Terre de Café - Tous droits reservés</p>
</div>
<script src="script.js"></script>
<script src="https://kit.fontawesome.com/79a4c85e07.js" crossorigin="anonymous"></script>
</body>
</html>