<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Admin')
        {
            header("location:../Session/login.php"); 
        }

        include '../connect.php';
        $count=0;
    

        $query= oci_parse($conn,"SELECT * FROM REQUEST_SHOP");
        $execute = oci_execute($query);

        if($execute)
        {
            $count=1;
        }
    
        $delete="";
        if(isset($_GET['delete']))
        {
          $delete="Record Deleted";
          $decline1="Record Added";
        }

        $decline="";
        if(isset($_GET['decline']))
        {
          $decline="Record Deleted";
          
        }

        $remove="";
        if(isset($_GET['remove']))
        {
          $remove="Record Deleted";
          
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
<link rel="stylesheet" type="text/css" href="../css/Admin/adminTrader.css" />
  <link rel="stylesheet" type="text/css" href="../css/Admin/sidenav.css"/>
	<link rel="stylesheet" type="text/css" href="../css/Admin/adminDashboard.css" />

</head>
<body>
<!--navbar section-->
<section id="home">
            
    <div class="nav">
        <!--navbar section-->
    
        
        <input type="checkbox" id="check">
        <label for="check">
            <i class="fas fa-bars" id="bar-btn"></i>
            <i class="fas fa-times" id="cross-btn"></i>
        </label>
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
                <li><a href="adminAccount.php" class="option "><i class="fas fa-tachometer-alt"></i> <span class="go">Dashboard</span></a></li>
                <li><a href="adminTrader.php" class="option "><i class="fas fa-portrait"></i> <span class="go">Trader</span></a></li>
                <li><a href="#" class="option active"><i class="fas fa-store"></i> <span class="go">Shop</span></a></li>
                <li><a href="adminProduct.php" class="option"><i class="fas fa-seedling"></i> <span class="go">Product</span></a></li>
                <li><a href="adminReport.php" class="option"><i class="far fa-file-powerpoint"></i> <span class="go">Report</span></a></li>
                <li><a href="adminReview.php" class="option"><i class="fas fa-comment-dots"></i><span class="go">Review</span></a></li>
                <li><a href="" class="option"></a></li>
            </ul>

        </div>
    </div>	
    
    <div class="canvas">
        <div class="vertical-nav" style="z-index:9999;">
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

<section id="mtrader">

  <div class="first_section">
    <h1>Shop Request</h1>
    <?php if($delete!=""){?>
      <h5 style="color:#6F0E18; ">
        <?php echo $delete; ?>
      </h5>
    <?php }?>

    <?php if($decline!=""){?>
      <h5 style="color:#6F0E18; ">
        <?php echo $decline; ?>
      </h5>
    <?php }?>
        <table class="table js-sort-table table-secondary table-striped table-hover" id="demo1">
            <thead>
              <tr style="background-color:black;">
                <th scope="col" class="js-sort-number">#</th>
                <th scope="col">Pan No</th>
                <th scope="col" class="js-sort-date">Shop Name</th>
                <th scope="col">Shop Location</th>
                <th scope="col">Type</th>
                <th scope="col">Trader ID</th>
                <th scope="col">Trader Name</th>
                <th scope="col">Operation</th>
              </tr>
            </thead>
              <tbody>
              <?php 
              $increase=0;
                    if($count==1)
                    {
                        while($row= oci_fetch_row($query)){
                            
                            $idt = $row['5'];
                            $select= oci_parse($conn,"SELECT * FROM USER_WEBSITE WHERE ID_USERS= '$idt'");
                            $run = oci_execute($select);
                            if($run)
                            {
                                $cell = oci_fetch_row($select);
                                $increase = $increase+1;
                ?>
                <tr>
                <div class="col-9 col-sm-5"></div>
                  <th scope="row"><?php echo $increase;?></th>
                  <td><?php echo $row['0'];?></td>
                  <td><?php echo $row['1'];?></td>
                  <td><?php echo $row['2'];?></td>
                  <td><?php echo $row['3'];?></td>
                  <td><?php echo $row['5'];?></td>
                  <td><a href="sub_page/viewTraderRequest.php?view=<?php echo $row['5'];?>"><?php echo $cell['1'];?></a></td>
                  <td>
                    <a href="sub_page/viewRequestShop.php?view=<?php echo  $row['0'];?>">View</a> / 
                    <a href="sub_page/declineRequestShop.php?decline=<?php echo $row['0'];?>">Delete</a>
                  </td>
                </tr>
                <?php } } }?>
              </tbody>
            </table>
          </div>

          
          <div class="second_section">
              <h1>Active Shop</h1>
              <?php if($delete!=""){?>
                <h5 style="color:#F8D7DA; ">
                  <?php echo $decline1; ?>
                </h5>
              <?php }?>

              <?php if($remove!=""){?>
                <h5 style="color:#F8D7DA; ">
                  <?php echo $remove; ?>
                </h5>
              <?php }?>
              <table class="table js-sort-table table-secondary table-striped table-hover" id="demo1">
              <thead>
                <tr style="background-color:black;">
                  <th scope="col" class="js-sort-number">#</th>
                  <th scope="col">Shop No</th>
                  <th scope="col">Shop Name</th>
                  <th scope="col">Type</th>
                  <th scope="col" class="js-sort-date">Trader Name</th>
                  <th scope="col" class="js-sort-date">Number of Product</th>
                  <th scope="col" class="js-sort-date">Operation</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $query= oci_parse($conn,"SELECT * FROM TRADER_SHOP");
                $execute = oci_execute($query);
        
                if($execute)
                {
                  $increase=0;
                   while($data=oci_fetch_row($query))
                   {
                    $increase++;
                     $tra_id=$data['5'];
                     $select = oci_parse($conn, "SELECT * FROM USER_WEBSITE WHERE ID_USERS = '$tra_id'");
                     $run = oci_execute($select);

                     if($run)
                     {
                       $sep = oci_fetch_row($select);
                     }
                     $count=0;
                     $shop_info=$data['0'];
                     $second = oci_parse($conn, "SELECT * FROM PRODUCT WHERE SHOP_INFO = '$shop_info' AND STATUS = 'Enable'");
                     $work = oci_execute($second);

                     if($work)
                     {
                       while($now = oci_fetch_row($second))
                       {
                         $count++;
                       }
                     }
              ?>
                <tr>
                  <th scope="row"><?php echo $increase;?></th>
                  <td><?php echo $data['0'];?></td>
                  <td><?php echo $data['1'];?></td>
                  <td><?php echo $data['3'];?></td>
                  <td><?php echo $sep['1'];?></td>
                  <td><?php echo $count;?></td>
                  <td><a href="sub_page/viewActiveShop.php?view=<?php echo $shop_info;?>">View</a></td>
                </tr>
                <?php } }?>
              </tbody>
            </table>
          </div>

  </section>
        <footer>
            <a href=""> Copyright &copy; 2021 E-Grocer Basket</a>
        </footer>
<!--Bootstrap Js files link-->
<script type="text/javascript" src="../js/sort-table.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/5cd602dbbe.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>                       