<?php 
session_start();
include '../connect.php';
if(isset($_POST['add']))
{
    $quanity = $_POST['num'];
    $pro = $_POST['pid'];

    $select= oci_parse($conn,"SELECT * FROM CART");
    $run = oci_execute($select);
    if($run)
    {

        if(!isset($_SESSION['id']))
        {
         
            $ff = oci_parse($conn, "SELECT * FROM PRODUCT WHERE PRODUCT_ID='$pro'");
            $rr = oci_execute($ff);

            if($ff)
            {
                $mm= oci_fetch_assoc($ff); 

                $price = $mm['PRICE'];
                $fake = 12958;
           
                $insert = oci_parse($conn,"INSERT INTO CART(PRODUCT_ID_FK, QUANITITY, TEMP_ID,PRICE) VALUES($pro, $quanity, $fake, $price)");
                $maybe = oci_execute($insert);

                if($maybe)
                {
                    header('location:shoppingCart.php?fk='.$fake);
                }
            }
            
        }

        elseif(isset($_SESSION['id']))
        {
            $ff = oci_parse($conn, "SELECT * FROM PRODUCT WHERE PRODUCT_ID='$pro'");
            $rr = oci_execute($ff);

            if($ff)
            {
                $mm= oci_fetch_assoc($ff); 

                $price = $mm['PRICE'];
                $userid = $_SESSION['id'];

                $insert1 = oci_parse($conn,"INSERT INTO CART(USER_ID_FK,PRODUCT_ID_FK, QUANITITY, TEMP_ID,PRICE) VALUES($userid,$pro, $quanity, 0,$price)");
                $maybe1 = oci_execute($insert1);

                if($maybe1)
                {
                    header('location:shoppingCart.php');
                }
            }
        }
    }

}

?>