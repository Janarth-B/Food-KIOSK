<?php
 
include('conf.php');
 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap 5 Administration Dashboard</title>
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
 
<div class="navigation mb-4">
    <nav class="navbar navbar-expand-lg fixed-top navbar-light mb-5 bg-gradient">
        <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="../images/LogoUMP-removebg-preview.png" class="object-fit-cover" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item mx-3">
                        <a class="nav-link" aria-current="page" href="vendorManageMenu.php">Home</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="vendorOrderList.php">Order List</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link active" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item ms-3 me-5">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                </ul>
            </div>
            <a href="../loginWebsite/user_page.php" class="login me-3">
                <button type="button" class="btn btn-warning p-2">
                    <i class="fa-regular fa-user"></i>
                    Vendor
                </button>
            </a>                      
        </div>
    </nav> 
</div>
 
<?php 
    include('../config/constants.php');
    $vendor_id = $_SESSION['vendor_id'];

    $sql2 = "SELECT COUNT(orders_id) AS total2 FROM orders WHERE order_date= (SELECT CURDATE()) AND vendor_id= $vendor_id";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $sum2 = $row2['total2'];
    
    $sql3 = "SELECT SUM(orders_subtotal) AS total3 FROM orders WHERE order_date= (SELECT CURDATE()) AND vendor_id= $vendor_id";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_assoc($result3);
    $sum3 = $row3['total3'];

    $sql4 = "SELECT SUM(orders_subtotal)/COUNT(orders_id) AS total4 FROM orders WHERE order_date= (SELECT CURDATE()) AND vendor_id= $vendor_id";
    $result4 = mysqli_query($conn, $sql4);
    $row4 = mysqli_fetch_assoc($result4);
    $sum4 = number_format((float)$row4['total4'], 2, '.', '');

    $sql = "SELECT (SUM(orders_subtotal) + 12) AS total FROM orders WHERE order_date> '2023-12-01' AND order_date< '2023-12-31' AND vendor_id= $vendor_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $sum = $row['total'];

?>

<div class="container">
    <div class="row mb-3">
        <div class="col-lg-6">
            <div class="card bg-primary bg-gradient mb-2 bg-opacity-75">
                <div class="card-body text-white text-center">
                    <p class="h3 text-black">Sales (Daily)</p>
                    <p class="h2">RM <?php echo $sum3; ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card bg-success bg-gradient mb-2">
                <div class="card-body text-white text-center">
                    <p class="h3 text-black">Sales per orders (Daily)</p>
                    <p class="h2">RM <?php echo $sum4; ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card bg-warning bg-gradient mb-2 bg-opacity-75">
                <div class="card-body text-white text-center">
                    <p class="h3 text-black">Sales (Monthly)</p>
                    <p class="h2">RM <?php echo $sum; ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card bg-secondary bg-gradient mb-2 bg-opacity-75">
                <div class="card-body text-white text-center">
                    <p class="h3 text-black">Orders per day</p>
                    <p class="h2"><?php echo $sum2; ?> orders</p>
                </div>
            </div>
        </div>
        
    </div>
 
    <!-- 2nd row - Chart -->
    <div class="row my-5">
        <div class="col">
            <div class="card">
                <div class="card-header h4">Sales/ Orders (Monthly)</div>
                <div class="card-body">
                    <div id="chart_line"></div>
                </div>
            </div>
        </div>
    </div>
 
    <!-- 3rd row - Datatables -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header h4 bg-info">List of Food Sold</div>
                <div class="card-body">
                    <table id="stf_dt" class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">NO</th>
                                <th scope="col">Food Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity Sold</th>
                                <th scope="col">Total Sale</th>
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
    $.post('api.php?getSales=1', {test: 123}, function (res) {
        console.log(res)
        var options = {
          series: [{
            name: "Sales (RM)",
            data: res.sales
          },
          {
            name: "Orders",
            data: res.orders
          },
        ],
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: [5, 7, 5],
          curve: 'straight',
          dashArray: [0, 8, 5]
        },
        title: {
          text: 'Sales(RM)/ Orders',
          align: 'left'
        },
        legend: {
          tooltipHoverFormatter: function(val, opts) {
            return val + ' - <strong>' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + '</strong>'
          }
        },
        markers: {
          size: 0,
          hover: {
            sizeOffset: 6
          }
        },
        xaxis: {
          categories: res.bulan,
        },
        tooltip: {
          y: [
            {
              title: {
                formatter: function (val) {
                  return val + " per month"
                }
              }
            },
            {
              title: {
                formatter: function (val) {
                  return val + " per month"
                }
              }
            },
            {
              title: {
                formatter: function (val) {
                  return val;
                }
              }
            }
          ]
        },
        grid: {
          borderColor: '#f1f1f1',
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart_line"), options);
        chart.render();
    }, 'json')
 
    

    
 
    /* ========================================================================== Ni coding utk Staff DT */
    $.post('api.php?getFoodSold=1', {test: 123}, function (res) {
        console.log(res)
        
        for(var i = 0; i < res.length; i++)
        {
            $('#stf_dt tbody').append(`
                <tr>
                    <td>${i+1}</td>
                    <td>${res[i].fName}</td>
                    <td>${res[i].fPrice}</td>
                    <td>${res[i].fQuantity}</td>
                    <td>${res[i].fTotal}</td>
                </tr>
            `)
            
        }
 
        new DataTable('#stf_dt')
    }, 'json')
 
    /* ========================================================================== Real-time Shipping */
    setInterval(function(){
        $.post('api.php?getshipping=1', {}, function (res) {
            $('#ship_incomp').html(res.incomp)
            $('#ship_total').html(res.total)
        }, 'json')
    }, 1000)
    // short-polling
 
});
 
</script>
</html>