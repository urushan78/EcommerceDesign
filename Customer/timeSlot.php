<?php
    session_start();
    include '../connect.php';
    $user_id = $_SESSION['id'];
    date_default_timezone_set('Asia/Kathmandu');
    $today = date("l");
    $time = date("H");


    if(isset($_GET['date']))
    {
        $total= $_GET['total'];
        $date = $_GET['date'];
        if(($result = substr($date, 0, 6))=='Friday')
        {
            $new= 'Fri';
        }
        elseif(($result = substr($date, 0, 8))=='Thursday')
        {
            $new= 'Thu';
        }
        elseif(($result = substr($date, 0, 9))=='Wednesday')
        {
            $new = 'Wed';
        }   
    }
    if(isset($_POST['submit']))
    {
        $time = $_POST['time'];
        $date = $_POST['slot'];
        $add=oci_parse($conn,"INSERT INTO COLLECTION_SLOT(USER_FK,COLLECTION_DATE, COLLECTION_TIME) VALUES ($user_id,'$date','$time')");
        $cont = oci_execute($add);
    
        if($cont)
        {
            $select = oci_parse($conn, "SELECT * FROM COLLECTION_SLOT WHERE USER_FK='$user_id' AND COLLECTION_DATE='$date' AND COLLECTION_TIME='$time'");
            $runner = oci_execute($select);
    
            if($runner)
            {
                $fet= oci_fetch_assoc($select);
    
                $slot = $fet['COLLECTION_ID'];
    
                $ins = oci_parse($conn,"INSERT INTO ORDERS(SLOT_ID) VALUES ($slot)");
                $ok = oci_execute($ins);
    
                if($ok)
                {
                    $osel = oci_parse($conn, "SELECT * FROM ORDERS WHERE SLOT_ID= '$slot'");
                    $ru = oci_execute($osel);
    
                    if($ru)
                    {
                        $fe = oci_fetch_assoc($osel);
    
                        $orders = $fe['ORDERS_ID'];
                    }
                    $query = oci_parse($conn, "SELECT * FROM CART WHERE USER_ID_FK= '$user_id'");   
                    $run = oci_execute($query);
                
                    
                    if($run)
                    {
                        while($row = oci_fetch_assoc($query))
                        {
                            $pid= $row['PRODUCT_ID_FK']; 
                            $qty= $row['QUANITITY']; 
                            $price = $row['PRICE'];
    
    
                            $go = oci_parse($conn, "INSERT INTO ORDER_PRODUCT(PRODUCT_ID_FK, USER_ID_FK, QUANITY, ORDERS_ID_FK,PRICE) VALUES($pid, $user_id, $qty,$orders,$price)");
                            $wait = oci_execute($go);
                
                            if($wait)
                            {
                                $quy = oci_parse($conn, "DELETE FROM CART WHERE PRODUCT_ID_FK = '$pid' AND USER_ID_FK= '$user_id'");   
                                $run = oci_execute($quy);
                            }
                        }  
                
                        $ret = oci_parse($conn, "SELECT * FROM ORDER_PRODUCT WHERE USER_ID_FK = '$user_id'"); 
                        $eesh = oci_execute($ret);
                
                        if($eesh)
                        {
                            while($tte = oci_fetch_assoc($ret))
                            {
                                $pro = $tte['PRODUCT_ID_FK'];
                                $upQty = $tte['QUANITY'];
                                $up = oci_parse($conn, "SELECT * FROM PRODUCT WHERE PRODUCT_ID = '$pro'");
                                $pu = oci_execute($up);
                
                                if($pu)
                                {
                                    $fet = oci_fetch_assoc($up);
                
                                    $oldQty= $fet['QUANTITY'];
                
                                    $newQty = $oldQty -  $upQty; 
                
                                    if($newQty<1)
                                    {
                                        $update = oci_parse($conn, "UPDATE PRODUCT SET QUANTITY=0, OUT_OF_STOCK = 'yes' WHERE PRODUCT_ID='$pro'");
                                        $execute = oci_execute($update);
                                    }
                                    else 
                                    {
                                        $update = oci_parse($conn, "UPDATE PRODUCT SET QUANTITY='$newQty' WHERE PRODUCT_ID='$pro'");
                                        $execute = oci_execute($update);
                                    }
    
                                    $in = oci_parse($conn,"INSERT INTO PAYMENT(USER_FK,ORDER_FK) VALUES($user_id,$orders)");
                                    $un = oci_execute($in);
    
                                    if($un)
                                    {
                                        header('location:billing.php?order='.$orders);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
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
    <fieldset>
    <div class="first-singup-title">
        <h2 class="fs-title">Collection Slot</h2>
        <h3 class="fs-subtitle">
        Selected Date: <?php echo $date?>
        </h3>
   </div>
   <input type="hidden" name="slot" value=<?php echo $_GET['date'];?>>
   <div class="f_l_name">
        <div class="fl_name">
            <select name="time">
              <option value="" selected disable hidden >Slot Time:</option>
              <?php

                    $date = $store_date;
                    $time1='10AM to 01PM';
                    $time2='01PM to 04PM';
                    $time3='04PM to 07PM';
//--------------------------Tuesday------------------------------------------------------------------
                    if($today=='Tuesday' &&$time<10 && $new == 'Wed')
                    {
                        echo "<option value=\"$time1\"> $time1</option>";
                        echo "<option value=\"$time2\"> $time2</option>";
                        echo "<option value=\"$time3\"> $time3</option>";
                    }
                    elseif($today=='Tuesday' &&$time>=10 &&$time<=13  && $new == 'Wed')
                    {
                        echo "<option value=\"$time2\"> $time2</option>";
                        echo "<option value=\"$time3\"> $time3</option>";
                    }
                    elseif($today=='Tuesday' &&$time>=13 &&$time<=16  && $new == 'Wed')
                    {
                        echo "<option value=\"$time3\"> $time3</option>";
                    }
                    elseif($today=='Tuesday' &&$time>=16 &&$time<=19 && $new == 'Wed')
                    {
                        echo "<option value=\"\">No Collection Time Available For Wednesday</option>";
                    }
                    elseif($today=='Tuesday' && $new == 'Thu')
                    {
                        echo "<option value=\"$time1\"> $time1</option>";
                        echo "<option value=\"$time2\"> $time2</option>";
                        echo "<option value=\"$time3\"> $time3</option>";
                    }
                    elseif($today=='Tuesday' && $new == 'Fri')
                    {
                        echo "<option value=\"$time1\"> $time1</option>";
                        echo "<option value=\"$time2\"> $time2</option>";
                        echo "<option value=\"$time3\"> $time3</option>";
                    }

//-----------------------------------Wednesday------------------------------------------------------
                    elseif($today=='Wednesday' &&$time<10 && $new == 'Thu')
                    {
                        echo "<option value=\"$time1\"> $time1</option>";
                        echo "<option value=\"$time2\"> $time2</option>";
                        echo "<option value=\"$time3\"> $time3</option>";
                    }
                    elseif($today=='Wednesday' &&$time>=10 &&$time<=13  && $new == 'Thu')
                    {
                        echo "<option value=\"$time2\"> $time2</option>";
                        echo "<option value=\"$time3\"> $time3</option>";
                    }
                    elseif($today=='Wednesday' &&$time>=13 &&$time<=16  && $new == 'Thu')
                    {
                        echo "<option value=\"$time3\"> $time3</option>";
                    }
                    elseif($today=='Wednesday' &&$time>=16 &&$time<=19 && $new == 'Thu')
                    {
                        echo "<option value=\"\">No Collection Time Available For Thursday</option>";
                    }
                    elseif($today=='Wednesday' && $new == 'Fri')
                    {
                        echo "<option value=\"$time1\"> $time1</option>";
                        echo "<option value=\"$time2\"> $time2</option>";
                        echo "<option value=\"$time3\"> $time3</option>";
                    }
                    elseif($today=='Wednesday' && $new == 'Wed')
                    {
                        echo "<option value=\"$time1\"> $time1</option>";
                        echo "<option value=\"$time2\"> $time2</option>";
                        echo "<option value=\"$time3\"> $time3</option>";
                    }

//-------------------------------Thursday---------------------------------------

                    elseif($today=='Thursday' &&$time<10 && $new == 'Fri')
                    {
                        echo "<option value=\"$time1\"> $time1</option>";
                        echo "<option value=\"$time2\"> $time2</option>";
                        echo "<option value=\"$time3\"> $time3</option>";
                    }
                    elseif($today=='Thursday' &&$time>=10 &&$time<=13  && $new == 'Fri')
                    {
                        echo "<option value=\"$time2\"> $time2</option>";
                        echo "<option value=\"$time3\"> $time3</option>";
                    }
                    elseif($today=='Thursday' &&$time>=13 &&$time<=16  && $new == 'Fri')
                    {
                        echo "<option value=\"$time3\"> $time3</option>";
                    }
                    elseif($today=='Thursday' &&$time>=16 &&$time<=19 && $new == 'Fri')
                    {
                        echo "<option value=\"\">No Collection Time Available For Friday</option>";
                    }

                    elseif($today=='Thursday' && $new == 'Wed')
                    {
                        echo "<option value=\"$time1\"> $time1</option>";
                        echo "<option value=\"$time2\"> $time2</option>";
                        echo "<option value=\"$time3\"> $time3</option>";
                    }
                    elseif($today=='Thursday' && $new == 'Thu')
                    {
                        echo "<option value=\"$time1\"> $time1</option>";
                        echo "<option value=\"$time2\"> $time2</option>";
                        echo "<option value=\"$time3\"> $time3</option>";
                    }

//----------------------------Friday, Saturday, Sunday, Monday-----------------------------------------
                    else
                    {
                        echo "<option value=\"$time1\"> $set</option>";
                        echo "<option value=\"$time1\"> $time1</option>";
                        echo "<option value=\"$time2\"> $time2</option>";
                        echo "<option value=\"$time3\"> $time3</option>";   
                    }
              ?>
            </select>
        </div>
   </div>
   
  <div class="fullfill-link" style="margin-top:-25px;">
    <input type="submit" name="submit" value="Submit">
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
