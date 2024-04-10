<?php
session_start();
    include '../connect.php';

    $REVIEW_ID = $_GET["REVIEW_ID"];

    $delete = "DELETE FROM REVIEW WHERE REVIEW_ID = ".$REVIEW_ID." ";
    $result = oci_parse($conn, $delete);
    oci_execute($result);

    $pid=$_GET['PRODUCT_ID'];

    header("location: productview.php?PRODUCT_ID=$pid"); 
?>