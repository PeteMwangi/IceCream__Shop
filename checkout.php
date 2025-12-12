<?php
include 'components/connect.php';

// Check user session or cookie
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location: login.php');
    exit();
}

// PLACE ORDER
if (isset($_POST['place_order'])) {

    // Sanitize input fields
    $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Combine address fields
    $flat = filter_var($_POST['flat'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $street = filter_var($_POST['street'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $city = filter_var($_POST['city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pin = filter_var($_POST['pin'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $address = "$flat, $street, $city, $pin";

    $address_type = filter_var($_POST['address_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $method = filter_var($_POST['method'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $success = false; // flag to trigger success alert

    // BUY NOW
    if (isset($_GET['get_id'])) {
        $get_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $get_product->execute([$_GET['get_id']]);

        if ($get_product->rowCount() > 0) {
            $fetch_p = $get_product->fetch(PDO::FETCH_ASSOC);
            $seller_id = $fetch_p['seller_id'];

            $insert_order = $conn->prepare("
                INSERT INTO `orders`
                (id, user_id, seller_id, name, number, email, address, address_type, method, product_id, price, qty)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $insert_order->execute([
                uniqid(),
                $user_id,
                $seller_id,
                $name,
                $number,
                $email,
                $address,
                $address_type,
                $method,
                $fetch_p['id'],
                $fetch_p['price'],
                1
            ]);

            $success = true;
        }

    } else {
        // FROM CART
        $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $verify_cart->execute([$user_id]);

        if ($verify_cart->rowCount() > 0) {
            while ($fetch_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)) {
                $product_id = $fetch_cart['product_id'];

                $get_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                $get_product->execute([$product_id]);
                $fetch_p = $get_product->fetch(PDO::FETCH_ASSOC);

                $seller_id = $fetch_p['seller_id'];
                $price = $fetch_p['price'];
                $qty = $fetch_cart['qty'];

                $insert_order = $conn->prepare("
                    INSERT INTO `orders`
                    (id, user_id, seller_id, name, number, email, address, address_type, method, product_id, price, qty)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");

                $insert_order->execute([
                    uniqid(),
                    $user_id,
                    $seller_id,
                    $name,
                    $number,
                    $email,
                    $address,
                    $address_type,
                    $method,
                    $product_id,
                    $price,
                    $qty
                ]);
            }

            // Clear cart after successful order
            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);
            $success = true;

        } else {
            $warning_msg[] = 'Your cart is empty!';
        }
    }
}
?>

<!-- ✅ SweetAlert Success Message -->
<?php if (!empty($success) && $success): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    title: "Order Placed 🎉",
    text: "Your checkout was successful! You’ll be redirected to your orders page.",
    icon: "success",
    confirmButtonColor: "#28a745",
    timer: 2500,
    showConfirmButton: false
}).then(() => {
    window.location.href = "orders.php";
});
</script>
<?php endif; ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ice - checkout page</title>
     <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    
</head>
<body>
<?php include 'components/user_header.php';?>

<!-- Banner Section -->
<div class="banner">
  <div class="detail">
    <h1>Checkout</h1>
    <p>"We’re a fun-loving team serving up happiness, one scoop at a time — crafting creamy, 
    delicious ice cream made with love, freshness, and a sprinkle of joy."</p>
    <span><a href="home.php">Home</a> <i class="bx bx-right-arrow-alt"></i> Checkout</span>
  </div>
</div>

<!-- Checkout Section -->
<div class="checkout">
  <div class="row">

    <!-- 🛍 Summary Section (Moved Above Billing Details) -->
    <div class="summary">
      <h3> 🛒 My Cart</h3>
      <div class="box-container">
        <?php
        $grand_total = 0;

        // If user clicked "Buy Now"
        if (isset($_GET['get_id'])) {
            $select_get = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_get->execute([$_GET['get_id']]);

            while ($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)) {
                $sub_total = $fetch_get['price'];
                $grand_total += $sub_total;
        ?>
            <div class="flex">
              <img src="uploaded_files/<?= htmlspecialchars($fetch_get['image']); ?>" class="image">
              <div>
                <h3 class="name"><?= htmlspecialchars($fetch_get['name']); ?></h3>
                <p class="price">Ksh <?= htmlspecialchars($fetch_get['price']); ?>/-</p>
              </div>
            </div>
        <?php
            }
        } else {
            // If user is checking out from Cart
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);

            if ($select_cart->rowCount() > 0) {
                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                    $select_products->execute([$fetch_cart['product_id']]); 
                    $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);

                    $sub_total = $fetch_cart['qty'] * $fetch_products['price'];
                    $grand_total += $sub_total;
        ?>
            <div class="flex">
              <img src="uploaded_files/<?= htmlspecialchars($fetch_products['image']); ?>" class="image">
              <div>
                <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                <p class="price">Ksh <?= htmlspecialchars($fetch_products['price']); ?> x <?= htmlspecialchars($fetch_cart['qty']); ?></p>
              </div>
            </div>
        <?php
                }
            } else {
                echo '<p class="empty">Your cart is empty!</p>';
            }
        }
        ?>
      </div>
      <div class="grand-total">
        <span>Total Amount Payable:</span>
        <strong>Ksh <?= number_format($grand_total); ?>/=</strong>
      </div>
    </div>

    <!-- 🧾 Billing Details Form -->
    <form action="" method="post" class="register">
      <input type="hidden" name="p_id" value="<?= $get_id ?? ''; ?>">
      <h3>Billing Details</h3>

      <div class="flex">
        <!-- Column 1 -->
        <div class="box">
          <div class="input-field">
            <p>Your Name <span>*</span></p>
            <input type="text" name="name" required maxlength="50" placeholder="Enter your name" class="input">
          </div>

          <div class="input-field">
            <p>Your Number <span>*</span></p>
            <input type="number" name="number" required maxlength="10" placeholder="Enter your number" class="input">
          </div>

          <div class="input-field">
            <p>Your Email <span>*</span></p>
            <input type="email" name="email" required maxlength="50" placeholder="Enter your email" class="input">
          </div>

          <div class="input-field">
            <p>Payment Method <span>*</span></p>
            <select name="method" class="input">
              <option value="cash on delivery">Cash on Delivery</option>
              <option value="credit or debit card">Credit/Debit Card</option>
              <option value="net banking">Net Banking</option>
            </select>
          </div>

          <div class="input-field">
            <p>Address Type <span>*</span></p>
            <select name="address_type" class="input">
              <option value="home">Home</option>
              <option value="office">Office</option>
            </select>
          </div>
        </div>

        <!-- Column 2 -->
        <div class="box">
          <div class="input-field">
            <p>Address Line 01 <span>*</span></p>
            <input type="text" name="flat" required maxlength="50" placeholder="Flat or Building Name" class="input">
          </div>

          <div class="input-field">
            <p>Address Line 02 <span>*</span></p>
            <input type="text" name="street" required maxlength="50" placeholder="Street Name" class="input">
          </div>

          <div class="input-field">
            <p>City Name <span>*</span></p>
            <input type="text" name="city" required maxlength="50" placeholder="City Name" class="input">
          </div>

          <div class="input-field">
            <p>Pincode <span>*</span></p>
            <input type="number" name="pin" required maxlength="6" placeholder="e.g. 110011" class="input">
          </div>
        </div>
      </div>

      <button type="submit" name="place_order" class="btn">Place Order</button>
    </form>

  </div>
</div>
</body>






<?php include 'components/footer.php';?>
<script src="https://cdjns.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>

<?php include 'components/alert.php';?>
</body>
</html>