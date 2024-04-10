<?php
    include '../../connect.php';
    session_start();
    $shoptype="";
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Trader')
        {
            header("location:../../Session/login.php"); 
        }

    if($_SESSION['log']==0)
    {
        header('location:../../Session/signup_extra/resetPassword.php?sess="first"');
    }

    $id= $_SESSION['id'];
    
?>
<html>
    <head> 
        <title>Add Product Page </title> 
        <link rel="stylesheet" type="text/css" href="../../css/Trader/productadd.css">
    </head>
    <body> 
        <div class="ptitle">
            <h2> Add Product </h2>
        </div>  
    
        <div class="pdetails">
            <form method="post" action="pinsert.php" enctype="multipart/form-data">  
                <div>
                    <input type="text" id="pname" name="Name" placeholder="Product Title" required><br><br>
                    
                    <div class="align">
                        <div id="leftAlign">
                            Price <br> <input type="text" name="Price" required> <br><br>
                            Manufacture Date <br> <input type="date" name="Manufacture_date" placeholder="mm/dd//yy" required> <br><br>
                            
                            Quantity <br>
                            <input type="number" name="Quantity" min="1" max="50" required value="1"> <br><br> 
                    
                            <div>
                                Maximum Order <br>
                                <input type="number" name="Maximum_order" min="1" max="20" required value="20"> <br><br>
                            </div>  
                        </div>

                        <div id="rightAlign">

                            Discounted Price <br> <input type="text" name="Discount" placeholder="[Hint: Write a numeric number]"> <br><br>

                            Expiry Date <br> <input type="date" name="Expiry_date" placeholder="mm/dd//yy" required> <br><br>

                            <div class="horiz"> 
                                <label> Available  </label> <br>
                                Yes<input type="radio" name="Available" value="Yes" required>
                                No <input type="radio" id="no" name="Available" value="No">
                            </div>
                            <!-- Delete Later
                            <input type="tezt"><br><br> -->

                            <div>
                                Minimum Order
                                <input type="number" name="Minimum_order" min="1" max="1" value="1" required> <br><br>
                            </div>
                        </div>
                    </div>

                    <textarea rows="5" cols="40" name="Description" placeholder="Short description of the product..." maxlength="150" required></textarea><br><br>

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
                        <option value="<?php echo $row['0'];?>"><?php echo $row['1'];?></option>
                        
                        <?php } }?>
                    </select>  
                        

                    <div class="btn">
                        <input type="submit" name="submit" value="Submit">
                        <input type="reset" value="Cancel">
                    </div>

                </div>

                <div id="profilePhoto">
                    <!-- <label> Upload a picture for your product</label> -->
                    <img src="../../image/account-default-image.jpg" onclick="triggerclick()" id="photodisplay"/>
                    <input type="file" name="image" onchange="displayimage(this)" id="imageupd" style="display:none;"/> <br><br>   
                </div> 

            </form>
            
        </div>
        <script src="../../js/imageUplod.js"></script>
    </body>
</html>
