<?php
    include '../connect.php';
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Admin')
    {
        header("location:../Session/login.php"); 
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
  <link rel="stylesheet" type="text/css" href="../css/Admin/sidenav.css"/>
	<link rel="stylesheet" type="text/css" href="../css/Admin/adminDashboard.css" />
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Trader', 'Number of Shop'],
          <?php     

            $query = oci_parse($conn, "SELECT * FROM USER_WEBSITE WHERE TYPE='Trader'");
            $run = oci_execute($query);
        
            if($run)
            {
                while($row=oci_fetch_row($query))
                {
                   $tid = $row['0'];
                   $select = oci_parse($conn, "SELECT * FROM TRADER_SHOP WHERE TRADER_INFO=$tid");
                   $complete = oci_execute($select);

                   if($complete)
                   {
                        $count =0;
                       while($data=oci_fetch_row($select))
                       {
                           $count++;
                       }
                   }
                    
          ?>
             ['<?php echo $row['1']?>', <?php echo $count;?>],
        
          <?php } }?>
          ['Others',    0]
        ]);

        var options = {
          title: 'Number of Shop Owned By Trader',
          backgroundColor: '#313030',
          titleTextStyle: {color:'#FFFFFF'},
          legend: {textStyle: { color: 'white' }}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Trader', 'Number of Shop'],
          <?php     

            $query = oci_parse($conn, "SELECT * FROM PRODUCT WHERE STATUS = 'Enable'");
            $run = oci_execute($query);
        
            if($run)
            {
                while($row=oci_fetch_row($query))
                {
                   $tid = $row['0'];
                   $select = oci_parse($conn, "SELECT * FROM REVIEW WHERE PRODUCT_ID_FK=$tid");
                   $complete = oci_execute($select);

                   if($complete)
                   {
                        $count =0;
                       while($data=oci_fetch_row($select))
                       {
                           $count++;
                       }
                   }
                    
          ?>
            ['<?php echo $row['1']?>', <?php echo $count;?>],
        
          <?php }}?>
          ['Others',    0]
        ]);

        var options = {
          title: 'Highest  Review Getters',
          backgroundColor: '#313030',
          titleTextStyle: {color:'#FFFFFF'},
          legend: {textStyle: { color: 'white' }}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

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
					<li><a href="adminTrader.php" class="option"><i class="fas fa-portrait"></i> <span class="go">Trader</span></a></li>
					<li><a href="adminShopRequest.php" class="option"><i class="fas fa-store"></i> <span class="go">Shop</span></a></li>
					<li><a href="adminProduct.php" class="option"><i class="fas fa-seedling"></i> <span class="go">Product</span></a></li>
					<li><a href="adminReport.php" class="option"><i class="far fa-file-powerpoint"></i> <span class="go">Report</span></a></li>
					<li><a href="adminReview.php" class="option"><i class="fas fa-comment-dots"></i><span class="go">Review</span></a></li>
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


            <div class="box-box">

                <div class="box-inner">
                    <div class="box-hold">
                        <div class="box-seperater">
                            
                            <div class="box-h-number">
                                <?php
                                    $query2 = oci_parse($conn,"SELECT * FROM USER_WEBSITE WHERE TYPE = 'Trader'");
                                    $run2 = oci_execute($query2);
                                    $rtn = 0;
                                    if($run2)
                                    { 
                                        while($row= oci_fetch_row($query2))
                                        {
                                            $rtn++;
                                        }
                                    }
                                ?>
                                <p><?php echo $rtn;?></p>
                            </div>
                            <div class="box-h-title">
                                <p>Register Trader</p>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="box-inner">
                    <div class="box-hold">
                        <div class="box-seperater">
                        <?php
                                    $query3 = oci_parse($conn,"SELECT * FROM TRADER_SHOP");
                                    $run3 = oci_execute($query3);
                                    $stn = 0;
                                    if($run3)
                                    { 
                                        while($row= oci_fetch_row($query3))
                                        {
                                            $stn++;
                                        }
                                    }
                                ?>
                            <div class="box-h-number">
                                <p><?php echo $stn;?></p>
                            </div>
                            <div class="box-h-title">
                                <p>Total Shops</p>
                            </div>
                        </div>
                       
                    </div>
                </div>

                <div class="box-inner">
                    <div class="box-hold">
                        <div class="box-seperater">
                                <?php
                                    $query4 = oci_parse($conn,"SELECT * FROM PRODUCT WHERE STATUS='Enable'");
                                    $run4 = oci_execute($query4);
                                    
                                    if($run4)
                                    { $ptn = 0;
                                        while($row= oci_fetch_row($query4))
                                        {
                                            $ptn++;
                                        }
                                    }
                                ?>
                            <div class="box-h-number">
                                <p><?php echo $ptn;?></p>
                            </div>
                            <div class="box-h-title">
                                <p>Products</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                
                
                <div class="box-inner">
                    <div class="box-hold">
                        <div class="box-seperater">
                            
                            <div class="box-h-number">
                                <?php 
                                    $aasq = oci_parse($conn,"SELECT * FROM REVIEW"); 
                                    $aa = oci_execute($aasq);

                                    if($aa)
                                    {
                                        $count=0;
                                        while($is = oci_fetch_assoc($aasq))
                                        {
                                            $count++;
                                        }
                                    }
                                ?>
                                <p><?php echo $count;?></p>
                            </div>
                            <div class="box-h-title">
                                <p> Feedback</p>
                            </div>
                        </div>
                        
                    </div>
                </div>


            </div>


            <div class="box-box-2">
                <div class="box-inner-2">
                    <div class="hold-box">
                        <div class="heads-box">
                            <p>CHART</p>
                        </div>
                        <div class="list-out-2">
                            <div id="piechart" style="width:90%; z-index:0;"></div>
                        </div>
                    </div>
                </div>

                <div class="box-inner-2">
                    <div class="hold-box">
                        <div class="heads-box">
                            <p>CHART</p>
                        </div>
                        <div class="list-out-2">
                        <div id="piechart2" style="width:90%; z-index:0;"></div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="box-box-3">
                <div class="box-inner-3">
                    <div class="box-holds-3">
                        <div class="headers-box">
                            <p>Reviews</p>
                        </div>

                        <div class="boxdisplay">

                            <?php 
                                $ka = oci_parse($conn, "SELECT * FROM REVIEW");
                                $ak = oci_execute($ka);

                                if($ak)
                                {
                                    $index=0;
                                    while($ne = oci_fetch_assoc($ka))
                                    {
                                        $cus = $ne['USER_ID_FK'];

                                        $ok =oci_parse($conn, "SELECT * FROM USER_WEBSITE WHERE ID_USERS = '$cus'");
                                        $ko = oci_execute($ok);

                                        if($ko)
                                        {
                                            while($data = oci_fetch_assoc($ok))
                                            {
                            ?>
                                <div class="customergive">
                                    <div class="tiney">
                                        <div class="tiy">
                                            <div class="img-feed">
                                                <img src="../image/account-default-image.jpg" alt="" width="100%">
                                            </div>
                                            <div class="name-feed">
                                                <p><?php echo $data['USER_NAME'];?></p>
                                            </div>
                                        </div>
                                        <div class="par-feed">
                                            <p><?php echo $ne['REVIEW'];?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } } $index++; if($index==3){break;}}}?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-box-4">
                <div class="first-box-inner">
                    <div class="inner-box-in">
                        <div class="head-inner-box">
                            <p>SHop Customer Details</p>
                        </div>

                        <div class="table-box-inner">
                            <table class="table ">
                                <thead>
                                  <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Shop</th>
                                    <th scope="col">Trader</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                     $sql = oci_parse($conn,"SELECT * FROM USER_WEBSITE WHERE TYPE='Trader'");
                                     $fast = oci_execute($sql);

                                     if($fast)
                                     {
                                         $index=0;
                                         $bb=0;
                                         while($water = oci_fetch_assoc($sql))
                                         {
                                             
                                            
                                             $trader = $water['ID_USERS'];
                                            $msql = oci_parse($conn,"SELECT * FROM TRADER_SHOP WHERE TRADER_INFO='$trader'");
                                            $furious = oci_execute($msql);

                                            if($furious)
                                            {
                                                while($air = oci_fetch_assoc($msql))
                                                {
                                                    $index++;
                                                   if($index==5)     
                                                   {
                                                       $bb=1;
                                                       break;
                                                   }
                                           
                                    ?>
                                  <tr>
                                    <td><?php echo $air['SHOP_NO'];?></td>
                                    <td><?php echo $air['SHOP_NAME'];?></td>
                                    <td><?php echo $water['USER_NAME'];?></td>
                                  </tr>
                                  <?php }

                                    if($bb==1)
                                    {
                                        break;
                                    }
                                  }
                                }
                               
                            }
                        ?>
                                </tbody>
                              </table>
                        </div>
                    </div>
                </div>
                <div class="second-box-inner">
                    <div class="inner-box-in">
                        <div class="head-inner-box">
                            <p>Trader</p>
                        </div>

                        <div class="list-inner-box">
                            <ul>
                                <?php 
                                    $query8 = oci_parse($conn,"SELECT * FROM USER_WEBSITE WHERE TYPE = 'Trader'");
                                    $run8 = oci_execute($query8);
                                    
                                    if($run8)
                                    { 
                                        while($row= oci_fetch_row($query8))
                                        {
                                            
                                       
                                ?>
                                <li>
                                    <div class="img-box-inner">
                                        <div class="img-feed">
                                            <img src="../image/account-default-image.jpg" alt="" width="100%">
                                        </div>
                                    </div>
                                    
                                    <div class="name-feed">
                                        <div class="link-box-inner">
                                            
                                            <a href="sub_page/viewTraderRequest.php?view=<?php echo $row['0']?>">
                                                <span><?php echo $row['1']?></span>
                                            </a>
                                        </div>
                                    </div>
                                </li>

                                <?php }} ?>
                            </ul>
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

