<?php
     include '../../connect.php';
     session_start();
     if(!isset($_SESSION['role']) || $_SESSION['role']!='Admin')
     {
         header("location:../../Session/login.php"); 
     }

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset='utf-8'>
    <title>Monthly Finance Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="../../js/sort-table.js"></script>
    <style type="text/css">
        table { border: 1px solid black; border-collapse: collapse; }

        th, td { padding: 2px 5px; border: 1px solid black; }

        thead { background: #ddd; }

        table#demo2.js-sort-0 tbody tr td:nth-child(1),
        table#demo2.js-sort-1 tbody tr td:nth-child(2),
        table#demo2.js-sort-2 tbody tr td:nth-child(3),
        table#demo2.js-sort-3 tbody tr td:nth-child(4),
        table#demo2.js-sort-4 tbody tr td:nth-child(5),
        table#demo2.js-sort-5 tbody tr td:nth-child(6),
        table#demo2.js-sort-6 tbody tr td:nth-child(7),
        table#demo2.js-sort-7 tbody tr td:nth-child(8),
        table#demo2.js-sort-8 tbody tr td:nth-child(9),
        table#demo2.js-sort-9 tbody tr td:nth-child(10) {
            background: #dee;
        }
        h1{
            text-align:center;
            padding:35px 0;
        }

    </style>
</head>
<body>
<header>
    <h1>Monthly Finance Report</h1>
</header>


<section id="body" class="container">
        <table class="table js-sort-table table-secondary table-striped table-hover" id="demo1">
            <thead>
                <tr>
                    <th scope="col" class="js-sort-number">#</th>
                    <th scope="col">Product Name</th>
                    <th scope="col" class="js-sort-number">Quantity Sold</th>
                    <th scope="col" class="js-sort-number">Price Per Product</th>
                    <th scope="col" class="js-sort-number">Income</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $sub=0;
                $increment = 1;
                 $group = oci_parse($conn, "SELECT * FROM USER_WEBSITE WHERE TYPE='Trader'");
                 $by= oci_execute($group);
                 if($by)
                 {
                     while($data = oci_fetch_assoc($group))
                     {
                         $trader_id=$data['ID_USERS']; 
                    $select = oci_parse($conn, "SELECT * FROM PRODUCT WHERE TRADER_INFO='$trader_id' AND STATUS='Enable'");
                    $run= oci_execute($select);

                    if($run)
                    {
                        
                        while($row=oci_fetch_assoc($select))
                        {
                            
                            $pid=$row['PRODUCT_ID'];

                            $select1=oci_parse($conn, "SELECT * FROM ORDER_PRODUCT WHERE PRODUCT_ID_FK='$pid'");
                            $run1= oci_execute($select1);

                            if($run)
                            {
                                $qty=0;
                                $total=0;
                                $great=0;
                                $b=1;
                                $color="";
                                while($fetch= oci_fetch_assoc($select1))
                                {
                                    
                                    $order = $fetch['ORDERS_ID_FK'];

                                    $sel = oci_parse($conn, "SELECT * FROM PAYMENT WHERE ORDER_FK='$order'");
                                    $ru = oci_execute($sel);
                                    
                                    if($sel)
                                    {
                                    $fet=oci_fetch_assoc($sel);

                                        $date = $fet['TIME'];

                                        $new = strtolower($date);

                                        $now = strtolower(date("d-M-Y", strtotime("first day of next month")));

                                        if($new==$now)
                                        {
                                            $b=0;
                                            break;
                                        }
                                    }

                                    $qty = $qty + $fetch['QUANITY'];

                                    $total = $qty*$fetch['PRICE'];

                                    $sub = $sub+$total;
                                    
                                }
                                if($b=0)
                                {
                                    break;
                                }

                                if($total==0)
                                {
                                    $color='#9F2525';
                                }
                                
                            }
                            
                ?>
                <tr style="color:<?php echo $color;?>;">
                    <th scope="row"><?php echo $increment;?></th>
                    <td><?php echo $row['NAME'];?></td>
                    <td><?php echo $qty;?></td>
                    <td>&pound<?php echo $row['PRICE'];?></td>
                    <td>&pound<?php echo $total;?></td>
                </tr>
                <?php $increment++;}}}}?>
                <tr>
                    <td colspan="4" style="font-weight:bold;">Total: </td>
                    <td style="font-weight:bold;">&pound<?php echo $sub;?></td>
                </tr>
            </tbody>

          </table>

</section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/5cd602dbbe.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
