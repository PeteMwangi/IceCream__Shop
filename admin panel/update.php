<?php
include '../components/connect.php';

$success_msg = [];
$warning_msg = [];

if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    $seller_id = '';
    header('location:login.php');
    exit();
}

if (isset($_POST['submit'])) {
    // Fetch seller info
    $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE id = ? LIMIT 1");
    $select_seller->execute([$seller_id]);
    $fetch_seller = $select_seller->fetch(PDO::FETCH_ASSOC);

    $prev_pass = $fetch_seller['password'];
    $prev_image = $fetch_seller['image'];

    $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Update name
    if (!empty($name)) {
        $update_name = $conn->prepare("UPDATE `sellers` SET name = ? WHERE id = ?");
        $update_name->execute([$name, $seller_id]);
        $success_msg[] = 'Username updated successfully';
    }

    // Update email
    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $warning_msg[] = 'Invalid email format';
        } else {
            $select_email = $conn->prepare("SELECT * FROM `sellers` WHERE email = ? AND id != ?");
            $select_email->execute([$email, $seller_id]);

            if ($select_email->rowCount() > 0) {
                $warning_msg[] = 'Email already exists';
            } else {
                $update_email = $conn->prepare("UPDATE `sellers` SET email = ? WHERE id = ?");
                $update_email->execute([$email, $seller_id]);
                $success_msg[] = 'Email updated successfully';
            }
        }
    }

    // Update image
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_SPECIAL_CHARS);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = uniqid() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = "../uploaded_files/" . $rename;

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $warning_msg[] = 'Image size is too large';
        } else {
            $update_image = $conn->prepare("UPDATE `sellers` SET image = ? WHERE id = ?");
            $update_image->execute([$rename, $seller_id]);
            move_uploaded_file($image_tmp_name, $image_folder);

            if (!empty($prev_image) && $prev_image != $rename) {
                @unlink("../uploaded_files/" . $prev_image);
            }
            $success_msg[] = 'Image updated successfully';
        }
    }

    // Update password
    $empty_pass = 'da3988edbcbcc444444748jjfkfkfk';

    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_SPECIAL_CHARS);

    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_SPECIAL_CHARS);

    $cpass = sha1($_POST['c_pass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_SPECIAL_CHARS);

    if ($old_pass != $empty_pass) {
        if ($old_pass != $prev_pass) {
            $warning_msg[] = 'Old password not matched';
        } elseif ($new_pass != $cpass) {
            $warning_msg[] = 'Confirm password does not match';
        } else {
            if ($new_pass != $empty_pass) {
                $update_pass = $conn->prepare("UPDATE `sellers` SET password = ? WHERE id = ?");
                $update_pass->execute([$cpass, $seller_id]);
                $success_msg[] = 'Password updated successfully';
            } else {
                $warning_msg[] = 'Please enter a new password';
            }
        }
    }
}
?>

<!-- HTML/JS Part to Show Alerts -->
<?php if (!empty($success_msg) || !empty($warning_msg)) : ?>
    <script>
        <?php foreach ($success_msg as $msg) : ?>
            alert("✅ <?php echo $msg; ?>");
        <?php endforeach; ?>

        <?php foreach ($warning_msg as $msg) : ?>
            alert("⚠️ <?php echo $msg; ?>");
        <?php endforeach; ?>
    </script>
<?php endif; ?>




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
    <title>Ice - update profile page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
</head>
<body>

<div class="main-container">
    <?php include '../components/admin_header.php'; ?>
</div>
    <section class="form-container">
        <div class="heading">
        <h1>update profile details</h1>
            <img src="../image/separator-img.png">
       
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <div class = "img-box">

            </div>
            <h3>update profile</h3>
            <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p>your name <span>*</span></p>
                        <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>"
                        class="box">
                </div>
                <div class="input-field">
                        <p>your email <span>*</span></p>
                        <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>"
                        class="box">
                    </div>
                  <div class="input-field">
    <p>Select Pic <span>*</span></p>
    <input type="file" name="image" accept="image/*" class="box">
</div>

              </div>
                  <div class="col">
                    <div class="input-field">
                        <p>old password <span>*</span></p>
                        <input type="password" name="old_pass" placeholder="enter your old password"
                        class="box">
                </div>
                <div class="input-field">
                        <p>new password <span>*</span></p>
                        <input type="password" name="new_pass" placeholder="enter your new password"
                        class="box">
                </div>
                    <div class="input-field">
                        <p>confirm password <span>*</span></p>
                        <input type="password" name="cpass" placeholder="confirm your password"
                        class="box">
                </div>
                </div>
            </div>
            <input type="submit" name="submit" value="update profile" class="btn">
        </form>
    </section>
</div>






<script src="https://cdjns.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>
<?php include '../components/alert.php';?>
</body>


















