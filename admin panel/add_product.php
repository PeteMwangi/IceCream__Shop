<?php
session_start(); // Needed for session messages

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../components/connect.php';

// Verify database connection
if (!$conn) {
    die("Database connection failed: " . print_r($conn->errorInfo(), true));
}

if(isset($_COOKIE['seller_id'])){
    $seller_id = $_COOKIE['seller_id'];
}else{
    header('location:loging.php');
    exit;
}

// Handle form submission
if (isset($_POST['publish'])){
    try {
        $id = unique_id();
        $name = filter_var($_POST['name'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_var($_POST['price'] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $description = filter_var($_POST['description'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $stock = filter_var($_POST['stock'] ?? 0, FILTER_SANITIZE_NUMBER_INT);
        $status = 'active';

        // Handle file upload
        $image = 'default.jpeg'; // Default image
        if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = '../uploaded_files/' . $image;

            // Validate image
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $image_tmp_name);
            
            if(!in_array($mime, $allowed_types)) {
                throw new Exception('Only JPG, PNG, and GIF images are allowed');
            }

            if ($image_size > 2000000) {
                throw new Exception('Image size is too large (max 2MB)');
            }

            if(!move_uploaded_file($image_tmp_name, $image_folder)) {
                throw new Exception('Failed to upload image');
            }
        }

        // Prepare and execute insert statement
        $insert_product = $conn->prepare("INSERT INTO products (id, seller_id, name, price, image, stock, product_detail, status) 
                                         VALUES (:id, :seller_id, :name, :price, :image, :stock, :description, :status)");
        
        $insert_product->bindParam(':id', $id);
        $insert_product->bindParam(':seller_id', $seller_id);
        $insert_product->bindParam(':name', $name);
        $insert_product->bindParam(':price', $price);
        $insert_product->bindParam(':image', $image);
        $insert_product->bindParam(':stock', $stock);
        $insert_product->bindParam(':description', $description);
        $insert_product->bindParam(':status', $status);

        if($insert_product->execute()) {
            // Optional: verify the product was inserted
            $check = $conn->prepare("SELECT * FROM products WHERE id = ?");
            $check->execute([$id]);
            if($check->rowCount() > 0) {
                $_SESSION['success_msg'] = "Product inserted and verified successfully!";
            } else {
                $_SESSION['warning_msg'] = "Product insertion succeeded but was not found for verification!";
            }
        } else {
            $errorInfo = $insert_product->errorInfo();
            throw new Exception("Database error: " . $errorInfo[2]);
        }

        // Redirect to avoid resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;

    } catch (Exception $e) {
        $_SESSION['warning_msg'] = "Error: " . $e->getMessage();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<!-- Display alerts -->
<?php
if (isset($_SESSION['warning_msg'])) {
    echo "<script>alert('" . $_SESSION['warning_msg'] . "');</script>";
    unset($_SESSION['warning_msg']);
}
if (isset($_SESSION['success_msg'])) {
    echo "<script>alert('" . $_SESSION['success_msg'] . "');</script>";
    unset($_SESSION['success_msg']);
}
?>









<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ice - Seller Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
</head>
<body>

<div class="main-container">
    <?php include '../components/admin_header.php'; ?>
</div>
    <section class="post-editor">
        <div class="heading">
            <h1>Add product</h1>
            <img src="../image/separator-img.png">
        </div>
        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data" class="register">
                <div class="input-field">
                    <p>product name<span>*</span></p>
                    <input type="text" name="name" maxlength="100" placeholder="add product name" required class="box">
                </div>
                <div class="input-field">
                    <p>product price<span>*</span></p>
                    <input type="number" name="price" maxlength="100" placeholder="add product price" required class="box">
                </div>
                <div class="input-field">
                    <p>product detail<span>*</span></p>
                   <textarea name="description" required maxlength="1000" placeholder="add product detail" class="box"></textarea>
                </div>
                <div class="input-field">
                    <p>product stock<span>*</span></p>
                    <input type="number" name="stock" maxlength="10" min="0" max="999999999"placeholder="add product stock" required class="box">
                </div>

                <div class="input-field">
                    <p>product image<span>*</span></p>
                    <input type="file" name="image" accept="image/*" required class="box">
                </div>
                <div class="flex-btn">
                    <input type="submit" name="publish" value="add product" class="btn">
                 
                </div>
            </form>
        </div>
</section>  
</div>






<script src="https://cdjns.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>
<?php include '../components/alert.php';?>
</body>



















