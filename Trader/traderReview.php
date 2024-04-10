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
                            <li><a href="traderShop.php" class="option "><i class="fas fa-store-alt"></i> <span class="go">Shop</span></a></li>
                            <li><a href="traderReport.php" class="option"><i class="fas fa-chart-line"></i> <span class="go">Report</span></a></li>
                            <li><a href="#" class="option active"><i class="fas fa-comment-dots"></i> <span class="go">Review</span></a></li>
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
                <div class="first_section" style="margin:0 12px;">
                    <h1 style="text-align:center; padding: 35px 0;">Product Request</h1>
      <table  class="table">
          <thead>
            <tr style="background-color:black; color:white;">
              <th scope="col">#</th>
              <th scope="col">Product Image</th>
              <th scope="col">Product Name</th>
              <th scope="col">No. of Reviews</th>
              <th scope="col">Latest Modified</th>
              <th scope="col">Operation</th>
            </tr>
          </thead>
            <tbody>
            <?php 
              $query=oci_parse($conn, "SELECT * FROM PRODUCT WHERE STATUS = 'Enable' AND TRADER_INFO='$trader_id'");
              $run = oci_execute($query);

              if($run)
              {
                  $increase = 0;
                  while($row=oci_fetch_assoc($query))
                  {
                      
                      $product_id = $row['PRODUCT_ID'];

                      $select = oci_parse($conn, "SELECT * FROM REVIEW WHERE PRODUCT_ID_FK ='$product_id' ORDER BY REVIEW_DATE ASC");
                      $compete = oci_execute($select);

                      if($compete)
                      {
                          $index=0;
                      
                          while($data=oci_fetch_assoc($select))
                          {
                              $date = $data['REVIEW_DATE'];
                              $index++;

                          }
                          
                          if($index==0)
                          {
                              continue;
                          }
                          $increase++;
                              
            ?>
              <tr>
              <div class="col-9 col-sm-5"></div>
                <th scope="row"><?php echo $increase;?></th>
                <td><img src="../image/<?php echo $row['IMAGE'];?>" alt="" width="50px" height="50px"></td>
                <td><a href="sub_page2/tproductedit.php?PRODUCT_ID=<?php echo $product_id;?>"><?php echo $row['NAME'];?></a></td>
                <td><?php echo $index;?></td>
                <td><?php echo $date ;?></td>
                <td>
                  <a href="sub_page/viewReview.php?view=<?php echo  $product_id;?>&block=<?php echo $data['REVIEW_ID'];?>">View</a> 
                </td>
                
              </tr>
              <?php } } }?>
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

