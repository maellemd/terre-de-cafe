<?php 
require_once '../connect.php';
$product_id = 1;  
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café américain - Terre de Café</title>
    <link rel="icon" href="img/favicon.png" type="img/favicon.png">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/shop.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <section id="header">
        <a href="../index.php"><img src="../img/logo-header.png" class="logo" alt=""></a>
        <div>
            <nav>
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
            </nav>
        </div>
        <div id="mobile">
            <a href="../cart/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <i id="bar" class="fa-solid fa-bars"></i>
        </div>
    </section>

    <section id="prodetails" class="section1">
        <div class="single-pro-image">
            <img src="../img/produits/american-coffee.png" width="100%" id="MainImg" alt="Café Américain">
            <div class="small-img-group">
                <div class="small-img-col">
                    <img src="../img/produits/american-coffee.png" width="100%" class="small-img" alt="Café Américain">
                </div>
                <div class="small-img-col">
                    <img src="../img/produits/cafe-grains1.jpg" width="100%" class="small-img" alt="Café en grains">
                </div>
                <div class="small-img-col">
                    <img src="../img/produits/cafe-grains2.jpg" width="100%" class="small-img" alt="Café en grains">
                </div>
                <div class="small-img-col">
                    <img src="../img/produits/cafe-moulu.jpg" width="100%" class="small-img" alt="Café moulu">
                </div>
            </div>
        </div>
        <div class="single-pro-details">
            <h6>Nos cafés</h6>
            <h4>Le Café Américain</h4>
            <h2>8.99€</h2>
            <form action="../cart/addCart.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $product_id; ?>">
                <select name="packaging" required>
                    <option value="">Sélectionner conditionnement</option>
                    <option value="250">250g</option>
                    <option value="500" disabled>500g - Bientôt de retour !</option>
                </select>
                <input type="number" name="quantity" value="1" min="1" max="10" required>
                <button type="submit" class="normal">Ajouter au panier</button>
            </form>
            <h4>Détails</h4>
            <span>Léger et délicat, le café américain est parfait pour ceux qui aiment une tasse douce et allongée. Ses arômes subtils de noisette et de chocolat au lait proviennent souvent d'un mélange soigneusement torréfié à partir de grains d'Amérique centrale et du Sud. Cette méthode de préparation, qui dilue un espresso avec de l'eau chaude, trouve ses origines dans les habitudes des soldats américains pendant la Seconde Guerre mondiale, qui cherchaient à recréer le café filtre de leur pays.</span>
        </div>
    </section>

    <section id="product1" class="section1">
        <h4 class="h2-center-it">Vous pourriez aimer</h4>
        <div class="product-container">
    <div class="pro" onclick="window.location.href='new-orleans.php';">
        <img src="../img/pro-page/new-orleans-coffee.png" alt="Café New Orleans">
        <div class="des">
            <span>Café</span>
            <h5>Café New Orleans</h5>
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fa-solid fa-star-half"></i>
            </div>
            <h4>12.99€</h4>
        </div>
        <form action="../cart/addCart.php" method="POST" class="cart-form">
            <input type="hidden" name="id" value="6">  <!-- ID du café New Orleans -->
            <input type="hidden" name="quantity" value="1">
            <input type="hidden" name="packaging" value="250">
            <button type="submit" class="cart-icon">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </button>
        </form>
    </div>

    <div class="pro" onclick="window.location.href='francais.php';">
        <img src="../img/pro-page/french-coffee.png" alt="Café Français">
        <div class="des">
            <span>Café</span>
            <h5>Café Français</h5>
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h4>7.99€</h4>
        </div>
        <form action="../cart/addCart.php" method="POST" class="cart-form">
            <input type="hidden" name="id" value="9">  <!-- ID du café français -->
            <input type="hidden" name="quantity" value="1">
            <input type="hidden" name="packaging" value="250">
            <button type="submit" class="cart-icon">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </button>
        </form>
    </div>

    <div class="pro" onclick="window.location.href='italien.php';">
        <img src="../img/pro-page/italian-coffee.png" alt="Café Italien">
        <div class="des">
            <span>Café</span>
            <h5>Café Italien</h5>
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h4>7.99€</h4>
        </div>
        <form action="../cart/addCart.php" method="POST" class="cart-form">
            <input type="hidden" name="id" value="3">  <!-- ID du café italien -->
            <input type="hidden" name="quantity" value="1">
            <input type="hidden" name="packaging" value="250">
            <button type="submit" class="cart-icon">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </button>
        </form>
    </div>

    <div class="pro" onclick="window.location.href='kenyan.php';">
        <img src="../img/pro-page/kenya-coffee.png" alt="Café Kenya">
        <div class="des">
            <span>Café</span>
            <h5>Café Kenya</h5>
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h4>12.99€</h4>
        </div>
        <form action="../cart/addCart.php" method="POST" class="cart-form">
            <input type="hidden" name="id" value="4">  <!-- ID du café kenyan -->
            <input type="hidden" name="quantity" value="1">
            <input type="hidden" name="packaging" value="250">
            <button type="submit" class="cart-icon">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </button>
        </form>
    </div>
</div>
    </section>

    <section id="newletter" class="section1 section2">
        <div class="newstext">
            <h4>S'inscrire à notre newsletter</h4>
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