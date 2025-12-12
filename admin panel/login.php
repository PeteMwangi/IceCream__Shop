<?php
include '../components/connect.php';

session_start(); // Start the session to store messages

if (isset($_POST['submit'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $hashed_pass = sha1($_POST['pass']);

    $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE email = ? AND password = ?");
    $select_seller->execute([$email, $hashed_pass]);
    $row = $select_seller->fetch(PDO::FETCH_ASSOC);

    if ($select_seller->rowCount() > 0) {
        setcookie('seller_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
        $_SESSION['success_msg'] = 'Login successful! Redirecting...';
        header('location: dashboard.php');
        exit;
    } else {
        $_SESSION['warning_msg'] = 'Incorrect email or password!';
        header('location: login.php');
        exit;
    }
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
    <form action=""method="post" enctype="multipart/form-data" class="login">
        <h3>login now</h3>

        <div class="input-field">
                    <p>your email<span>*</span></p>
                    <input type="email" name="email" placeholder="enter your email" maxlength="50"
                    required class="box";>
                </div>

 <div class="col">
                <div class="input-field">
                    <p>your password<span>*</span></p>
                    <input type="password" name="pass" placeholder="enter your password" maxlength="50"
                    required class="box";>
                </div>


        
       
                <p class="link">do not have an account? <a href="register.php">register now</a></p>
                <input type="submit" name="submit" value="login now" class="btn">
    </form>
</div>





<script src="https://cdjns.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/script.js"></script>
<?php include '../components/alert.php';?>
</body>



















