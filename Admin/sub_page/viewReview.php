<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Admin')
        {
            header("location:../../Session/login.php"); 
        }

    include '../../connect.php';

    if(isset($_GET['view']))
    {
        $product = $_GET['view'];
        $review = $_GET['block'];
    }
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="../../css/Admin/review_product.css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Product</title>
</head>
<body>
    <div class="all">
        <div class="container">
            <div class="table">

                <div class="row">
                    <?php 
                        $select = oci_parse($conn,"SELECT * FROM REVIEW WHERE REVIEW_ID= '$review'");
                        $off = oci_execute($select);

                        if($off)
                        {
                            $data = oci_fetch_assoc($select);

                            $now = oci_parse($conn,"SELECT * FROM PRODUCT WHERE PRODUCT_ID= '$product'");
                            $go = oci_execute($now);

                            if($go)
                            {
                                $take = oci_fetch_assoc($now);
                            }
                        }
                    ?>
                    <div class="col-6">
                        <div class="img-box">
                            <img src="../../image/<?php echo $take['IMAGE'];?>"/>
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="header">
                            <h2><?php echo $take['NAME'];?></h2>
                            <div class="rate">
                               <p> Rating:</p>
                                <div class="stars">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                </div>
                            </div>
                            <h5>Product Type: <?php echo $take['CATEGORY'];?></h5>
                            <h3>Price: £<?php echo $take['PRICE'];?></h3>
                        </div>

                        <div class="add">
                            <label for="minus" id="reference">Quantity: <?php echo $take['QUANTITY'];?></label>
                        </div> 

                    </div>
                </div>
            </div>
            
            <div class="product-details">
                <h4>Product Details</h4>
                <p>
                    <?php echo $take['DESCRIPTION'];?>
                </p>
            </div>
        
        
            <div class="comment">
                <h4>Comments</h4>
                <?php 
                  $query = oci_parse($conn,"SELECT * FROM REVIEW WHERE PRODUCT_ID_FK = '$product'");
                  $run = oci_execute($query);
                    if($run)
                    {
                       while($row = oci_fetch_assoc($query)) 
                       {
                            $user = $row['USER_ID_FK'];

                            $select = oci_parse($conn,"SELECT * FROM USER_WEBSITE WHERE ID_USERS='$user'");
                            $work = oci_execute($select);

                            if($work)
                            {
                                $userDisplay = oci_fetch_assoc($select);
                ?>
                <div class="comment-area" style="padding-left:1em;">
                <div class="imgbox" style="display:flex">
                    <img src="../../image/account-default-image.jpg" alt="" width="50px" height="50px"  style="border-radius: 50%;">
                    <p style="padding-left: 12px;">
                       <span style="display:block"> <?php echo $userDisplay['USER_NAME'];?> </span>
                       <span style="display:block"><a href="deleteReview.php?delete=<?php echo $row['REVIEW_ID'];?>" style="color:black; "><i class="fas fa-trash-alt"></i></a> </span>
                    </p>
                </div>

                <div class="section_area">
                    <p style="max-width:900px; border:1px solid black; margin-top:12px; padding:12px 0;padding-left:4em;"><?php echo $row['REVIEW'];?></p>
                </div>
                </div>
                <hr>
                <?php } } }?>
            </div>
            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/5cd602dbbe.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    
</body>
</html>