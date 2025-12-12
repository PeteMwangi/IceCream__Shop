<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
    exit();
}

// Remove item from wishlist
if (isset($_POST['remove_item'])) {
    $remove_id = $_POST['remove_id'];
    $verify_remove = $conn->prepare("SELECT * FROM `wishlist` WHERE id = ? AND user_id = ?");
    $verify_remove->execute([$remove_id, $user_id]);
    
    if ($verify_remove->rowCount() > 0) {
        $delete_item = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
        $delete_item->execute([$remove_id]);
        $message[] = 'Item removed from wishlist!';
    } else {
        $message[] = 'Item not found in your wishlist!';
    }
}

// Move to cart (optional functionality)
if (isset($_POST['move_to_cart'])) {
    $product_id = $_POST['product_id'];
    $price = $_POST['price'];
    
    // Check if item already in cart
    $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE product_id = ? AND user_id = ?");
    $verify_cart->execute([$product_id, $user_id]);
    
    if ($verify_cart->rowCount() > 0) {
        $message[] = 'Item already in cart!';
    } else {
        $insert_cart = $conn->prepare("INSERT INTO `cart` (id, product_id, price, qty) VALUES (?, ?, ?, 1)");
        $insert_cart->execute([$user_id, $product_id, $price]);
        
        // Remove from wishlist after moving to cart
        $remove_id = $_POST['remove_id'];
        $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
        $delete_wishlist->execute([$remove_id]);
        
        $message[] = 'Item moved to cart!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ice Cream - My Wishlist</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <style>
        .wishlist {
            background-image: url('../image/bg1.webp');
            background-size: cover;
            min-height: 100vh;
            padding: 2rem 0;
        }

        .wishlist .heading {
            text-align: center;
            margin-bottom: 2rem;
        }

        .wishlist .heading h1 {
            font-size: 2.5rem;
            color: var(--main-color);
            margin-bottom: 1rem;
        }

        .wishlist .heading img {
            width: 200px;
            margin: 0 auto;
        }

        .wishlist .box_container {
            padding: 2% 6%;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .wishlist .box {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .wishlist .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .wishlist .box .image {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .wishlist .box .content {
            padding: 1.5rem;
        }

        .wishlist .box .name {
            font-size: 1.3rem;
            color: var(--main-color);
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .wishlist .box .price {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 1rem;
            font-weight: bold;
        }

        .wishlist .box .btn-container {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .wishlist .box .btn {
            column-gap: 3;
            padding: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            display: column;
            align-items: center;
            justify-content: center;
            
        }

        .wishlist .box .view-btn {
            background: #fff;
            color: white;
        }

        .wishlist .box .view-btn:hover {
            background: #fff;
        }

        .wishlist .box .cart-btn {
            background: #ff8e9d;
            color: white;
        }

        .wishlist .box .cart-btn:hover {
            background: #ff8e9d;
        }

        .wishlist .box .remove-btn {
            background: #e74c3c;
            color: white;
        }

        .wishlist .box .remove-btn:hover {
            background: #c0392b;
        }

        .wishlist .empty {
            text-align: center;
            padding: 3rem;
            background: rgba(255,255,255,0.9);
            border-radius: 10px;
            grid-column: 1 / -1;
        }

        .wishlist .empty img {
            width: 150px;
            margin-bottom: 1rem;
        }

        .wishlist .empty h3 {
            font-size: 1.5rem;
            color: #666;
            margin-bottom: 1rem;
        }

        .wishlist .empty p {
            color: #888;
            margin-bottom: 1.5rem;
        }

        .wishlist .empty .btn {
            display: inline-block;
            padding: 0.8rem 2rem;
            background: var(--main-color);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .wishlist .empty .btn:hover {
            background: #ffffffff;
        }

        @media (max-width: 768px) {
            .wishlist .box_container {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                padding: 2% 4%;
                gap: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .wishlist .box_container {
                grid-template-columns: 1fr;
                padding: 2%;
            }
            
            .wishlist .box .btn-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<?php include 'components/user_header.php'; ?>

<div class="wishlist">
    <div class="banner">
        <div class="detail">
            <h1>My Wishlist</h1>
            <p>"Your favorite ice cream flavors are waiting! Save them here to order later or move them to your cart when you're ready to indulge."</p>
            <span><a href="home.php">Home</a> <i class="fas fa-chevron-right"></i> My Wishlist</span>
        </div>
    </div>

    <div class="heading">
        <h1>Saved Items</h1>
        <img src="image/separator-img.png" alt="separator">
    </div>

    <div class="box_container">
        <?php
      
        $select_wishlist = $conn->prepare("SELECT w.*, p.name, p.image 
                                          FROM `wishlist` w 
                                          INNER JOIN `products` p ON w.product_id = p.id 
                                          WHERE w.user_id = ? 
                                          ORDER BY w.id DESC");
        $select_wishlist->execute([$user_id]);

        if ($select_wishlist->rowCount() > 0) {
            while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <div class="box">
                    <img src="uploaded_files/<?= htmlspecialchars($fetch_wishlist['image']); ?>" 
                         alt="<?= htmlspecialchars($fetch_wishlist['name']); ?>" 
                         class="image">
                    <div class="content">
                        <h3 class="name"><?= htmlspecialchars($fetch_wishlist['name']); ?></h3>
                        <p class="price">Ksh <?= htmlspecialchars($fetch_wishlist['price']); ?></p>
                        
                    
                            <form method="POST" style="display: inline; flex: 1;">
                                <input type="hidden" name="product_id" value="<?= $fetch_wishlist['product_id']; ?>">
                                <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
                                <input type="hidden" name="remove_id" value="<?= $fetch_wishlist['id']; ?>">
                                <button type="submit" name="move_to_cart" class="btn cart-btn">
                                    <i class="fas fa-shopping-cart"></i> Cart
                                </button>
                            </form>
                            
                            <form method="POST" style="display: inline; flex: 1;">
                                <input type="hidden" name="remove_id" value="<?= $fetch_wishlist['id']; ?>">
                                <button type="submit" name="remove_item" class="btn remove-btn" 
                                        onclick="return confirm('Are you sure you want to remove this item from your wishlist?');">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
        ?>
            <div class="empty">
                <img src="image/empty-wishlist.png" alt="Empty wishlist">
                <h3>Your wishlist is empty</h3>
                <p>Start adding your favorite ice cream flavors to your wishlist!</p>
                <a href="menu.php" class="btn">Browse Products</a>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<?php include 'components/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>

<?php include 'components/alert.php'; ?>
</body>
</html>