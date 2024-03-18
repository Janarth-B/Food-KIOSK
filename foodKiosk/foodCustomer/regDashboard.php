<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registered User Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
 
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   
    <!-- Datatables -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.5/fc-4.3.0/fh-3.4.0/datatables.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.5/fc-4.3.0/fh-3.4.0/datatables.min.js"></script>
   
    <!-- Apex Chart -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
 
    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="../node_modules/vendorStyle.css">
</head>
<body>
<?php 
    include('../partials/customerDashboardMenuBar.php');
    $connnectDB = mysqli_connect('localhost', 'root', '', 'web_project');
    $user_id = $_SESSION['user_id'];

    $sqlRs = mysqli_fetch_array(mysqli_query($connnectDB, "SELECT SUM(orders_subtotal) AS todaySpending FROM orders WHERE user_id = $user_id AND order_date = (SELECT CURRENT_DATE()) AND orders_status IS NOT NULL"));
    
    $sqlRs2 = mysqli_fetch_array(mysqli_query($connnectDB, "SELECT SUM(orders_subtotal) AS monthSpending FROM orders WHERE user_id = $user_id AND YEAR(order_date) = YEAR(CURRENT_DATE()) AND MONTH(order_date) = MONTH(CURRENT_DATE()) AND orders_status IS NOT NULL"));

    $sqlRs3 = mysqli_fetch_array(mysqli_query($connnectDB, "SELECT COUNT(orders_id) AS ordersNum FROM orders WHERE user_id = '$user_id' AND orders_status IS NOT NULL"));

    $sqlRs4 = mysqli_fetch_array(mysqli_query($connnectDB, "SELECT COUNT(payment_id) AS cardUsage FROM orders JOIN payment USING(orders_id) WHERE user_id = '$user_id' AND payment_method = 'Membership Card' AND orders_status IS NOT NULL"));
?>

<div class="container">
    <div class="row mb-3">
        <div class="col-lg-3">
            <div class="card bg-danger bg-gradient mb-2 bg-opacity-75">
                <div class="card-body text-white text-center">
                    <p class="h3 text-black">Total Spending (Today)</p>
                    <p class="h2">RM <?php if($sqlRs['todaySpending'] == 0) {echo 0; } else {echo $sqlRs['todaySpending']; }; ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card bg-secondary bg-gradient mb-2 bg-opacity-75">
                <div class="card-body text-white text-center">
                    <p class="h3 text-black">Total Spending (Month)</p>
                    <p class="h2">RM <?php if($sqlRs2['monthSpending'] == 0) {echo 0; } else {echo $sqlRs2['monthSpending']; }?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card bg-info bg-gradient mb-2">
                <div class="card-body text-white text-center">
                    <p class="h3 text-black">Total Number of Orders</p>
                    <p class="h2"><?php echo $sqlRs3['ordersNum'] ; ?> Orders</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card bg-warning bg-gradient mb-2">
                <div class="card-body text-white text-center">
                    <p class="h3 text-black">Usage of Membership Card</p>
                    <p class="h2"><?php echo $sqlRs4['cardUsage']; ?> Orders</p>
                </div>
            </div>
        </div>
    </div>
 
    <!-- 2nd row - Chart 1 -->
    <div class="row my-5">
        <div class="col">
            <div class="card">
                <div class="card-header h4">Spending (Monthly)</div>
                <div class="card-body">
                    <div id="chart_line"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3rd row - Chart 2 -->
    <div class="row my-5">
        <div class="col">
            <div class="card">
                <div class="card-header h4">Points (Received & Redeemed)</div>
                <div class="card-body">
                    <div id="chart_line2"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3rd row - Pie Chart -->
    <div class="row my-5">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header h4">Favourite Kiosk</div>
                <div class="card-body">
                    <div id="chart_pie1"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header h4">Favourite Menu</div>
                <div class="card-body">
                    <div id="chart_pie2"></div>
                </div>
            </div>
        </div>
    </div>
 
    <!-- 4rd row - Datatables -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header h4 bg-info">List of Latest 10 Orders</div>
                <div class="card-body">
                    <table id="stf_dt" class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Subtotal (RM)</th>
                                <th scope="col">Payment Method</th>
                                <th scope="col">Payment Date</th>
                                <th scope="col">Collect Date</th>
                                <th scope="col">Points Received</th>
                                <th scope="col">Points Redeemed</th>
                            </tr>
                        </thead>
                        <tbody>
 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../partials/footer.php'); ?>
 
</body>
 
<script>
 
$(document).ready(function() {
 
    /* ========================================================================== Ni coding utk line chart */
    $.post('api.php?getSpending=1', {test: 123}, function (res) {
        console.log(res)
        var options = {
                series: [{
                name: "Spending (RM)",
                data: res.total
            }],
                chart: {
                height: 350,
                type: 'line',
                zoom: {
                enabled: false
                }
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                curve: 'straight'
            },
            // title: {
            //  text: 'Profit Gain Trends by Month',
            //  align: 'left'
            // },
            colors: ['#FF9800'],
            grid: {
                row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
                },
            },
            xaxis: {
                categories: res.bulan,
            }
        };
 
        var chart = new ApexCharts(document.querySelector("#chart_line"), options);
        chart.render();
    }, 'json')

    $.post('api.php?getPoints=1', {test: 123}, function (res) {
        console.log(res)
        var options = {
                series: [{
                name: "Points Received",
                data: res.points1}, {
                name: "Points Redeemed",
                data: res.points2
            }],
                chart: {
                height: 350,
                type: 'line',
                zoom: {
                enabled: false
                }
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                curve: 'smooth'
            },
            // title: {
            //  text: 'Profit Gain Trends by Month',
            //  align: 'left'
            // },
            colors: ['#66DA26', '#E91E63'],
            grid: {
                row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
                },
            },
            xaxis: {
                categories: res.bulan,
            }
        };
 
        var chart = new ApexCharts(document.querySelector("#chart_line2"), options);
        chart.render();
    }, 'json')
 
    $.post('api.php?getFavouriteKiosk=1', {test: 123}, function (res) {
        console.log(res)
        var options = {
                series: res.kioskFrequency,
                labels: res.kioskName, 
                chart: {
                height: 300,
                type: 'donut',
                zoom: {
                enabled: false
                }
            }, 
            colors: ['#546E7A'],
        }
 
        var chart = new ApexCharts(document.querySelector("#chart_pie1"), options);
        chart.render();
    }, 'json')

    $.post('api.php?getFavouriteMenu=1', {test: 123}, function (res) {
        console.log(res)
        var options = {
                series: res.menuQuantity,
                labels: res.foodCategory, 
                chart: {
                height: 300,
                type: 'pie',
                zoom: {
                enabled: false
                }
            }
        }
 
        var chart = new ApexCharts(document.querySelector("#chart_pie2"), options);
        chart.render();
    }, 'json')

    $.post('api.php?getOrder=1', {test: 123}, function (res) {
        console.log(res)
        for(var i = 0; i < res.length; i++)
        {
            $('#stf_dt tbody').append(`
                <tr>
                    <td>${res[i].orders_id}</td>
                    <td>${res[i].orders_subtotal}</td>
                    <td>${res[i].payment_method}</td>
                    <td>${res[i].payment_dateTime}</td>
                    <td>${res[i].orders_collectTime}</td>
                    <td>${res[i].points_received}</td>
                    <td>${res[i].points_redeemed}</td>
                </tr>
            `)
        }
 
        new DataTable('#stf_dt')
    }, 'json')
 
});
 
</script>
</html>