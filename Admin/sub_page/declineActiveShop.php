<?php   
    include '../../connect.php';
    session_start();
    $shoptype="";
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Admin')
    {
        header("location:../../Session/login.php"); 
    }
    if(isset($_GET['decline']))
    {
        $id = $_GET['decline'];
         $query = oci_parse($conn,"DELETE FROM TRADER_SHOP WHERE SHOP_NO = '$id'");
            $execute = oci_execute($query);

            if($execute)
            {
                
                header('location:../adminShopRequest.php?remove="decline"');
            }
    }
   
?>