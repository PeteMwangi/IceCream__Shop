<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

include 'components/add_wishlist.php';
include 'components/add_cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ice - Product Detail Page</title>
  <link rel="stylesheet" type="text/css" href="css/user_style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="banner">
  <div class="detail">
    <h1>Product Detail</h1>
    <p>"We’re a fun-loving team serving up happiness, one scoop at a time — crafting creamy, 
    delicious ice cream made with love, freshness, and a sprinkle of joy"</p>
    <span><a href="home.php">Home</a> <i class="bx bx-right-arrow-alt"></i> Product Detail</span>
  </div>
</div>

<section class="view_page">
  <div class="heading">
    <h1>Product Detail</h1>
    <img src="image/separator-img.png">
  </div>

<?php
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    $select_products = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $select_products->execute([$pid]);

    if ($select_products->rowCount() > 0) {
        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
?>
        <form action="" method="post" class="box">
            <div class="img-box">
                <img src="uploaded_files/<?= $fetch_products['image']; ?>">
            </div>
            <div class="detail">
                <?php if ($fetch_products['stock'] > 9) { ?>
                    <span class="stock" style="color: green;">In stock</span>
                <?php } elseif ($fetch_products['stock'] == 0) { ?>
                    <span class="stock" style="color: red;">Out of stock</span>
                <?php } else { ?>
                    <span class="stock" style="color: red;">Hurry only <?= $fetch_products['stock']; ?> left</span>
                <?php } ?>
                <p class="price">Ksh<?= $fetch_products['price']; ?>/-</p>
                <div class="name"><?= $fetch_products['name']; ?></div>
                <p class="product-detail"><?= $fetch_products['product_detail']; ?></p>
                <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                <div class="button">
                    <button type="submit" name="add_to_wishlist" class="btn">Add to Wishlist <i class="bx bx-heart"></i></button>
                    <input type="hidden" name="qty" value="1" min="0" class="quantity">
                    <button type="submit" name="add_to_cart" class="btn">Add to Cart <i class="bx bx-cart"></i></button>
                </div>
            </div>
        </form>
<?php
        }
    }
}
?>
</section>

<div class="products">
    <div class="heading">
        <h1>Similar Products</h1>
        <p>"We’re a fun-loving team serving up happiness, one scoop at a time — crafting creamy, 
        delicious ice cream made with love, freshness, and a sprinkle of joy"</p>
        <img src="image/separator-img.png">
    </div>
    <?php include 'components/footer.php'; ?>
</div>




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/user_script.js"></script>
<?php include 'components/alert.php'; ?>

</body>
</html>



