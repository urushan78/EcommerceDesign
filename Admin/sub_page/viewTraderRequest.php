<?php
    include '../../connect.php';
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Admin')
        {
            header("location:../../Session/login.php"); 
        }

        if(isset($_GET['view']))
        {
            $id = $_GET['view'];

            $query= oci_parse($conn,"SELECT * FROM USER_WEBSITE WHERE ID_USERS ='$id'");
            $execute = oci_execute($query);

            if($execute)
            {
                $row= oci_fetch_row($query);
            }
        }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Trader Details</title>
	
	<link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../../css/Trader/trader_signup.css">
  
</head>
<body>
<section id="nav">
<a href="../adminTrader.php" style="margin-left:5em;"><i class="fas fa-arrow-left"></i> Back</a>
<form id="msform" action="" method="POST">
  <!-- progressbar -->
  
  <!-- fieldsets -->
  <fieldset>
  
    <div class="first-singup-title">
        <h2 class="fs-title">Trader Details</h2>
        <h3 class="fs-subtitle"></h3>
   </div>
   <div class="f_l_name">
        <div class="fl_name">
            <input type="text" name="name" placeholder="*First Name" required value="<?php echo $row['1'];?>" readonly/>
        </div>
   </div>

   <div class="f_l_name">
        <div class="fl_name">
            <input type="email" name="email" placeholder="*Email" required value="<?php echo $row['3'];?>" readonly />
        </div>
        <div class="fl_name">
            <input type="tel" name="phone" placeholder="*Phone [9999-8888-22]" pattern="[0-9]{4}-[0-9]{4}-[0-9]{2}" required  value="<?php echo $row['4'];?>" readonly/>
        </div>
   </div>
    
  <div class="gType">
    <div class="firstup upupup">
      <label for="gender">Gender:</label>
        <input type="radio" id="male" name="gender" value="Male" required <?php  if(!strcmp($row['8'],'Male')){ echo "checked";}?> disabled />
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="Female" <?php  if(!strcmp($row['8'],'Female')){ echo "checked";}?> disabled />
        <label for="female">Female</label><br>
    </div>

    <div class="firstup">
      <label for="age">Age: </label>
      <input type="number" id="age"  name="age" min="18" max="70" style="max-width:90px;" value="<?php echo $row['9']; ?>" readonly /> 
    </div>
  </div>

 </fieldset> 

    <fieldset style="margin-top:45px;">
    <div class="main">
                    <h2 style="margin-bottom:12px;">SHOP DETAILS</h2>
                    
                    <table class="table">
                        <thead>
                            <tr style="background-color:black; color:white;">
                                <th scope="col">Pan No</th>
                                <th scope="col">Shop Name</th>
                                <th scope="col">Location</th>
                                <th scope="col">Type</th>
                                <th scope="col">Product Contained</th>
                                <th>Operation</th>
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
                                <td>
                                    <a href="viewActiveShop.php?view=<?php echo $row['0'];?>">View</a>
                                </td>
                            </tr>

                            <?php }}?>
                        </tbody>
                    </table>
                </div>
            </fieldset>


                <fieldset style="margin-top:45px;">
                <div class="main">
                    <h2 style="margin-bottom:12px;">Product Collections</h2>
                    <table class="table">
                        <thead>
                            <tr style="background-color:black; color:white;">
                                <th scope="col"> ID </th>
                                <th scope="col"> Image </th>
                                <th scope="col"> Name </th>
                                <th scope="col"> Price </th>
                                <th scope="col"> Category </th>
                                <th scope="col"> SHOP ID </th>
                                <th scope="col"> Operation </th>
                                
                            </tr>
                        </thead>

                        <?php
                         $result = oci_parse($conn, "SELECT * FROM PRODUCT WHERE TRADER_INFO = '$id' AND STATUS = 'Enable'");
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
                            <td ><a href="viewProduct.php?view=<?php echo $eachrow["PRODUCT_ID"];?>">View</a></td>
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