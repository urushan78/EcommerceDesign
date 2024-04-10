<?php
    include '../../connect.php';
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Admin')
        {
            header("location:../../Session/login.php"); 
        }

        if(isset($_GET['view']))
        {
            $pid= $_GET['view'];

            $query= oci_parse($conn, "SELECT * FROM PRODUCT WHERE PRODUCT_ID = '$pid' AND STATUS = 'Enable'");
            $communicate = oci_execute($query); 

            if($communicate)
            {
                $row = oci_fetch_row($query);

            }
        }
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Product</title>
	
	<link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../../css/Trader/trader_signup.css">
  
</head>
<body>
<section id="nav">
	
<form id="msform" action="" method="POST">
  <!-- progressbar -->

  <!-- fieldsets -->
  <fieldset>
    <div class="first-singup-title">
        <h2 class="fs-title">View Product</h2>
        <h3 class="fs-subtitle">
        </h3>
        
   </div>
   

   
   <div class="f_l_name">
        <img src="../../image/<?php echo $row['12']?>" alt="" width="120px" height="120px" style="border-radius:50%; margin: 0 auto;">
            
   </div>
   
   </div>
   <p style="font-size:20px; font-weight:700;"> <span style="font-size:22px"> Product ID: </span> <?php echo $row['0']; ?></p>
   <input type="hidden" name="id" placeholder="*Shop Pan No" required value="<?php echo $row['0']; ?>" readonly />

   <div class="f_l_name">
       
          <div class="fl_name">
            <input type="text" name="name" placeholder="*Shop Name" required  value="Name: <?php echo $row['1']; ?>" readonly />
          </div>
        
   </div>

   
   <div class="f_l_name">
        <div class="fl_name">
            <input type="text" name="price" placeholder="*Shop Location" required value="Price: &pound <?php  echo $row['2']; ?>" readonly />
        </div>
        <div class="fl_name">
            <select name="ptype" id="ptype" required>
              <option value="" disabled selected hidden>*Product Type</option>
              <option value="Green Groceries" <?php  if(!strcmp($row['11'],'Green Groceries')){ echo "selected";} ?> disabled>Green Groceries</option>
              <option value="Bakery"   <?php  if(!strcmp($row['11'],'Bakery')){ echo "selected";} ?> disabled>Bakery</option>
              <option value="Delicatessen"  <?php  if(!strcmp($row['11'],'Delicatessen')){ echo "selected";} ?> disabled>Delicatessen</option>
              <option value="Meat" <?php if(!strcmp($row['11'],'Meat')){ echo "selected";} ?> disabled>Meat</option>
              <option value="Fish" <?php   if(!strcmp($row['11'],'Fish')){ echo "selected";} ?> disabled> Fish</option>
            </select>
        </div>
   </div>

  
   
  <div class="holderup">
  <textarea name="des"  cols="20" rows="10"  required style="resize:none;" placeholder="*Product Description" readonly>
  <?php echo $row['10']; ?>
  </textarea>
  </div>
   
  <div class="fullfill-link">
    <a href="disableProduct.php?disable=<?php echo $row['0'];?>" class="next action-button" style="background-color:#721C24; text-size:15px; padding:11px 19px;" >Disable</a>
  </div>
   
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