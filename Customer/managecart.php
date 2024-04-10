<?php 
    session_start();
    include '../connect.php';
    $user_id = $_SESSION['id'];
    if(isset($_GET['unset']))
    {
        $select= oci_parse($conn, "SELECT * FROM CART WHERE TEMP_ID = '12958'");
        $exe = oci_execute($select);

        if($exe)
        {
            $update = oci_parse($conn, "UPDATE CART SET TEMP_ID=0, USER_ID_FK = '$user_id' WHERE TEMP_ID = '12958'");
            $run = oci_execute($update);

            if($run)
            {
                header('location:shoppingCart.php');
            }
        }
    }

    
?>