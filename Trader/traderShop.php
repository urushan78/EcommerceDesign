<?php
include '../connect.php';
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Trader')
        {
            header("location:../Session/login.php"); 
        }

    if($_SESSION['log']==0)
    {
        header('location:../Session/signup_extra/resetPassword.php?sess="first"');
    }

    $id = $_SESSION['id'];

    $editShop="";
    if(isset($_GET['editShop']))
    {
        $editShop="Successfully Edited";
    }

    $editShop1="";
    if(isset($_GET['editShop1']))
    {
        $editShop1="Successfully Edited";
    }

    $delete="";
    if(isset($_GET['delete']))
    {
        $delete="Successfully Deleted";
    }

    $delete1="";
    if(isset($_GET['delete1']))
    {
        $delete1="Successfully Deleted";
    }

    $shopAdd="";
    if(isset($_GET['shopAdd']))
    {
        $shopAdd="Successfully Deleted";
    }
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
	<link rel="stylesheet" type="text/css" href="../css/Admin/sidenav.css" />
	<link rel="stylesheet" type="text/css" href="../css/Trader/traderOrderDetails.css"/>
    
    
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
                                        <img src="../image/account-default-image.jpg" width= "100%" alt="">
                                    </div>
                                    <div class="box-account-details">
                                        <div class="details">
                                            <p><?php echo $_SESSION['name'];?></p>
                                            <p><a href="../Session/signup_extra/logout.php">Logout</a></p>
                                        </div>
                                    </div>
                            </li>
                            <li><a href="traderAccount.php" class="option"><i class="fas fa-tachometer-alt"></i> <span class="go">Dashboard</span></a></li>
                            <li><a href="traderProduct.php" class="option"><i class="fas fa-shopping-cart"></i> <span class="go">Product</span></a></li>
                            <li><a href="#" class="option active"><i class="fas fa-store-alt"></i> <span class="go">Shop</span></a></li>
                            <li><a href="traderReport.php" class="option"><i class="fas fa-chart-line"></i> <span class="go">Report</span></a></li>
                            <li><a href="traderReview.php" class="option "><i class="fas fa-comment-dots"></i> <span class="go">Review</span></a></li>
                            <li><a href="traderSetting.php" class="option"><i class="fas fa-cog"></i> <span class="go">Setting</span></a></li>
                            <li><a href="traderOrderDetails.php" class="option "><i class="fas fa-bell"></i><span class="go">Order Details</span></a></li>
                            <li><a href="" class="option"></a></li>
                        </ul>
        
                    </div>
                </div>	
                
                <div class="canvas">
                    <div class="vertical-nav">
                        <div class="box-logo">
                            <img src="../image/font-logo-2.png" alt="Logo" width="100%">
                        </div>
        
                        <div class="box-account appear">
                            <div class="box-account-image">
                                <img src="../image/account-default-image.jpg" width= "100%" alt="">
                            </div>
                            <div class="box-account-details">
                                <ul>
                                    <li><?php echo $_SESSION['name'];?></li>
                                    <li><a href="../Session/signup_extra/logout.php">Logout</a></li>
                                </ul>
        
                            </div>
                        </div>
                    </div> 
                </div>
            </section>
        
            <section id="orderDetails">
                <div class="main">
                    <h1>Request Shop</h1>
                    <?php if($editShop!=""){?>
                        <h5 style="color:#276535; text-align:center; margin-top:-18px;">
                            <?php echo $editShop;?>
                        </h5>
                    <?php }?>

                    <?php if($delete!=""){?>
                        <h5 style="color:#721C24; text-align:center; margin-top:-18px;">
                            <?php echo $delete;?>
                        </h5>
                    <?php }?>


                    <?php if($shopAdd!=""){?>
                        <h5 style="color:#276535; text-align:center; margin-top:-18px;">
                            <?php echo $shopAdd;?>
                        </h5>
                    <?php }?>
                    <form action="sub_page/traderAddShop.php" style="text-align:center; padding: 12px 0;">
                        <input type="submit" name="submit" value=" + Add Shop" style="margin-bottom:1em;" />
                    </form>
                   
                    <table class="table">
                        <thead>
                            <tr style="background-color:black; color:white;">
                                <th scope="col">Pan No</th>
                                <th scope="col">Shop Name</th>
                                <th scope="col">Location</th>
                                <th scope="col">Type</th>
                                <th scope="col">Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                
                                $query = oci_parse($conn,"SELECT * FROM REQUEST_SHOP WHERE REG_ID = '$id'");
                                $run= oci_execute($query);

                                if($run)
                                {
                                    while($row=oci_fetch_row($query))
                                    {
                            ?>
                            <tr>
                                <th scope="row"><?php echo $row['0'];?></th>
                                <td><?php echo $row['1'];?></td>
                                <td><?php echo $row['2'];?></td>
                                <td><?php echo $row['3'];?></td>
                                <td><a href="sub_page/traderDeleteShop.php?delete=<?php echo $row['0'];?>">Delete</a></td>
                            </tr>

                            <?php }}?>
                        </tbody>
                    </table>
                </div>
            </section>
        

            <section id="orderDetails">
                <div class="main">
                    <h1>SHOP DETAILS</h1>
                    <?php if($delete1!=""){?>
                        <h5 style="color:#721C24; text-align:center; margin-top:-18px;">
                            <?php echo $delete1;?>
                        </h5>
                    <?php }?>

                    <?php if($editShop1!=""){?>
                        <h5 style="color:#276535; text-align:center; margin-top:-18px;">
                            <?php echo $editShop1;?>
                        </h5>
                    <?php }?>
                    <table class="table">
                        <thead>
                            <tr style="background-color:black; color:white;">
                                <th scope="col">Pan No</th>
                                <th scope="col">Shop Name</th>
                                <th scope="col">Location</th>
                                <th scope="col">Type</th>
                                <th scope="col">Product Contained</th>
                                <th scope="col">Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = oci_parse($conn,"SELECT * FROM TRADER_SHOP WHERE TRADER_INFO = '$id'");
                                $run= oci_execute($query);

                                if($run)
                                {
                                    while($row=oci_fetch_row($query))
                                    {
                                        $shop= $row['0'];
                                        $query1 =oci_parse($conn, "SELECT * FROM PRODUCT WHERE SHOP_INFO = '$shop' AND STATUS = 'Enable'");
                                        $run1 = oci_execute($query1);
                                        
                                        if($run1)
                                        {
                                            $count=0;
                                            while($cell=oci_fetch_row($query1))
                                            {
                                                $count++;
                                            }
                                        } 
                                
                            ?>
                            <tr>
                                <th scope="row"><?php echo $row['0'];?></th>
                                <td><?php echo $row['1'];?></td>
                                <td><?php echo $row['2'];?></td>
                                <td><?php echo $row['3'];?></td>
                                <td><?php echo $count;?></td>
                                <td><a href="sub_page/traderEditShop.php?edit=<?php echo $row['0'];?>">Edit</a> </td>
                            </tr>

                            <?php }}?>
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

