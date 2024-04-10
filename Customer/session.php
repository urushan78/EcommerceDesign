<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role']!='Customer'){
    header("location:../Session/login.php");
}
?>