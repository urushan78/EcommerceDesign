<?php
    include '../connect.php';
    $count=0;
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Trader')
        {
            header("location:../Session/login.php"); 
        }

    if($_SESSION['log']==0)
    {
        header('location:../Session/signup_extra/resetPassword.php?sess="first"');
    }

    $trader_id = $_SESSION['id'];

    $success="";
    if(isset($_GET['delete']))
    {
        $success="Record Delete";
    }

    $insert="";
    if(isset($_GET['insert']))
    {
        $insert="Record Inserted";
    }

    $edit="";
    if(isset($_GET['edit']))
    {
        $edit="Record Edited";
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
	<link rel="stylesheet" type="text/css" href="../css/Trader/traderProduct.css"/>
    
</head>
<body>

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
                            <li><a href="#" class="option active"><i class="fas fa-shopping-cart"></i> <span class="go">Product</span></a></li>
                            <li><a href="traderShop.php" class="option "><i class="fas fa-store-alt"></i> <span class="go">Shop</span></a></li> 
                            <li><a href="traderReport.php" class="option"><i class="fas fa-chart-line"></i> <span class="go">Report</span></a></li>
                            <li><a href="traderReview.php" class="option"><i class="fas fa-comment-dots"></i> <span class="go">Review</span></a></li>
                            <li><a href="traderSetting.php" class="option"><i class="fas fa-cog"></i> <span class="go">Setting</span></a></li>
                            <li><a href="#" class="option "><i class="fas fa-bell"></i><span class="go">Order Details</span></a></li>
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

        <?php
                $result = oci_parse($conn, "SELECT * FROM PRODUCT_REQ WHERE TRADER_INFO = '$trader_id'");
                oci_execute($result);
        ?>

            <section id="traderproduct">
                <div class="main">
                    <h1>Request Collection </h1>
                    <?php if($success!=""){?>
                        <h5 style="color:#721C24;">
                            <?php echo $success;?>
                        </h5>
                    <?php }?>

                    <?php if($insert!=""){?>
                        <h5 style="color:#276535;">
                            <?php echo $insert;?>
                        </h5>
                    <?php }?>

                    <?php if($edit!=""){?>
                        <h5 style="color:#276535;">
                            <?php echo $edit;?>
                        </h5>
                    <?php }?>
                    <div class="menu">
                        <div class="leftalign">
                            <form class="btn" action="sub_page/tproductadd.php">
                                <input type="submit" value="+ Add Product"><br><br>
                            </form>

                        </div>

                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Image </th>
                                <th> Name </th>
                                <th> Price </th>
                                <th> Quantity </th>
                                <th> Category </th>
                                <th> Operation </th>
                            </tr>
                        </thead>

                        <?php
                            while (($eachrow = oci_fetch_assoc($result))) {
                        ?>

                        <tr>
                            <td><?php echo $eachrow["PRODUCT_ID"];?></td>
                            <td> <img src="../image/<?php echo $eachrow["IMAGE"]?>"></td>
                            <td><?php echo $eachrow["NAME"];?></td>
                            <td>£<?php echo $eachrow["PRICE"];?></td>
                            <td><?php echo $eachrow["QUANTITY"];?></td>
                            <td><?php echo $eachrow["CATEGORY"];?></td>
                            <td><a href="sub_page/pdelete.php?PRODUCT_ID=<?php echo $eachrow["PRODUCT_ID"];?>"><i class="fas fa-trash" aria-hidden="true" style="color:black;"></i></a> <a href="sub_page/tproductedit.php?PRODUCT_ID=<?php echo $eachrow["PRODUCT_ID"];?>"><i class="fas fa-pen" aria-hidden="true" style="color:black;"></i></a></td>
                        </tr>
                            
                        <?php
                            }
                        ?> 
                    </table>
                </div>
            </section>
        



            <?php
                $result = oci_parse($conn, "SELECT * FROM PRODUCT WHERE STATUS = 'Enable' AND TRADER_INFO = '$trader_id'");
                oci_execute($result);
            
                 if(isset($_POST['search']))
                 {
                     
                    $search = $_POST['namesearch'];
                    $query = "SELECT * FROM PRODUCT WHERE NAME LIKE '%$search%' AND STATUS = 'Enable' AND TRADER_INFO = '$trader_id'";
                    $result = oci_parse($conn, $query);
                    $run= oci_execute($result);
                 }
                        
                if(isset($_POST['filter']))
                {
                    $search = ucfirst($_POST['categorySearch']);
                    $query = "SELECT * FROM PRODUCT WHERE CATEGORY LIKE '%$search%' AND STATUS = 'Enable' AND TRADER_INFO = '$trader_id'";
                    $result = oci_parse($conn, $query);
                    $run= oci_execute($result);
                }
        ?>

            <section id="traderproduct">
                <div class="main">
                    <h1>Product Collection </h1>
                    <?php if($success!=""){?>
                        <h5 style="color:#721C24;">
                            <?php echo $success;?>
                        </h5>
                    <?php }?> 

                    <?php if($edit!=""){?>
                        <h5 style="color:#276535;">
                            <?php echo $edit;?>
                        </h5>
                    <?php }?>
                    <div class="menu">
                        <div class="leftalign" style="padding-top:3.3em;">
                            
                            <form method="POST" action="">
                                <input type="text" name="namesearch" placeholder="Search Product..." value="<?php if(isset($_POST['namesearch'])){ echo $_POST['namesearch'];}?>">
                                <input type="submit" name="search" value="Search" style="margin-left:5px;"> 
                            </form>
                        </div>

                        <div class="rightalign">
                            <label> Total Products: <?php echo $count;?></label> <br><br>
                            
                            <form method="POST" action="">
                                <input type="submit" name="filter" value="Filter" value="<?php if(isset($_POST['filter'])){ echo $_POST['filter'];}?>">
                                <input type="text" name="categorySearch" placeholder="--Select a Category--"><br><br>
                            </form>
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Image </th>
                                <th> Name </th>
                                <th> Price </th>
                                <th> Quantity </th>
                                <th> Category </th>
                                <th> Operation </th>
                            </tr>
                        </thead>

                        <?php
                            while (($eachrow = oci_fetch_assoc($result))) {
                        ?>

                        <tr>
                            <td><?php echo $eachrow["PRODUCT_ID"];?></td>
                            <td> <img src="../image/<?php echo $eachrow["IMAGE"]?>"></td>
                            <td><?php echo $eachrow["NAME"];?></td>
                            <td>£<?php echo $eachrow["PRICE"];?></td>
                            <td><?php echo $eachrow["QUANTITY"];?></td>
                            <td><?php echo $eachrow["CATEGORY"];?></td>
                            <td><a href="sub_page2/pdelete.php?PRODUCT_ID=<?php echo $eachrow["PRODUCT_ID"];?>"><i class="fas fa-trash" aria-hidden="true" style="color:black;"></i></a> <a href="sub_page2/tproductedit.php?PRODUCT_ID=<?php echo $eachrow["PRODUCT_ID"];?>"><i class="fas fa-pen" aria-hidden="true" style="color:black;"></i></a></td>
                        </tr>
                            
                        <?php
                            }
                        ?> 
                    </table>
                </div>
            </section>
            <section class="foots">
            <footer>
                    <a href=""> Copyright &copy; 2021 E-Grocer Basket</a>
                </footer>
           </section>
 
	
	<!--Bootstrap Js files link-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/5cd602dbbe.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>


