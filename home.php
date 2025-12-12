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
    <title>Ice - home page</title>
     <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    
</head>
<body>
<?php include 'components/user_header.php';?>
<!-- Slider -->
<div class="slider-container">
    <div class="slider">
        <div class="slideBox active">
            <div class="textBox">
                <h1>we pride ourselves on <br> exceptional flavours</h1>
                <a href="menu.php" class="btn">shop now</a>
            </div>
            <div class="imgBox">
                <img src="image/slider.jpg">
                
            </div>
        </div>
        <div class="slideBox">
            <div class="textBox">
                <h1>cold treats are my kind <br> of comfort food</h1>
                <a href="menu.php" class="btn">shop now</a>
            </div>
            <div class="imgBox"> 
                <img src="image/slider0.jpg">
            </div>
        </div>
    </div>

    <ul class="controls">
        <li onclick="nextSlide();" class="next">
            <i class="bx bx-right-arrow-alt"></i>
        </li>
        <li onclick="prevSlide();" class="prev">
            <i class="bx bx-left-arrow-alt"></i>
        </li>
    </ul>
</div>
<!---slider--->

<div class="service">
    <div class="box-container">
        <!---service item box--->
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/services.png" class="img1">
                  <img src="image/services (1).png" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>delivery</h4>
                <span>100% secure</span>
            </div>
        </div>
            <!---service item box--->
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/services (2).png" class="img1">
                    <img src="image/services (3).png" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>payment</h4>
                <span>100% secure</span>
            </div>
        </div>
        <!---service item box--->
    
        <!---service item box--->
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/services (5).png" class="img1">
                    <img src="image/services (6).png" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>support</h4>
                <span>24*7 hours</span>
            </div>
        </div>
        <!---service item box--->
          <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/services (7).png" class="img1">
                    <img src="image/services (8).png" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>gift service</h4>
                <span>support gift service</span>
            </div>
        </div>
        <!---service item box--->
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/service.png" class="img1">
                    <img src="image/service (1).png" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>returns</h4>
                <span>24*7  free return</span>
            </div>
        </div>
         <!---service item box--->
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/services.png" class="img1">
                    <img src="image/services (1).png" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>deliver</h4>
                <span>100% secure</span>
                    </div>
                </div>
            </div>
        </div>
        <!---service section end--->
         <div class="categories">
            <div class="heading">
                <h1>categories features</h1>
                <img src="image/separator-img.png">
            </div>
            <div class="box-container">
                <div class="box">
                    <img src="image/categories.jpg">
                    <a href="menu.php" class="btn">coconut</a>
                </div>
                <div class="box">
                    <img src="image/categories0.jpg">
                    <a href="menu.php" class="btn">chocolate</a>
                </div>
                <div class="box">
                    <img src="image/categories2.jpg">
                    <a href="menu.php" class="btn">strawberry</a>
                </div>
                <div class="box">
                    <img src="image/categories1.jpg">
                    <a href="menu.php" class="btn">corn</a>
                </div>
            </div>
         </div>
        <!--- categories --->
        <img src="image/menu-banner.jpg" class="menu-banner">
        <div class="taste">
             <div class="heading">
                <span>Taste</span>
                <h1>buy any ice cream @ get one free</h1>
                <img src="image/separator-img.png">
            </div>
            <div class="box-container">
             <div class="box">
                <img src="image/taste.webp">
                <div class="detail">
                    <h2>natural sweetness</h2>
                    <h2>vanilla</h2>
                </div>
            </div>
            <div class="box">
                <img src="image/taste0.webp">
                <div class="detail">
                    <h2>natural sweetness</h2>
                    <h2>matcha</h2>
                </div>
            </div>
            <div class="box">
                <img src="image/taste1.webp">
                <div class="detail">
                    <h2>natural sweetness</h2>
                    <h2>blueberry</h2>
                </div>
            </div>
        </div>
    </div>
    <!--taste--->
    <div class="ice-container">
        <div class="overlay"></div>
        <div class="detail">
            <h1>Ice cream is cheaper than <br> therapy for stress</h1>
            <p>Deliciously creamy ice cream at pocket-friendly prices – cool down without breaking the bank</p>
            <a href="menu.php" class="btn">shop now</a>
        </div>
    </div>
      <!--container section--->
    <div class="taste2">
        <div class="t-banner">
            <div class="overlay"></div>
            <div class="detail">
                <h1>Find your taste of desserts</h1>
            <p>Treat then to a delicious treat and send them Luck 'o the Irish too!</p>
            <a href="menu.php" class="btn">shop now</a>
            </div>
        </div>
        <div class="box-container">
          <div class="box">
            <div class="box-overlay"></div>
                <img src="image/type4.jpg">
                <div class="box-details fadeIn-bottom">
                    <h1>strawberry</h1>
                    <p>Find your taste of desserts</p>
                    <a href="menu.php" class="btn">explore more</a>
            </div>
          </div>
            <div class="box">
            <div class="box-overlay"></div>
                <img src="image/type.avif">
                <div class="box-details fadeIn-bottom">
                    <h1>strawberry</h1>
                    <p>Find your taste of desserts</p>
                    <a href="menu.php" class="btn">explore more</a>
            </div>
          </div>  
            <div class="box">
            <div class="box-overlay"></div>
                <img src="image/type1.png">
                <div class="box-details fadeIn-bottom">
                    <h1>strawberry</h1>
                    <p>Find your taste of desserts</p>
                    <a href="menu.php" class="btn">explore more</a>
            </div>
          </div>    
            <div class="box">
            <div class="box-overlay"></div>
                <img src="image/type2.png">
                <div class="box-details fadeIn-bottom">
                    <h1>strawberry</h1>
                    <p>Find your taste of desserts</p>
                    <a href="menu.php" class="btn">explore more</a>
            </div>
          </div>  
            <div class="box">
            <div class="box-overlay"></div>
                <img src="image/type0.avif">
                <div class="box-details fadeIn-bottom">
                    <h1>strawberry</h1>
                    <p>Find your taste of desserts</p>
                    <a href="menu.php" class="btn">explore more</a>
            </div>
          </div>  
            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/type4.jpg">
                <div class="box-details fadeIn-bottom">
                    <h1>strawberry</h1>
                    <p>Find your taste of desserts</p>
                    <a href="menu.php" class="btn">explore more</a>
            </div>
          </div>  
        </div>
    </div>
     <!--taste2 section--->
     <div class="flavour">
        <div class="box-container">
            <img src="image/left-banner2.webp">
            <div class="detail">
                <h1>Hot Deal ! Sale Up To <span>20% off</span></h1>
                <p>Expired</p>
                <a href="menu.php" class="btn">shop now</a>
            </div>
        </div>
     </div>
     <!--container section--->
     <div class="usage">
        <div class="heading">
            <h1>how it works</h1>
            <img src="image/separator-img.png">
        </div>
        <div class="row">
            <div class="box-container">
                <div class="box">
                    <img src="image/icon0.avif">
                    <div class="detail">
                        <h3>scoop ice-cream</h3>
                        <p>Deliciously creamy ice cream at pocket-friendly prices – cool down without breaking the bank</p>
                        
                    </div>
                </div>
                 <div class="box">
                    <img src="image/icon1.avif">
                    <div class="detail">
                        <h3>scoop ice-cream</h3>
                        <p>Deliciously creamy ice cream at pocket-friendly prices – cool down without breaking the bank</p>
                    </div>
                </div>
                 <div class="box">
                    <img src="image/icon2.avif">
                    <div class="detail">
                        <h3>scoop ice-cream</h3>
                        <p>Deliciously creamy ice cream at pocket-friendly prices – cool down without breaking the bank</p>
                        
                    </div>
                </div>
                <div class="box">
                    <img src="image/icon3.avif">
                    <div class="detail">
                        <h3>scoop ice-cream</h3>
                        <p>Deliciously creamy ice cream at pocket-friendly prices – cool down without breaking the bank</p>
                        
                    </div>
                </div>
                <div class="box">
                    <img src="image/icon4.avif">
                    <div class="detail">
                        <h3>scoop ice-cream</h3>
                        <p>Deliciously creamy ice cream at pocket-friendly prices – cool down without breaking the bank</p>
                    </div>
                </div>
            </div>
        </div>
     </div>
   <!--usage section end--->
   <div class="pride">
    <div class="detail">
        <h1>We Pride Ourselves On <br> Exceptional Flavours</h1>
        <p>We sell the best ice creams - rich, creamy, and full of flavor! <br> Whether you love classic vanilla, chocolate, or fruity blends, we’ve got something for everyone🍦</p>
        <a href="shop.php" class="btn">shop now</a>
    </div>
   </div>


<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<script src="js/user_script.js"></script>

<?php include 'components/footer.php';?>
</body>
</html>