<?php
    include '../connect.php';

    $shop = "SELECT * FROM TRADER_SHOP WHERE P_TYPE='$_GET[P_TYPE]'";
    $values = oci_parse($conn, $shop);
    oci_execute($values);
?>
<html>
    <head>
        <title>Shop Page</title>
        <link rel="stylesheet" type="text/css" href="../css/Customer/shop.css">
    </head>
    <body>
        <div class="shoptitle">
            <h5>Shops Registered to <?php echo ucwords($_GET['P_TYPE'])?></h5>
        </div>
        
        <div class="all">
            <div class="shop">
                <?php
                    while($eachrow = oci_fetch_assoc($values)){
                ?>
                <!-- <a href="shopproducts.php"> -->
                    <div class="shopboxes" onclick="location.href='#';" style="cursor:pointer">
                        <img src="../image/<?php echo $eachrow["IMAGE"]?>">
                        <div class="block">
                            <p><?php echo $eachrow["SHOP_NAME"];?></p>
                            <p><?php echo $eachrow["SHOP_LOCATION"];?></p>
                        </div>
                    </div>
                <!-- </a> -->
                <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>