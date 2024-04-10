<?php
    session_start();
    include '../connect.php';
    $user_id = $_SESSION['id'];
    if(isset($_GET['total']))
    {
        $total= $_GET['total'];             
    }

    if(isset($_POST['send']))
    {
        $date = $_POST['date'];
        header('location:timeSlot.php?date="'.$date.'"&total='.$total);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection Slot</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" type="text/css" href="../css/Trader/trader_signup.css">
    <link rel="stylesheet" type="text/css" href="../css/Customer/nav.css">
    <link rel="stylesheet" type="text/css" href="../css/Customer/footer.css">
</head>
<body>
    
    <form id="msform" action="" method="POST" style="max-width: 850px;">
    <input type="hidden" name="total" value="<?php echo $total;?>">
    <fieldset>
    <div class="first-singup-title">
        <h2 class="fs-title">Collection Slot</h2>
        <h3 class="fs-subtitle">
        Select Date <br><br>
        Today: <?php echo date("l M/d/Y")?>
        </h3>
   </div>
   
  <div class="f_l_name">
        <div class="fl_name">
            <select name="date" required>
            <option value="" selected disable hidden >Slot Date:</option>
            <?php
                date_default_timezone_set('Asia/Kathmandu');
                $today = date("l");
                $time = date("H"); 
                $set ='';
                if($today=='Monday')
                {
                    $suggs1= date("l M/d/Y", strtotime("+2 day"));
                    echo "<option value=\"$suggs1\" > $suggs1</option>";
                    $suggs2= date("l M/d/Y", strtotime("+3 day"));
                    echo "<option value=\"$suggs2\"> $suggs2</option>";
                    $suggs3= date("l M/d/Y", strtotime("+4 day"));
                    echo "<option value=\"$suggs3\"> $suggs3</option>";


                }
                elseif($today=='Tuesday' &&$time<19)
                {
                    $suggs1= date("l M/d/Y", strtotime("+1 day"));
                    echo "<option value=\"$suggs1\"> $suggs1</option>";
                    $suggs2= date("l M/d/Y", strtotime("+2 day"));
                    echo "<option value=\"$suggs2\"> $suggs2</option>";
                    $suggs3= date("l M/d/Y", strtotime("+3 day"));
                    echo "<option value=\"$suggs3\"> $suggs3</option>";

                }
                elseif($today=='Tuesday' && $time>=19)
                {
                    $suggs1= date("l M/d/Y", strtotime("+2 day"));
                    echo "<option value=\"$suggs1\"> $suggs1</option>";
                    $suggs2= date("l M/d/Y", strtotime("+3 day"));
                    echo "<option value=\"$suggs2\"> $suggs2</option>";
                    $suggs3= date("l M/d/Y", strtotime("+8 day"));
                    echo "<option value=\"$suggs3\"> $suggs3</option>";

                }
                elseif($today=='Wednesday' && $time<19)
                {
                    $suggs1= date("l M/d/Y", strtotime("+1 day"));
                    echo "<option value=\"$suggs1\"> $suggs1</option>";
                    $suggs2= date("l M/d/Y", strtotime("+2 day"));
                    echo "<option value=\"$suggs2\"> $suggs2</option>";
                    $suggs3= date("l M/d/Y", strtotime("+7 day"));
                    echo "<option value=\"$suggs3\"> $suggs3</option>";
                }
                elseif($today=='Wednesday' && $time>=19)
                {
                    $suggs1= date("l M/d/Y", strtotime("+2 day"));
                    echo "<option value=\"$suggs1\"> $suggs1</option>";
                    $suggs2= date("l M/d/Y", strtotime("+7 day"));
                    echo "<option value=\"$suggs2\"> $suggs2</option>";
                    $suggs3= date("l M/d/Y", strtotime("+6 day"));
                    echo "<option value=\"$suggs3\"> $suggs3</option>";
                }
                elseif($today=='Thursday' && $time<19)
                {
                    $suggs1= date("l M/d/Y", strtotime("+1 day"));
                    echo "<option value=\"$suggs1\"> $suggs1</option>";
                    $suggs2= date("l M/d/Y", strtotime("+6 day"));
                    echo "<option value=\"$suggs2\"> $suggs2</option>";
                    $suggs3= date("l M/d/Y", strtotime("+7 day"));
                    echo "<option value=\"$suggs3\"> $suggs3</option>";
                }
                elseif($today=='Thursday' && $time>=19)
                {
                    $suggs1= date("l M/d/Y", strtotime("+6 day"));
                    echo "<option value=\"$suggs1\"> $suggs1</option>";
                    $suggs2= date("l M/d/Y", strtotime("+7 day"));
                    echo "<option value=\"$suggs2\"> $suggs2</option>";
                    $suggs3= date("l M/d/Y", strtotime("+8 day"));
                    echo "<option value=\"$suggs3\"> $suggs3</option>";
                }
                elseif($today=='Friday')
                {
                    $suggs1= date("l M/d/Y", strtotime("+5 day"));
                    echo "<option value=\"$suggs1\"> $suggs1</option>";
                    $suggs2= date("l M/d/Y", strtotime("+6 day"));
                    echo "<option value=\"$suggs2\"> $suggs2</option>";
                    $suggs3= date("l M/d/Y", strtotime("+7 day"));
                    echo "<option value=\"$suggs3\"> $suggs3</option>";
                }
                elseif($today=='Saturday')
                {
                    $suggs1= date("l M/d/Y", strtotime("+4 day"));
                    echo "<option value=\"$suggs1\"> $suggs1</option>";
                    $suggs2= date("l M/d/Y", strtotime("+5 day"));
                    echo "<option value=\"$suggs2\"> $suggs2</option>";
                    $suggs3= date("l M/d/Y", strtotime("+6 day"));
                    echo "<option value=\"$suggs3\"> $suggs3</option>";
                }
                elseif($today=='Sunday')
                {
                    $suggs1= date("l M/d/Y", strtotime("+3 day"));
                    echo "<option value=\"$suggs1\"> $suggs1</option>";
                    $suggs2= date("l M/d/Y", strtotime("+4 day"));
                    echo "<option value=\"$suggs2\"> $suggs2</option>";
                    $suggs3= date("l M/d/Y", strtotime("+5 day"));
                    echo "<option value=\"$suggs3\"> $suggs3</option>";
                }
?>
            </select>
        </div>
   </div>

   
  <div class="fullfill-link" style="margin-top:-25px;">
    <input type="submit" name="send" value="Submit">
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/5cd602dbbe.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


</body>
</html>
