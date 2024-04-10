<?php
include '../connect.php';

    if(isset($_POST['search'])){
        $search = ucwords($_POST['search']);
        $catsearch = ($_POST['search']);
        $shopsearch = ucwords($_POST['search']);

        $searchquery="SELECT p.PRODUCT_ID, p.IMAGE, p.NAME, p.PRICE, p.QUANTITY, p.CATEGORY, s.SHOP_NAME 
        FROM PRODUCT p INNER JOIN TRADER_SHOP s ON  p.SHOP_INFO = s.SHOP_NO
        WHERE s.SHOP_NAME LIKE '$shopsearch%' OR p.NAME LIKE '$search%' OR p.CATEGORY LIKE '$catsearch%'"; 

        $searchresult = oci_parse($conn, $searchquery);
        oci_execute($searchresult);
    } 
?>
<html>
    <head>
        <title>Search Result</title>
        <link rel="stylesheet" type="text/css" href="../css/Customer/category.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <style>
            .boxes{
                display:inline-block;
            }

            .back a{
                color:black;
            }
        </style>
    </head>
    <body>
        <?php
            include 'navbar.php';
        ?>
        <div class="back" style="margin:100px 0px 0px 15px;">
            <a href="landing.php"><i class="fas fa-caret-left"></i></i> Go back to home page</a>
        </div>
        <?php
            while($eachrow = oci_fetch_assoc($searchresult)){
        ?>  
            <div class="boxes" style="margin:30px 15px 20px 15px; width:200px;">
                <img src="../image/<?php echo $eachrow["IMAGE"]?>">
                <p><?php echo $eachrow["NAME"];?></p>
                <p>£<?php echo $eachrow["PRICE"];?></p> 

                <div class="buy-btn">
                    <a href="productview.php?PRODUCT_ID=<?php echo $eachrow["PRODUCT_ID"];?>">Buy Now</a>
                </div> 
            </div>
        <?php
            }
        ?>
        <script src="https://kit.fontawesome.com/5cd602dbbe.js" crossorigin="anonymous"></script>
    </body>
</html>