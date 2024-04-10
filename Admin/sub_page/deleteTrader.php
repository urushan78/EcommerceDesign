<?php
    include '../../connect.php';
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Admin')
        {
            header("location:../../Session/login.php"); 
        }

        if(isset($_GET['approved']))
        {
            $id = $_GET['approved'];
            $query = oci_parse($conn,"DELETE FROM TRADER_REQUEST WHERE TRADER_ID = '$id'");
            $execute = oci_execute($query);

            if($execute)
            {
                
                header('location:../adminTrader.php?approved="approved"');
            }
        }

    if(isset($_GET['delete']))
    {
        $id = $_GET['delete'];
        $query = oci_parse($conn,"DELETE FROM TRADER_REQUEST WHERE TRADER_ID = '$id'");
        $execute = oci_execute($query);

        if($execute)
        {
            
            header('location:../adminTrader.php?all="all"');
        }
    }
?>