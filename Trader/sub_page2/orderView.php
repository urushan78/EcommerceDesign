<?php
    session_start();
    include '../../connect.php';

    if(!isset($_SESSION['role']) || $_SESSION['role']!='Trader')
        {
            header("location:../../Session/login.php"); 
        }

    if($_SESSION['log']==0)
    {
        header('location:../../Session/signup_extra/resetPassword.php?sess="first"');
    }

    $trader_id = $_SESSION['id'];

    if(isset($_GET['order']))
    {
        $order_id = $_GET['order'];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <style>
        .invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">

    			<h2>Invoice</h2><h3 class="pull-right">Order # <?php echo $order_id;?></h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Billed To:</strong><br>
    					<?php echo  $_SESSION['name'];?><br>
                        <?php $oo=oci_parse($conn,"SELECT * FROM USER_WEBSITE WHERE ID_USERS=' $trader_id'");$ee=oci_execute($oo);if($ee){$use=oci_fetch_assoc($oo);}?>
    					<?php echo $use['EMAIL'];?><br>
    					<?php echo $use['PHONE'];?><br>
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
                        <address>
                        <?php 
                            $gq = oci_parse($conn,"SELECT * FROM ORDERS WHERE ORDERS_ID='$order_id'");
                            $tr = oci_execute($gq);

                            if($tr)
                            {
                                $work = oci_fetch_assoc($gq);

                                $slot = $work['SLOT_ID'];

                                $lots = oci_parse($conn, "SELECT * FROM COLLECTION_SLOT WHERE COLLECTION_ID= '$slot'");
                                $tosl = oci_execute($lots);

                                if($tosl)
                                {
                                    $hh = oci_fetch_assoc($lots);
                                }
                            }
                        ?>
                        <strong>Collection Slot:</strong><br>
                        <p style="text-align:right;">
                            <?php echo $hh['COLLECTION_DATE'];?><br>
                           <?php echo $hh['COLLECTION_TIME'];?><br>
                        </p>
                        </address>
                    </div>

    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td class="text-center"><strong>Shop Name</strong></td>
        							<td class="text-center"><strong>Product Name</strong></td>
        							<td class="text-center"><strong>Per Price</strong></td>
        							<td class="text-center"><strong>Quantity</strong></td>
        							<td class="text-center"><strong>Income</strong></td>
        							<td class="text-center"><strong>Customer</strong></td>
                                </tr>
    						</thead>
    						<tbody>
                            <?php 
                                $els = oci_parse($conn, "SELECT * FROM ORDER_PRODUCT WHERE ORDERS_ID_FK='$order_id'");
                                $ut = oci_execute($els);

                                    if($ut)
                                    {
                                        while($ch = oci_fetch_assoc($els))
                                        {   
                                            $product = $ch['PRODUCT_ID_FK'];

                                            $sss = oci_parse($conn, "SELECT * FROM PRODUCT WHERE PRODUCT_ID='$product'");
                                            $uuu = oci_execute($sss);

                                            if($uuu)
                                            {
                                                $pro=oci_fetch_assoc($sss);
                                                $shop = $pro['SHOP_INFO']; 

                                                $oop = oci_parse($conn, "SELECT * FROM TRADER_SHOP WHERE SHOP_NO='$shop'");
                                                $qqw = oci_execute($oop);

                                            if($qqw)
                                            {
                                                $mob = oci_fetch_assoc($oop);
                                            }

                                            }

                                            $user = $ch['USER_ID_FK'];

                                            $hmm = oci_parse($conn, "SELECT * FROM USER_WEBSITE WHERE ID_USERS='$user'");
                                            $luu = oci_execute($hmm);

                                            if($luu)
                                            {
                                                $use=oci_fetch_assoc($hmm);
                                            }

                            ?>
    							<tr>

    								<td class="text-center"><?php echo $mob['SHOP_NAME']?></td>
    								<td class="text-center"><?php echo $pro['NAME']?></td>
    								<td class="text-center">&pound<?php echo $ch['PRICE']?></td>
    								<td class="text-center"><?php echo $ch['QUANITY']?></td>
    								<td class="text-center">&pound<?php echo ($ch['QUANITY']*$ch['PRICE'])?></td>
    								<td class="text-center"><?php echo $use['USER_NAME']?></td>

    							</tr>
                                <?php
                                    }
                                }?>

    						</tbody>

    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    <a href="../traderOrderDetails.php">Back</a>
</div>
</body>
</html>