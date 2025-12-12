<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $hashed_pass = sha1($_POST['pass']);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $hashed_pass]);

    if ($select_user->rowCount() > 0) {
        $row = $select_user->fetch(PDO::FETCH_ASSOC);
        setcookie('user_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
        $_SESSION['success_msg'] = 'Login successful! Redirecting...';
        header('Location: home.php');
        exit;
    } else {
        $_SESSION['warning_msg'] = 'Incorrect email or password!';
        header('Location: login.php');
        exit;
    }
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
<?php include 'components/user_header.php';?>
<div class="banner">
  <div class="detail">
    <h1>login</h1>
    <p>"We’re a fun-loving team serving up happiness, one scoop at a time — crafting creamy, 
    delicious ice cream made with love, freshness, and a sprinkle of joy"</p>
    <span><a href="home.php">home</a> <i class="bx bx-right-arrow-alt"></i> login</span>
  </div>
</div>

<div class="form-container">
  <form action="" method="post" enctype="multipart/form-data" class="login">
    <h3>login now</h3>

    <div class="input-field">
      <p>your email <span>*</span></p>
      <input type="email" name="email" placeholder="enter your email" maxlength="50" required class="box">
    </div>

    <div class="input-field">
      <p>your password <span>*</span></p>
      <input type="password" name="pass" placeholder="enter your password" maxlength="50" required class="box">
    </div>

    <p class="link">don’t have an account? <a href="register.php">register now</a></p>
    <input type="submit" name="submit" value="login now" class="btn">
  </form>
</div>









<?php include 'components/footer.php';?>
<script src="https://cdjns.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>
<?php include 'components/alert.php';?>