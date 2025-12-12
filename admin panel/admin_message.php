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

// Delete message
if (isset($_POST['delete_msg'])) {
    $delete_id = $_POST['delete_id'];
    $delete_msg = $conn->prepare("DELETE FROM `message` WHERE id = ?");
    $delete_msg->execute([$delete_id]);
    $_SESSION['success_msg'] = 'Message deleted successfully';
    header('Location: admin_message.php');
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
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ice - Seller Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
</head>
<body>


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

<section class="message-container">
    <div class="heading">
        <h1>Unread Messages</h1>
        <img src="../image/separator-img.png">
    </div>

    <div class="box-container">
        <?php
        $select_message = $conn->prepare("SELECT * FROM `message`");
        $select_message->execute();
        if ($select_message->rowCount() > 0) {
            while ($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="box">
            <h3 class="name"><?= htmlspecialchars($fetch_message['name']); ?></h3>
            <h4><?= htmlspecialchars($fetch_message['subject']); ?></h4>
            <p><?= nl2br(htmlspecialchars($fetch_message['message'])); ?></p>
            <form action="" method="post">
                <input type="hidden" name="delete_id" value="<?= $fetch_message['id']; ?>">
                <input type="submit" name="delete_msg" value="Delete Message" class="btn"
                       onclick="return confirm('Delete this message?');">
            </form>
        </div>
        <?php 
            }
        } else {
            echo '<div class="empty"><p>No unread messages yet!</p></div>';
        }
        ?>
    </div> 
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/admin_script.js"></script>
<?php include '../components/alert.php'; ?>
</body>
</html>
