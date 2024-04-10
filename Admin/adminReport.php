<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Admin')
        {
            header("location:../Session/login.php"); 
        }

        include '../connect.php';

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
                <li><a href="adminShopRequest.php" class="option "><i class="fas fa-store"></i> <span class="go">Shop</span></a></li>
                <li><a href="adminProduct.php" class="option "><i class="fas fa-seedling"></i> <span class="go">Product</span></a></li>
                <li><a href="adminReport.php" class="option active"><i class="far fa-file-powerpoint"></i> <span class="go">Report</span></a></li>
                <li><a href="adminReview.php" class="option  "><i class="fas fa-comment-dots"></i><span class="go">Review</span></a></li>
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

<section id="mtrader">

  <div class="first_section">
    <h1>Finance Report</h1>
        <table class="table js-sort-table table-secondary table-striped table-hover" id="demo1">
            <thead>
              <tr style="background-color:black;">
                <th scope="col">#</th>
                <th scope="col">Report Name</th>
                <th scope="col">Report Type</th>
                <th scope="col">Date</th>
                <th scope="col">Operation</th>
              </tr>
            </thead>
              <tbody>
              <tr>
                <th>1</th>
                <td>Financial Report</td>
                <td>Monthly</td>
                <td><?php echo date("M", strtotime("this month"))?> - <?php echo date("M", strtotime("next month")) ?></td>
                <td><a href="sub_page2/mSReport.php">Run</a></td>
            </tr>
            <tr>
                <th>2</th>
                <td>Financial Report</td>
                <td>Weekly</td>
                <td><?php echo date("M.d", strtotime("previous monday"))?> - <?php echo date("M.d", strtotime("next monday")) ?></td>
                <td><a href="sub_page2/wFReport.php">Run</a></td>
            </tr>
           
            <tr>
                <th>3</th>
                <td>Sales Report</td>
                <td>Monthly</td>
                <td><?php echo date("M", strtotime("this month"))?> - <?php echo date("M", strtotime("next month")) ?></td>
                <td><a href="sub_page2/mFReport.php">Run</a></td>
            </tr>

            <tr>
                <th>4</th>
                <td>Sales Report</td>
                <td>Weekly</td>
                <td><?php echo date("M.d", strtotime("previous monday"))?> - <?php echo date("M.d", strtotime("next monday")) ?></td>
                <td><a href="sub_page2/wSReport.php">Run</a></td>
            </tr> 
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