<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../lucasStyle.css">
    </head>
    <body>
        <?php include('../partials/customerOrderStatusMenuBar.php')?>
        <table>
    <?php
            $connectDB = mysqli_connect("localhost", "root", "", "web_project");
            $user_id = $_SESSION['user_id'];
            $DBdata = mysqli_query($connectDB, "SELECT * 
                                                FROM ((orders 
                                                JOIN orders_item USING (orders_id)) 
                                                JOIN food USING (food_id)) 
                                                WHERE orders_id = (SELECT MAX(orders_id) 
                                                                    FROM orders 
                                                                    WHERE user_id = '$user_id' AND orders_status = 'Completed')");
            if(mysqli_num_rows($DBdata) > 0) {
                while($row = mysqli_fetch_array($DBdata)) {    
    ?>
                    <tr>
                        <td rowspan="2" class="resize_food_img_container"><img src="../images/menu/<?php echo $row['food_image']?>" alt="Menu"></td>
                        <td class="resize_food_name_container2"><?php echo $row['food_name']?></td>
                        <td class="resize_item_quantity_container">x <?php echo $row['item_quantity']?></td>
                    </tr>
                    <tr>
                        <td class="resize_instruction_container">
    <?php
                            if($row['special_instructions'] != NULL) {
                                echo $row['special_instructions'];
                            } else {
                                echo 'No Special Instruction';
                            }
    ?>
                        </td>
                        <td class="larger_food_price_container2"><?php echo "RM {$row['food_price']}"?></td>
                    </tr>
    <?php
                }
            }
    ?>
        </table>
        <br>
        <div class="payment_info_container">
    <?php
            $vendorData = mysqli_query($connectDB, "SELECT * FROM (((orders 
                                                    JOIN orders_item USING (orders_id)) 
                                                    JOIN food USING (food_id)) 
                                                    JOIN food_vendor USING(vendor_id))
                                                    WHERE orders_id = (SELECT MAX(orders_id) 
                                                                        FROM orders 
                                                                        WHERE user_id = '$user_id')");
            $userInfoRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT * FROM registered_or_general_user JOIN registered_user USING(user_id) WHERE user_id = '$user_id'"));
            $vendorInfoRow = mysqli_fetch_array($vendorData);
    ?>
            <table class="align_table1">
                <tr><td><b>Your info:</b></td></tr>
                <tr><td><?php echo $userInfoRow['registered_username']?></td></tr>
                <tr><td><?php echo $userInfoRow['registered_email']?></td></tr>
                <tr><td><?php echo $userInfoRow['registered_phoneNum']?></td></tr>
                <tr><td class="row_padding_top"><b>Vendor info:</b></td></tr>
                <tr><td><?php echo $vendorInfoRow['vendor_username']?></td></tr>
                <tr><td><?php echo $vendorInfoRow['vendor_email']?></td></tr>
                <tr><td><?php echo $vendorInfoRow['vendor_phoneNum']?></td></tr>
            </table>
            <table class="align_table3">
                <tr>
                    <td>Subtotal</td>
                    <td>
    <?php
                        $paymentRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT * 
                                                                                    FROM payment 
                                                                                    WHERE orders_id = (SELECT MAX(orders_id) 
                                                                                                        FROM orders 
                                                                                                        WHERE user_id = '$user_id')"));
                        if(isset($_SESSION['subtotal'])) {
                            echo "RM {$_SESSION['subtotal']}";
                        } else {
                            $ordersSubtotal = $vendorInfoRow['orders_subtotal'];
                            $pointsRedeemed = $paymentRow['points_redeemed'];
                            $subtotal = $ordersSubtotal + $pointsRedeemed;
                            echo "RM {$subtotal}";
                        }
    ?>    
                    </td>
                </tr>
                <tr>
                    <td>Points Redeemed</td>
                    <td>
    <?php                   
                        $paymentRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT * 
                                                                                    FROM payment 
                                                                                    WHERE orders_id = (SELECT MAX(orders_id) 
                                                                                                        FROM orders 
                                                                                                        WHERE user_id = '$user_id' AND orders_status = 'Completed')"));
                        echo "{$paymentRow['points_redeemed']} points";
    ?>
                    </td>
                </tr>
                <tr>
                    <td class="row_padding_top">Total</td>
                    <td class="row_padding_top">
    <?php
                        
                        $ordersRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT * 
                                                                                    FROM orders 
                                                                                    WHERE orders_id = (SELECT MAX(orders_id) 
                                                                                                        FROM orders 
                                                                                                        WHERE user_id = '$user_id' AND orders_status = 'Completed')"));
                        echo "RM {$ordersRow['orders_subtotal']}";
    ?>
                    </td>
                </tr>
                <tr>
                    <td>Points Received</td>
                    <td>
    <?php
                        echo "{$paymentRow['points_received']} points";
    ?>
                    </td>
                </tr>
                <tr>
                    <td class="row_padding_top">Payment Method</td>
                    <td class="row_padding_top">
    <?php
                        echo $paymentRow['payment_method'];
    ?>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <div class="qr_center_container" id="qr_receipt"></div>
        <p class="text_align_center">Scan me</p>

        <script src="../node_modules/qrcode.min.js"></script>
        <script>
            const QRElement = document.getElementById('qr_receipt');
            new QRCode(QRElement, {
                text: '<?php echo "Total: RM {$ordersRow['orders_subtotal']}"?>',
                colorDark: 'rgb(54, 156, 176)',
            });
        </script>
    </body>
</html>