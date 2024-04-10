<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role']!='Customer'){
    header("location:../test/extra/login.php");
}
?>