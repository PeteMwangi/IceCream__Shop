<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    header('location:login.php');
    exit;
}

session_start();

if (isset($_POST['update_cart'])) {
    $cart_id = filter_var($_POST['cart_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $qty = filter_var($_POST['qty'], FILTER_SANITIZE_SPECIAL_CHARS);

    $update_qty = $conn->prepare("UPDATE cart SET qty = ? WHERE id = ?");
    $update_qty->execute([$qty, $cart_id]);

    $_SESSION['success_msg'] = 'Cart quantity updated successfully!';
    header("Location: cart.php"); // Reload to show message
    exit;
}

// delete
if (isset($_POST['delete_item'])) {
    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_SPECIAL_CHARS);

    
    $verify_delete_item = $conn->prepare("SELECT * FROM cart WHERE id = ?");
    $verify_delete_item->execute([$cart_id]);

    if ($verify_delete_item->rowCount() > 0) {

        $delete_cart_id = $conn->prepare("DELETE FROM cart WHERE id = ?");
        $delete_cart_id->execute([$cart_id]);

        $_SESSION['success_msg'] = 'Cart item deleted successfully';
        header("Location: cart.php");
        exit;
    } else {
        $_SESSION['warning_msg'] = 'Cart item already deleted or not found';
        header("Location: cart.php");
        exit;
    }
}

//empty

if (isset($_POST['empty_cart'])) {
    // ✅ Fix SQL syntax: remove single quotes around table name
    $verify_empty_item = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $verify_empty_item->execute([$user_id]);

    if ($verify_empty_item->rowCount() > 0) {

        $delete_cart_id = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $delete_cart_id->execute([$user_id]);
        
        $_SESSION['success_msg'] = 'Cart emptied successfully';
    } else {
        $_SESSION['warning_msg'] = 'Your cart is already empty';
    }

    header("Location: cart.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ice - user cart page</title>
     <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
<?php include 'components/user_header.php';?>
<div class="banner">
  <div class="detail">
    <h1>cart</h1>
    <p>"We’re a fun-loving team serving up happiness, one scoop at a time — crafting creamy, 
    delicious ice cream made with love, freshness, and a sprinkle of joy"</p>
    <span><a href="home.php">cart</a> <i class="bx bx-right-arrow-alt"></i> login</span>
  </div>
</div>
<div class="products">
    <div class="heading">
        <h1>my cart</h1>
        <img src="image/separator-img.png">
    </div>
    <div class="box-container">
        <?php
$grand_total = 0;
$select_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$select_cart->execute([$user_id]);

if ($select_cart->rowCount() > 0) {
    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
        $select_products = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $select_products->execute([$fetch_cart['product_id']]);

        if ($select_products->rowCount() > 0) {
            $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
?>
    <form action="" method="post" class="box" <?php if ($fetch_products['stock'] == 0) { echo 'disabled'; } ?>>
        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
        <img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image">
        
        <?php if($fetch_products['stock'] > 9){ ?>
        <span class="stock" style="color: green;">In stock</span>
        <?php }elseif($fetch_products['stock'] == 0){ ?>
        <span class="stock" style="color: red;">Out of stock</span>
        <?php }else{ ?>
        <span class="stock" style="color:red;"> Hurry only <? $fetch_products['stock']; ?>left</span>
        <?php }?>
        <div class="content">
            <img src="image/shape-19.png" class="shap">
            <h3 class="name"><?= $fetch_products['name']; ?></h3>
            <div class="flex-btn">
                <p class="price">price Ksh<?= $fetch_products['price']; ?>/=</p>
                <input type="number" name="qty" required min="1" value="<?= $fetch_cart['qty'] 
                ?>" max="99" maxlength="2" class="box qty">
                <button type="submit" name="update_cart" class="bx bxs-edit fa-edit box">    </button> 
            </div>
            <div class="flex-btn">
                <p class="sub-total">sub total : <span>Ksh<?= $sub_total = ($fetch_cart['qty']
                *$fetch_cart['price']); ?></span></p>
                <button type="submit" name="delete_item" class="btn" onclick="return confirm ('remove from cart');">delete</button>

            </div>
        </div>
    </form>
<?php
            $grand_total += $sub_total;
        }else{
            echo '
            <div class="empty">
            <p> no products was found!</p>
            </div>
            ';
        }
    }
}else{
    echo '
            <div class="empty">
            <p> no products added yet!</p>
            </div>
            ';
    }
?>
 </div>
            <?php if ($grand_total != 0){ ?>
              <div class="cart-total">
                <p>total amaount payable : <span> Ksh <?= $grand_total; ?>/-</span></p>
                <div class="button">
                    <form action="" method="post">
                        <button type="submit" name="empty_cart" class="btn" onclick="return confirm
                        ('are you sure to empty your cart');">empty cart</button>
                    </form>
                    <a href="checkout.php" class="btn">proceed to checkout</a>
            </div>
            </div>
            <?php } ?>
                </div>      
            
</div>





<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_SESSION['success_msg'])): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '<?= $_SESSION['success_msg']; ?>',
        confirmButtonColor: '#3085d6'
    });
</script>
<?php unset($_SESSION['success_msg']); endif; ?>





<?php include 'components/footer.php';?>
<script src="https://cdjns.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>
<?php include 'components/alert.php';?>