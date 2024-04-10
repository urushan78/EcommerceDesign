<?php
    session_start();

    include '../connect.php';
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Customer'){
        if(isset($_POST['oldpw']) && isset($_POST['newpw']) && isset($_POST['c_newpw'])){
            function validate($data){
                $data= trim($data);
                $data= stripslashes($data);
                $data= htmlspecialchars($data);

                return $data;
            }

            $oldpw = validate($_POST['oldpw']);
            $newpw = validate($_POST['newpw']);
            $c_newpw = validate($_POST['c_newpw']);

            if(empty($oldpw)){
                header("Location: chgpw.php?error=Please enter your current password");
                exit();
            }else if(empty($newpw)){
                header("Location: chgpw.php?error=Please enter a new password"); 
                exit();
            }elseif($newpw =! $c_newpw){
                header("Location: chgpw.php?error=Your passwords donot match");
                exit();
            }else{
                $oldpw = md5($oldpw);
                $newpw = md5($newpw);
                $id = $_SESSION['id'];

                $query= "SELECT PASSWORD FROM USER_WEBSITE WHERE ID_USERS='$id' AND PASSWORD='$oldpw'";
                $result= oci_parse($conn, $query);
                oci_execute($result);

                if(oci_fetch_assoc($result) == TRUE){
                    echo "correct";
                }else{
                    header("Location: chgpw.php?error=Incorrect Password"); 
                    exit();
                }
            }

        }else{
            header("Location: chgpw.php");
        }
    }
?>