<?php
    include '../../connect.php';
    $invalid="";
    if(isset($_POST['login']))
    {
        $email= $_POST['email'];
        $log = $_POST['log'];

        $query= oci_parse($conn, "SELECT * FROM USER_WEBSITE WHERE EMAIL = '$email' AND TYPE= '$log' ");
        $run = oci_execute($query);

        $row = oci_fetch_row($query);
        $num = oci_num_rows($query);

        if($num==1)
        {
            $id = $row['0'];
            $name = $row['1'];
            function rand_string( $length ) {

                $chars = "0123456789";
                return substr(str_shuffle($chars),0,$length);
            
              }
            
              $otp =  rand_string(5);

              $query = oci_parse($conn,"UPDATE USER_WEBSITE SET OTP = '$otp' WHERE ID_USERS = '$id'");
              $run = oci_execute($query);

              if($run)
              {
                $to= $email;
                $subject = "OTP VERIFICATION";
                $message = "Hello ".$name.",\r\n\r\nPlease follow up on your OTP code.";
                $message .= "\r\n\r\n\r\nOTP: ".$otp;
                $header = "Form: E-Grocer Basket"; 
                $mail = mail($to, $subject, $message, $header);
                
                if($mail)
                {
                    header('location:verifyOTP.php?id='.$id);
                }
              }

        }
        else
        {
            $invalid="Invalid Email";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/login.css">
    <link rel="stylesheet" type="text/css" href="../../css/Trader/trader_signup.css">
    <link rel="stylesheet" type="text/css" href="../../css/Customer/nav.css">
    <link rel="stylesheet" type="text/css" href="../../css/Customer/footer.css">
</head>
<body>
    

    <form id="msform" action="" method="POST" style="max-width: 550px; margin-bottom:91px;">
    <fieldset>
    <div class="first-singup-title">
        <h2 class="fs-title">Enter Your Details</h2>
        <h3 class="fs-subtitle">
            <?php if($invalid!=""){
                echo $invalid;
            }?>
        </h3>
   </div>
   

   <div class="f_l_name">

        <div class="fl_name">
            <input type="email" name="email" placeholder="*Email" required value="<?php if(isset($_POST['email'])) { echo htmlentities ($_POST['email']); }?>" />
        </div>
   </div>
    
   <div class="f_l_name">
        <div class="fl_name">
            <select name="log" id="log" required>
              <option value="" selected disable hidden >Select Account Type</option>
              <option value="Customer"  <?php if(isset($_POST['log'])) { if(!strcmp($_POST['log'],'Customer')){ echo "selected";} }?>>Customer</option>
              <option value="Trader" <?php if(isset($_POST['log'])) { if(!strcmp($_POST['log'],'Trader')){ echo "selected";} }?>>Trader</option>
              <option value="Admin" <?php if(isset($_POST['log'])) { if(!strcmp($_POST['log'],'Admin')){ echo "selected";} }?>> Admin</option>
            </select>
        </div>
   </div>
   
  <div class="fullfill-link" style="margin-top:-25px;">
    <input type="submit" name="login" class="next action-button" value="Login">
  </div>
  </fieldset>
    </form>
    <!--Footer-->
	<footer>
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
                        <img src="../../image/font-logo.png" width="100%">
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
                    <img src="../../image/font-logo.png" width="100%">
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/5cd602dbbe.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function(){
        $("#myModal").modal('show');
    });
</script>

</body>
</html>