<?php
    include '../../connect.php';

    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Trader')
        {
            header("location:../../Session/login.php"); 
        }

    if($_SESSION['log']==0)
    {
        header('location:../../Session/signup_extra/resetPassword.php?sess="first"');
    }

    if(isset($_GET['PRODUCT_ID']))
    {
        $Product_ID = $_GET["PRODUCT_ID"];
        $delete = "DELETE FROM PRODUCT_REQ WHERE PRODUCT_ID = '$Product_ID' AND STATUS = 'Enable'";

        $result = oci_parse($conn, $delete);
        $run= oci_execute($result);

        if($run)
        {
            header("location: ../traderproduct.php?delete='success'");
        }
        
    }
?>
