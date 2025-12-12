<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:orders.php');
    exit();
}

if (isset($_POST['cancel'])) {
    $update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
    $update_order->execute(['canceled', $get_id]);

    header('location:order.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ice - order dtail page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    
</head>
<body>
<?php include 'components/user_header.php';

// Get order ID from URL
if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
} else {
    header('location: orders.php');
    exit();
}
?>

<div class="banner">
  <div class="detail">
    <h1>order detail</h1>
    <p>"We're a fun-loving team serving up happiness, one scoop at a time — crafting creamy, 
    delicious ice cream made with love, freshness, and a sprinkle of joy"</p>
    <span><a href="home.php">home</a> <i class="bx bx-right-arrow-alt"></i>order detail</span>
  </div>
</div>

<div class="order-detail">
    <div class="heading">
        <h1>my order detail</h1>
        <p>We're a fun-loving team serving up happiness, one scoop at a time — crafting creamy, 
        delicious ice cream made with love</p>
        <img src="image/separator-img.png">
    </div>
    <div class="box-container">
      <?php
        $grand_total = 0;
        $select_order = $conn->prepare("SELECT * FROM `orders` WHERE id = ? LIMIT 1");
        $select_order->execute([$get_id]);

        if ($select_order->rowCount() > 0){
            
            while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)){
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                $select_product->execute([$fetch_order['product_id']]);
                if ($select_product->rowCount() > 0){
                    while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
                     $sub_total = ($fetch_order['price'] * $fetch_order['qty']);
                     $grand_total += $sub_total;   
        ?>
                <div class="box">
                    <div class="col">
                        <p class="title"><i class="fa-regular fa-calendar-days"></i> <?= $fetch_order['dates']; ?></p>
                        <img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image">
                       <p class="price">Ksh <?= $fetch_product['price']; ?></p>
                       <h3 class="name"><?= $fetch_product['name']; ?></h3>
                       <p class="grand-total">Total amount payable : <span> Ksh <?= $grand_total; ?></span></p>
                    </div>
                  <div class="col">
                    <p class="title">Billing address</p>
                    <p class="user"><i class="fa-solid fa-user"></i> <?= $fetch_order['name']
                    ; ?></p>
                    <p class="user"><i class="fa-solid fa-phone"></i> <?= $fetch_order['number']; ?></p>
                    <p class="user"><i class="fa-solid fa-envelope"></i> <?= $fetch_order['email']; ?></p>
                    <p class="user"><i class="fa-solid fa-map-pin"></i>  <?= $fetch_order['address']; ?></p>
                     <p class="status" style="color:<?php if($fetch_order['status'] == 'delivered'){
                        echo "green";}elseif($fetch_order['status'] == 'canceled'){echo "red";}else
                        {echo "orange";} ?>"><?= $fetch_order['status']; ?></p>
                    <?php if($fetch_order['status']=='canceled'){ ?>
                        <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn">
                        order again</a>
                        <?php }else{ ?>
                        <form action="" method="post">
                            <button type="submit" name="cancel" class="btn" onclick="return confirm('Do you want to cancel this product?')">cancel</button>
                        </form>
                <?php } ?>
                </div>
            </div>
        <?php
                    }
                }
            }
        } else {
            echo '<p class="empty">Order not found!</p>';
        }
        ?>
    </div>
</div>







<?php include 'components/footer.php';?>
<script src="https://cdjns.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>
<?php include 'components/alert.php';?>