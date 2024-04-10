<?php
include'../connect.php';
$count=0;
$email_error="";
$exist_email=false;
$shopno_error=false;
$shopno_exist="";
$shopname_error=false;
$shopname_exist="";


  if(isset($_POST['submit']))
  {
    $name= $_POST['fname']." ".$_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $shopname = $_POST['shopname'];
    $shoplocation = $_POST['shoplocation'];
    $shopno = $_POST['shopno'];
    $ptype = $_POST['ptype'];
    $des= $_POST['des'];
    

    
    if (filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $stid = oci_parse($conn, 'SELECT * FROM USER_WEBSITE');
      $result = oci_execute($stid);

      if($result)
      {
        while( $row= oci_fetch_row($stid))
        {
          if($row['3']==$email)
                {
                  $exist_email=true;
                    break;
                }
        }

        if($exist_email)
        {
          $email_error="Email already registered.";
        }

      }

      $query= oci_parse($conn, 'SELECT * FROM TRADER_SHOP');
      $execute = oci_execute($query);

      if($execute)
      {
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
          $shopno_exist="Pan number already exist.";
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
          $shopname_exist="Shop name already exist.";
        }
      }

          
      if(!($exist_email&&$shopno_error&&$shopname_error))
      {

        $query1= oci_parse ($conn,"INSERT INTO 
        TRADER_REQUEST(TRADER_NAME,TRADER_EMAIL,TRADER_PHONE,TRADER_GENDER,TRADER_AGE,SHOP_NAME,SHOP_LOCATION,PAN_NUMBER,P_TYPE,DES,NUMBER_ADD_SHOP) 
        VALUES('$name','$email',$phone,'$gender',$age,'$shopname','$shoplocation',$shopno,'$ptype','$des',1)");
        
        $run = oci_execute($query1);

        if($run)
        {
          
          header('location:login.php?register="register"');  
        }
            
        }
        else
        {
          echo "failed";
        }

      }
      else{
        $email_error="Invalid Email";
      }
    } 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Signup form</title>
	
	<link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/Trader/trader_signup.css">
  <link rel="stylesheet" type="text/css" href="../css/Customer/footer.css">
  
</head>
<body>
<section id="nav">
	
<form id="msform" action="" method="POST">
  <!-- progressbar -->
  
  <!-- fieldsets -->
  <fieldset>
    <div class="first-singup-title">
        <h2 class="fs-title">Sign Up As Trader</h2>
        <h3 class="fs-subtitle">Trader Details</h3>
   </div>
   <div class="f_l_name">
        <div class="fl_name">
            <input type="text" name="fname" placeholder="*First Name" required value="<?php if(isset($_POST['fname'])) { echo htmlentities ($_POST['fname']); }?>" />
        </div>
        <div class="fl_name">
            <input type="text" name="lname" placeholder="*Last Name" required value="<?php if(isset($_POST['lname'])) { echo htmlentities ($_POST['lname']); }?>" />
        </div>
   </div>

   <div class="f_l_name">
        <div class="fl_name">
            <input type="email" name="email" placeholder="*Email" required value="<?php if(isset($_POST['email'])) { echo htmlentities ($_POST['email']); }?>" />
            <?php if(!($email_error=="")){?>
                    <div class="danger-error-error" style="padding-top:12px">
                        <p style="background-color:#F8D7DA; text-align:center; border-radius: 20px;max-width: 50%;margin: 0 auto;">
                            <?php echo $email_error;?>
                        </p>
                    </div>
                    <?php }?>
        </div>
        <div class="fl_name">
            <input type="tel" name="phone" placeholder="*Phone [9999-8888-22]" pattern="[0-9]{4}-[0-9]{4}-[0-9]{2}" required  value="<?php if(isset($_POST['phone'])) { echo htmlentities ($_POST['phone']); }?>" />
        </div>
   </div>
    
  <div class="gType">
    <div class="firstup upupup">
      <label for="gender">Gender:</label>
        <input type="radio" id="male" name="gender" value="Male" required <?php if(isset($_POST['gender'])) { if(!strcmp($_POST['gender'],'male')){ echo "checked";} }?> />
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="Female" <?php if(isset($_POST['gender'])) { if(!strcmp($_POST['gender'],'female')){ echo "checked";} }?> />
        <label for="female">Female</label><br>
    </div>

    <div class="firstup">
      <label for="age">Age: </label>
      <input type="number" id="age"  name="age" min="18" max="70" style="max-width:90px;" value="<?php if(isset($_POST['age'])) { echo htmlentities ($_POST['age']); }?>" /> 
    </div>
  </div>

  <div class="f_l_name">
        <div class="fl_name">
            <input type="number" name="shopno" placeholder="*Shop Pan No" required value="<?php if(isset($_POST['shopno'])) { echo htmlentities ($_POST['shopno']); }?>" style="-webkit-appearance: none; -moz-appearance: textfield;"/>
        
            <?php if(!($shopno_exist=="")){?>
              <div class="danger-error-error" style="padding-top:12px">
                <p style="background-color:#F8D7DA; text-align:center; border-radius: 20px;max-width: 50%;margin: 0 auto;">
                  <?php echo $shopno_exist;?>
                </p>
              </div>
            <?php }?>
        </div>
          <div class="fl_name">
            <input type="text" name="shopname" placeholder="*Shop Name" required  value="<?php if(isset($_POST['shopname'])) { echo htmlentities ($_POST['shopname']); }?>" />
            <?php if(!($shopname_exist=="")){?>
              <div class="danger-error-error" style="padding-top:12px">
                <p style="background-color:#F8D7DA; text-align:center; border-radius: 20px;max-width: 50%;margin: 0 auto;">
                  <?php echo $shopname_exist;?>
                </p>
              </div>
            <?php }?>
          </div>
        
   </div>

   <div class="f_l_name">
        <div class="fl_name">
            <input type="text" name="shoplocation" placeholder="*Shop Location" required value="<?php if(isset($_POST['shoplocation'])) { echo htmlentities ($_POST['shoplocation']); }?>" />
        </div>
        <div class="fl_name">
            <select name="ptype" id="ptype" required>
              <option value="" disabled selected hidden>*Product Type</option>
              <option value="Green Groceries" <?php if(isset($_POST['ptype'])) { if(!strcmp($_POST['ptype'],'Green Groceries')){ echo "selected";} }?>>Green Groceries</option>
              <option value="Bakery"   <?php if(isset($_POST['ptype'])) { if(!strcmp($_POST['ptype'],'Bakery')){ echo "selected";} }?>>Bakery</option>
              <option value="Delicatessen"  <?php if(isset($_POST['ptype'])) { if(!strcmp($_POST['ptype'],'Delicatessen')){ echo "selected";} }?>>Delicatessen</option>
              <option value="Meat" <?php if(isset($_POST['ptype'])) { if(!strcmp($_POST['ptype'],'Meat')){ echo "selected";} }?>>Meat</option>
              <option value="Fish" <?php if(isset($_POST['ptype'])) { if(!strcmp($_POST['ptype'],'Fish')){ echo "selected";} }?>> Fish</option>
            </select>
        </div>
   </div>

  
  <div class="holderup">
  <textarea name="des"  cols="20" rows="10"  required style="resize:none;" placeholder="*Product Description" >
  <?php if(isset($_POST['des'])) { echo htmlentities ($_POST['des']); }?>
  </textarea>
  </div>


   
  <div class="fullfill-link">
    <input type="submit" name="submit" class="next action-button" value="Submit">
  </div>

  </fieldset>
  
