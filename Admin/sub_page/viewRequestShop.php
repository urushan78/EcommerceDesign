<?php
    include '../../connect.php';
    session_start();
    $shoptype="";
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Admin')
        {
            header("location:../../Session/login.php"); 
        }

    if(isset($_GET['view']))
    {
        $shop_id = $_GET['view'];
        $query= oci_parse($conn,"SELECT * FROM REQUEST_SHOP WHERE PAN_NUMBER = '$shop_id'");
        $run = oci_execute($query); 

        if($run)
        {
            $row = oci_fetch_row($query);
            $trader_id= $row['5'];
        }
    }
    $shopno_error=false;
    $shopno_exist="";
    $shopname_error=false;
    $shopname_exist="";
    if(isset($_POST['approve']))
    {
        echo "areh";
        $shopname = $_POST['shopname'];
        $shoplocation = $_POST['shoplocation'];
        $shopno = $_POST['shopno'];
        $ptype = $_POST['ptype'];
        $des= $_POST['des'];

        $query= oci_parse($conn, 'SELECT * FROM TRADER_SHOP');
          $execute = oci_execute($query);

          if($execute)
          {
            echo "back";
            while( $row= oci_fetch_row($query))
            {
              if($row['0']==$shopno)
                {
                  $shopno_error=true;
                        break;
                }
            }

            if($shopno_error)
            {
              $shopno_exist="Pan number already.";
            }

            while( $row= oci_fetch_row($query))
            {
              if($row['1']==$shopname)
                {
                  $shopname_error=true;
                        break;
                }
            }

    
            if($shopno_error)
            {
              $shopname_exist="Shop name already registered.";
            }
    
        }

        if( !($shopno_error&&$shopno_error))
        {
            $query= oci_parse($conn,"INSERT INTO TRADER_SHOP(SHOP_NO,SHOP_NAME,SHOP_LOCATION,P_TYPE,DES,TRADER_INFO)
            VALUES($shopno,'$shopname','$shoplocation','$ptype','$des',$trader_id)");
            $connect= oci_execute($query);

            if($connect)
            {
                  header('location:declineRequestShop.php?delete='.$shop_id);
            }
        }
    }
    
?>
<!DOCTYPE html>
<html>
<head>
	<title>Request Shop</title>
	
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
        <h2 class="fs-title">Request Shop Details</h2>
        <h3 class="fs-subtitle">
        <?php if(!($shopno_exist=="")){?>
              <div class="danger-error-error">
                <p style="color:#F8D7DA; ">
                  <?php echo $shopno_exist;?>
                </p>
              </div>
            <?php }?>

            <?php if(!($shopname_exist=="")){?>
              <div class="danger-error-error">
                <p style="color:#F8D7DA;">
                  <?php echo $shopname_exist;?>
                </p>
              </div>
            <?php }?>
        </h3>
        
   </div>
   
   <div class="f_l_name">
        <div class="fl_name">
            <input type="text" name="shopno" placeholder="*Shop Pan No" required value="<?php echo $row['0']; ?>" readonly />
        </div>
          <div class="fl_name">
            <input type="text" name="shopname" placeholder="*Shop Name" required  value="<?php echo $row['1']; ?>" readonly />
          </div>
        
   </div>

   <div class="f_l_name">
        <div class="fl_name">
            <input type="text" name="shoplocation" placeholder="*Shop Location" required value="<?php  echo $row['2']; ?>" readonly />
        </div>
        <div class="fl_name">
            <select name="ptype" id="ptype" required>
              <option value="" disabled selected hidden>*Product Type</option>
              <option value="Green Groceries" <?php  if(!strcmp($row['3'],'Green Groceries')){ echo "selected";} ?> disabled>Green Groceries</option>
              <option value="Bakery"   <?php  if(!strcmp($row['3'],'Bakery')){ echo "selected";} ?> disabled>Bakery</option>
              <option value="Delicatessen"  <?php  if(!strcmp($row['3'],'Delicatessen')){ echo "selected";} ?> disabled>Delicatessen</option>
              <option value="Meat" <?php if(!strcmp($row['3'],'Meat')){ echo "selected";} ?> disabled>Meat</option>
              <option value="Fish" <?php   if(!strcmp($row['3'],'Fish')){ echo "selected";} ?> disabled> Fish</option>
            </select>
        </div>
   </div>

   
  <div class="holderup">
  <textarea name="des"  cols="20" rows="10"  required style="resize:none;" placeholder="*Product Description" readonly>
  <?php echo $row['4']; ?>
  </textarea>
  </div>
   
  <div class="fullfill-link">
    <input type="submit" name="approve" class="next action-button" value="Approve"  style="background-color:#276535;">
    <a href="deleteTrader.php?delete=<?php echo $row['0'];?>" class="next action-button" style="background-color:#721C24; text-size:15px; padding:11px 19px;" >Decline</a>
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