<?php
    include '../connect.php';
    session_start();

    if(isset($_SESSION['role']) && ($_SESSION['role'])=='Customer'){
        $username = $_SESSION['name'];
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            if(isset($_POST['pay'])){
                $query = "INSERT INTO ORDER_DETAILS(ORDER_ID, PRODUCT_ORDERED, ORDER_DATE, PRODUCT_QUANTITY, ORDERED_BY) VALUES (null, '$_POST[productname]',SYSDATE ,'$_POST[quantity]', '$username')";
                $result = oci_parse($conn, $query);
                oci_execute($result);

                echo "ORDER PLACED!";

            }
        }
    }else{
        echo "<script> 
            alert('Please login before placing your orders');
            window.location.href='../Session/login.php';
        </script>";
    }

?>