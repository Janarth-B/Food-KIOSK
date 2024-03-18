<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk1 Add Delete Menu</title>
    <link rel="stylesheet" href="../lucasStyle.css">
   
    
</head>
<body>
    <?php include('../partials/customerMenuBar.php'); ?>
    <!--  -->
    <!--  -->
    <!--  -->
    <?php 
        if(isset($_SESSION['kiosk_id'])) {
            unset($_SESSION['kiosk_id']);
        }
        $_SESSION['kiosk_id'] = $_GET['kiosk_id'];
    ?>
    <!--  -->
    <!--  -->
    <!--  -->
    <?php
        if(isset($_GET['kiosk_id'])) {

            $kioskId = $_GET['kiosk_id'];
            $result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM food WHERE kiosk_id= '$kioskId'");
            $row = mysqli_fetch_assoc($result);
            $rows = $row['count'];  
            
            $sql2 = "SELECT * FROM kiosk WHERE kiosk_id= '$kioskId'";
            $run2 = mysqli_query($conn, $sql2);
            $count2 = mysqli_num_rows($run2);

            if($count2 > 0) {
                while($row2 = mysqli_fetch_assoc($run2)) {
                    $kioskId = $row2['kiosk_id'];
                    $kioskName = $row2['kiosk_name'];
                    $kioskBusinessDay = $row2['kiosk_businessDay'];
                    $kioskOpenHour = $row2['kiosk_openHour'];
                    $kioskCloseHour = $row2['kiosk_closeHour'];
                    $kioskImg = $row2['kiosk_picture'];
                    $kioskStatus = $row2['kiosk_status'];
                    $kioskDescription = $row2['kiosk_description'];
    ?>

    <div class="container-fluid">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="no-underline text-reset link-primary" href="customerViewKiosk.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kiosk1</li>
            </ol>
        </nav>
    </div>

    <div class="container-fluid shadow p-3">
        <div class="row">
            <div class="col-2" style="height: 100px;">
                <img class="h-100" src="<?php echo SITEURL; ?>images/kiosk/<?php echo $kioskImg; ?>" alt="">              
            </div>
            <div class="col-10" style="height: 100px;">
                <div class="row row-cols-1 h-100">
                    <div class="col">
                        <h1><?php echo $kioskName; ?></h1>
                    </div>
                    <div class="col">
                        <h3 class="text-secondary mb-0 fs-6"><?php echo $kioskDescription; ?></h3>
                    </div>
                </div> 
            </div>
        </div>      
        <div class="row text-secondary m-3 g-0">
            <div class="col-2">
                <label for="">Opening Hours</label>
            </div>
            <div class="col-10">
                Today <?php echo $kioskOpenHour; ?>:00-<?php echo $kioskCloseHour; ?>:00
            </div>
        </div>
    </div>

    <?php            
                    }
                }
    ?>

    <?php
        if(isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        } 

        if(isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if(isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if(isset($_SESSION['unauthorize'])) {
            echo $_SESSION['unauthorize'];
            unset($_SESSION['unauthorize']);
        }

        if(isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
    ?>


<div class="container my-4 search-bar">
        <div class="row">
            <div class="col-8">
                <form class="d-flex" action="<?php echo SITEURL; ?>foodCustomer/customerFoodSearch.php" method="POST" role="search">
                    <input type="hidden" name="kioskId" value="<?php echo $kioskId; ?>">
                    <input class="form-control w-25 shadow transition" type="search" name="search" placeholder="Search" aria-label="Search">
                    <button class="btn search-btn transition" type="submit" name="submit" value="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            
            
        </div>
    </div>

    <div class="container mt-3 filter-container">
        <div class="row m-0 category-head">
            <div class="col">
                <ul onclick="categoryFilter()">
                    <div class="category-title active rounded-pill" id="all">
                        <li>All</li>
                    </div>
                    <div class="category-title rounded-pill" id="rice">
                        <li>Rice</li>
                    </div>
                    <div class="category-title rounded-pill" id="mee">
                        <li>Mee</li>
                    </div>
                    <div class="category-title rounded-pill" id="bread">
                        <li>Bread</li>
                    </div>
                    <div class="category-title rounded-pill" id="porridge">
                        <li>Porridge</li>
                    </div>
                    <div class="category-title rounded-pill" id="sides">
                        <li>Sides</li>
                    </div>
                    <div class="category-title rounded-pill" id="soup">
                        <li>Soup</li>
                    </div>
                    <div class="category-title rounded-pill" id="drink">
                        <li>Drink</li>
                    </div>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row row-cols-2 row-cols-md-3 g-3">

            <?php
                    if ($rows == 0) {
                        echo "The menu is empty.";
                    } else {
                        $sql = "SELECT * FROM food WHERE kiosk_id= $kioskId AND food_availability= 'Available' AND food_remainingQuantity> 0";
                        $run = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($run);

                        if($count > 0) {
                            while($row2 = mysqli_fetch_assoc($run)) {
                                $foodId = $row2['food_id'];
                                $foodImg = $row2['food_image'];
                                $foodName = $row2['food_name'];
                                $foodDescription = $row2['food_description'];
                                $foodPrice = $row2['food_price'];
                                $foodAvailability = $row2['food_availability'];
                                $foodQuantity = $row2['food_remainingQuantity'];
                                $foodCategory = $row2['food_category'];
                            
            ?>
            

            <form class="all <?php echo $foodCategory;?>" action="../processing.php" method="POST">
                <div class="col">
                    <div class="card mb-3 shadow transition">
                        <div class="container mt-3 mx-1">                     
                            <div class="row g-0 mb-0">
                                <div class="col-md-4" style="height: 120px; width: 120px;">
                                  <img src="../images/menu/<?php echo $foodImg; ?>" class="img-fluid rounded h-100" alt="...">                               
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body pb-0">
                                        <div class="row">                                     
                                            <div class="col-11 pe-0 h-100">
                                                <div style="height: 50px;">
                                                    <h5 class="card-title"><?php echo $foodName; ?></h5>
                                                </div>
                                                <div style="height: 50px;">
                                                    <p class="card-text text-secondary"><?php echo $foodDescription; ?></p>
                                                </div>
                                                
                                                
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p class="card-text text-primary fw-semibold fs-6 text-reset">
                                                            <span style="font-size: 12px;">RM</span><?php echo $foodPrice; ?>
                                                        </p>
                                                    </div>                                                 
                                                </div>
                                            </div>
                                            <div class="col-1 mt-n2" style="padding-left: 6px; padding-right: 12px;">
                                                <img src="../images/qr/qr_<?php echo $foodName;?>.png" style="width: 35px;" alt="">
                                            </div>
                                        </div>                                           
                                    </div>                                    
                                </div>
                            </div>   
                            <div class="row g-0 my-0 py-2">
                                <div class="col-md-4">
                                    <div class="col">
                                        <p class="card-text text-body-tertiary p-0 m-0"><?php echo $foodAvailability . ": "; echo $foodQuantity; ?></p>
                                    
                                    </div>
                                  
                                </div>
                                <div class="col-md-8">                                                   
                                    <div class="row justify-content-end" style="padding-left: 6px; padding-right: 12px;">
                                        <div class="col-6"></div>
                                        <div class="col-3 offset-2 btn-group">
                                            <button class="btn search-btn transition" type="submit" name="addFoodtoBasket" value="<?php echo $foodId;?>"
            <?php
                                                if(isset($_SESSION['basket_id']) && $_SESSION['basket_id'] != $_SESSION['kiosk_id']) {
                                                    echo 'disabled';
                                                }
            ?>
                                            >
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>                                 
                                </div>
                            </div>
                       </div>                
                    </div>
                </div>
            </form>
            
            <?php            
                            }
                        }
                    }                                                   
                }
                else {
                    echo '<script>window.location = "'. SITEURL . 'foodCustomer/customerManageMenu.php?kiosk_id=' . $kioskId . '";</script>';
                }       
            ?>



            
            

            

            
        </div>
    </div>
    


<?php
    if($rows != 0) {
?>
        <br><br><br>
        <form>
            <button type="submit" class="checkout_button" formaction="<?php echo htmlspecialchars('./basket.php')?>">View Basket</button>
        </form>
<?php
    }
?>



    <?php include('../partials/footer.php'); ?>

</body>
</html>