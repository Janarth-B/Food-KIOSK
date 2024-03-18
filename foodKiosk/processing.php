<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    $kiosk_id = $_SESSION['kiosk_id'];
    $connectDB = mysqli_connect("localhost", "root", "", "web_project");

    if(isset($_POST['addFoodtoBasket'])) {
        $addFoodtoBasket = $_POST['addFoodtoBasket'];
        $ordersData = mysqli_query($connectDB, "SELECT * FROM orders WHERE user_id = '$user_id' AND orders_status IS NULL");
        $ordersItemData = mysqli_query($connectDB, "SELECT * FROM orders_item WHERE food_id = '$addFoodtoBasket' AND orders_id = (SELECT orders_id FROM orders WHERE user_id = '$user_id' AND orders_status IS NULL)");
        $vendor_idRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT vendor_id FROM kiosk WHERE kiosk_id = '$kiosk_id'"));
        $vendor_id = $vendor_idRow['vendor_id'];
        if(mysqli_num_rows($ordersData) == 0) {
            mysqli_query($connectDB, "INSERT INTO orders(orders_id, user_id, vendor_id, orders_subtotal) VALUES ('', '$user_id', '$vendor_id', '')");
            $_SESSION['basket_id'] = $kiosk_id;
        }
        if(mysqli_num_rows($ordersItemData) == 0 ) {
            mysqli_query($connectDB, "INSERT INTO orders_item VALUES ('$addFoodtoBasket', (SELECT orders_id FROM orders WHERE user_id = '$user_id' AND orders_status IS NULL), 1, '')");
        } else {
            $item_quantityRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT item_quantity FROM orders_item WHERE food_id = '$addFoodtoBasket' AND orders_id = (SELECT orders_id FROM orders WHERE user_id = '$user_id' AND orders_status IS NULL)"));
            $food_remainingQuantityRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT food_remainingQuantity FROM food WHERE food_id = '$addFoodtoBasket'"));
            if($item_quantityRow['item_quantity'] < $food_remainingQuantityRow['food_remainingQuantity']) {
                mysqli_query($connectDB, "UPDATE orders_item SET item_quantity = item_quantity + 1 WHERE food_id = '$addFoodtoBasket' AND orders_id = (SELECT orders_id FROM orders WHERE user_id = '$user_id' AND orders_status IS NULL)");
            }
        }
        mysqli_query($connectDB, "UPDATE orders
                                            SET orders_subtotal = (SELECT SUM(food.food_price * orders_item.item_quantity)
                                                                    FROM food 
                                                                    JOIN orders_item
                                                                    USING(food_id)
                                                                    WHERE orders_id = (SELECT orders_id 
                                                                                        FROM orders 
                                                                                        WHERE user_id = '$user_id' AND orders_status IS NULL))
                                            WHERE user_id = '$user_id' AND orders_status IS NULL");
        header("Location: ./foodCustomer/customerManageMenu.php?kiosk_id={$kiosk_id}");
    }
    if(isset($_POST['filtering'])) {
        unset($_SESSION['food_category']);
        $_SESSION['food_category'] = $_POST['food_category'];
        header("Location: ./selectFood.php");
    }
    if(isset($_POST['remove_filter'])) {
        unset($_SESSION['food_category']);
        header("Location: ./selectFood.php");
    }
    if(isset($_POST['delete'])) {
        $deleteIndex = $_POST['delete'];
        mysqli_query($connectDB, "DELETE FROM orders_item WHERE food_id = $deleteIndex AND orders_id = (SELECT orders_id FROM orders WHERE user_id = '$user_id' AND orders_status IS NULL)");
        $ordersData = mysqli_query($connectDB, "SELECT * FROM orders_item WHERE orders_id = (SELECT MAX(orders_id) FROM orders WHERE user_id = '$user_id' AND orders_status IS NULL)");
        if(mysqli_num_rows($ordersData) == 0) {
            mysqli_query($connectDB, "DELETE FROM orders WHERE user_id = '$user_id' AND orders_status IS NULL");
            unset($_SESSION['basket_id']);
        }
        header("Location: ./foodCustomer/basket.php");
    }
    if(isset($_POST['minus'])) {
        $minusIndex = $_POST['minus'];
        $item_quantityRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT item_quantity FROM orders_item WHERE food_id = $minusIndex AND orders_id = (SELECT orders_id FROM orders WHERE user_id = '$user_id' AND orders_status IS NULL)"));
        if($item_quantityRow['item_quantity'] > 1) {
            mysqli_query($connectDB, "UPDATE orders_item SET item_quantity = item_quantity - 1 WHERE food_id = $minusIndex AND orders_id = (SELECT orders_id FROM orders WHERE user_id = '$user_id' AND orders_status IS NULL)");
            mysqli_query($connectDB, "UPDATE orders
                                        SET orders_subtotal = (SELECT SUM(food.food_price * orders_item.item_quantity)
                                                                FROM food 
                                                                JOIN orders_item
                                                                USING(food_id)
                                                                WHERE orders_id = (SELECT orders_id 
                                                                                    FROM orders 
                                                                                    WHERE user_id = 'user_id' AND orders_status IS NULL))
                                        WHERE user_id = 'user_id' AND orders_status IS NULL");
            header("Location: ./foodCustomer/basket.php");
        } else {
            header("Location: ./foodCustomer/basket.php");
        }
    }
    if(isset($_POST['plus'])) {
        $plusIndex = $_POST['plus'];
        $item_quantityRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT item_quantity FROM orders_item WHERE food_id = $plusIndex AND orders_id = (SELECT orders_id FROM orders WHERE user_id = '$user_id' AND orders_status IS NULL)"));
        $food_remainingQuantityRow = mysqli_fetch_array(mysqli_query($connectDB, "SELECT food_remainingQuantity FROM food WHERE food_id = $plusIndex"));
        if($item_quantityRow['item_quantity'] < $food_remainingQuantityRow['food_remainingQuantity']) {
            mysqli_query($connectDB, "UPDATE orders_item SET item_quantity = item_quantity + 1 WHERE food_id = $plusIndex AND orders_id = (SELECT orders_id FROM orders WHERE user_id = '$user_id' AND orders_status IS NULL)");
            mysqli_query($connectDB, "UPDATE orders
                                        SET orders_subtotal = (SELECT SUM(food.food_price * orders_item.item_quantity)
                                                                FROM food 
                                                                JOIN orders_item
                                                                USING(food_id)
                                                                WHERE orders_id = (SELECT orders_id 
                                                                                    FROM orders 
                                                                                    WHERE user_id = '$user_id' AND orders_status IS NULL))
                                        WHERE user_id = '$user_id' AND orders_status IS NULL");
            header("Location: ./foodCustomer/basket.php");
        } else {
            header("Location: ./foodCustomer/basket.php");
        }
    }
    if(isset($_POST['placeOrder'])) {
        foreach ($_POST['specialInstruction'] as $foodId => $instruction) {
            mysqli_query($connectDB, "UPDATE orders_item 
                                        SET special_instructions = '$instruction' 
                                        WHERE food_id = $foodId AND orders_id = (SELECT orders_id 
                                                                                    FROM orders 
                                                                                    WHERE user_id = '$user_id' AND orders_status IS NULL)");
            mysqli_query($connectDB, "UPDATE food 
                                        SET food_remainingQuantity = food_remainingQuantity - (SELECT item_quantity 
                                                                                                FROM orders_item 
                                                                                                WHERE food_id = $foodId AND orders_id = (SELECT orders_id 
                                                                                                                                            FROM orders 
                                                                                                                                            WHERE user_id = '$user_id' AND orders_status IS NULL)) 
                                        WHERE food_id = $foodId");
        }
        $paymentMethod = $_POST['payment_method'];
        $pointsRedeemed = $_SESSION['pointsRedeemed'];
        $ordersSubtotal = mysqli_fetch_array(mysqli_query($connectDB, "SELECT orders_subtotal FROM orders WHERE user_id = '$user_id' AND orders_status IS NULL"));
        $pointsReceived = floor(floatval($ordersSubtotal['orders_subtotal']) * 0.1);
        mysqli_query($connectDB, "UPDATE orders SET orders_status = 'Ordered' WHERE user_id = '$user_id' AND orders_status IS NULL");
        mysqli_query($connectDB, "UPDATE orders SET orders_subtotal = orders_subtotal - '$pointsRedeemed' WHERE user_id = '$user_id' AND orders_status = 'Ordered'");
        mysqli_query($connectDB, "INSERT INTO payment VALUES ('', (SELECT orders_id 
                                                                    FROM orders 
                                                                    WHERE user_id = '$user_id' AND orders_status = 'Ordered'), '$paymentMethod', (SELECT CURRENT_TIMESTAMP()), '$pointsReceived', '$pointsRedeemed')");
        unset($_SESSION['pointsRedeemed']);
        header("Location: ./foodCustomer/regOrderStatus.php");
    }
    if(isset($_POST['placeOrderGen'])) {
        foreach ($_POST['specialInstruction'] as $foodId => $instruction) {
            mysqli_query($connectDB, "UPDATE orders_item 
                                        SET special_instructions = '$instruction' 
                                        WHERE food_id = $foodId AND orders_id = (SELECT orders_id 
                                                                                    FROM orders 
                                                                                    WHERE user_id = '$user_id' AND orders_status IS NULL)");
            mysqli_query($connectDB, "UPDATE food 
                                        SET food_remainingQuantity = food_remainingQuantity - (SELECT item_quantity 
                                                                                                FROM orders_item 
                                                                                                WHERE food_id = $foodId AND orders_id = (SELECT orders_id 
                                                                                                                                            FROM orders 
                                                                                                                                            WHERE user_id = '$user_id' AND orders_status IS NULL)) 
                                        WHERE food_id = $foodId");
        }
        mysqli_query($connectDB, "UPDATE orders SET orders_status = 'Ordered' WHERE user_id = '$user_id' AND orders_status IS NULL");
        mysqli_query($connectDB, "INSERT INTO payment VALUES ('', (SELECT orders_id 
                                                                    FROM orders 
                                                                    WHERE user_id = '$user_id' AND orders_status = 'Ordered'), 'Cash', (SELECT CURRENT_TIMESTAMP()), '', '')");
        header("Location: ./foodCustomer/genOrderStatus.php");
    }
?>