<?php
    session_start();
    include '../connect.php';

    if(isset($_GET['order']))
    {
        $order = $_GET['order'];
    }
    $user_id = $_SESSION['id'];

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

    			<h2>Invoice</h2><h3 class="pull-right">Order # <?php echo $order;?></h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Billed To:</strong><br>
    					<?php echo  $_SESSION['name'];?><br>
                        <?php $oo=oci_parse($conn,"SELECT * FROM USER_WEBSITE WHERE ID_USERS=' $user_id'");$ee=oci_execute($oo);if($ee){$use=oci_fetch_assoc($oo);}?>
    					<?php echo $use['EMAIL'];?><br>
    					<?php echo $use['PHONE'];?><br>
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
                        <address>
                        <?php 
                            $gq = oci_parse($conn,"SELECT * FROM ORDERS WHERE ORDERS_ID='$order'");
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
                            Collection Date: <?php echo $hh['COLLECTION_DATE'];?><br>
                            Collection Time: <?php echo $hh['COLLECTION_TIME'];?><br>
                        </address>
                    </div>

    		</div>
    		<div class="row">
    			<div class="col-xs-6">
                <?php 
                    $sel = oci_parse($conn, "SELECT * FROM PAYMENT WHERE ORDER_FK='$order'");
                    $e = oci_execute($sel);

                    if($e)
                    {
                        $f = oci_fetch_assoc($sel);
                    }
                ?>
    				<address>
    					<strong>Payment Method:</strong><br>
    					Paypal <br>
                        Payment Id:<?php echo $f['PAYMENT_ID'];?>
    				</address>
    			</div>
                
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Order Date:</strong><br>
    					<?php echo $f['TIME'];?><br><br>
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
        							<td><strong>Item</strong></td>
        							<td class="text-center"><strong>Price</strong></td>
        							<td class="text-center"><strong>Quantity</strong></td>
        							<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>
                            <?php 
                                 $sels= oci_parse($conn, "SELECT * FROM ORDER_PRODUCT WHERE USER_ID_FK = '$user_id' AND ORDERS_ID_FK='$order'");
                                 $ecute = oci_execute($sels);

                                 if($ecute)
                                 {
                                    while($fe=oci_fetch_assoc($sels))
                                    {
                                        $pid = $fe['PRODUCT_ID_FK'];

                                        $els = oci_parse($conn, "SELECT * FROM PRODUCT WHERE PRODUCT_ID='$pid'");
                                        $ut = oci_execute($els);

                                        if($ut)
                                        {
                                            $ch = oci_fetch_assoc($els);
                                        
                                 
                            ?>
    							<tr>
    								<td><?php echo $ch['NAME']?></td>
    								<td class="text-center">&pound<?php echo $ch['PRICE']?></td>
    								<td class="text-center"><?php echo $fe['QUANITY']?></td>
    								<td class="text-right">&pound<?php echo $fe['PRICE']?></td>
    							</tr>
                                <?php
                                    }
                                }
                                $email = $use['EMAIL'];
                                $name =  $_SESSION['name'];
                                $date = $hh['COLLECTION_DATE'];
                                $time = $hh['COLLECTION_TIME'];
                                $to= $email;
                                $subject = "Order Confirmed";
                                $message = "Hello ".$name.",\r\n\r\nYour order has been successfully confirmed. Find Your Details Below:";
                                $message .= "\r\n\r\n\r\nCollection Slot: ".$date." (".$time.")";
                                $message .= "\r\nPayment : Completed";
                                $header = "Form: E-Grocer Basket"; 
                                $mail = mail($to, $subject, $message, $header);
                                
                            }?>

    						</tbody>

    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    <a href="landing.php">Continue Shopping</a>
</div>
</body>
</html>