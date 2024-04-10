<?php
include '../connect.php';
$success="";
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role']!='Trader')
        {
            header("location:../Session/login.php"); 
        }

    if($_SESSION['log']==0)
    {
        header('location:../Session/signup_extra/resetPassword.php?sess="first"');
    }
    $id= $_SESSION['id'];
    
    if(isset($_POST['update']))
    {
       $name= $_POST['name'];
       $gender= $_POST['gender'];
       $age= $_POST['age'];
       $email= $_POST['email'];
       $phone= $_POST['phone'];


       $query = oci_parse($conn,"UPDATE USER_WEBSITE SET
                                                       USER_NAME= '$name',
                                                       EMAIL = '$email',
                                                       Phone = $phone,
                                                       GENDER_USER = '$gender',
                                                       USER_AGE = $age WHERE ID_USERS = $id");
        $execute = oci_execute($query);
        
        if($execute)
        {
            $success="Record Updated Successfully!!";
        }
    }

    
?>
<!DOCTYPE html>
 <html lang="en"> 
<head>
	<meta charset="utf-8">
	<title>Welcome <?php echo $_SESSION['name'];?></title>
	<!--Bootstrap files link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../css/Admin/sidenav.css" />
	<link rel="stylesheet" type="text/css" href="../css/Trader/trader_signup.css"/>
	<link rel="stylesheet" type="text/css" href="../css/Trader/traderSetting.css"/>
    
    
</head>
<body>
    <main>
        	<!--navbar section-->
	<section id="home">
				
                <div class="nav">
                    <!--navbar section-->
                
                    <div class="sidebar">
                        <header>Menu</header>
                        <ul>
                            <li>
                                <div class="box-account disapear">
                                    <div class="box-account-image">
                                        <img src="../image/account-default-image.jpg" width= "100%" alt="">
                                    </div>
                                    <div class="box-account-details">
                                        <div class="details">
                                            <p><?php echo $_SESSION['name'];?></p>
                                            <p><a href="../Session/signup_extra/logout.php">Logout</a></p>
                                        </div>
                                    </div>
                            </li>
                            <li><a href="traderAccount.php" class="option"><i class="fas fa-tachometer-alt"></i> <span class="go">Dashboard</span></a></li>
                            <li><a href="traderProduct.php" class="option"><i class="fas fa-shopping-cart"></i> <span class="go">Product</span></a></li>
                            <li><a href="traderShop.php" class="option "><i class="fas fa-store-alt"></i> <span class="go">Shop</span></a></li>  
                            <li><a href="traderReport.php" class="option"><i class="fas fa-chart-line"></i> <span class="go">Report</span></a></li>
                            <li><a href="traderReview.php" class="option"><i class="fas fa-comment-dots"></i> <span class="go">Review</span></a></li>
                            <li><a href="#" class="option active"><i class="fas fa-cog"></i> <span class="go">Setting</span></a></li>
                            <li><a href="TraderOrderDetails.php" class="option "><i class="fas fa-bell"></i><span class="go">Order Details</span></a></li>
                            <li><a href="" class="option"></a></li>
                        </ul>
        
                    </div>
                </div>	
                
                <div class="canvas">
                    <div class="vertical-nav">
                        <div class="box-logo">
                            <img src="../image/font-logo-2.png" alt="Logo" width="100%">
                        </div>
        
                        <div class="box-account appear">
                            <div class="box-account-image">
                                <img src="../image/account-default-image.jpg" width= "100%" alt="">
                            </div>
                            <div class="box-account-details">
                                <ul>
                                    <li><?php echo $_SESSION['name'];?></li>
                                    <li><a href="../Session/signup_extra/logout.php">Logout</a></li>
                                </ul>
        
                            </div>
                        </div>
                    </div> 
                </div>
            </section>-->
        
            <?php
              
               $query = oci_parse($conn, "SELECT * FROM USER_WEBSITE WHERE ID_USERS = $id");
               $result = oci_execute($query);
           
               if($result)
               {
                   $row = oci_fetch_row($query);
               }
            ?>
            <section id="tradersettings" style="margin-top:8em;">
            <form id="msform" action="" method="POST" enctype="multipart/form-data">

                <fieldset>
                <div class="first-singup-title">
                    <h2 class="fs-title">Settings</h2>
                    <h3 class="fs-subtitle">
                        <?php if(!($success=="")){?>
                            <div class="danger-error-error">
                                <p style="color:#155724;">
                                    <?php echo $success;?>
                                </p>
                            </div>
                        <?php }?>
                    </h3>
                </div>
                    <div class="profilePhoto">
                        <div class="img_box_pro">
                            <img src="../image/account-default-image.jpg" onclick="triggerclick()" id="photodisplay" alt="" />
                        </div>
                        <p>Click on the image to choose.</p>
                        <input type="file" name="image" onchange="displayimage(this)" id="imageupd" style="display:none;">
                    </div>
                <div class="f_l_name">
                        <div class="fl_name">
                            <input type="text" name="name" placeholder="* Name" required value="<?php echo $row['1']; ?>"/>
                        </div>
                        <div class="fl_name">
                            <input type="text" name="role" placeholder="*Role"  value="<?php echo $row['2']; ?>" readonly />
                        </div>
                </div>

                <div class="gType">
                    <div class="firstup upupup">
                    <label for="gender">Gender:</label>
                        <input type="radio" id="male" name="gender" value="male" required <?php if(!strcmp($row['8'],'Male')){ echo "checked";} ?> />
                        <label for="male">Male</label>
                        <input type="radio" id="female" name="gender" value="female" <?php if(!strcmp($row['8'],'Female')){ echo "checked";} ?> />
                        <label for="female">Female</label><br>
                    </div>

                    <div class="firstup">
                    <label for="age">Age: </label>
                    <input type="number" id="age"  name="age" min="18" max="70" style="max-width:90px;" value="<?php echo $row['9']; ?>" /> 
                    </div>
                </div>

                <div class="f_l_name">
                        <div class="fl_name">
                            <input type="email" name="email" placeholder="*Email" required value="<?php echo $row['3']; ?>" />
                        </div>
                        <div class="fl_name">
                            <input type="tel" name="phone" placeholder="*Phone" pattern="[0-9]{10}" required  value="<?php echo $row['4']; ?>" />
                        </div>
                </div>
                <div class="fullfill-link">
                    <input type="submit" name="update" class="next action-button" value="Update">
                </div>

                <a href="../Session/signup_extra/resetPassword.php">Reset Password</a>
                
                </fieldset>
                
                </form>

            </section>
        
           <section class="foots">
            <footer>
                    <a href=""> Copyright &copy; 2021 E-Grocer Basket</a>
                </footer>
           </section>
    </main>
	
	<!--Bootstrap Js files link-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/5cd602dbbe.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <script>
        function triggerclick(){
    document.querySelector('#imageupd').click();
} 

function displayimage(e){ 
    if(e.files[0]){
        var reader = new FileReader();

        reader.onload = function(e){
            document.querySelector('#photodisplay').setAttribute('src', e.target.result); 
        }
        reader.readAsDataURL(e.files[0]);
    }
}
    </script>
</body>
</html>

