<?php
    include '../connect.php';
    
    session_start();

    $editdetails = "SELECT * FROM USER_WEBSITE WHERE ID_USERS='$_GET[ID_USERS]'";
    $values = oci_parse($conn, $editdetails);
    oci_execute($values);

    $eachrow = oci_fetch_assoc($values);    

    if(isset($_POST['update'])){
        $query="UPDATE USER_WEBSITE SET USER_NAME='$_POST[fname]', EMAIL='$_POST[emailad]', PHONE='$_POST[phoneno]' WHERE ID_USERS='$_SESSION[id]'";
        $result=oci_parse($conn, $query);
        oci_execute($result);

        echo "<script> 
            alert('You have successfully changed your details. Please login again to view them.');
            window.location.href='../Session/login.php';
        </script>";
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

    <style>
        #msform .action-button {
            width:150px;
        }
    </style>
</head>
<body>
        <h3 style="text-align:center; margin:20px 0 0 0">Manage Your Account</h3>  
        
        <?php
            if(isset($_SESSION['role']) && ($_SESSION['role'])=='Customer'){
        ?>
            <form id="msform" action="" method="post" style="width:600px">
                <fieldset>
                    <div class="details">
                        <div class="fl_name">
                            <label for="name">Full Name</label>
                            <input type="text" name="fname" value="<?php echo $_SESSION['name']; ?>">

                            <div class="fl_name">
                                <label for="email">Email Address</label>
                                <input type="text" name="emailad" value="<?php echo $eachrow['EMAIL'];?>">
                            </div>
                        </div>

                        <div class="fl_name">
                            <label for="phone">Contact Number</label>
                            <input type="text" name="phoneno" value="<?php echo $eachrow['PHONE']; ?>">
                        </div>

                        <a href="chgpw.php">Change Password</a>
                        <div class="fullfill-link">
                            <input type="submit" name="update" class="next action-button" value="Save Changes">
                            <a href="landing.php"><input type="button" class="next action-button" value="Cancel"> </a>
                        </div>
                    </div>
                </fieldset>
            </form>
        <?php
            }
        ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/5cd602dbbe.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
    <?php
        include 'footer.php';
    ?>
</html>