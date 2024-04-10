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
    if(isset($_GET['PRODUCT_ID']))
    {
        $PRODUCT_ID = $_GET['PRODUCT_ID'];
    }
    
    if(isset($_POST['submit']))
    {
        
        $file = $_FILES["image"]["name"];
        $Name = $_POST['Name'];
        $Price = $_POST['Price'];
        $Discount = $_POST['Discount'];
        $Manufacture_date= $_POST['Manufacture_date'];
        $Expiry_date = $_POST['Expiry_date'];
        $Quantity = $_POST['Quantity'];
        $Available = $_POST['Available'];
        $Maximum_order = $_POST['Maximum_order'];
        $Minimum_order = $_POST['Minimum_order'];
        $Description = $_POST['Description'];
        $shopNo = $_POST['shoptype'];

        $query= oci_parse($conn, "SELECT * FROM TRADER_SHOP WHERE SHOP_NO = '$shopNo'");
        $run = oci_execute($query);
        if($run)
        {
            $row= oci_fetch_row($query);

            $Category= $row['3'];
            echo $Category;
        }

        echo $Category;

        $query="UPDATE PRODUCT SET 
        Name='$Name',
        CATEGORY='$Category', 
        Price=$Price, 
        Discount='$Discount', 
        Manufacture_date= to_date(:Manufacture_date, 'YY/MM/DD'), 
        Expiry_date=to_date(:Expiry_date, 'YY/MM/DD'), 
        Quantity='$Quantity', 
        Available='$Available', 
        Maximum_order=$Maximum_order, 
        Minimum_order=$Minimum_order, 
        Description='$Description',
        IMAGE = '$file',
        SHOP_INFO = $shopNo
        WHERE Product_ID=$PRODUCT_ID";
        $execute= oci_parse($conn, $query);

        echo $Category;
        oci_bind_by_name($execute, ":Manufacture_date",$Manufacture_date);
        oci_bind_by_name($execute, ":Expiry_date",$Expiry_date);

        $run=oci_execute($execute);

        if($run)
        {
            header("location:../traderProduct.php?edit='edit'");
        }
    }

?>
<html>
    <head> 
        <title>Add Product Page </title> 
        <link rel="stylesheet" type="text/css" href="../../css/Trader/productadd.css">
    </head>
    <body> 
        <div class="ptitle">
            <h2> Edit Product </h2>
        </div>  
    <?php
        if(isset($_GET['PRODUCT_ID']))
        {
            $PRODUCT_ID=$_GET['PRODUCT_ID'];

            $execute=oci_parse($conn,"SELECT * FROM PRODUCT WHERE PRODUCT_ID='$PRODUCT_ID' AND STATUS = 'Enable'");
            $run = oci_execute($execute);

            if($run)
            {
                $cell=oci_fetch_row($execute);
            }
        }
   ?>
        <div class="pdetails">
            <form method="post" action="" enctype="multipart/form-data">  
                <div>
                    <input type="text" id="pname" name="Name" placeholder="Product Title" required value="<?php echo $cell['1'];?>"><br><br>
                    
                    <div class="align">
                        <div id="leftAlign">
                            Price <br> <input type="text" name="Price" required value="<?php echo $cell['2'];?>"> <br><br>
                            Manufacture Date <br> <input type="date" name="Manufacture_date" placeholder="mm/dd//yy" required value="<?php echo $cell['4'];?>"> <br><br>
                            
                            Quantity <br>
                            <input type="number" name="Quantity" min="1" max="50" required value="1" value="<?php echo $cell['6'];?>" > <br><br> 
                    
                            <div>
                                Maximum Order <br>
                                <input type="number" name="Maximum_order" min="1" max="20" required value="20" value="<?php echo $cell['8'];?>" > <br><br>
                            </div>  
                        </div>

                        <div id="rightAlign">

                            Discounted Price <br> <input type="text" name="Discount" placeholder="[Hint: Write a numeric number]" value="<?php echo $cell['3'];?>"> <br><br>

                            Expiry Date <br> <input type="date" name="Expiry_date" placeholder="mm/dd//yy" required value="<?php echo $cell['5'];?>"> <br><br>

                            <div class="horiz"> 
                                <label> Available  </label> <br>
                                Yes<input type="radio" name="Available" value="Yes" required <?php if($cell['7']=='Yes'){echo "checked";}?>   >
                                No <input type="radio" id="no" name="Available" value="No"   <?php if($cell['7']=='No'){echo "checked";}?>>
                            </div>
                            <!-- Delete Later
                            <input type="tezt"><br><br> -->

                            <div>
                                Minimum Order
                                <input type="number" name="Minimum_order" min="1" max="1" value="1" required value="<?php echo $cell['9'];?>"> <br><br>
                            </div>
                        </div>
                    </div>

                    <textarea rows="5" cols="40" name="Description" placeholder="Short description of the product..." maxlength="150" required>
                    <?php echo $cell['10'];?>
                    </textarea><br><br>

                    <select name="shoptype" required style="margin-bottom:1em;">
                        <option value="" selected disabled hidden> Select Shop </option>
                        <?php 
                            $query= oci_parse($conn, "SELECT * FROM TRADER_SHOP WHERE TRADER_INFO = '$id'");
                            $run = oci_execute($query);
                            if($run)
                            {

                                while($row=oci_fetch_row($query))
                                {
                        ?>
                        <option value="<?php echo $row['0'];?>" <?php if($row['0']==$cell['0']){echo "selected";}?> ><?php echo $row['1'];?></option>
                        
                        <?php } }?>
                    </select>  
                        

                    <div class="btn">
                        <input type="submit" name="submit" value="Submit">
                        <input type="reset" value="Cancel">
                    </div>

                </div>

                <div id="profilePhoto">
                    <!-- <label> Upload a picture for your product</label> -->
                    <img src="../../image/<?php echo $cell['12'];?>" onclick="triggerclick()" id="photodisplay"/>
                    <input type="file" name="image" onchange="displayimage(this)" id="imageupd" style="display:none;"/> <br><br>   
                </div> 

                

            </form>
            
        </div>
        <script src="../../js/imageUplod.js"></script>
    </body>
</html>
