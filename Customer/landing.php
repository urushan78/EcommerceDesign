<?php
    include '../connect.php';
    session_start();
    
    $query= "SELECT * FROM PRODUCT WHERE STATUS='Enable'";
    $result= oci_parse($conn, $query);
    oci_execute($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" type="text/css" href="../css/Customer/trend.css">
    <link rel="stylesheet" type="text/css" href="../css/Customer/shopbycategory.css">
    <link rel="stylesheet" type="text/css" href="../css/Customer/nav.css"/>
    <link rel="stylesheet" type="text/css" href="../css/Customer/review.css">
    <link rel="stylesheet" type="text/css" href="../css/Customer/body.css">
    <link rel="stylesheet" type="text/css" href="../css/Customer/footer.css">
    <title>E-Grocer basket</title>
</head>

<body>
    <?php
        include 'navbar.php';
    ?>

    <section id="banner" style="text-align:center">
        <div class="container-fluid">
            <div class="container">
                <ul>
                    <a href="#sortbyCat"> <li> Categories </li></a>
                    <a href="#trend"><li> Trending  </li></a>
                    <a href="#review"><li> Reviews  </li></a>
                    <a href="#lower"><li>Quick Links</li></a>
                </ul>
            </div>
        </div>
    </section>
    
    <section id="carousel-slider">
     <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="../image/1.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../image/2.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../image/3.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../image/4.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../image/5.jpg" class="d-block w-100" alt="...">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </section>


    <section id="sortbyCat">
        <div>
            <h2 class="title negative"> Shop by Category </h2>
        </div>
        <div class="category">
           <a href="bakery.php?P_TYPE=bakery">
                <img src="../image/bakery-2.jpeg" alt="Bakery" style="width:100%">
                <p>Bakery</p>
           </a>
        </div>
        <div class="category">
            <a href="delicatessen.php?P_TYPE=deli">
                <img src="../image/delicatessen-2.jpeg" alt="Delicatessen" style="width:100%">
                <p>Delicatessen</p>
            </a>
        </div>
        <div class="category">
            <a href="greengrocer.php?P_TYPE=greengrocer">
                <img src="../image/vegg-2.jpeg" alt="Green Grocery" style="width:100%">
                <p>Greengrocer</p>
            </a>
        </div>
        <div class="category">
            <a href="meat.php?P_TYPE=meat">
                <img src="../image/meat-2.jpeg" alt="Butcher" style="width:100%">
                <p>Meat</p>
            </a>
        </div>
        <div class="category">
            <a href="fish.php?P_TYPE=fish">
                <img src="../image/fish-2.jpg" alt="Fishmonger" style="width:100%">
                <p>Fish</p>
            </a>
        </div>  
    </section>

    <section id="trend">
        <h2 class="title" >Trending Products</h2>

            <div class="row">
                
                <div class="product text-center">
                        
                    <div class="display">
                        <?php
                            while(($eachrow = oci_fetch_assoc($result)) != false){
                                $count = oci_num_rows($result);
                                $datatoshow = 12; 
                            
                                if($count <= 12){
                        ?>
                        <div class="boxes col-lg-2 col-md-4 col-6">
                            <img src="../image/<?php echo $eachrow["IMAGE"]?>">
                            <p><?php echo $eachrow["NAME"];?></p>
                            <p>£<?php echo $eachrow["PRICE"];?></p>

                            <!-- <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o"></i>
                            </div> -->
                            <a href="productview.php?PRODUCT_ID=<?php echo $eachrow["PRODUCT_ID"];?>" class="buy-btn">Buy Now</a>
                        </div>
                        <?php
                                }
                            }
                        ?>
                    </div> 
                </div>
            </div> 
    </section>
<!--review-->
    <section id="review">
        
        <h1>Reviews</h1>
        
        <div class="review-box-container">	
           <div class="review-box">
                <div class="box-top"> 
                    <div class="profile">
                        <div class= "profile-img">
                            <img src="../image/cus3.png"> 
                        </div>
                        <div class= "name-user">
                            <p> Emilia Fischer </p>
                        </div>
                    </div>
                </div>
                <div class="customer-comment">
                   <p> Shopping from this website has been nothing but a good experience for me. The traders are very friendly and make you feel very welcome. </p>
                </div>
            </div>

            <div class="review-box">
                <div class="box-top"> 
                    <div class="profile">
                        <div class= "profile-img">
                            <img src="../image/cus2.png"> 
                        </div>
                        <div class= "name-user">
                            <p> Angela Beesly </p>
                        </div>
                    </div>
                </div>
                <div class="customer-comment">
                   <p> I can find most, if not all food products in this website. The traders have done a great job with the service as well as their prices. </p>
                </div>
            </div>

            <div class="review-box">
                <div class="box-top"> 
                    <div class="profile">
                        <div class= "profile-img">
                            <img src="../image/cus1.png"> 
                        </div>
                        <div class= "name-user">
                            <p> Harry Wittek </p>
                        </div>
                    </div>
                </div>
                <div class="customer-comment">
                   <p> A great experience shopping from here. The only thing i would recommend is a delivery service in the long run. Otherwise, it's a 5 star from me! </p>
                </div>
            </div>
        </div>
        </section>
    
    <!--Footer-->
	<?php   
    include 'footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/5cd602dbbe.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    
</body>
</html>