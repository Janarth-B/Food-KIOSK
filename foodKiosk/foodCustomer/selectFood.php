<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="./lucasStyle.css">
        <script src="./lucasFontawesome.js"></script>
    </head>
    <body>
        <div class="prevent_hidden">
            <div class="header">
                <img src="./images/LogoUMP-removebg-preview.png" alt="Logo UMP" class="float_left">
                <ul>
                    <li><a href="">HOME</a></li>
                    <li><a href="">Order Status</a></li>
                    <li><a href="">MembershipCard</a></li>
                    <li><a href="">Dashboard</a></li>
                    <li><a href="">Setting</a></li>
                </ul>
                <div class="cart_border">
                    <a href="./basket.php"><i class="fa-solid fa-cart-shopping" style="color: #000000;"></i></a>
                </div>
                <button>Login / Sign Up</button>
            </div>
            <hr class="hr_blur">
            <div class="filter_menu">
                <a href="./filterMenu.php"><i class="fa-solid fa-filter fa-2xl" style="color: #51aecd;"></i>Filter</a>
            </div>
            <form action="<?php echo htmlspecialchars('./processing.php')?>" method="POST">
    <?php       
                $connectDB = mysqli_connect("localhost", "root", "", "web_project");
                if(isset($_SESSION['food_category'])) {
                    if($_SESSION['food_category'] == 'ascending') {
                        $DBdata = mysqli_query($connectDB, "SELECT * FROM food WHERE kiosk_id = 1 ORDER BY food_price ASC");
                    } else if($_SESSION['food_category'] == 'descending') {
                        $DBdata = mysqli_query($connectDB, "SELECT * FROM food WHERE kiosk_id = 1 ORDER BY food_price DESC");
                    } else {
                        $foodCategory = $_SESSION['food_category'];
                        $DBdata = mysqli_query($connectDB, "SELECT * FROM food WHERE kiosk_id = 1 AND food_category = '$foodCategory'");
                    }
                } else {
                    $DBdata = mysqli_query($connectDB, "SELECT * FROM food WHERE kiosk_id = 1");
                }
                if(mysqli_num_rows($DBdata) > 0) {
                    while($row = mysqli_fetch_array($DBdata)) {
                        if($row['food_availableDay'] == 'available') {
    ?>
                            <div class="menu_container">
    <?php
                        } else {
    ?>
                            <div class="unavailable_menu_container">
    <?php
                        }
    ?>
                                <div class="menu_left_container">
                                    <img src="<?php echo $row['food_image']?>" alt="food_image">
                                    <spa><?php echo $row['food_availableDay']?></spa>
                                    <br>
                                    <span><?php echo $row['food_remainingQuantity']?> remaining</span>
                                </div>
                                <div class="menu_right_container">
                                    <div><img src="./images/QR.png" alt="qrCode"></div>
                                    <p><b><?php echo $row['food_name']?></b></p>
                                    <p><?php echo $row['food_description']?></p>
                                    <p><b>RM <?php echo $row['food_price']?></b></p>
                                    <p><button type="submit" name="addFoodtoBasket" value="<?php echo $row['food_id']?>" <?php if($row['food_availableDay'] == 'unavailable') echo 'disabled';?>><i class="fa-solid fa-plus fa-2xl" style="color: #e40101;"></i></button></p>
                                </div>
                            </div>
    <?php
                    }
    ?>
                    <button type="submit" class="checkout_button" formaction="<?php echo htmlspecialchars('./basket.php')?>">View Basket</button>
    <?php
                } else {
                    echo '<div class="empty_basket_message">Seems like no food in this kiosk</div><br><br>';
                }
    ?>
            </form>
        </div>
    </body>
</html>