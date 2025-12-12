<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<script src="js/user_script.js"></script>
<script src="js/user_script.js" defer></script>


<header class="header">
  <section class="flex">
    <a href="home.php" class="logo">
      <img src="image/logo.png" width="138px">
    </a>

    <nav class="navbar">
      <a href="home.php">home</a>
      <a href="about-us.php">about us</a>
      <a href="menu.php">shop</a>
      <a href="order.php">order</a>
      <a href="contact.php">contact us</a>
    </nav>

    <form action="search_product.php" method="post" class="search-form">
      <input type="text" name="search_product" placeholder="search product..." required maxlength="100">
      <button type="submit" class="bx bx-search-alt-2" id="search_product_btn"></button>
    </form>

    <div class="icons">
      <div class="bx bx-list-plus" id="menu-btn"></div>
      <div class="bx bx-search-alt-2" id="search-btn"></div>
     <?php
$count_wishlist_item = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ?");
$count_wishlist_item->execute([$user_id]);
$total_wishlist_items = $count_wishlist_item->rowCount();
?>
<a href="wishlist.php"><i class="bx bx-heart"></i><sup><?= $total_wishlist_items; ?></sup></a>

<?php
$count_cart_item = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$count_cart_item->execute([$user_id]);
$total_cart_items = $count_cart_item->rowCount();
?>
<a href="cart.php"><i class="bx bx-cart"></i><sup><?= $total_cart_items; ?></sup></a>
   
<div class="user-menu-wrapper">
  <i class="bx bxs-user" id="user-btn"></i>

  <div class="profile-popup" id="profilePopup">
    <a href="login.php" class="btn">Login</a>
    <a href="register.php" class="btn">Sign Up</a>
    <a href="home.php" class="btn">Log Out</a>
  </div>
</div>


    </div>
    <div class="profile-detail">
        <?php
$select_profile = $conn->prepare("SELECT * FROM users WHERE id = ?");
$select_profile->execute([$user_id]);

if ($select_profile->rowCount() > 0) {
    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
?>
    <img src="uploaded_files/<?= htmlspecialchars($fetch_profile['image']); ?>" alt="Profile Image">
    <h3 style="margin-bottom: 1rem;"><?= htmlspecialchars($fetch_profile['name']); ?></h3>
    <div class="flex-btn">
        <a href="profile.php" class="btn">view profile</a>
        <a href="components/user_logout.php" onclick="return confirm('Logout from this website?');" class="btn">logout</a>
    </div>
<?php 
} else { 
?>
    <h3 style="margin-bottom: 1rem;">Please login or register</h3>
    <div class="flex-btn">
        <a href="login.php" class="btn">login</a>
        <a href="register.php" class="btn">register</a>
    </div>
<?php 
} 
?>

    </div>
  </section>
</header>
