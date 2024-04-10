<?php
    
?>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/Customer/nav.css">
</head>

<body>

    <section id="nav">
        <nav class="navbar navbar-expand-lg navbar-light ">
            <a class="navbar-brand" href="landing.php"><img src="../image/Ebasket_logo.png" alt="" width="100%"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="form-inline my-2 my-lg-0" action="search_run.php" method="post">
                    <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search by Name, Category or Shop..." aria-label="Search">
                    <i class="fa fa-search"></i>
                </form>
                <?php                       
                    $count= 0;
                    if(isset($_SESSION['cart'])){
                        $count=count($_SESSION['cart']);
                    }
                                
                    if(isset($_SESSION['role']) && ($_SESSION['role'])=='Customer'){

                        if($_SESSION['log']==0)
                        {
                            $id = $_SESSION['id'];
                            header('location:../Session/signup_extra/sendOTP.php?cid='.$id);
                        }
                ?>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="landing.php"><i class="fa fa-user"></i> <?php echo $_SESSION['name']; ?> <i class="fas fa-caret-down"></i>  </a>
                            <a class="managedets" href="customerdetail.php?ID_USERS=<?php echo $_SESSION['id'];?>">Manage Customer Details</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="shoppingCart.php"><i class="fa fa-shopping-cart"></i> Items (<?php echo $count;?>)</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="../Session/signup_extra/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                        </li>
                    </ul>
                <?php
                    }else{
                ?>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="../Session/login.php"><i class="fa fa-user"></i> Sign In</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="../Session/trader_signup.php"><i class="fa fa-box-open"></i> Become Trader</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="shoppingCart.php"><i class="fa fa-shopping-cart"></i> Items (<?php echo $count;?>)</a>
                        </li>
                    </ul>
                <?php
                    }
                ?>
            
            </div> 
          </nav>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>