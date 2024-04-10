<?php 
include '../connect.php';
session_start();


if(isset($_GET['PRODUCT_ID']))
{
    $prod= $_GET['PRODUCT_ID'];
}

if(isset($_POST['submit']))
{
    if(!isset($_SESSION['role']))
    {
        echo "<script> 
                alert('Please login first.');
                window.location.href = '../Session/login.php';
            </script>";
    }
    else
    {
        $user_id = $_SESSION['id'];
        $comment = $_POST['comment'];

        if(!empty($comment))
        {
            $query = oci_parse($conn,"INSERT INTO REVIEW(USER_ID_FK, PRODUCT_ID_FK, REVIEW) VALUES($user_id, $prod, '$comment')");
            $exe = oci_execute($query); 

            if($exe)
            {
                header('location: productview.php?PRODUCT_ID='.$prod);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/Customer/nav.css"/>
    <link rel="stylesheet" type="text/css" href="../css/Customer/footer.css"/>
    <link rel="stylesheet" type="text/css" href="../css/Customer/productView.css"/>

</head>
<body>
<?php include 'navbar.php';?>
<?php
    $stock=0;
    $quey=oci_parse($conn, "SELECT * FROM PRODUCT WHERE PRODUCT_ID ='$prod' AND STATUS = 'Enable'");
    $exe = oci_execute($quey); 

    if($exe)
    {

        $row = oci_fetch_assoc($quey);
        $cat = $row['CATEGORY'];
        $array= array("green groceries","bakery","delicatessen","meat","fish");
        $arar = $row['NAME'];
        $areh="";
        if(strtolower($cat)=='greengrocer')
        {
            $areh = "greengrocer.php?P_TYPE=$cat";
        }
        elseif(strtolower($cat)=='bakery')
        {
            $areh = "bakery.php?P_TYPE=$cat";
        }
        elseif(strtolower($cat)=='delicatessen')
        {
            $areh = "delicatessen.php?P_TYPE=$cat";
        }
        elseif(strtolower($cat)=='meat')
        {
            $areh ="meat.php?P_TYPE=$cat";
        }
        else
        {
            $areh = "fish.php?P_TYPE=$cat";
        }
        $status = $row['OUT_OF_STOCK'];

        if($status=='yes')
        {
            $stock="Out Of Stock";
        }
    }
?>
    <section id="banner">
        <div class="container-fluid">
            <div class="container">
                <a href="<?php echo ucwords($areh);?>"><?php echo ucwords($cat);?> ></a>
                <a href="productview.php?PRODUCT_ID=<?php echo $ggx["PRODUCT_ID"];?>"><?php echo $arar;?></a>
            </div>
        </div>
    </section>
    <div class="all">
        <div class="container">
            <div class="table">

                <div class="row">
                    
                    <div class="col-6">
                        <div class="img-box">
                            <img src="../image/<?php echo $row['IMAGE']; ?>"/>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="header">
                        <form> 
                            <h2 style="font-size:25px;"><?php echo $row['NAME'];?></h2>
                            <h5>Product Type: <?php echo $row['CATEGORY'];?></h5>
                            <?php
                            if($row['DISCOUNT'] == TRUE){
                                $price = $row['PRICE'] - $row['DISCOUNT'];
                        ?>  
                                <span style="font-size:20px;"> Price: <span style="text-decoration: line-through;"> £<?php echo $row['PRICE']?></span> £<?php echo $price?></span>
                                <span style="color:red; font-size:22px; font-weight:bold;"><?php echo 'GET £' . $row['DISCOUNT'] . ' off now!';?></span>
                        <?php
                            }else{
                                echo "Price: " . "£" . $row['PRICE'] . "<br> <br>";
                            }
                        ?>
                        </div>
                    </form> 

                    <?php 
                            if($stock=="")
                            {
                            ?>
                        <form action="addtoCart.php" method="POST">
                            <label for="minus">Quantity:</label>
                            <input  type= "hidden" name= "pid" value="<?php echo $prod;?>">
                            <input  type= "number" name= "num" value="1" class="num" min="1" max="20" style="width:70px;">
                                   
                            <div class="btn-wad" style="padding-top:2em;">
                                <input type="submit" name="add" style="background-color:#3F3F3F; color:white; padding:12px 20px;" value="Add To Cart">
                            </div>
                        </form>
                        <?php }?>
                        
                        <?php if($stock!=""){?>
                            <form action="" method="">
                                <label for="minus">Quantity: <?php echo $stock;?></label>
                            </form>
                        <?php }?>

                    </div>
                </div>
            </div>
            
            <div class="product-details">
                <h4>Product Details</h4>
                <p>
                <?php echo $row['DESCRIPTION']?>
                </p>
            </div>
        
            <div class="comment">
                <h4>Comments</h4>
                <div class="comment-area">
                    <form action="" method="POST">
                        <textarea placeholder="Please Leave a Comment" rows="6" cols="101" name="comment"></textarea>
                        <br>
                        <input type="submit" name="submit" value="Submit" class="button5" />
                    </form>
                    <!-- <form action="review-edit.php" method="post">
                        <input type="hidden" name="update" value="<?php echo $row['REVIEW']?>">
                    </form> -->
                </div>
            </div>

            
            <?php 
                $rrq= oci_parse($conn, "SELECT * FROM REVIEW WHERE PRODUCT_ID_FK='$prod'");
                $exec = oci_execute($rrq); 

                if($exec)
                {
                    while($row = oci_fetch_assoc($rrq)){
                    $user = $row['USER_ID_FK'];
                    
                        $btr= oci_parse($conn, "SELECT * FROM USER_WEBSITE WHERE ID_USERS='$user'");
                        $exe = oci_execute($btr);
                        if($exe)
                        {
                            while($userDisplay= oci_fetch_assoc($btr))
                            {       
            ?>
                <div class="comment-area" style="padding-left:1em;padding-top:1em;">
                <div class="imgbox" style="display:flex">
                    <img src="../image/account-default.jpg" alt="" width="50px" height="50px"  style="border-radius: 50%; margin-right:10px;">
                    
                    <p>
                        <span style="display:block; font-weight:bold;"> <?php echo $userDisplay['USER_NAME'];?> </span>
                        <?php echo $row['REVIEW']?>
                    </p>
                    <?php                                      
                        if(isset($_SESSION['role']) && ($_SESSION['role'])=='Customer'){
                            if(($_SESSION['name'])== "$userDisplay[USER_NAME]"){
                    ?>
                        <p class="fa-align">
                            <a href="review-delete.php?REVIEW_ID=<?php echo $row["REVIEW_ID"];?>&PRODUCT_ID=<?php echo $prod;?>"><i class="fas fa-trash" onclick="return confirm('Do you want to delete this comment?');"></i></a>
                        </p>
                    <?php
                            }
                        }
                    ?> 
                </div> 
                </div>
                <?php }}} }?>
        
            <div class="similar-products">
                <h4 style="text-align: center; margin-bottom: -40px;">Similar Products</h4>
            <div class="table">
                <div class="row">
                    
                    <?php 
                        $uuq = oci_parse($conn, "SELECT * FROM PRODUCT WHERE CATEGORY = '$cat' AND STATUS='Enable'");
                        $otc = oci_execute($uuq);

                        if($otc)
                        {
                            $index=0;
                            while($ggx = oci_fetch_assoc($uuq))
                            {
                    ?>
                    <div class="product text-center col-lg-3 col-md-4 col-12">
                            
                        <div class="img-box">
                            <img class="img-fluid mb-2" src="../image/<?php echo $ggx['IMAGE'];?>" alt="">
                        </div>

                        <div class="name-box">
                            <h5 class="p-name"><?php echo $ggx['NAME'];?></h5>
                        </div>

                        <div class="price-box">
                            <h4 class="price-name">£<?php echo $ggx['PRICE'];?></h4>
                        </div>

                        <a href="productview.php?PRODUCT_ID=<?php echo $ggx["PRODUCT_ID"];?>" class="buy-btn">Buy Now</a>
                    </div>
                    <?php $index++; if($index==4){break;}}}?>
                </div>
            </div>
            </div>
        </div>
    </div>

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