<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="./lucasStyle.css">
        <script src="./lucasFontawesome.js"></script>
    </head>
    <body>
        <div class="prevent_hidden_blur">
            <div class="header">
                <img src="./images/LogoUMP-removebg-preview.png" alt="Logo UMP" class="float_left">
                <ul>
                    <li>HOME</li>
                    <li>Order Status</li>
                    <li>MembershipCard</li>
                    <li>Dashboard</li>
                    <li>Setting</li>
                </ul>
                <div class="cart_border">
                    <a><i class="fa-solid fa-cart-shopping" style="color: #000000;"></i></a>
                </div>
                <button>Login / Sign Up</button>
            </div>
            <hr class="hr_blur">
            <div class="filter_menu">
                <a><i class="fa-solid fa-filter fa-2xl" style="color: #51aecd;"></i>Filter</a>
            </div>
            <form>
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
                            <div class="menu_container_blur">
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
                                    <p><button disabled><i class="fa-solid fa-plus fa-2xl" style="color: #e40101;"></i></button></p>
                                </div>
                            </div>
    <?php
                    }
    ?>
                    <button class="checkout_button">View Basket</button>
    <?php
                } else {
                    echo '<div class="empty_basket_message">Seems like no food in this kiosk</div><br><br>';
                }
    ?>
            </form>
        </div>
        <form action="<?php echo htmlspecialchars('./processing.php')?>" method="POST">
            <div class="filter_container">
                <div><a href="./selectFood.php"><i class="fa-solid fa-square-xmark fa-2xl" style="color: #cd0a0a;"></i></a></div>
                <div class="filter_sort">
                    <h2>Filter by Category</h2>
    <?php
                    $foodCategoryData = mysqli_query($connectDB, "SELECT DISTINCT food_category FROM food WHERE kiosk_id = 1 ORDER BY food_category");
                    while($row = mysqli_fetch_array($foodCategoryData)) {
    ?>
                        <input type="radio" id="<?php echo $row['food_category']?>" name="food_category" value="<?php echo $row['food_category']?>">
                        <label for="<?php echo $row['food_category']?>"><?php echo $row['food_category']?></label>
                        <br><br>
    <?php
                    }
    ?>
                </div>
                <div class="filter_sort">
                        <h2>Sort by Price</h2>
                        <input type="radio" id="asc" name="food_category" value="ascending" required>
                        <label for="asc">Ascending</label>
                        <br><br>
                        <input type="radio" id="desc" name="food_category" value="descending">
                        <label for="desc">Descending</label>
                </div>
                <div class="filter_sort_button_container">
                    <input type="submit" class="receipt_button" name="remove_filter" value="Remove Filter" formnovalidate>
                    <input type="submit" class="receipt_button" name="filtering" value="Filter">
                </div>
            </div>
        </form>
    </body>
</html>