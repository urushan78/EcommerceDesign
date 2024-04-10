<?php
    include '../../connect.php';
    $match = "";
    $length = "";
    if(isset($_GET['change']))
    {
        $id= $_GET['change'];
    }

    if(isset($_POST['submit']))
    {
        $new = $_POST['new'];
        $confirm = $_POST['confirm'];

        if($new == $confirm)
        {
            if($new>=8)
            {
                $password = password_hash($new,PASSWORD_DEFAULT );

                $update = oci_parse($conn,"UPDATE USER_WEBSITE SET PASSWORD = '$password' WHERE ID_USERS='$id'");
                $run = oci_execute($update); 

                if($run)
                {
                    header('location:../login.php?changed="success"');
                }
            }
            else
            {
                $length= "Length should be greater then 8 characters";
            }
        }
        else
        {
            $match="Password Doesn't Match";
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" type="text/css" href="../../css/Trader/trader_signup.css">
    <link rel="stylesheet" type="text/css" href="../../css/Customer/nav.css">
</head>
<body>
    

    <form id="msform" action="" method="POST" style="max-width: 550px; margin-top:120px;">
    <fieldset>
    <div class="first-singup-title">
        <h2 class="fs-title">OTP Verification</h2>
        <h3 class="fs-subtitle" style="color:#7F2E36;">
            <?php if($match!="")
                {
                    echo $match;
                }
            ?>

            <?php if($length!="")
                {
                    echo $length;
                }
            ?>
        </h3>
   </div>
   

   <div class="f_l_name">
        <div class="fl_name">
            <input type="password" name="new" placeholder="*Enter password" required"/>
        </div>
   </div>

   <div class="f_l_name">
        <div class="fl_name">
            <input type="password" name="confirm" placeholder="*Confirm password" required"/>
        </div>
   </div>
    
   
  <div class="fullfill-link" style="margin-top:-25px;">
    <input type="submit" name="submit" class="next action-button" value="Submit">
  </div>
  </fieldset>
    </form>

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