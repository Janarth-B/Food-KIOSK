<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Order List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
                            <a class="nav-link active" href="#">Order List</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link" href="vendorDashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item ms-3 me-5">
                            <a class="nav-link" href="#">Profile</a>
                        </li>
                    </ul>
                </div>
                <a href="../loginWebsite/vendor_page.php" class="login me-3">
                    <button type="button" class="btn btn-warning p-2">
                        <i class="fa-regular fa-user"></i>
                        Vendor
                    </button>
                </a>                      
            </div>
        </nav> 
    </div>

    <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header bg-dark-subtle bg-gradient">
                                    <h4 class="text-black">
                                        Order List
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <table class='table table-bordered table-striped' id="platinum-list">
                                        <tr>
                                            <th>NO</th>
                                            <th class="text-center">User Name</th>
                                            <th class="text-center">Phone Number</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Order Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>

                                        <?php
                                            $connectDB = mysqli_connect("localhost", "root", "", "web_project");
                                            $vendor_id = $_SESSION['vendor_id'];
                                            $allOrdersInfo = mysqli_query($connectDB, "SELECT * 
                                                                                        FROM (orders 
                                                                                        JOIN registered_or_general_user USING(user_id)) 
                                                                                        WHERE vendor_id = '$vendor_id' AND (orders_status = 'Ordered' OR orders_status = 'Prepared')");
                                            $ordersInfo = mysqli_query($connectDB, "SELECT * 
                                                                                    FROM (orders 
                                                                                    JOIN registered_user USING(user_id)) 
                                                                                    WHERE vendor_id = '$vendor_id' AND (orders_status = 'Ordered' OR orders_status = 'Prepared')");
                                            $ordersInfo2 = mysqli_query($connectDB, "SELECT * 
                                                                                    FROM (orders 
                                                                                    JOIN registered_user USING(user_id)) 
                                                                                    WHERE vendor_id = '$vendor_id' AND (orders_status = 'Ordered' OR orders_status = 'Prepared')");
                                            if(mysqli_num_rows($allOrdersInfo) > 0) {
                                                $countOrders = 1;
                                                while($allOrdersInfoRow = mysqli_fetch_array($allOrdersInfo)) {
                                        ?>
                                                    <tr>
                                                        <td class="fw-bold align-middle"><?php echo $countOrders;?></td>
                                                        <td class="align-middle">
                                        <?php
                                                            while($usernameInfoRow = mysqli_fetch_array($ordersInfo)) {
                                                                if($allOrdersInfoRow['user_id'] == $usernameInfoRow['user_id']) {
                                                                    echo $usernameInfoRow['registered_username'];
                                                                    break;
                                                                }
                                                            }
                                        ?>
                                                        </td>
                                                        <td class="text-center align-middle">
                                        <?php
                                                            echo $allOrdersInfoRow['registered_phoneNum'];
                                        ?>
                                                        </td>
                                                        <td class="text-center align-middle">
                                        <?php
                                                            while($emailInfoRow = mysqli_fetch_array($ordersInfo2)) {
                                                                if($allOrdersInfoRow['user_id'] == $emailInfoRow['user_id']) {
                                                                    echo $emailInfoRow['registered_email'];
                                                                    break;
                                                                }
                                                            }
                                        ?>
                                                        </td>
                                                        <td class="d-flex justify-content-center"><button type="button" class="btn btn-outline-primary rounded-0 disabled">Ordered</button></td>
                                                        <td>
                                                            <div class="row justify-content-center">
                                                                <div class="col-auto">
                                                                    <form action="./vendorUpdateOrderStatus.php" method="POST">
                                                                        <input type="hidden" name="user_id" value="<?php echo $allOrdersInfoRow['user_id']; ?>">
                                                                        <button type="submit" name="updateOrderStatus" class="btn btn-success" value="Update">Update Status</button>
                                                                    </form>   
                                                                </div>
                                                            </div>                 
                                                        </td>
                                                    </tr>
                                        <?php
                                                    $countOrders++;
                                                }
                                            }
                                        ?>

                                    </table>  
                                         
                                </div>
                            </div>
                            
                        </div> 
                        
                    </div>
                    
                
                </div>
            </main>

    <?php
        if(!(isset($_SESSION['vendor_id']) OR isset($_SESSION['admin_id']) OR isset($_SESSION['user_id']))) {
            header("location:../loginWebsite/login_form.php");
        }
    ?>

    <script src="../node_modules/popper.min.js"></script>
    <script src="../node_modules/jquery-3.7.1.min.js"></script>
    <script src="../node_modules/script.js"></script>
    <script src="../lucasIndex.js"></script>
    
</body>
</html>