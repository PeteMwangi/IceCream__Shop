<?php
include '../components/connect.php';
session_start();

// Check seller login
if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    $seller_id = '';
    header('location:login.php');
    exit();
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
    <title>Ice - Seller Dashboard - Registered Users</title>

    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
</head>
<body>

<div class="main-container">
    <?php include '../components/admin_header.php'; ?>
</div>

<section class="user-container">
    <div class="heading">
        <h1>Registered Users</h1>
        <img src="../image/separator-img.png" alt="separator">
    </div>

    <div class="box-container">
        <?php
        $select_users = $conn->prepare("SELECT * FROM `users`");
        $select_users->execute();

        if ($select_users->rowCount() > 0) {
            while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)) {
                $user_id = $fetch_users['id'];
        ?>
                <div class="box">
                    <p>user id : <span><?= htmlspecialchars($user_id); ?></span></p>
                    <p>user name : <span><?= htmlspecialchars($fetch_users['name']); ?></span></p>
                    <p>user email : <span><?= htmlspecialchars($fetch_users['email']); ?></span></p>
                </div>
        <?php
            }
        } else {
            echo '
            <div class="empty">
                <p>No user registered yet!</p>
            </div>';
        }
        ?>
    </div> 
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/admin_script.js"></script>
<?php include '../components/alert.php'; ?>

</body>
</html>
