<?php 

 include '../connect.php';
 session_start();

 if(isset($_POST['pay']))
 {
     if(!isset($_SESSION['role']) || $_SESSION!= 'Customer')
     {
        echo "<script> 
            alert('You need to be logged in first');
            window.location.href='../Session/login.php?manage=\"manage\"';
            </script>";
     }

     else
     {
         header('location: managecart.php');
     }
 }

?>