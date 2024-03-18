<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../lucasStyle.css">
    </head>
    <body>
        <?php include('../partials/customerOrderStatusMenuBar.php');?>
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
            $userInfoRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT * FROM registered_or_general_user WHERE user_id = '$user_id'"));
            $vendorInfoRow = mysqli_fetch_array($vendorData);
    ?>
            <table class="align_table4">
                <tr><td><b>Your info:</b></td></tr>
                <tr><td></td></tr>
                <tr><td><?php echo $userInfoRow['registered_phoneNum']?></td></tr>
                <tr><td class="row_padding_top"><b>Vendor info:</b></td></tr>
                <tr><td><?php echo $vendorInfoRow['vendor_username']?></td></tr>
                <tr><td><?php echo $vendorInfoRow['vendor_email']?></td></tr>
                <tr><td><?php echo $vendorInfoRow['vendor_phoneNum']?></td></tr>
            </table>
            <table class="align_table2">
                <tr>
                    <td>Total</td>
                    <td class="position_abs_right100">
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