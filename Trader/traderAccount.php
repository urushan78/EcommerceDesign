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
	<link rel="stylesheet" type="text/css" href="../css/Admin/sidenav.css"/>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Product', 'Hours per Day'],
            <?php 
                $fnc = oci_parse($conn,"SELECT * FROM PRODUCT WHERE TRADER_INFO='$trader_id'");
                $gxr = oci_execute($fnc);

                if($gxr)
                {
                    while($hello = oci_fetch_assoc($fnc))
                    {
                        $pid = $hello['PRODUCT_ID']; 

                        $amp = oci_parse($conn,"SELECT * FROM ORDER_PRODUCT WHERE PRODUCT_ID_FK='$pid'");
                        $lmp = oci_execute($amp);
        
                        if($lmp)
                        {
                            $count=0;
                            while($rpm = oci_fetch_assoc($amp))
                            {
                                $count++;
                            }
                        }
                    
            ?>
          ['<?php echo $hello['NAME']?>',  <?php echo $count;?>],
          <?php }}?>
          


          ['Others',    0]
        ]);

        var options = {
          title: 'Number of Products Ordered',
          backgroundColor: '#313030',
          pieHole: 0.4,
          titleTextStyle: {color:'#FFFFFF'},
          legend: {textStyle: { color: 'white' }}
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>

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
					<li><a href="#" class="option active"><i class="fas fa-tachometer-alt"></i> <span class="go">Dashboard</span></a></li>
					<li><a href="traderProduct.php" class="option"><i class="fas fa-shopping-cart"></i> <span class="go">Product</span></a></li>
                    <li><a href="traderShop.php" class="option "><i class="fas fa-store-alt"></i> <span class="go">Shop</span></a></li>
                    <li><a href="traderReport.php" class="option"><i class="fas fa-chart-line"></i> <span class="go">Report</span></a></li>
					<li><a href="traderReview.php" class="option"><i class="fas fa-comment-dots"></i> <span class="go">Review</span></a></li>
					<li><a href="traderSetting.php" class="option"><i class="fas fa-cog"></i> <span class="go">Setting</span></a></li>
					<li><a href="traderOrderDetails.php" class="option"><i class="fas fa-bell"></i><span class="go">Order Details</span></a></li>
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


            <div class="initial">
                <div class="inherit">
                    <div class="hold">
                        <div class="head">
                            <p>Earning</p>
                        </div>
                        <?php 
                        $total=0;
                            $fnc = oci_parse($conn, "SELECT * FROM PRODUCT WHERE TRADER_INFO='$trader_id'");
                            $gxr = oci_execute($fnc);

                            if($gxr)
                            {
                                while($tsm = oci_fetch_assoc($fnc))
                                {
                                    $pro = $tsm['PRODUCT_ID'];

                                    $godl= oci_parse($conn, "SELECT * FROM ORDER_PRODUCT WHERE PRODUCT_ID_FK='$pro'");
                                    $soul = oci_execute($godl);

                                    if($soul)
                                    {
                                        while($blind=oci_fetch_assoc($godl))
                                        {
                                            $one = $blind['QUANITY']*$blind['PRICE'];

                                            $total = $total + $one;
                                        }
                                    }
                                }
                            }
                        ?>
                        <div class="price">
                            <p>£<?php echo $total;?>.00</p>
                        </div>
                    </div>
                </div>

                <div class="inherit">
                    <div class="hold">
                        <div class="head">
                            <p>Product</p>
                        </div>
                        <div class="price">
                            <?php 
                                $select = oci_parse($conn, "SELECT * FROM PRODUCT WHERE TRADER_INFO ='$trader_id' ");
                                $run = oci_execute($select);

                                if($run)
                                {
                                    $count = 0;
                                    while(oci_fetch_row($select))
                                    {
                                        $count++;
                                    }
                                }
                            ?>
                            <p><?php echo $count;?></p>
                        </div>
                    </div>
                  </div>

                  <div class="inherit">
                    <div class="hold">
                        <div class="head">
                            <p>SHOP</p>
                        </div>
                        <div class="price">
                        <?php 
                                $select = oci_parse($conn, "SELECT * FROM TRADER_SHOP WHERE TRADER_INFO ='$trader_id' ");
                                $run = oci_execute($select);

                                if($run)
                                {
                                    $count = 0;
                                    while(oci_fetch_row($select))
                                    {
                                        $count++;
                                    }
                                }
                            ?>
                            <p><?php echo $count;?></p>
                        </div>
                    </div>
                  </div>
            </div>


            <div class="initial-2">
                <div class="kid-div">
                    <div class="hold-2">
                        <div class="heads">
                            <p>Products</p>
                        </div>
                        <div class="list-out">
                            <table>
                                <?php 
                                    $make= oci_parse($conn, "SELECT * FROM PRODUCT WHERE TRADER_INFO = ' $trader_id' ORDER BY PRODUCT_ID DESC");
                                    $exe = oci_execute($make); 

                                    if($exe)
                                    {
                                        $index=0;
                                        while($her = oci_fetch_assoc($make))
                                        {
                                    
                                ?>
                                <tr>
                                    <td class="t-name" style="padding:0px; font-size:18px;"><a href="sub_page/viewReview.php?view=<?php echo $her['PRODUCT_ID'];?>"><?php echo $her['NAME'];?></a></td>
                                    <td style="padding:0px; font-size:18px;">&pound<?php echo $her['PRICE'];?></td>
                                </tr>
                                <?php $index++; if($index==4){break;} } }?>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="kid-div-2">
                    <div class="hold-2">
                        <div class="heads">
                            <p>CHART</p>
                        </div>

                        <div class="list-out">
                        <div id="donutchart" style="width:90%; z-index:0;"></div>
              
                        </div>
                    </div>
                </div>
            </div>


            <div class="initial-3">
                <div class="child-div">
                    <div class="hold-3">
                        <div class="headers">
                            <p>Reviews</p>
                        </div>

                        <div class="display">

                        <?php 
                            $select = oci_parse($conn, "SELECT * FROM PRODUCT WHERE TRADER_INFO ='$trader_id'");
                            $run = oci_execute($select);

                            if($run)
                            {
                                $index=0;
                                while($row = oci_fetch_assoc($select))
                                {
                                    $pid = $row['PRODUCT_ID'];
                                    $query= oci_parse($conn,"SELECT * FROM REVIEW WHERE PRODUCT_ID_FK = '$pid' ORDER BY REVIEW_ID DESC");
                                    $work = oci_execute($query);

                                    if($work)
                                    {
                                        while($data = oci_fetch_assoc($query))
                                        {
                                            $user_id = $data['USER_ID_FK']; 
                                            $sell= oci_parse($conn,"SELECT * FROM USER_WEBSITE WHERE ID_USERS = '$user_id'");
                                            $ok = oci_execute($sell);

                                            if($work)
                                        {
                                            $numUser = oci_fetch_assoc($sell);
                                        }
                        ?>
                            <div class="feedback">
                                <div class="smaller">
                                    <div class="sm">
                                        <div class="feedback-img">
                                            <img src="../image/account-default-image.jpg" alt="" width="100%">
                                        </div>
                                        <div class="feedback-name">
                                            <p><?php echo $numUser['USER_NAME'];?></p>
                                        </div>
                                    </div>
                                    <div class="feedback-par">
                                        <p><?php echo $data['REVIEW'];?></p>
                                    </div>
                                </div>
                            </div>
                            <?php  }  } $index++; if( $index>3){break;} elseif($index==1){continue;}}}?>
                            
                        </div>
                    </div>
                </div>
            </div>



            <footer>
                <a href=""> Copyright &copy; 2021 E-Grocer Basket</a>
            </footer>
        </div>
	</section>
	
	<!--Bootstrap Js files link-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/5cd602dbbe.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>

