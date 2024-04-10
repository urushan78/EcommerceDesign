<?php
   $old_error="";
   $match_error="";
   $new_error="";
   $char_error="";
   $first_change="";
    include '../../connect.php';
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Trader')
        {
            header("location:../login.php"); 
        }

    $id= $_SESSION['id'];
    
    if(isset($_POST['submit']))
    {
        
        $old= $_POST['old'];
        $new= $_POST['new'];
        $confirm= $_POST['confirm'];


        $query = oci_parse($conn,"SELECT * FROM USER_WEBSITE WHERE ID_USERS = $id");
        $execute = oci_execute($query);

        
        if($execute)
        {
            $row = oci_fetch_row($query);

            if(!(password_verify($old,$row['5'])))
            {
                $old_error="Incorrect Old Password";
            }
            elseif($new!=$confirm)
            {
                $match_error="Password Doesn't Match";
            }
            elseif($old==$new)
            {
                $new_error= "Provide Different Password";
            }
            elseif($new<8)
            {
                $char_error="Length Should Be Greater Than 7";
            }
            elseif($old_error==""&&$match_error==""&&$new_error==""&&$char_error=="")
            {
                $pass= password_hash($new,PASSWORD_DEFAULT);
                
                $query = oci_parse($conn,"UPDATE USER_WEBSITE SET 
                                                                PASSWORD= '$pass',
                                                                LOG=1 WHERE ID_USERS = $id");
                $execute = oci_execute($query);

                if($execute)
                {
                    header('location:../login.php?change="change"');
                }
            }
        }
        
    }

    if(isset($_GET['sess']))
    {
        $first_change="Please Reset Your Password";
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
</head>
<body>
        
    <form id="msform" action="" method="POST" style="max-width: 550px;">
    <fieldset>
    <div class="first-singup-title">
        <h2 class="fs-title">Reset Password</h2>
        <h3 class="fs-subtitle">
        <?php if(!($old_error=="")){?>
                <div class="danger-error-error">
                    <p style="color:#faa1a9;">
                        <?php echo $old_error;?>
                    </p>
                </div>
            <?php }?>

            <?php if(!($match_error=="")){?>
                <div class="danger-error-error">
                    <p style="color:#faa1a9;">
                        <?php echo $match_error;?>
                    </p>
                </div>
            <?php }?>

            <?php if(!($new_error=="")){?>
                <div class="danger-error-error">
                    <p style="color:#faa1a9;">
                        <?php echo $new_error;?>
                    </p>
                </div>
            <?php }?>

            <?php if(!($char_error=="")){?>
                <div class="danger-error-error">
                    <p style="color:#faa1a9;">
                        <?php echo $char_error;?>
                    </p>
                </div>
            <?php }?>

            <?php if(!($first_change=="")){?>
                <div class="danger-error-error">
                    <p style="color:#faa1a9;">
                        <?php echo $first_change;?>
                    </p>
                </div>
            <?php }?>
        </h3>
   </div>
   
   <div class="f_l_name">
        <div class="fl_name">
            <input type="password" name="old" placeholder="*Old Password" required  />
        </div>
   </div>

   <div class="f_l_name">
        <div class="fl_name">
            <input type="password" name="new" placeholder="*New Password" required  />
        </div>
   </div>
    


  <div class="f_l_name">
        <div class="fl_name">
            <input type="password" name="confirm" placeholder="*Confirm Password" required />
        </div>
   </div>
 
  <div class="fullfill-link" style="margin-top:-25px;">
    <input type="submit" name="submit" class="next action-button" value="Submit">
  </div>

  </fieldset>
    </form>
    <!--Footer-->
	
 

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