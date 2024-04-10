<?php
    include '../connect.php';

    session_start();
    $count =0;
    if(isset($_GET['fk']))
    {
        $here = oci_parse($conn, "SELECT * FROM CART WHERE TEMP_ID = '12958'");
        $ram = oci_execute($here);

        if($ram)
        {
            while(oci_fetch_row($here))
            {
                $count++;
            }
        }
    }
    elseif(!isset($_SESSION['id']))
    {
        $here = oci_parse($conn, "SELECT * FROM CART WHERE TEMP_ID = '12958'");
        $ram = oci_execute($here);

        if($ram)
        {
            while(oci_fetch_row($here))
            {
                $count++;
            }
        }
    }
    else
    {
        $id = $_SESSION['id'];
        $here = oci_parse($conn, "SELECT * FROM CART WHERE USER_ID_FK = '$id'");
        $ram = oci_execute($here);

        if($ram)
        {
            while(oci_fetch_row($here))
            {
                $count++;
            }
        }
    }
    
    if(isset($_POST['update']))
    {
        $qty = $_POST['qty']; 
        $hid = $_POST['hid'];
        $price = $_POST['price'];

        $tolq = $price * $qty;
        $update = oci_parse($conn,"UPDATE CART SET QUANITITY= '$qty', PRICE='$tolq'  WHERE CART_ID='$hid'");
        $ahead = oci_execute($update);

    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title> Shopping Cart </title>
    </head>
    <body>
    <?php
        include 'navbar.php';
    ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 style="margin:100px 0 20px 0;"> Shopping Basket </h2>
                    <h5 style="margin-bottom:30px;"> Number of Items: <?php echo $count;?></h5>
                </div>

                <div class="container">
                    <table class="table">
                        <thead class="text-center">
                            <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Operation</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">

                            <?php 
                                
                                if(isset($_GET['fk']))
                                {
                                    $qnq =0;
                                    $total=0;
                                    $value = $_GET['fk'];
                            
                                    $select = oci_parse($conn,"SELECT * FROM CART WHERE TEMP_ID='$value'");
                                    $exe = oci_execute($select);
                            
                                    if($exe)
                                    {
                                        while($gg = oci_fetch_assoc($select))
                                        {
                                            $pid = $gg['PRODUCT_ID_FK'];
                                            
                                            $again = oci_parse($conn,"SELECT * FROM PRODUCT WHERE PRODUCT_ID='$pid'");
                                            $e = oci_execute($again);

                                            if($e)
                                            {
                                                $begin = oci_fetch_assoc($again);
                                    ?>
                                        <tr>
                                            <td><img src="../image/<?php echo $begin['IMAGE'];?>" alt="" width="60px" height="60px" /> <p><?php echo $begin['NAME'];?></p></td>
                                            <td style="padding-top:28px;">&pound<?php echo $begin['PRICE'];?></td>
                                            <td style="padding-top:28px;">
                                               <form action="" method="POST">
                                               <input type="hidden" name="hid" value="<?php echo $gg['CART_ID'];?>">
                                                <input type="number" min="1" max="20"name="qty" value="<?php echo $gg['QUANITITY'];?>" style="width:50px; text-align:center;">
                                                <input type="submit" name="update" value="Update" style="font-size:12px; ">
                                               </form>
                                            </td>
                                            <td style="padding-top:28px;">&pound<?php $tol = $begin['PRICE']*$gg['QUANITITY']; echo $tol; ?></td>
                                            <td style="padding-top:28px;"><a href="deleteCart.php?del=<?php echo $gg['CART_ID'];?>"><i class="fas fa-trash"></i></a></td>
                                        </tr>
                                    <?php
                                        $qnq = $qnq + $gg['QUANITITY'];
                                        if($qnq>20)
                                        {
                                            echo "<script> 
                                                alert('Quantity Limit Exceded. (Maximum Limit: 20)');
                                                window.location.href='shoppingCart.php';
                                                </script>";
                                        }
                                        $total = $total +$tol;
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    $total=0;
                                    $qnq = 0;
                                    $id = $_SESSION['id'];

                                    $select = oci_parse($conn,"SELECT * FROM CART WHERE USER_ID_FK='$id'");
                                    $exe = oci_execute($select);
                            
                                    if($exe)
                                    {
                                        while($gg = oci_fetch_assoc($select))
                                        {
                                            $pid = $gg['PRODUCT_ID_FK'];
                                            
                                            $again = oci_parse($conn,"SELECT * FROM PRODUCT WHERE PRODUCT_ID='$pid'");
                                            $e = oci_execute($again);

                                            if($e)
                                            {
                                                $begin = oci_fetch_assoc($again);
                                        ?>
                                        <tr>
                                            <td><img src="../image/<?php echo $begin['IMAGE'];?>" alt="" width="60px" height="60px" /> <p><?php echo $begin['NAME'];?></p></td>
                                            <td style="padding-top:28px;">&pound<?php echo $begin['PRICE'];?></td>
                                            <td style="padding-top:28px;">
                                               <form action="" method="POST">
                                               <input type="hidden" name="hid" value="<?php echo $gg['CART_ID'];?>">
                                               <input type="hidden" name="price" value="<?php echo $begin['PRICE'];?>">
                                                <input type="number" min="1" max="20"name="qty" value="<?php echo $gg['QUANITITY'];?>" style="width:50px; text-align:center;">
                                                <input type="submit" name="update" value="Update" style="font-size:12px; ">
                                               </form>
                                            </td>
                                            <td style="padding-top:28px;">&pound<?php $tol = $begin['PRICE']*$gg['QUANITITY']; echo $tol; ?></td>
                                            <td style="padding-top:28px;"><a href="deleteCart.php?de=<?php echo $gg['CART_ID'];?>"><i class="fas fa-trash"></i></a></td>
                                        </tr>
                                    <?php
                                        $qnq = $qnq + $gg['QUANITITY'];
                                        if($qnq>20)
                                        {
                                            echo "<script> 
                                                alert('Quantity Limit Exceded. (Maximum Limit: 20)');
                                                window.location.href='shoppingCart.php';
                                                </script>";
                                        }
                                        $total = $total +$tol;
                                            }
                                        }
                                   }   
                                }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="container" style="display:flex;  justify-content: flex-end;">
            <div class="amttag" style="">
                <h4 style="padding:12px 0;"> Quanity: <?php echo $qnq;?></h4>
                <h4 style="padding:12px 0; "> Total Amount: &pound<?php echo $total;?></h4>
                
                <?php 
                    if(isset($_GET['fk']))
                    {
                ?>
                <form action="proceedPayment.php" method="post" style="padding:12px 0; padding-bottom:2em;">
                    <input type="submit" name="pay" value="Pay Now">
                </form>
                <?php }
                
                else{?>
                <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" style="padding:12px 0; padding-bottom:2em;">
                    <input type="hidden" name="business" value="sb-h436wj6626094@business.example.com">			
                    <!-- Buy Now button. -->
                    <input type="hidden" name="cmd" value="_xclick">			
                    <!-- Details about the item that buyers will purchase. -->
                    <input type="hidden" name="item_name" value="E-Grocer Basket">
                    <input type="hidden" name="item_number" value="01">
                    <input type="hidden" name="amount" value="<?php echo $total;?>">
                    <input type="hidden" name="currency_code" value="GBP">	
                    
                    <input type='hidden' name='cancel_return' value='http://localhost/test/Customer/cancle.php'>
			        <input type='hidden' name='return' value='http://localhost//test/Customer/sucess.php?total=<?php echo $total;?> '>			
                    <!-- URLs -->
                    <input type="submit" name="submit" Value="Buy Now">
                </form>
                <?php }?>
            </div>
        </div>

   <!--Footer-->
   <?php
    include 'footer.php';
   ?>
 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/5cd602dbbe.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
</html>