</form>

<footer class="lower">
        <div class="containers">
            <div class="rows show">
                
                <div class="co-1 co">
                    
                    <ul>
                        <li><p>Information</p></li>
                        <li><a href="">Collection Slot Details</a></li>
                        <li><a href="">Privacy Policy</a></li>
                        <li><a href="">Terms & Conditions</a></li>
                        <li><a href="">Contact Us</a></li>
                        <li><a href="">About Us</a></li>
                    </ul>
                </div>

                <div class="co-2 co">
                    
                    <div class="img-box">
                        <img src="../image/font-logo.png" width="100%">
                        <p>A place where everything special, shop form local traders near cleckhuddersfax area.</p>
                    </div>

                </div>


                <div class="co-3 co">
                    
                    <ul>
                        <li><p>Quick Links</p></li>
                        <li><a href="">Shop By Category</a></li>
                        <li><a href="">Trending Products</a></li>
                        <li><a href="">Add to Cart</a></li>
                        <li><a href="">Become a Trader</a></li>
                        <li><a href="">Sign In</a></li>
                    </ul>
                </div>
            </div>


            <div class="row-img hides">
                <div class="img-box">
                    <img src="../image/font-logo.png" width="100%">
                </div>
                <p>A place where everything special, shop form local traders near cleckhuddersfax area.</p>
            </div>
        <div class="rows hide">
                

            <div class="co-1 co">
                
                <ul>
                    <li><p>Information</p></li>
                    <li><a href="">Collection Slot Details</a></li>
                    <li><a href="">Privacy Policy</a></li>
                    <li><a href="">Terms & Conditions</a></li>
                    <li><a href="">Contact Us</a></li>
                    <li><a href="">About Us</a></li>
                </ul>
            </div>

            
            <div class="co-3 co">
                
                <ul>
                    <li><p>Quick Links</p></li>
                    <li><a href="">Shop By Category</a></li>
                    <li><a href="">Trending Products</a></li>
                    <li><a href="">Add to Cart</a></li>
                    <li><a href="">Become a Trader</a></li>
                    <li><a href="">Sign In</a></li>
                </ul>
            </div>
        </div>

        </div> 
    
    </footer>
    <div class="down">
        <a href=""> Copyright &copy; 2021 E-Grocer Basket</a>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/5cd602dbbe.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>