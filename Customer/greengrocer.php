<?php
    include '../connect.php';

    session_start();

    include 'navBar.php';

    $query ="SELECT * FROM PRODUCT WHERE CATEGORY='greengrocer' order by PRODUCT_ID ASC";
    $result= oci_parse($conn, $query);
    oci_execute($result);

    if(isset($_POST['sort'])){
        $order = $_POST['sort'];

        $select ="SELECT * FROM PRODUCT WHERE CATEGORY='greengrocer'";

        if($order == 'maxprice'){
            $orderQuery = $select . " ORDER BY PRICE DESC";
            $result = oci_parse($conn, $orderQuery);
            oci_execute($result);
        }elseif($order == 'minprice'){
            $orderQuery = $select . " ORDER BY PRICE ASC" ;
            $result = oci_parse($conn, $orderQuery);
            oci_execute($result);
        }
    }
?>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/Customer/category.css">
    <link rel="stylesheet" type="text/css" href="../css/Customer/nav.css">
</head>

<body>
    <div id="moreCat">
        <div id="Sidetitle">
            <h2 style="color:#ffff;"> MORE CATEGORIES </h2>
        </div>

        <div class="category first active">
        <a href="greengrocer.php?P_TYPE=greengrocer">
                <div class="svgImg">
                    <img src="../image/harvest.svg" alt="Fishmonger" style="width:50px">
                </div>
                <p>Greengrocer</p>
            </a>
        </div>  

        <div class="category">
            <a href="bakery.php?P_TYPE=bakery">
                <div class="svgImg"> 
                    <img src="../image/bread.svg" alt="Delicatessen" style="width:50px">
                </div>
                <p>Bakery</p>
            </a>
        </div>

        <div class="category">
        <a href="delicatessen.php?P_TYPE=deli">
                <div class="svgImg">
                    <img src="../image/lobster.svg" alt="Delicatessen" style="width:50px"> 
                </div>
                <p>Delicatessen</p>
            </a>
        </div>

        <div class="category">
            <a href="meat.php?P_TYPE=meat">
                <div class="svgImg">
                    <img src="../image/meat.svg" alt="Butcher" style="width:50px">
                </div>
                <p>Meat</p>
            </a>
        </div>

        <div class="category">
        <a href="fish.php?P_TYPE=fish">
                <div class="svgImg">
                    <img src="../image/fish.svg" alt="Fishmonger" style="width:50px">
                </div>
                <p>Fish</p>
            </a>
        </div>  
        
    </div>
    <div class="wrapall">
        <?php
            include 'shop.php';
        ?>

        <div id="sorting">
            <form method="post">
                <select name="sort">
                    <option value="" selected hidden>Sort By</option>
                    <option value="maxprice">Maximum Price</option>
                    <option value="minprice">Minimum Price</option>
                </select> 

                <input type="submit" name="orderSearch" value="Sort"><br><br>
            </form>
        </div>

        <div id="title">
            <h5> Greengrocer Category </h5>
        </div>
        
        <div id="arrange">
            <?php
                    while(($eachrow = oci_fetch_assoc($result)) != false){
            ?>
                    <div class="boxes">
                        <!-- <a href="tproductcrud.php?PRODUCT_ID=<?php echo $eachrow["PRODUCT_ID"];?>"></a> -->
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
        </div>
    </div>
</body>
</html>