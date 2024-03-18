<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../lucasStyle.css">
    </head>
    <body>
    <?php 
        include('../partials/vendorMenuBar.php');
        $connectDB = mysqli_connect("localhost", "root", "", "web_project");
        $user_id = $_POST['user_id'];
        if(isset($_POST['orderStatus']) && $_POST['orderStatus'] == 'orderPrepared') {
            mysqli_query($connectDB, "UPDATE orders 
                                        SET orders_status = 'Prepared' 
                                        WHERE user_id = '$user_id' AND orders_id = (SELECT MAX(orders_id)
                                                                                    FROM orders
                                                                                    WHERE user_id = '$user_id')");
        } else if(isset($_POST['orderStatus']) && $_POST['orderStatus'] == 'orderCompleted') {
            mysqli_query($connectDB, "UPDATE orders 
                                        SET orders_status = 'Completed' 
                                        WHERE user_id = '$user_id' AND orders_id = (SELECT MAX(orders_id)
                                                                                    FROM orders
                                                                                    WHERE user_id = '$user_id')");
        }
    ?>
        <div class="orders_status_top_container">
            <table>
                <tr>
                    <td>
    <?php
                        $ordersStatusRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT orders_status 
                                                                                        FROM orders 
                                                                                        WHERE orders_id = (SELECT MAX(orders_id) 
                                                                                                            FROM orders 
                                                                                                            WHERE user_id = '$user_id')"));
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
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $user_id?>">
                        <td><button type="submit" class="prepared_completed_button" name="orderStatus" value="orderPrepared" <?php if($ordersStatusRow['orders_status'] == 'Prepared' || $ordersStatusRow['orders_status'] == 'Completed') {echo 'disabled';}?>>Order Prepared</button></td>
                        <td><button type="submit" class="prepared_completed_button" name="orderStatus" value="orderCompleted" <?php if($ordersStatusRow['orders_status'] == 'Completed') {echo 'disabled';}?>>Order Completed</button></td>
                    </form>
                </tr>
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
            $userInfo = mysqli_query($connectDB, "SELECT * FROM registered_or_general_user JOIN registered_user USING(user_id) WHERE user_id = '$user_id'");
            if(mysqli_num_rows($userInfo) > 0) {
                $userInfoRow = mysqli_fetch_array($userInfo);
    ?>
                <table class="align_table1">
                    <tr><td><b>User info:</b></td></tr>
                    <tr><td><?php echo $userInfoRow['registered_username']?></td></tr>
                    <tr><td><?php echo $userInfoRow['registered_email']?></td></tr>
                    <tr><td><?php echo $userInfoRow['registered_phoneNum']?></td></tr>
                </table>
    <?php
            } else {
                $userInfoRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT * FROM registered_or_general_user WHERE user_id = '$user_id'"));
    ?>
                <table class="align_table1">
                    <tr><td><b>User info:</b></td></tr>
                    <tr><td><?php echo $userInfoRow['registered_phoneNum']?></td></tr>
                </table>
    <?php
            }
    ?>
        </div>
    </body>
</html>