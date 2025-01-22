<?php 
require 'connect.php';

try {
    // Récupération des produits de la base de données
    $products = $pdo->query('SELECT * FROM products')->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    // MEssage d'erreur
    die('Un problème est survenu lors du chargement des produits. Veuillez réessayer plus tard.');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Commander - Terre de Café</title>
  <link rel="icon" href="img/favicon.png" type="img/favicon.png">
  <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/shop.css">
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
<section id="page-header-shop">
    <h2>Découvrez nos cafés d'exception</h2>
</section>

<!-- Les produits -->
<section id="product1" class="section1">
    <div class="product-container">
        <?php foreach ($products as $product) : ?>
            <div class="pro" onclick="window.location.href='<?php echo $product->url ?? 'detail.php?id=' . $product->id; ?>';">
                <img src="<?php echo $product->image ?? 'img/pro-page/default-coffee.png'; ?>" alt="<?php echo htmlspecialchars($product->name); ?>">
                <div class="des">
                    <span>Café</span>
                    <h5><?php echo htmlspecialchars($product->name); ?></h5>
                    <div class="star">
                        <?php 
                        // Les notes de chaque café
                        $rating = $product->rating ?? 0;
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $rating) {
                                echo '<i class="fas fa-star"></i>';
                            } elseif ($i - 0.5 <= $rating) {
                                echo '<i class="fa-solid fa-star-half"></i>';
                            } else {
                                echo '<i class="far fa-star"></i>';
                            }
                        }
                        ?>
                    </div>
                    <h4><?php echo number_format($product->price, 2); ?>€</h4>
                </div>
                <form action="../cart/addCart.php" method="POST" class="cart-form">
                <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="packaging" value="250">
                    <button type="submit" class="cart-icon">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </button>
                </form>            
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Pagination -->
<section id="pagination" class="section1">
    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <a href="#"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
</section>

<!-- Newsletter -->
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