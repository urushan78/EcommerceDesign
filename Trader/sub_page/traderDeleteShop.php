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
        if(($_GET['count'])>0)
        {
            echo "<script> 
            alert('You need to delete the product first');
            window.location.href='../traderShop.php';
            </script>";
        }
        else
        {
            $id = $_GET["delete"];
            $delete = "DELETE FROM REQUEST_SHOP WHERE PAN_NUMBER = '$id' ";

            $result = oci_parse($conn, $delete);
            $run= oci_execute($result);

            if($run)
            {
                header("location: ../traderShop.php?delete='success'");
            }
        

        }
            }
?>
