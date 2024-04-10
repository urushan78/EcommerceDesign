<?php
    include '../../connect.php';
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Trader')
        {
            header("location:../../Session/login.php"); 
        }

    if($_SESSION['log']==0)
    {
        header('location:../../Session/signup_extra/resetPassword.php?sess="first"');
    }

    $id= $_SESSION['id'];

    


    if(isset($_POST['submit'])){

        $file = $_FILES["image"]["name"];

        $Name = $_POST['Name'];
        $Price = $_POST['Price'];

        if(empty($_POST['Discount']))
        {
            $Discount = 0;
        }
        else
        {
            $Discount = $_POST['Discount'];
        }
        
        $Manufacture_date= $_POST['Manufacture_date'];
        $Expiry_date = $_POST['Expiry_date'];
        $Quantity = $_POST['Quantity'];
        $Available = $_POST['Available'];
        $Maximum_order = $_POST['Maximum_order'];
        $Minimum_order = $_POST['Minimum_order'];
        $Description = $_POST['Description'];
        $shopNo = $_POST['shoptype'];

        $Category="";

        $query= oci_parse($conn, "SELECT * FROM TRADER_SHOP WHERE SHOP_NO = '$shopNo'");
        $run = oci_execute($query);
        if($run)
        {
            $row= oci_fetch_row($query);

            $Category= $row['3'];
        }
    }

    $query ="INSERT INTO PRODUCT_REQ 
    ( NAME, PRICE, DISCOUNT, MANUFACTURE_DATE, EXPIRY_DATE, QUANTITY, AVAILABLE, MAXIMUM_ORDER, MINIMUM_ORDER, DESCRIPTION, CATEGORY, IMAGE,TRADER_INFO,SHOP_INFO) 
    VALUES ('$Name', '$Price','$Discount',to_date(:Manufacture_date, 'YY/MM/DD'),to_date(:Expiry_date, 'YY/MM/DD'), '$Quantity','$Available',$Maximum_order,$Minimum_order, '$Description','$Category', '$file', $id, $shopNo)";

    $execute= oci_parse($conn,$query);
    oci_bind_by_name($execute, ":Manufacture_date",$Manufacture_date);
    oci_bind_by_name($execute, ":Expiry_date",$Expiry_date);
    

    $run=oci_execute($execute);
    
    if($run){
        header("location: ../traderproduct.php?insert='success'");
        
    }else{
        echo "error please try again";
        echo "<a href=\"../traderproduct.php\">Go Back</a>";
    }
?>