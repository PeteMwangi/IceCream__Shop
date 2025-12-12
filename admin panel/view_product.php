 
<?php
include '../components/connect.php';
if(isset($_COOKIE['seller_id'])){
    $seller_id = $_COOKIE['seller_id'];
}else{
    $seller_id = '';
    header('location:loging.php');
}

//delete products
if(isset($_POST['delete'])){
    $p_id = $_POST['product_id'];
    $p_id = filter_var($p_id, FILTER_SANITIZE_SPECIAL_CHARS);


    $delete_product = $conn->prepare("DELETE FROM products WHERE id = ?");
    $delete_product->execute([$p_id]);

    $success_msg[] = 'product deleted successfully';
}
?>

<!-- Display alerts -->
<?php

if (isset($_SESSION['warning_msg'])) {
    echo "<script>alert('" . $_SESSION['warning_msg'] . "');</script>";
    unset($_SESSION['warning_msg']); // Remove the message after displaying
}
if (isset($_SESSION['success_msg'])) {
    echo "<script>alert('" . $_SESSION['success_msg'] . "');</script>";
    unset($_SESSION['success_msg']); // Remove the message after displaying
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nai Fresh - Show Products page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
</head>
<body>

<div class="main-container">
    <?php include '../components/admin_header.php'; ?>
</div>

<section class="show-post">
    <div class="heading">
        <h1>your products</h1>
        <img src="../image/separator-img.png">
    </div> <!-- 🛠️ this was missing closing tag for .heading -->

    <div class="box-container">
        <?php
        $select_products = $conn->prepare("SELECT * FROM products WHERE seller_id = ?");
        $select_products->execute([$seller_id]);
        if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <form action="" method="post" class="box">
            <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
            <?php if ($fetch_products['image'] != '') { ?>
            <img src="../uploaded_files/<?= $fetch_products['image']; ?>" class="image">
            <?php } ?>

            <div class="status" style="color: <?php if ($fetch_products['status'] == 'active') { echo "limegreen"; } else { echo "coral"; } ?>">
                <?= $fetch_products['status']; ?>
            </div>

            <div class="price">KES<?= $fetch_products['price']; ?>/-</div>

            <div class="content">
                <img src="../image/shape-19.png" class="shap">
                <div class="title"><?= $fetch_products['name']; ?></div>
                <div class="flex-btn">
                    <a href="edit_product.php?id=<?= $fetch_products['id']; ?>" class="btn">edit</a>
                    <button type="submit" name="delete" class="btn" onclick="return confirm('delete this product');">delete</button>
                    <a href="read_product.php?post_id=<?= $fetch_products['id']; ?>" class="btn">read </a>
                </div>
            </div>
        </form>
        <?php
            }
        } else {
            echo '
            <div class="empty">
                <p>no products added yet! <br> <a href="add_products.php" class="btn" style="margin-top: 1.5rem;">add products</a></p>
            </div>';
        }
        ?>
    </div>
</section>


        



<script src="https://cdjns.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>
<?php include '../components/alert.php';?>
</body>



















