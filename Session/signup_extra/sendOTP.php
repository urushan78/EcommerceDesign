<?php 
    include '../../connect.php';

    if(isset($_GET['cid']))
    {
        $cid = $_GET['cid']; 

        $query = oci_parse($conn,"SELECT * FROM USER_WEBSITE WHERE ID_USERS='$cid'");
        $run = oci_execute($query); 

        if($run)
        {
            $row= oci_fetch_assoc($query);

            $email =$row['EMAIL'];
            $name =$row['USER_NAME'];



            function rand_string( $length ) 
            {
                $chars = "0123456789";
                return substr(str_shuffle($chars),0,$length);
            }
            
            $otp =  rand_string(5);

            $query = oci_parse($conn,"UPDATE USER_WEBSITE SET OTP = '$otp', LOG=1 WHERE ID_USERS = '$cid'");
            $complete = oci_execute($query);

            if($complete)
            {
                $to= $email;
                $subject = "OTP VERIFICATION";
                $message = "Hello ".$name.",\r\n\r\nPlease follow up on your OTP code.";
                $message .= "\r\n\r\n\r\nOTP: ".$otp;
                $header = "Form: E-Grocer Basket"; 
                $mail = mail($to, $subject, $message, $header);
                
                if($mail)
                {
                    header('location:verifyOTP.php?cid='.$cid);
                }
                else
                {
                    header('location:logout.php?nouser="nouser"');
                }
            }
        }
    }

?>