<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../lucasStyle.css">
        <script src="../lucasIndex.js"></script>
    </head>
    <body>
    <?php 
            include('../partials/customerOrderStatusMenuBar.php');
            $connectDB = mysqli_connect("localhost", "root", "", "web_project");
            $user_id = $_SESSION['user_id'];
            $ordersStatusData = mysqli_query($connectDB, "SELECT orders_status 
                                                            FROM orders 
                                                            WHERE orders_id = (SELECT MAX(orders_id) 
                                                                                FROM orders 
                                                                                WHERE user_id = '$user_id')");
            if(mysqli_num_rows($ordersStatusData) > 0) {
                $ordersStatusRow = mysqli_fetch_array($ordersStatusData);
    ?>
                <div class="orders_status_top_container">
            <table>
                <tr>
                    <td rowspan="2">
    <?php
                        if($ordersStatusRow['orders_status'] == 'Ordered') {
    ?>
                            <img src="../images/foodOrdered.png" alt="foodOrdered">
    <?php
                        } else if($ordersStatusRow['orders_status'] == 'Prepared') {
    ?>
                            <img src="../images/foodPrepared.png" alt="foodPrepared">
    <?php
                        } else if($ordersStatusRow['orders_status'] == 'Completed') {
    ?>
                            <img src="../images/foodCompleted.png" alt="foodCompleted">
    <?php
                        }
    ?>
                    </td>
                    <td>
                        <div id="orderQR" style="display: flex; justify-content: center;"></div>
                    </td>
                    <td rowspan="2">
    <?php
                        if($ordersStatusRow['orders_status'] == 'Completed') {
    ?>
                            <button type="button" onclick="location.href = './regOrderReceipt.php'" class="receipt_button">Payment Receipt</button>
    <?php
                        } else {
    ?>
                            <button type="button" class="receipt_button">Payment Receipt</button>
    <?php
                        }
    ?>
                    </td>
                </tr>
                <tr><td>Scan Me To View Order</td></tr>
            </table>
        </div>
        <br><br><br>
        <table>
    <?php
            $DBdata = mysqli_query($connectDB, "SELECT * 
                                                FROM ((orders 
                                                JOIN orders_item USING (orders_id)) 
                                                JOIN food USING (food_id)) 
                                                WHERE orders_id = (SELECT MAX(orders_id) 
                                                                    FROM orders 
                                                                    WHERE user_id = '$user_id')");
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
                                                                                                        WHERE user_id = '$user_id')"));
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
    <?php
            if(!isset($_SESSION['paid']) && $ordersStatusRow['orders_status'] == 'Completed') {
                mysqli_query($connectDB, "UPDATE orders 
                                            SET orders_collectTime = (SELECT CURRENT_TIMESTAMP()) 
                                            WHERE orders_id = (SELECT MAX(orders_id) 
                                                                FROM orders 
                                                                WHERE user_id = '$user_id')");
                mysqli_query($connectDB, "UPDATE orders 
                                            SET order_date = (SELECT CURRENT_DATE()) 
                                            WHERE orders_id = (SELECT MAX(orders_id) 
                                                                FROM orders 
                                                                WHERE user_id = '$user_id')");
                mysqli_query($connectDB, "UPDATE registered_user 
                                            SET registered_points = registered_points - (SELECT points_redeemed 
                                                                                            FROM payment 
                                                                                            WHERE orders_id = (SELECT MAX(orders_id) 
                                                                                                                FROM orders 
                                                                                                                WHERE user_id = '$user_id' AND orders_status = 'Completed')) + 
                                                                                        (SELECT points_received 
                                                                                        FROM payment 
                                                                                        WHERE orders_id = (SELECT MAX(orders_id) 
                                                                                                            FROM orders 
                                                                                                            WHERE user_id = '$user_id' AND orders_status = 'Completed')) 
                                            WHERE user_id = '$user_id'");
                if($paymentRow['payment_method'] == 'Membership Card') {
                    mysqli_query($connectDB, "UPDATE registered_user 
                                                SET registered_cardBalance = registered_cardBalance - (SELECT orders_subtotal 
                                                                                                        FROM orders 
                                                                                                        WHERE orders_id = (SELECT MAX(orders_id) 
                                                                                                                            FROM orders 
                                                                                                                            WHERE user_id = '$user_id')) 
                                                WHERE user_id = '$user_id'");
                }
                $_SESSION['paid'] = 'yes';
            }
    ?>
    <?php
            } else {
                echo 'No order';
            }
    ?>

    <?php
        if(!(isset($_SESSION['vendor_id']) OR isset($_SESSION['admin_id']) OR isset($_SESSION['user_id']))) {
            header("location:../loginWebsite/login_form.php");
        }
    ?>
    
    <script src="../node_modules/qrcode.min.js"></script>
    <script>
        const qrDiv = document.getElementById('orderQR');
        new QRCode(qrDiv, '<?php echo "Order ID: " . $vendorInfoRow['orders_id']; ?>');
    </script>
    </body>
</html>