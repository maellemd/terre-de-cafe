<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../session_config.php';
require_once __DIR__ . '/../connect.php';

// Initialiser le panier s'il n'existe pas
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Gérer les modifications du panier
if (isset($_POST['update_quantity'])) {
    $cart_key = $_POST['cart_key'];
    $new_quantity = (int)$_POST['quantity'];
    
    // Supprimer l'article si quantité = 0
    if ($new_quantity <= 0) {
        unset($_SESSION['cart'][$cart_key]);
    } else if ($new_quantity <= 10) {
        $_SESSION['cart'][$cart_key]['quantity'] = $new_quantity;
    }
    
    header('Location: cart.php');
    exit();
}

$cartItems = $_SESSION['cart'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon panier - Terre de Café</title>
    <link rel="icon" href="../img/favicon.png" type="img/favicon.png">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/cart.css">
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
                    <li id="shopping-bag"><a href="../cart/cart.php" class="active">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a></li>
                    <a href="#" id="close"><i class="fa-regular fa-circle-xmark"></i></a>
                </ul>
            </nav>
        </div>
        <div id="mobile">
            <a href="../cart/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <i id="bar" class="fa-solid fa-bars"></i>
        </div>
    </section>

    <section id="page-header-cart" class="cart-header">
        <h2>Mon panier</h2>
    </section>

    <div class="cart-container">
        <div class="cart">
            <?php if (empty($cartItems)): ?>
                <div class="empty-cart">
                    <i class="fas fa-shopping-basket"></i>
                    <p>Votre panier est vide</p>
                    <a href="../shop.php" class="btn-continue">Continuer mes achats</a>
                </div>
            <?php else: ?>
                <div class="cart-content">
                    <div class="rowtitle">
                        <span>Produit</span>
                        <span>Conditionnement</span>
                        <span>Prix</span>
                        <span>Quantité</span>
                        <span>Total</span>
                        <span>Action</span>
                    </div>

                    <?php foreach ($cartItems as $cart_key => $product): ?>
                        <div class="cart-item">
                            <span class="product-name"><?= htmlspecialchars($product['name']) ?></span>
                            <span class="product-packaging"><?= $product['packaging'] ?>g</span>
                            <span class="product-price"><?= number_format($product['price'], 2) ?>€</span>
                            <span class="product-quantity">
                                <form action="cart.php" method="POST" class="quantity-form">
                                    <input type="hidden" name="cart_key" value="<?= $cart_key ?>">
                                    <input type="hidden" name="update_quantity" value="1">
                                    <div class="quantity-controls">
                                        <button type="button" onclick="decrementQuantity(this)">-</button>
                                        <input type="number" name="quantity" value="<?= $product['quantity'] ?>" 
                                               min="0" max="10" onchange="this.form.submit()">
                                        <button type="button" onclick="incrementQuantity(this)">+</button>
                                    </div>
                                </form>
                            </span>
                            <span class="product-total"><?= number_format($product['price'] * $product['quantity'], 2) ?>€</span>
                            <span class="product-actions">
                                <button onclick="removeItem('<?= $cart_key ?>')" class="remove-item">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </span>
                        </div>
                    <?php endforeach; ?>

                    <div class="cart-total">
                        <div class="total-info">
                            <strong>Total de la commande :</strong>
                            <span><?= number_format(array_reduce($cartItems, function ($sum, $item) {
                                return $sum + $item['price'] * $item['quantity'];
                            }, 0), 2) ?>€</span>
                        </div>
                    </div>

                    <div class="cart-actions">
                        <a href="../shop.php" class="btn-continue">Continuer mes achats</a>
                        <?php if (isset($_SESSION['id'])): ?>
                            <a href="checkout.php" class="btn-checkout">Passer commande</a>
                        <?php else: ?>
                            <div class="login-notice">
                                <p>Veuillez <a href="../account/connexion.php?redirect=checkout">vous connecter</a> pour finaliser votre commande.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

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

    <script>
    function incrementQuantity(button) {
        const input = button.parentElement.querySelector('input[type="number"]');
        if (input.value < 10) {
            input.value = parseInt(input.value) + 1;
            input.form.submit();
        }
    }

    function decrementQuantity(button) {
        const input = button.parentElement.querySelector('input[type="number"]');
        if (input.value > 0) {
            input.value = parseInt(input.value) - 1;
            input.form.submit();
        }
    }

    function removeItem(cartKey) {
        if (confirm('Voulez-vous vraiment supprimer cet article ?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'cart.php';

            const keyInput = document.createElement('input');
            keyInput.type = 'hidden';
            keyInput.name = 'cart_key';
            keyInput.value = cartKey;

            const quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = 'quantity';
            quantityInput.value = '0';

            const updateInput = document.createElement('input');
            updateInput.type = 'hidden';
            updateInput.name = 'update_quantity';
            updateInput.value = '1';

            form.appendChild(keyInput);
            form.appendChild(quantityInput);
            form.appendChild(updateInput);
            document.body.appendChild(form);
            form.submit();
        }
    }
    </script>
    <script src="../script.js"></script>
    <script src="https://kit.fontawesome.com/79a4c85e07.js" crossorigin="anonymous"></script>
</body>
</html>