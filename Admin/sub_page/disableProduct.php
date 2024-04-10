<?php
     include '../../connect.php';
     session_start();
     if(!isset($_SESSION['role']) || $_SESSION['role']!='Admin')
         {
             header("location:../../Session/login.php"); 
         }
         
    if(isset($_GET['delete']))
    {
        $pid=$_GET['delete'];

        $query = oci_parse($conn,"DELETE FROM PRODUCT_REQ WHERE PRODUCT_ID ='$pid'");
        $run = oci_execute($query); 

        if($run)
        {
            header('location:../adminProduct.php?delete="success"');
        }
    }

    if(isset($_GET['disable']))
    {
        $pid=$_GET['disable'];

        $query = oci_parse($conn,"UPDATE PRODUCT SET STATUS = 'DISABLE' WHERE PRODUCT_ID= '$pid'");
        $run = oci_execute($query); 

        if($run)
        {
            header('location:../adminProduct.php?disable="success"');

            $select= oci_parse($conn,"SELECT * FROM PRODUCT WHERE PRODUCT_ID= '$pid' ");
            $connect = oci_execute($select);

            if($connect)
            {
                $row = oci_fetch_row($select);
                $pname = $row['1'];
                $category = $row['11'];
                $sid = $row['14'];
                $tid= $row['13'];

                $select = oci_parse($conn,"SELECT * FROM USER_WEBSITE WHERE ID_USERS = '$tid'");
                $connect = oci_execute($select);

                if($connect)
                {
                    $row = oci_fetch_row($select);
                    $email = $row['3'];
                    $name = $row['1'];
                   
                    $select = oci_parse($conn,"SELECT * FROM TRADER_SHOP WHERE SHOP_NO = '$sid'");
                    $connect = oci_execute($select);
                    if($connect)
                    {
                        $row = oci_fetch_row($select);
                        $shopname = $row['1'];
                        
                        $to= $email;
                        $subject = "Product Disabled";
                        $message = "Hello ".$name.",\r\n\r\nWe have just found you violated our terms and conditions. Thus your product has been disabled\r\n\r\nPlease find the details of your product below.";
                        $message .= "\r\n\r\n\r\nPlease see to it that no such action are committed in the future.";
                        $header = "Form: E-Grocer Basket"; 
                
                        $mail = mail($to, $subject, $message, $header);
                
                        if($mail)
                        {
                            header('location:../adminProduct.php?approved="success"');
                        }
                    }
                    
                }
                
            }
            
        }
        
       

    }
?>

