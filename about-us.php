<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id='';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ice - about us page</title>
     <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    
</head>
<body>
<?php include 'components/user_header.php';?>
<div class="banner">
    <div class="detail">
        <h1>about us</h1>
        <p>"We’re a fun-loving team serving up happiness, one scoop at a time — crafting creamy, <br>
        delicious ice cream made with love, freshness, and a sprinkle of joy</p>
        <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>about us</span>
    </div>
</div>
<div class="chef">
    <div class="box-container">
        <div class="box">
            <div class="heading">
                <span>Annah K.</span>
                <h1>chef</h1>
                <img src="image/separator-img.png">
            </div>
<p>Meet Chef Annah – the heart behind every scoop! With a passion for sweet creations and years of dessert magic, Annah brings her love for flavor, fun, 
    and freshness into every batch of our ice cream</p>
<div class="flex-btn">
    <a href="" class="btn">explore our menu</a>
    <a href="menu.php" class="btn">visit our shop</a>
</div>
</div>
<div class="box">
    <img src="image/chef.png" class="img">
        </div>
    </div>
</div>
<!--cheaf-->
<div class="story">
    <div class="heading">
        <h1>our story</h1>
        <img src="image/separator-img.png">
    </div>
    <p>Works in a cozy ice cream shop called “scoops and smiles” Nia creates flavors no one’s ever heard of: 
        <br>Sunset Peach & Chilli, Midnight Coffee Swirl, 
        <br>even Blueberry-Lemon Thunder. 
        People say she can taste your mood 
       and scoop exactly what your soul needs</p>
       <a href="menu.php" class="btn">our services</a>
</div>
<div class="container">
    <div class="box-container">
    <div class="img-box">
        <img src="image/1 (2).png">
     
       
    </div>
    <div class="box">
        <div class="heading">
            <h1>Taking Ice Cream To New Heights</h1>
            <img src="image/separator-img.png">
        </div>
        <p>Ice cream is a sweet, creamy dessert loved by people of all ages around the world. Made from milk, cream, sugar, and various flavorings, it is frozen to create a smooth and refreshing treat. Whether served in a cone, cup, or with toppings like sprinkles, 
            chocolate syrup, or fruits, ice cream brings joy with every bite. It comes in many flavors, from classic vanilla and chocolate to unique combinations like mango-chili or cookie dough.</p>
            <a href="" class="btn">learn more</a>
        </div>
    </div>
</div>

<!-- -->
<div class="team">
    <div class="heading">
        <span>our team</span>
        <h1>Quality & passion with our services</h1>
        <img src="image/separator-img.png" alt="">
    </div>
    <div class="box-container">
        <div class="box">
            <img src="image/b1.png" class="img">
            <div class="content">
            <img src="image/shape-19.png" alt="" class="shap">
            <h2>Wanjiku Beth</h2>
            <P></P>
        </div>
        </div>
            <div class="box">
            <img src="image/Gemini2.png" class="img">
            <div class="content">
            <img src="image/shape-19.png" alt="" class="shap">
            <h2>Onyi</h2>
            <P></P>
        </div>
        </div>
            <div class="box">
            <img src="image/Gemini3.png" class="img">
            <div class="content">
            <img src="image/shape-19.png" alt="" class="shap">
            <h2>Tom Musyoka</h2>
            <P></P>
        </div>
        </div>
    </div>
</div>






<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<script src="js/user_script.js"></script>

<?php include 'components/footer.php';?>
</body>
</html>