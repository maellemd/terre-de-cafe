<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact - Terre de Café</title>
  <link rel="icon" href="img/favicon.png" type="img/favicon.png">
  <link rel="stylesheet" href="styles/styles.css">
  <link rel="stylesheet" href="styles/contact.css">
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
<section id="page-header-contact" class="contact-header">
    <h2>Contactez-nous</h2>
</section>
<div id="container">
    <h1>&bull; Dites-nous tout &bull;</h1>
    <div class="underline">
    </div>
    <form action="#" method="post" id="contact_form">
      <div class="name">
        <label for="name"></label>
        <input type="text" placeholder="Nom complet" name="name" id="name_input" required>
      </div>
      <div class="email">
        <label for="email"></label>
        <input type="email" placeholder="Email" name="email" id="email_input" required>
      </div>
      <div class="telephone">
        <label for="name"></label>
        <input type="text" placeholder="Numéro de téléphone" name="telephone" id="telephone_input" required>
      </div>
      <div class="subject">
        <label for="subject"></label>
        <select placeholder="Sujet de ma demande" name="subject" id="subject_input" required>
          <option disabled hidden selected>Sujet de ma demande</option>
          <option>Demande d'informations</option>
          <option>Réclamation</option>
          <option>Recrutement</option>
          <option>Autre demande</option>
        </select>
      </div>
      <div class="message">
        <label for="message"></label>
        <textarea name="message" placeholder="Message" id="message_input" cols="30" rows="5" required></textarea>
      </div>
      <div class="submit">
        <input type="submit" value="Envoyer" id="form_button" />
      </div>
    </form>
  </div>
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