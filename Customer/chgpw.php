<?php
    include '../connect.php';
    session_start();
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
        <h5 style="text-align:center; margin:30px 0 0 0">Change Your Password</h5>

        <form id="msform" action="changepw.php" method="post" style="width:500px">
            <fieldset>
                <?php
                    if(isset($_GET['error'])){
                ?>
                <p class="error"><?php echo $_GET['error'];?></p>
                <?php
                    }
                ?>
                <div class="fl_name">
                    <input type="password" name="oldpw" placeholder="Enter Current Passowrd">
                    <input type="password" name="newpw" placeholder="Enter New Passowrd">
                    <input type="password" name="c_newpw" placeholder="Confirm New Passowrd">
                </div>
                <div class="fullfill-link">
                    <input type="submit" name="change" class="next action-button" value="Save Changes">
                    <a href="customerdetail.php"><input type="button" class="next action-button" value="Go Back"> </a>
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
    </body>
    <?php
        include 'footer.php';
    ?>
</html>