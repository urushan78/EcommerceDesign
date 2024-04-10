<?php 
include '../connect.php';
if(isset($_GET['del']))
{
    $del = $_GET['del'];

    $delete = oci_parse($conn, "DELETE FROM CART WHERE CART_ID='$del'");
    $qqe = oci_execute($delete); 

    if($qqe)
    {
        header('location:shoppingCart.php?fk=12958');
    }
}

if(isset($_GET['de']))
{
    $de = $_GET['de'];

    $delete = oci_parse($conn, "DELETE FROM CART WHERE CART_ID='$de'");
    $qqe = oci_execute($delete); 

    if($qqe)
    {
        header('location:shoppingCart.php');
    }
}

?>