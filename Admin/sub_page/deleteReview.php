<?php 
 session_start();
 if(!isset($_SESSION['role']) || $_SESSION['role']!='Admin')
     {
         header("location:../../Session/login.php"); 
     }

 include '../../connect.php';

 if(isset($_GET['delete']))
 {
     $review = $_GET['delete'];

     $query = oci_parse($conn, "SELECT *  FROM REVIEW WHERE REVIEW_ID = '$review'");
     $hold = oci_execute($query);

     if($hold)
     {
         $data= oci_fetch_assoc($query);

         $time = $data['REVIEW_DATE'];
         $feedback =  $data['REVIEW'];
         $pro = $data['PRODUCT_ID_FK'];
         $user = $data['USER_ID_FK'];

         $second = oci_parse($conn, "SELECT *  FROM PRODUCT WHERE PRODUCT_ID = '$pro'");
         $make = oci_execute($second);

        if($make)
        {
            $now = oci_fetch_assoc($second);

            $product= $now['NAME'];
        }

     }

     $delete = oci_parse($conn, "DELETE FROM REVIEW WHERE REVIEW_ID = '$review'");
     $run = oci_execute($delete); 

     if($run)
     {
        $select = oci_parse($conn, "SELECT * FROM USER_WEBSITE WHERE ID_USERS = '$user'");
        $work = oci_execute($select); 

        if($work)
        {
            $row = oci_fetch_assoc($select);

            $email = $row['EMAIL'];
            $name = $row['USER_NAME'];


            $to= $email;
            $subject = "Violation of E-Grocer Guidelines";
            $message = "Hello ".$name.",\r\n\r\nWe didn't appreciate the comment you had recently left on ".$time." for ". $product."\r\n\r\n\r\nPlease Note this action is not to be repeated again. Let us create a positive living energy.";
            $header = "Form: E-Grocer Basket"; 
            $mail = mail($to, $subject, $message, $header);
            
            if($mail)
            {
                header('location: ../adminReview.php?delete="done"');
            }
            else
            {
                header('Fail Retry');
            }

        }  
     }
 }
?>