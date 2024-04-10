<?php
include '../../connect.php';
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Trader')
        {
            header("location:../../Session/login.php"); 
        }

    if($_SESSION['log']==0)
    {
        header('location:../../Session/signup_extra/resetPassword.php?sess="first"');
    }

    $trader_id = $_SESSION['id'];
?>
<!DOCTYPE html>
 <html lang="en"> 
<head>
	<meta charset="utf-8">
	<title>Welcome <?php echo $_SESSION['name'];?></title>
	<!--Bootstrap files link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/Admin/sidenav.css" />
	<link rel="stylesheet" type="text/css" href="../../css/Trader/traderOrderDetails.css"/>
    
    
</head>
<body>
    <main>
        	<!--navbar section-->
	<section id="home">
				
                <div class="nav">
                    <!--navbar section-->
                
                    <div class="sidebar">
                        <header>Menu</header>
                        <ul>
                            <li>
                                <div class="box-account disapear">
                                    <div class="box-account-image">
                                        <img src="../../image/account-default-image.jpg" width= "100%" alt="">
                                    </div>
                                    <div class="box-account-details">
                                        <div class="details">
                                            <p><?php echo $_SESSION['name'];?></p>
                                            <p><a href="../../Session/signup_extra/logout.php">Logout</a></p>
                                        </div>
                                    </div>
                            </li>
                            <li><a href="traderAccount.php" class="option"><i class="fas fa-tachometer-alt"></i> <span class="go">Dashboard</span></a></li>
                            <li><a href="traderProduct.php" class="option"><i class="fas fa-shopping-cart"></i> <span class="go">Product</span></a></li>
                            <li><a href="traderShop.php" class="option "><i class="fas fa-store-alt"></i> <span class="go">Shop</span></a></li> 
                            <li><a href="traderReport.php" class="option"><i class="fas fa-chart-line"></i> <span class="go">Report</span></a></li>
                            <li><a href="traderReview.php" class="option"><i class="fas fa-comment-dots"></i> <span class="go">Review</span></a></li>
                            <li><a href="traderSetting.php" class="option"><i class="fas fa-cog"></i> <span class="go">Setting</span></a></li>
                            <li><a href="#" class="option active"><i class="fas fa-bell"></i><span class="go">Order Details</span></a></li>
                            <li><a href="" class="option"></a></li>
                        </ul>
        
                    </div>
                </div>	
                
                <div class="canvas">
                    <div class="vertical-nav">
                        <div class="box-logo">
                            <img src="../../image/font-logo-2.png" alt="Logo" width="100%">
                        </div>
        
                        <div class="box-account appear">
                            <div class="box-account-image">
                                <img src="../../image/account-default-image.jpg" width= "100%" alt="">
                            </div>
                            <div class="box-account-details">
                                <ul>
                                    <li><?php echo $_SESSION['name'];?></li>
                                    <li><a href="../../Session/signup_extra/logout.php">Logout</a></li>
                                </ul>
        
                            </div>
                        </div>
                    </div> 
                </div>
            </section>
        
            <section id="orderDetails">
                <div class="main">
                    <h1>Order Collection</h1>
                    <table class="table">
                        <thead>
                            <tr style="background-color:black; color:white;">
                                <th scope="col">Order ID</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Slot Date</th>
                                <th scope="col">Slot Time</th>
                                <th scope="col">Order Placed</th>
                                <th scope="col">Operation</th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            <?php 
                            

                            $select = oci_parse($conn,"SELECT * FROM PRODUCT WHERE TRADER_INFO='$trader_id'");
                            $run = oci_execute($select);

                            if($run)
                            {
                                
                                while($row = oci_fetch_assoc($select))
                                {
                                    $pid = $row['PRODUCT_ID'];

                                    $find = oci_parse($conn, "SELECT * FROM ORDER_PRODUCT WHERE PRODUCT_ID_FK= '$pid'");
                                    $exe = oci_execute($find);

                                    if($exe)
                                    {
                                        while($held= oci_fetch_assoc($find))
                                        {  
                                            $uid = $held['USER_ID_FK'];
                                            $orders = $held['ORDERS_ID_FK'];

                                            $sll = oci_parse($conn,"SELECT * FROM  ORDERS WHERE ORDERS_ID =' $orders'");
                                            $qq = oci_execute($sll);

                                            if($qq)
                                            {
                                                $hen = oci_fetch_assoc($sll);
                                                $slot= $hen['SLOT_ID'];

                                                $sltt = oci_parse($conn,"SELECT * FROM  COLLECTION_SLOT WHERE COLLECTION_ID =' $slot'");
                                                $qt = oci_execute($sltt);

                                                if($qt)
                                                {
                                                    $when = oci_fetch_assoc($sltt);
                                                }

                                            }

                                            $hel = oci_parse($conn,"SELECT * FROM  PAYMENT WHERE ORDER_FK =' $orders'");
                                            $rq = oci_execute($hel);

                                            if($hel)
                                            {
                                                $oc = oci_fetch_assoc($hel);
                                            }

                                            $sel =  oci_parse($conn, "SELECT * FROM USER_WEBSITE WHERE ID_USERS= '$uid'");
                                            $exe = oci_execute($sel);

                                            if($exe)
                                            {
                                                $feth = oci_fetch_assoc($sel);
                                            }
                            ?>            
                            <tr>
                                <th scope="row"><?php echo $orders;?></th>
                                <th><?php echo $feth['USER_NAME']?></th>
                                <th><?php echo $when['COLLECTION_DATE']?></th>
                                <th><?php echo $when['COLLECTION_TIME']?></th>
                                <th><?php echo $oc['TIME']?></th>
                                <th><a href="sub_page2/orderView.php?order=<?php echo $orders;?>">View</a></th>
                            </tr>
                            <?php 
                                        }
                                    }         
                              }    
                            }
                            
                            ?>
                            
                        </tbody>
                    </table>
                </div>
            </section>
        
           <section class="foots">
            <footer>
                    <a href=""> Copyright &copy; 2021 E-Grocer Basket</a>
                </footer>
           </section>
    </main>
	
	<!--Bootstrap Js files link-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/5cd602dbbe.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>

