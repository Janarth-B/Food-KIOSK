<?php 
    session_start();
    if(!(isset($_SESSION['admin_id']) || isset($_SESSION['vendor_id']) || isset($_SESSION['user_id']))){
        header('location:../loginWebsite/login_form.php');
     }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../lucasStyle.css">
    </head>
    <body>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
            <table>
    <?php
                $connectDB = mysqli_connect("localhost", "root", "", "web_project");
                $user_id = $_SESSION['user_id'];
                if(isset($_POST['pointsRedeemed'])) {
                    foreach ($_POST['specialInstruction'] as $foodId => $instruction) {
                        mysqli_query($connectDB, "UPDATE orders_item 
                                                    SET special_instructions = '$instruction' 
                                                    WHERE food_id = $foodId AND orders_id = (SELECT orders_id 
                                                                                                FROM orders 
                                                                                                WHERE user_id = '$user_id' AND orders_status IS NULL)");
                    }
                }
                $DBdata = mysqli_query($connectDB, "SELECT * FROM ((orders JOIN orders_item USING (orders_id)) JOIN food USING (food_id)) WHERE (user_id = '$user_id' AND orders_status IS NULL)");
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
                                <input type="text" name="specialInstruction[<?php echo $row['food_id']?>]" placeholder="Kindly Provide Your Special Instruction Here..." value="<?php echo $row['special_instructions']?>">
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
                <table class="align_table2">
                    <tr>
                        <td><input type="number" name="pointsRedeemed" min="1" placeholder="Enter Points To Redeem" class="points_input_height"></td>
                        <td><button type="submit" class="redeem_button" formnovalidate>Confirm Redeem</button></td>
                    </tr>
                    <tr>
                        <td>Subtotal</td>
                        <td>
    <?php 
                            $row = mysqli_fetch_array(mysqli_query($connectDB, "SELECT * FROM orders WHERE user_id = '$user_id' AND orders_status IS NULL"));
                            echo "RM {$row['orders_subtotal']}";
                            $_SESSION['subtotal'] = $row['orders_subtotal'];
    ?>    
                        </td>
                    </tr>
                    <tr>
                        <td>Points Redeemed</td>
                        <td>
    <?php                   
                            $_SESSION['pointsRedeemed'] = 0;
                            if(empty($_POST['pointsRedeemed']) || $_POST['pointsRedeemed'] < 1 || $_POST['pointsRedeemed'] > $row['orders_subtotal']) {
                                echo '0 point';
                            } else {
                                $pointsRedeemed = $_POST['pointsRedeemed'];
                                $userInfoRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT * FROM registered_user WHERE user_id = '$user_id'"));
                                if($pointsRedeemed <= $userInfoRow['registered_points']) {
                                    echo "{$pointsRedeemed} points";
                                    $_SESSION['pointsRedeemed'] = $pointsRedeemed;
                                }
                            }
    ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="row_padding_top">Total</td>
                        <td class="row_padding_top">
    <?php
                             if(empty($_POST['pointsRedeemed']) || $_POST['pointsRedeemed'] < 1 || $_POST['pointsRedeemed'] > $row['orders_subtotal']) {
                                $subtotalAfterRedeemed = false;
                                echo "RM {$row['orders_subtotal']}";
                            } else {
                                $subtotalAfterRedeemed = false;
                                $pointsRedeemed = $_POST['pointsRedeemed'];
                                $userInfoRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT * FROM registered_user WHERE user_id = '$user_id'"));
                                if($pointsRedeemed <= $userInfoRow['registered_points']) {
                                    $subtotalAfterRedeemed = $row['orders_subtotal'] - (int)$pointsRedeemed;
                                    echo "RM {$subtotalAfterRedeemed}";
                                }
                            }
    ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Points Received</td>
                        <td>
    <?php
                            echo floor($row['orders_subtotal'] * 0.1) . ' points';
    ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="row_padding_top">Payment Method</td>
                        <td class="row_padding_top">
                            <input type="radio" name="payment_method" value="Membership Card" id="card" required 
    <?php                       
                                $cardInfoRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT * FROM registered_user WHERE user_id = '$user_id'"));
                                if($subtotalAfterRedeemed == false) {
                                    if($row['orders_subtotal'] > $cardInfoRow['registered_cardBalance']) {
                                        echo 'disabled';
                                    } else {
                                        if(isset($_POST['payment_method']) && ($_POST['payment_method'] == 'Membership Card')) {
                                            echo 'checked';
                                        }
                                    }
                                } else {
                                    if($subtotalAfterRedeemed > $cardInfoRow['registered_cardBalance']) {
                                        echo 'disabled';
                                    } else {
                                        if(isset($_POST['payment_method']) && ($_POST['payment_method'] == 'Membership Card')) {
                                            echo 'checked';
                                        }
                                    }
                                }
    ?>                      >
                            <label for="card"><b>Membership Card</b></label>
                            <input type="radio" name="payment_method" value="Cash" id="cash" <?php if(isset($_POST['payment_method']) && ($_POST['payment_method'] == 'Cash')) { echo 'checked';}?>>
                            <label for="cash"><b>Cash</b></label>
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            <button type="submit" class="checkout_button" name="placeOrder" formaction="<?php echo htmlspecialchars('../processing.php')?>" formmethod="POST">Place Order</button>
        </form>
    </body>
</html>