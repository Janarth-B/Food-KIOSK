<?php include('../config/constants.php'); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="../node_modules/vendorStyle.css">


<script src="../node_modules/popper.min.js"></script>
<script src="../node_modules/jquery-3.7.1.min.js"></script>
<script src="../node_modules/script.js"></script>


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
                        <a class="nav-link active" aria-current="page" href="vendorManageMenu.php">Home</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="vendorOrderList.php">Order List</a>
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

<?php
    if(!(isset($_SESSION['admin_id']) || isset($_SESSION['vendor_id']) || isset($_SESSION['user_id']))){
        header('location:../loginWebsite/login_form.php');
     }
?>