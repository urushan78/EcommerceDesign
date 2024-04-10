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

    if(isset($_GET['delete']))
    {
        $id = $_GET["delete"];
        $delete = "DELETE FROM TRADER_SHOP WHERE SHOP_NO = '$id' ";

        $result = oci_parse($conn, $delete);
        $run= oci_execute($result);

        if($run)
        {
            header("location: ../traderShop.php?delete1='success'");
        }
        
    }
?>
