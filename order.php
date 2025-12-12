<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ice - user login page</title>
     <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    
</head>
<body>
<?php include 'components/user_header.php'; ?>

<div class="banner">
  <div class="detail">
    <h1>My Orders 🛒</h1>
    <p>"We’re a fun-loving team serving up happiness, one scoop at a time — crafting creamy, 
    delicious ice cream made with love, freshness, and a sprinkle of joy."</p>
    <span><a href="home.php">Home</a> <i class="bx bx-right-arrow-alt"></i> My Orders</span>
  </div>
</div>

<div class="orders">
  <div class="heading">
    <h1>My Orders</h1>
    <img src="image/separator-img.png" alt="separator">
  </div>

  <div class="box_container">
    <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY dates DESC");
      $select_orders->execute([$user_id]);

      if ($select_orders->rowCount() > 0) {
        while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
          $product_id = $fetch_orders['product_id'];

          $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
          $select_products->execute([$product_id]);

          if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
    ?>
              <div class="box" <?php if ($fetch_orders['status'] == 'canceled') echo 'style="border:2px solid red"'; ?>>
                <a href="view_order.php?get_id=<?= htmlspecialchars($fetch_orders['id']); ?>">
                  <img src="uploaded_files/<?= htmlspecialchars($fetch_products['image']); ?>" class="image">
                  <p class="date"><i class="fa fa-calendar"></i> <?= $fetch_orders['dates']; ?></p> 
                  <div class="content">
                    <img src="image/shape-19.png" class="shap">
                                 
                    <div class="row">
                      <h3><?= htmlspecialchars($fetch_products['name']); ?></h3>
                      <p class="price">Price : $<?= htmlspecialchars($fetch_products['price']); ?>/-</p>
                      <p class="status" style="color:<?php if($fetch_orders['status'] == 'delivered'){echo "green";}elseif($fetch_orders['status'] == 'canceled'){echo "red";}else{echo "orange";} ?>"><?= $fetch_orders['status']; ?></p>
                    </div>
                  </div>
                </a>
              </div>
    <?php
            }
          }
        }
      } else {
        echo '<p class="empty">No orders placed yet</p>';
      }
    ?>
  </div>
</div>








<?php include 'components/footer.php';?>
<script src="https://cdjns.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>

<?php include 'components/alert.php';?>