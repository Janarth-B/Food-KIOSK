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
                    <a href=""><i class="fa-solid fa-cart-shopping" style="color: #000000;"></i></a>
                </div>
                <button>Login / Sign Up</button>
            </div>
            <hr class="hr_blur">
            <div class="user_graph_container">
                <div class="align_graph">
                    <img src="./images/Kiosk1.jpg" alt="insightfulGraph">
                </div>
                <div class="align_button_right">
                    <button type="button" class="user_dashboard_button">View by week</button>
                    <button type="button" class="user_dashboard_button">View by month</button>
                </div>
            </div>
            <br><br>
            <div class="user_graph_container2">
                <button type="button" onclick="location.href = './userDashboardDesc.php'"><i class="fa-solid fa-sort fa-2xl" style="color: #000000;"></i></button>
                <div class="user_report_container">
                    <h2>Frequently Visited Kiosk</h2>
                    <div class="user_report_ranking_container">
                        <table>
        <?php
                            $connectDB = mysqli_connect("localhost", "root", "", "web_project");
                            $DBdata = mysqli_query($connectDB, "SELECT COUNT(DISTINCT orders_id), kiosk_name 
                                                                FROM (((kiosk 
                                                                JOIN food USING(kiosk_id)) 
                                                                JOIN orders_item USING(food_id)) 
                                                                JOIN orders USING(orders_id)) 
                                                                WHERE user_id = 1 AND orders_status = 'Completed' 
                                                                GROUP BY kiosk_id 
                                                                ORDER BY COUNT(DISTINCT orders_id) ASC");
                            $countList = 1;
                            while($row = mysqli_fetch_array($DBdata)) {
        ?>
                                <tr>
                                    <td><?php echo "{$countList}. "?></td>
                                    <td><?php echo $row['kiosk_name']?></td>
                                    <td><?php echo '--- ' . $row['COUNT(DISTINCT orders_id)']?></td>
                                </tr>
        <?php
                                $countList++;
                            }
        ?>
                        </table>
                    </div>
                </div>
                <div class="user_report_container">
                    <h2>Your Favourite Menu</h2>
                    <div class="user_report_ranking_container">
                        <table>
        <?php
                            $DBdata = mysqli_query($connectDB, "SELECT SUM(item_quantity), food_name 
                                                                FROM ((orders_item 
                                                                JOIN food USING(food_id)) 
                                                                JOIN orders USING(orders_id)) 
                                                                WHERE user_id = 1 AND orders_status = 'Completed' 
                                                                GROUP BY food_id 
                                                                ORDER BY SUM(item_quantity) ASC");
                            $countList = 1;
                            while($row = mysqli_fetch_array($DBdata)) {
        ?>
                                <tr>
                                    <td><?php echo "{$countList}. "?></td>
                                    <td><?php echo $row['food_name']?></td>
                                    <td><?php echo '--- ' . $row['SUM(item_quantity)']?></td>
                                </tr>
        <?php
                                $countList++;
                            }
        ?>
                        </table>
                    </div>
                </div>
            </div>
            <br><br>
            <hr class="hr_blur">
            <div class="footer">
                <div class="copyRight">
                    <p>Copyright &COPY;<script>document.write(new Date().getFullYear())</script> KIOSK UMPSA</p>
                    <p>Universiti Malaysia Pahang,<br> 26600 Pekan,<br> Pahang</p>
                </div>
                <div class="bottom_page_navigation">
                    <table>
                        <tr><td colspan="3"><a href="">HOME</a></td></tr>
                        <tr><td colspan="3"><a href="">MembershipCard</a></td></tr>
                        <tr><td colspan="3"><a href="">Dashboard</a></td></tr>
                        <tr><td colspan="3"><a href="">Setting</a></td></tr>
                        <tr>
                            <td><a href=""><i class="fa-brands fa-facebook" style="color: #000000;"></i></a></td>
                            <td><a href=""><i class="fa-brands fa-instagram" style="color: #000000;"></i></a></td>
                            <td><a href=""><i class="fa-brands fa-x-twitter" style="color: #000000;"></i></a></td>
                        </tr>
                    </table>
                </div>
                <div class="bottom_help_navigation">
                    <table>
                        <tr><td><a href="">Help Center</a></td></tr>
                        <tr><td><a href="">Terms and Conditions</a></td></tr>
                        <tr><td><a href="">Privacy Policy</a></td></tr>
                        <tr><td><a href="">FAQs</a></td></tr>
                        <tr><td><a href="">About</a></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>