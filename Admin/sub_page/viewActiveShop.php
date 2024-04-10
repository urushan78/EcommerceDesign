<?php
    include '../../connect.php';
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Admin')
        {
            header("location:../../Session/login.php"); 
        }

        if(isset($_GET['view']))
        {
            $shop_info = $_GET['view'];

            $query = oci_parse($conn, "SELECT * FROM TRADER_SHOP WHERE SHOP_NO='$shop_info'");
            $compete = oci_execute($query);

            if($compete)
            {
                $row = oci_fetch_row($query);
                $trader_id = $row['5'];

                $query = oci_parse($conn, "SELECT * FROM USER_WEBSITE WHERE ID_USERS='$trader_id'");
                $compete = oci_execute($query);

                if($compete)
                {
                    $hold = oci_fetch_row($query);
                }
            }
        }
    
?>
<!DOCTYPE html>
<html>
<head>
	<title>Request Form</title>
	
	<link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../../css/Trader/trader_signup.css">
  
</head>
<body>
<section id="nav">
<a href="../adminShopRequest.php" style="margin-left:5em;"><i class="fas fa-arrow-left"></i> Back</a>
<form id="msform" action="" method="POST">
  <!-- progressbar -->
  
  <!-- fieldsets -->
  <fieldset>
  
    <div class="first-singup-title">
        <h2 class="fs-title">View Shop:- <?php echo $row['0'];?></h2>
        <h3 class="fs-subtitle">Shop Details</h3>
   </div>

   <div class="f_l_name">
        <div class="fl_name">
        <input type="text" name="id" placeholder="*Trader ID" required value=" Trader ID: <?php echo $hold['0'];?>" readonly/>
        </div>

        <div class="fl_name">
        <input type="text" name="name" placeholder="*Trader Name" required value="Trader Name: <?php echo $hold['1'];?>" readonly/>
        </div>
   </div>

   <div class="f_l_name">
        <div class="fl_name">
        <input type="text" name="no" placeholder="*Shop No" required value=" Shop No: <?php echo $row['0'];?>" readonly/>
        </div>

        <div class="fl_name">
        <input type="text" name="name" placeholder="*Shop Name" required value=" Shop Name: <?php echo $row['1'];?>" readonly/>
        </div>
   </div>

   <div class="f_l_name">
        <div class="fl_name">
            <input type="text" name="location" placeholder="*Shop Location" required value="<?php echo $row['2'];?>" readonly />
        </div>
        <div class="fl_name">
            <input type="text" name="type" placeholder="*Shop Type"  required  value="<?php echo $row['3'];?>" readonly/>
        </div>
   </div>
    
  <div class="holderup">
  <textarea name="des"  cols="20" rows="10"  required style="resize:none;" placeholder="*Product Description" >
  <?php echo $row['4'];?>
  </textarea>

 </fieldset> 

    
 <fieldset style="margin-top:45px;">
 <div class="main">
                    <h2 style="margin-bottom:12px;">Product Collection </h2>
                    <table class="table">
                        <thead>
                            <tr style="background-color:black; color:white;">
                                <th scope="col"> ID </th>
                                <th scope="col"> Image </th>
                                <th scope="col"> Name </th>
                                <th scope="col"> Price </th>
                                <th scope="col"> Category </th>
                                <th scope="col"> SHOP ID </th>
                                <th scope="col"> OPERATION </th>
                            </tr>
                        </thead>

                        <?php
                         $result = oci_parse($conn, "SELECT * FROM PRODUCT WHERE SHOP_INFO = '$shop_info' AND STATUS = 'Enable'");
                         oci_execute($result);
                            while (($eachrow = oci_fetch_assoc($result))) {
                        ?>

                        <tr>
                            <td scope="row"><?php echo $eachrow["PRODUCT_ID"];?></td>
                            <td> <img src="../../image/<?php echo $eachrow["IMAGE"]?>" height="50px" width="50px"></td>
                            <td ><?php echo $eachrow["NAME"];?></td>
                            <td >£<?php echo $eachrow["PRICE"];?></td>
                            <td ><?php echo $eachrow["CATEGORY"];?></td>
                            <td ><?php echo $eachrow["SHOP_INFO"];?></td>
                            <td><a href="viewProduct.php?view=<?php echo $eachrow["PRODUCT_ID"];?>">View</a></td>
                        </tr>
                            
                        <?php
                            }
                        ?> 
                    </table>
                </div>
 </fieldset>


    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/5cd602dbbe.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>