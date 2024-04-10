<?php
    Session_start();

    Session_unset();

    session_destroy();

    if(isset($_GET['nouser']))
    {
        header("location: ../../landing.php"); 
    }
    else
    {
        header("location: ../login.php");
    }

?>