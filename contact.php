<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

// Send message
if (isset($_POST['send_message'])) { // <-- fix: underscore instead of space
    if ($user_id != '') {
        
        $id = unique_id();

        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $subject = $_POST['subject'];
        $subject = filter_var($subject, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $message = $_POST['message'];
        $message = filter_var($message, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Correct table syntax and parameter order
        $verify_message = $conn->prepare("SELECT * FROM `message` WHERE user_id = ? AND name = ? AND email = ? AND subject = ? AND message = ?");
        $verify_message->execute([$user_id, $name, $email, $subject, $message]);

        if ($verify_message->rowCount() > 0) {
            $warning_msg[] = 'Message already exists';
        } else {
            $insert_message = $conn->prepare("INSERT INTO `message`(id, user_id, name, email, subject, message) VALUES (?,?,?,?,?,?)");
            $insert_message->execute([$id, $user_id, $name, $email, $subject, $message]);

            $success_msg[] = 'Message sent successfully';
        }
    } else {
        $warning_msg[] = 'not sent';
    }
}

// Show alerts
if (!empty($success_msg)) {
    foreach ($success_msg as $msg) {
        echo "<script>alert('$msg');</script>";
    }
}

if (!empty($warning_msg)) {
    foreach ($warning_msg as $msg) {
        echo "<script>alert('$msg');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ice - contact us page</title>
     <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    
</head>
<body>
<?php include 'components/user_header.php';?>
<div class="banner">
  <div class="detail">
    <h1>contact us</h1>
    <p>"We’re a fun-loving team serving up happiness, one scoop at a time — crafting creamy, 
    delicious ice cream made with love, freshness, and a sprinkle of joy"</p>
    <span><a href="home.php">home</a> <i class="bx bx-right-arrow-alt"></i> contact us</span>
  </div>
</div>
<div class="services">
  <div class="heading">
    <h1>our services</h1>
    <p>Just A Few Click To Make The Reservation Online For Saving Your Time And Money</p>
    <img src="image/separator-img.png"></div>
  <div>
    <div class="box-container">
    <div class="box">
      <img src="image/0.png">
    <div>
    <h1>free shipping fast</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit   </p>
    </div>
  </div>

  <div class="box">
      <img src="image/1.png">
    <div>
    <h1>money back & guarantee</h1>
    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit </p>
    </div>
  </div>

  <div class="box">
      <img src="image/2.png">
    <div>
    <h1>online support 24/7</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit </p>
      </div>
    </div>
  </div>
</div>
 <div class="heading">
    <h1>drop us a line</h1>
    <p>Just A Few Click To Make The Reservation Online For Saving Your Time And Money</p>
    <img src="image/separator-img.png">
  </div>  
<div class="form-container">
 
    <form action="" method="post" class="register">
    <div class="input-field">
      <label>name <sup>*</label>
      <input type="text" name="name" required placeholder="enter your name" class="box">
    </div>
    <div class="input-field">
      <label>email <sup>*</label>
      <input type="email" name="email" required placeholder="enter your email" class="box">
    </div>
    <div class="input-field">
      <label>subject <sup>*</label>
      <input type="text" name="subject" required placeholder="reason.." class="box">
    </div>
    <div class="input-field">
      <label>comment <sup>*</label>
     <textarea name="message" cols="30" rows="10" required placeholder="" class="box"></textarea>
    </div>
    <button type="submit" name="send_message" class="btn">send message</button>
  </form>
</div>

<div class="address">
  <div class="heading">
    <h1>our contact details</h1>
    <p>Just A Few Click To Make The Reservation Online For Saving Your Time And Money</p>
    <img src="image/separator-img.png">
  </div>
<div class="box-container">
  <div class="box">
    <i class="bx bxs-map-alt"></i>
    <div>
      <h4>address</h4>
      <p>0100, Thika Rd <br> Nairobi, Ruaraka</p>
    </div>
  </div>

  <div class="box">
    <i class="bx bxs-phone-incoming"></i>
    <div>
      <h4>phone number</h4>
      <p>0789097651</p>
      <p>0789097990</p>
    </div>
  </div>

  <div class="box">
    <i class="bx bxs-envelope"></i>
    <div>
      <h4>email</h4>
      <p>sweety1@gmail.com</p>
      <p>sweety2@gmail.com</p>
    </div>
  </div>
 </div>
</div>



<?php include 'components/footer.php';?>
<script src="https://cdjns.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>
<?php include 'components/alert.php';?>