<?php
    include '../connect.php';
    $email_error="";
    $invalid_pw="";
    $count=0;
    $fail="";

    $customer="";
    if(isset($_GET["customer"]))
    {

        $customer="Success ";
    }
    $register_trader="";
    if(isset($_GET["register"]))
    {

        $register_trader="Your request is successfully processed. ";
    }

    $changed="";
    if(isset($_GET["changed"]))
    {

        $changed="Your password is changed.";
    }
    
    $complete="";
    if(isset($_GET["complete"]))
    {

        $complete="Successfully Registered, Please Login. ";
    }

    $change="";
    if(isset($_GET["change"]))
    {

        $change="Password Successfully Changed, Please Login";
    }

    
    if(isset($_POST['login']))
    {
        

        $email = $_POST['email'];
        $password = $_POST['password'];
        $type = $_POST['log'];
         // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $stid = oci_parse($conn, "SELECT * FROM USER_WEBSITE");
        $result = oci_execute($stid);

      
        if($result)
        {
            while( $row= oci_fetch_row($stid))
            {
                if(!strcmp($row['3'],$email))
                {
                    $count=1;
                    break;
                }

            }

            if($count==1)
            {
                if(password_verify($password,$row['5']))
                {
                    if($row['2']==$type)
                    {
                        session_start();
						$_SESSION['name']= $row['1'];
                        $_SESSION['role']= $type;
                        $_SESSION['log']=$row['7'];
                        $_SESSION['id']=$row['0'];
                        if($_SESSION['role']=='Admin')
                        {
                            header('location:../Admin/adminAccount.php');
                        }
                        elseif($_SESSION['role']=='Trader')
                        {
                            header('location:../Trader/traderAccount.php');
                        }
                        elseif($_SESSION['role']=='Customer')
                        {
                            if(isset($_GET['manage']))
                            {
                                header('location:../Customer/managecart.php?unset="unset"');
                            }
                            else
                            {
                                header('location:../Customer/landing.php');
                            }
                            
                        }        
                    }
                    else
                    {
                        $fail =" Invalid Credentials";
                    }  
                }
                else
                {
                    $invalid_pw=" Invalid Password";
                }
            }  
            else{
                $email_error="Seems like you don't have an account with us.";
            }
        }
        else{
            echo "Error while signing in";
        }
    } 
    else 
    {
        $email_error="Invalid Email";
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
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" type="text/css" href="../css/Trader/trader_signup.css">
    <link rel="stylesheet" type="text/css" href="../css/Customer/nav.css">
    <link rel="stylesheet" type="text/css" href="../css/Customer/footer.css">
</head>
<body>
    
    <?php if(!($register_trader=="")):?>
        <div id="myModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Request Processed</h5>
                        
                    </div>
                    <div class="modal-body">
                        <p>Thank you for considering to register with us, we will respond to your request very soon via your email address. Stay Safe!!</p>
                        <a href="login.php">Click Here to Continue</a>
                    </div>
                
                    
                </div>
            </div>
        </div>
    <?php endif;?>

    <?php if(!($complete=="")):?>
        <div id="myModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Successfully Registered</h5>
                        
                    </div>
                    <div class="modal-body">
                        <p>Congratulation, You have successfully been register.</p>
                        <a href="login.php">Click Here to Continue</a>
                    </div>
                
                    
                </div>
            </div>
        </div>
    <?php endif;?>


    <?php if(!($changed=="")):?>
        <div id="myModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Successfully Password Changed</h5>
                        
                    </div>
                    <div class="modal-body">
                        <p>Congratulation, You have successfully changed your password.</p>
                        <a href="login.php">Click Here to Continue</a>
                    </div>
                
                    
                </div>
            </div>
        </div>
    <?php endif;?>

    <?php if(!($customer=="")):?>
        <div id="myModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Account Verified</h5>
                        
                    </div>
                    <div class="modal-body">
                        <p>Congratulation, You have successfully verified your account.</p>
                        <a href="login.php">Click Here to Continue</a>
                    </div>
                
                    
                </div>
            </div>
        </div>
    <?php endif;?>
    
    <form id="msform" action="" method="POST" style="max-width: 550px;">
    <fieldset>
    <div class="first-singup-title">
        <h2 class="fs-title">Welcome Back</h2>
        <h3 class="fs-subtitle">
        <?php if(!($fail=="")){?>
                <div class="danger-error-error">
                    <p style="color:#faa1a9;">
                        <?php echo $fail;?>
                    </p>
                </div>
            <?php }?>

            <?php if(!($email_error=="")){?>
                <div class="danger-error-error">
                    <p style="color:#faa1a9;">
                        <?php echo $email_error;?>
                    </p>
                </div>
            <?php }?>

            <?php if(!($invalid_pw=="")){?>
                <div class="danger-error-error" style="padding-top:12px">
                    <p style="color:#faa1a9;">
                        <?php echo $invalid_pw;?>
                    </p>
                </div>
            <?php }?>

            <?php if(!($change=="")):?>
                <div class="danger-error-error" style="padding-top:12px">
                    <p style="color:#155724;">
                        <?php echo $change;?>
                    </p>
                </div>
            <?php endif;?>
        </h3>
   </div>
   

   <div class="f_l_name">

        <div class="fl_name">
            <input type="email" name="email" placeholder="*Email" required value="<?php if(isset($_POST['email'])) { echo htmlentities ($_POST['email']); }?>" />
        </div>
   </div>
    


  <div class="f_l_name">
        <div class="fl_name">
            <input type="password" name="password" placeholder="*Password" required />
            <a href="signup_extra/forgetPassword.php">Forgot Password?</a>
        </div>
   </div>

   <div class="f_l_name">
        <div class="fl_name">
            <select name="log" id="log" required>
              <option value="" selected disable hidden >Login As:</option>
              <option value="Customer"  <?php if(isset($_POST['log'])) { if(!strcmp($_POST['log'],'Customer')){ echo "selected";} }?>>Customer</option>
              <option value="Trader" <?php if(isset($_POST['log'])) { if(!strcmp($_POST['log'],'Trader')){ echo "selected";} }?>>Trader</option>
              <option value="Admin" <?php if(isset($_POST['log'])) { if(!strcmp($_POST['log'],'Admin')){ echo "selected";} }?>> Admin</option>
            </select>
        </div>
   </div>
   
  <div class="fullfill-link" style="margin-top:-25px;">
    <input type="submit" name="login" class="next action-button" value="Login">
  </div>

  <div class="fullfill-link secret" style="margin-bottom:14px;">
      <a href="customer_signup.php" class="next action-button extra_btn" style="padding:14px 12px" >Become Customer</a>
      <a href="trader_signup.php" class="next action-button extra_btn" style="padding:14px 12px">Become Trader</a>
  </div>

  <div class="fullfill-link dispose" style="margin-bottom:15px;">
      <a href="customer_signup.php" class="next action-button extra_btn" style="padding:14px 12px" >Become Customer</a>
  </div>

  <div class="fullfill-link dispose">
    <a href="trader_signup.php" class="next action-button extra_btn" style="padding:14px 12px">Become Trader</a>
  </div>

  </fieldset>
    </form>

    <?php
        include '../Customer/footer.php';
    ?>


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