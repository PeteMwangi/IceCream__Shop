 
<?php
include '../components/connect.php';
if(isset($_COOKIE['seller_id'])){
    $seller_id = $_COOKIE['seller_id'];
}else{
    $seller_id = '';
    header('location:loging.php');
}

$get_id = $_GET['post_id'];
// Delete
if (isset($_POST['delete'])) {
    $p_id = $_POST['product_id'];
    $p_id = filter_var($p_id, FILTER_SANITIZE_STRING); // optional

    // select image to delete
    $delete_image = $conn->prepare("SELECT * FROM products WHERE id = ? AND seller_id = ?");
    $delete_image->execute([$p_id, $seller_id]);

    $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

    if (!empty($fetch_delete_image['image'])) {
        unlink('../uploaded_files/' . $fetch_delete_image['image']);
    }

    // delete product
    $delete_product = $conn->prepare("DELETE FROM products WHERE id = ? AND seller_id = ?");
    $delete_product->execute([$p_id, $seller_id]);

    header("Location: view_product.php");
    exit;
}

?>


 
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

<section class="read-post">
    <div class="heading">
        <h1>product detail</h1>
        <img src="../image/separator-img.png">
    </div> 

    <div class="box-container">
    <?php
$select_product = $conn->prepare("SELECT * FROM products WHERE id = ? AND seller_id = ?");
$select_product->execute([$get_id, $seller_id]);

if ($select_product->rowCount() > 0) {
    while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
?>
        <form action="" method="post" class="box">
            <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">

            <div class="status" style="color: <?= $fetch_product['status'] === 'active' ? 'limegreen' : 'coral'; ?>">
                <?= $fetch_product['status']; ?>
            </div>

            <?php if (!empty($fetch_product['image'])) { ?>
                <img src="../uploaded_files/<?= $fetch_product['image']; ?>" class="image" alt="product image">
            <?php } ?>

            <div class="price">$<?= $fetch_product['price']; ?>/-</div>
            <div class="title"><?= $fetch_product['name']; ?></div>
            <div class="content"><?= $fetch_product['product_detail']; ?></div>
            <div class="flex-btn">
                <a href= "edit_product.php>id=<?= $fetch_product['id']; ?>" class="btn">edit</a>
                <button type="submit" name="delete" class="btn" onclick="return confirm('delete this product');">delete</button>
                <a href= "view_product.php>post_id=<?= $fetch_product['id']; ?>" class="btn">go back</a>
            </div>
        </form>
<?php
    }
} else {
    echo '
    <div class="empty">
        <p>no products added yet! <br> 
        <a href="add_products.php" class="btn" style="margin-top: 1.5rem;">add products</a></p>
    </div>';
}
?>

    </div>
</section>
</div>

        



<script src="https://cdjns.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>
<?php include '../components/alert.php';?>
</body>



















