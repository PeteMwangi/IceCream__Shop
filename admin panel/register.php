<?php
include '../components/connect.php';

if (isset($_POST['submit'])) {

    $id = unique_id();
    $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $hashed_pass = sha1($_POST['pass']);
    $cpass = sha1($_POST['cpass']);

    // Image upload
// Image upload
if (!empty($_FILES['image']['name'])) {
    $image_name = $_FILES['image']['name']; // keep the original name
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $image_name;

    move_uploaded_file($image_tmp_name, $image_folder); // move file

} else {
    $image_name = "default.png"; // fallback image
}


    $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE email = ?");
    $select_seller->execute([$email]);

    if ($select_seller->rowCount() > 0) {
        echo "<script>
            alert('Email already exists!');
            window.location.href = 'register.php';
        </script>";
        exit;
    } 

    if ($hashed_pass !== $cpass) {
        echo "<script>
            alert('Confirm password does not match!');
            window.location.href = 'register.php';
        </script>";
        exit;
    }

    // Insert new user
    $insert_seller = $conn->prepare("INSERT INTO `sellers` (id, name, email, password, image) VALUES (?, ?, ?, ?, ?)");
    $insert_seller->execute([$id, $name, $email, $hashed_pass, $image_name]);
    
    if (!empty($_FILES['image']['name'])) {
        move_uploaded_file($image_tmp_name, $image_folder);
    }

    // ✅ Show alert, then redirect to login page
    echo "<script>
        alert('New seller registered! Please login now.');
        window.location.href = 'login.php';
    </script>";
    exit;
}
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ice - Seller registration page</title>
        <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
        <link rel="stylesheet" href="https://cdjns.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    </head>
<body>
<div class="form-container">
    <form action=""method="post" enctype="multipart/form-data" class="register">
        <h3>register now</h3>
        <div class="flex">
            <div class="col">
                <div class="input-field">
                    <p>your name<span>*</span></p>
                    <input type="text" name="name" placeholder="enter your name" maxlength="50"
                    required class="box";>
                </div>
                <div class="input-field">
                    <p>your email<span>*</span></p>
                    <input type="email" name="email" placeholder="enter your email" maxlength="50"
                    required class="box";>
                </div>
            </div>
            <div class="col">
                <div class="input-field">
                    <p>your password<span>*</span></p>
                    <input type="password" name="pass" placeholder="enter your password" maxlength="50"
                    required class="box";>
                </div>
                <div class="input-field">
                    <p>confirm password<span>*</span></p>
                    <input type="password" name="cpass" placeholder="confirm your password" maxlength="50"
                    required class="box";>
                </div>
            </div>
      
        </div>
        <div class="input-field">
                    <p>your profile<span>*</span></p>
                    <input type="file" name="iamge" accept="image/*" 
                    required class="box";>
                </div>
                <p class="link">already have an account? <a href="login.php">login now</a></p>
                <input type="submit" name="submit" value="register now" class="btn">
    </form>
</div>





<script src="https://cdjns.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/script.js"></script>
<?php include '../components/alert.php';?>
</body>



















