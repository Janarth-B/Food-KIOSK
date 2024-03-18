<?php

session_start();
$connnectDB = mysqli_connect('localhost', 'root', '', 'web_project');
$user_id = $_SESSION['user_id'];

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);


if($_GET['getSpending'])
{
    $sql = "SELECT SUM(orders_subtotal) total, DATE_FORMAT(order_date, '%D %M %Y') mth FROM orders WHERE user_id = '$user_id' GROUP BY DAY(order_date) ORDER BY order_date DESC LIMIT 15";
    $result = $connnectDB ->query($sql);
    $result = $result->fetch_all(MYSQLI_ASSOC);
 
 
    foreach($result as $row)
    {
        $total[] = $row['total'];
        $bulan[] = $row['mth'];
    }
 
    echo json_encode([
        "total" => $total,
        "bulan" => $bulan,
    ]);
    die;
}



if($_GET['getPoints'])
{
    $sql = "SELECT SUM(points_received) pointsReceived, DATE_FORMAT(order_date, '%D %M %Y') mth FROM payment JOIN orders USING(orders_id) WHERE user_id = '$user_id' GROUP BY DAY(payment_dateTime) ORDER BY order_date DESC LIMIT 15";
    $result = $connnectDB ->query($sql);
    $result = $result->fetch_all(MYSQLI_ASSOC);
 
    foreach($result as $row)
    {
        $points1[] = $row['pointsReceived'];
        $bulan[] = $row['mth'];
    }



    $sql = "SELECT SUM(points_redeemed) pointsRedeemed, DATE_FORMAT(order_date, '%D %M %Y') mth FROM payment JOIN orders USING(orders_id) WHERE user_id = '$user_id' GROUP BY DAY(payment_dateTime) ORDER BY order_date DESC LIMIT 15";
    $result2 = $connnectDB ->query($sql);
    $result2 = $result2->fetch_all(MYSQLI_ASSOC);
 
    foreach($result2 as $row)
    {
        $points2[] = $row['pointsRedeemed'];
    }
 
    echo json_encode([
        "points1" => $points1,
        "points2" => $points2,
        "bulan" => $bulan,
    ]);

    die;
}



if($_GET['getFavouriteKiosk'])
{
    $sql = "SELECT COUNT(orders_id) kioskFrequency, kiosk_name FROM orders JOIN kiosk USING(vendor_id) WHERE user_id = '$user_id' AND orders_status IS NOT NULL GROUP BY vendor_id";
    $result = $connnectDB ->query($sql);
    $result = $result->fetch_all(MYSQLI_ASSOC);
 
    foreach($result as $row)
    {
        $kioskFrequency[] = (int)$row['kioskFrequency'];
        $kioskName[] = $row['kiosk_name'];
    }
 
    echo json_encode([
        "kioskFrequency" => $kioskFrequency,
        "kioskName" => $kioskName,
    ]);

    die;
}


if($_GET['getFavouriteMenu'])
{
    $sql = "SELECT SUM(item_quantity) menuQuantity, food_category FROM ((orders_item JOIN food USING(food_id)) JOIN orders USING(orders_id)) WHERE user_id = '$user_id' AND orders_status IS NOT NULL GROUP BY food_category ORDER BY SUM(item_quantity) DESC";
    $result = $connnectDB ->query($sql);
    $result = $result->fetch_all(MYSQLI_ASSOC);
 
    foreach($result as $row)
    {
        $menuQuantity[] = (int)$row['menuQuantity'];
        $foodCategory[] = $row['food_category'];
    }
 
    echo json_encode([
        "menuQuantity" => $menuQuantity,
        "foodCategory" => $foodCategory,
    ]);

    die;
}



if($_GET['getOrder'])
{
    $sql = "SELECT orders_id, orders_subtotal, orders_collectTime, payment_method, payment_dateTime, points_received, points_redeemed FROM orders JOIN payment USING(orders_id) WHERE user_id = '$user_id' AND orders_status IS NOT NULL ORDER BY order_date DESC LIMIT 10";
    $result = $connnectDB ->query($sql);
    $result = $result->fetch_all(MYSQLI_ASSOC);
 
    echo json_encode($result);
    die;
}
 
?>