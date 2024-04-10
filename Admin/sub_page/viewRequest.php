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

            $query= oci_parse($conn,"SELECT * FROM TRADER_REQUEST WHERE TRADER_ID='$id'");
            $execute = oci_execute($query);

            if($execute)
            {
                $row= oci_fetch_row($query);
            }
        }
    if(isset($_POST['approve']))
    {
      $name= $_POST['name'];
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $gender = $_POST['gender'];
      $age = $_POST['age'];

      function rand_string( $length ) {

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$%";
        return substr(str_shuffle($chars),0,$length);
    
      }
    
      $password =  rand_string(8);

      $hash = password_hash("$password", PASSWORD_DEFAULT);
      
      $insert= oci_parse($conn,"INSERT INTO USER_WEBSITE(USER_NAME,TYPE,EMAIL,PHONE,GENDER_USER,USER_AGE,LOG,PASSWORD)
                        VALUES('$name','Trader','$email',$phone,'$gender',$age,0,'$hash')");
      $connect = oci_execute($insert);

      if($connect)
      {
        $shopname = $_POST['shopname'];
        $shoplocation = $_POST['shoplocation'];
        $shopno = $_POST['shopno'];
        $ptype = $_POST['ptype'];
        $des= $_POST['des'];

        $select= oci_parse($conn,"SELECT * FROM USER_WEBSITE WHERE EMAIL='$email'");
        $connect = oci_execute($select);

        if($connect)
        {
          $row=oci_fetch_row($select);
          $tid= $row['0'];

          $insert= oci_parse($conn, "INSERT INTO TRADER_SHOP(SHOP_NO,SHOP_NAME,SHOP_LOCATION,P_TYPE,DES,TRADER_INFO)
                            VALUES('$shopno','$shopname','$shoplocation','$ptype','$des','$tid')");
          $connect = oci_execute($insert);

          if($connect)
          {
            $to= $email;
            $subject = "Trader Account Confirmed";
            $message = "Hello ".$name.",\r\n\r\nWe are happy that you've become an official E-Grocer Trader. You can now login with following credentials:\r\n\r\n";
            $message .= "Email: ".$email."\r\nPassword: ".$password."\r\n\r\nHope you enjoy your new journey with us.";
            $header = "Form: E-Grocer Basket"; 

            $mail = mail($to, $subject, $message, $header);

            if($mail)
            {
              header('location:deleteTrader.php?approved='.$id);
            }

            else
            {
              echo "Try again email wasn't send";
            }
           
          }
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
	
<form id="msform" action="" method="POST">
  <!-- progressbar -->
  
  <!-- fieldsets -->
  <fieldset>
    <div class="first-singup-title">
        <h2 class="fs-title">Approve Trader</h2>
        <h3 class="fs-subtitle">Trader Details</h3>
   </div>
   <div class="f_l_name">
        <div class="fl_name">
            <input type="text" name="name" placeholder="*First Name" required value="<?php echo $row['1'];?>" readonly/>
        </div>
   </div>

   <div class="f_l_name">
        <div class="fl_name">
            <input type="email" name="email" placeholder="*Email" required value="<?php echo $row['2'];?>" />
        </div>
        <div class="fl_name">
            <input type="tel" name="phone" placeholder="*Phone [9999-8888-22]" pattern="[0-9]{4}-[0-9]{4}-[0-9]{2}" required  value="<?php echo $row['3'];?>" readonly/>
        </div>
   </div>
    
  <div class="gType">
    <div class="firstup upupup">
      <label for="gender">Gender:</label>
        <input type="radio" id="male" name="gender" value="Male" required <?php  if(!strcmp($row['4'],'Male')){ echo "checked";}?> disable />
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="Female" <?php  if(!strcmp($row['4'],'Female')){ echo "checked";}?> disable />
        <label for="female">Female</label><br>
    </div>

    <div class="firstup">
      <label for="age">Age: </label>
      <input type="number" id="age"  name="age" min="18" max="70" style="max-width:90px;" value="<?php echo $row['5']; ?>" readonly /> 
    </div>
  </div>

  <div class="f_l_name">
        <div class="fl_name">
            <input type="text" name="shopno" placeholder="*Shop Pan No" required value="<?php echo $row['8'];?>" readonly/>
        </div>
          <div class="fl_name">
            <input type="text" name="shopname" placeholder="*Shop Name" required  value="<?php echo $row['9'];?>" readonly/>
          </div>
        
   </div>

   <div class="f_l_name">
        <div class="fl_name">
            <input type="text" name="shoplocation" placeholder="*Shop Location" required value="<?php echo $row['10'];?>" readonly/>
        </div>
        <div class="fl_name">
            <select name="ptype" id="ptype" required>
              <option value="" disabled selected hidden>*Product Type</option>
              <option value="Green Groceries" <?php if(!strcmp($row['12'],'Green Groceries')){ echo "selected";} ?> disable>Green Groceries</option>
              <option value="Bakery"   <?php if(!strcmp($row['12'],'Bakery')){ echo "selected";} ?> disable>Bakery</option>
              <option value="Delicatessen"  <?php  if(!strcmp($row['12'],'Delicatessen')){ echo "selected";} ?> disable>Delicatessen</option>
              <option value="Meat" <?php if(!strcmp($row['12'],'Meat')){ echo "selected";} ?> disable>Meat</option>
              <option value="Fish" <?php  if(!strcmp($row['12'],'Fish')){ echo "selected";} ?> disable> Fish</option>
            </select>
        </div>
   </div>

  <div class="holderup">
  <textarea name="des"  cols="20" rows="10"  required style="resize:none;" placeholder="*Product Description" readonly>
  <?php echo $row['11']; ?>
  </textarea>
  </div>

  <div class="fullfill-link">
    <input type="submit" name="approve" class="next action-button" value="Approve" style="background-color:#276535;">
    <a href="deleteTrader.php?delete=<?php echo $row['0'];?>" class="next action-button" style="background-color:#721C24; text-size:15px; padding:11px 19px;" >Decline</a>
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