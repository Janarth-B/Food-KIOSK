<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk1 Add Delete Menu</title>

    
</head>
<body>
    <?php include('../partials/vendorMenuBar.php'); ?>

    

    <div class="container-fluid shadow p-3">
        <div class="row">
            <div class="col-2" style="height: 100px;">
                <img class="h-100" src="./images/Kiosk1.jpg" alt="">              
            </div>
            <div class="col-10" style="height: 100px;">
                <div class="row row-cols-1 h-100">
                    <div class="col">
                        <h1>KIOSK 1</h1>
                    </div>
                    <div class="col">
                        <h3 class="text-secondary mb-0 fs-6">Clean food, HengHe flavour, Masala taste</h3>
                    </div>
                </div> 
            </div>
        </div>      
        <div class="row text-secondary m-3 g-0">
            <div class="col-2">
                <label for="">Opening Hours</label>
            </div>
            <div class="col-10">
                Today 10:00-20:00
            </div>
        </div>
    </div>

    <div class="container mt-4 search-bar">
        <div class="row">
            <div class="col-8">
                <?php 
                    $search = $_POST['search'];
                    $kioskId = $_POST['kioskId'];
                ?>
                <form class="d-flex" action="<?php echo SITEURL; ?>foodVendor/vendorFoodSearch.php" method="POST" role="search">
                    <input type="hidden" name="kioskId" value="<?php echo $kioskId; ?>">
                    <input class="form-control w-25 shadow transition" type="search" name="search" value="<?php echo $search; ?>" aria-label="Search">
                    <button class="btn search-btn transition" type="submit" name="submit" value="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <div class="col-4">
                <a href="<?php echo SITEURL; ?>foodVendor/vendorAddNewMenu.php?kiosk_id=<?php echo $kioskId; ?>" class="btn search-btn ms-auto float-end transition">
                        <i class="fa-solid fa-plus d-inline-block me-2"></i>
                        <span class="d-inline-block">Add Menu</span>
                
                </a>         
            </div>
            
        </div>
    </div>

   

    <div class="container">
        <div class="row row-cols-2 row-cols-md-3 g-3 mt-4">

            <?php 
                $sql = "SELECT * FROM food WHERE food_name LIKE '%$search%' OR food_description LIKE '%$search%'";

                $run = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($run);

                if($count > 0) {
                    while($row = mysqli_fetch_assoc($run)) {
                        $foodId = $row['food_id'];
                        $foodImg = $row['food_image'];
                        $foodName = $row['food_name'];
                        $foodDescription = $row['food_description'];
                        $foodPrice = $row['food_price'];
                        $foodAvailability = $row['food_availability'];
                        $foodQuantity = $row['food_remainingQuantity'];


            ?>        

            <form action="delete_food.php" method="GET">
                <div class="col">
                    <div class="card mb-3 shadow transition">
                        <div class="container mt-3 mx-1">                     
                            <div class="row g-0 mb-0">
                                <div class="col-md-4" style="height: 120px; width: 120px;">
                                    <?php
                                        if($foodImg == "") {
                                            echo "<div class='error h-100'>Image not Available.</div>";
                                        }
                                        else {
                                            ?>
                                            <img src="../images/menu/<?php echo $foodImg; ?>" class="img-fluid rounded h-100" alt="...">
                                            <?php
                                        }
                                    ?>
                                                                   
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body pb-0">
                                        <div class="row">                                     
                                            <div class="col-10" style="height: 100px;">
                                                <h5 class="card-title"><?php echo $foodName; ?></h5>
                                                <p class="card-text text-secondary"><?php echo $foodDescription; ?></p>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p class="card-text text-primary fw-semibold fs-6 text-reset">
                                                            <span style="font-size: 12px;">RM</span><?php echo $foodPrice; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-3 offset-2 btn-group">
                                                        
                                                        

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-2 mt-n2">
                                                <img src="./images/QR.png" style="width: 35px;" alt="">
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
                                    
                                        <div class="col-10">
                                            <div class="row">
                                                <div class="col-6"></div>
                                                <div class="col-3 offset-2 btn-group">
                                                        <a href="<?php echo SITEURL;?>foodVendor/vendorUpdateMenu.php?food_id=<?php echo $foodId; ?>" class="btn search-btn rounded transition" style="--bs-btn-padding-y: .2rem; --bs-btn-padding-x: .75rem; --bs-btn-font-size: .9rem;">
                                                            Edit
                                                        </a>

                                                          
                                                        <a href="<?php echo SITEURL;?>foodVendor/vendorDeleteFood.php?food_id=<?php echo $foodId; ?>&food_image=<?php echo $foodImg; ?>&kiosk_id=<?php echo $kioskId; ?>" class="btn border-0 rounded mx-2 transition" style="--bs-btn-padding-y: .2rem; --bs-btn-padding-x: .75rem; --bs-btn-font-size: .9rem;">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </a>
                                                        
                                                            
                                                        

                                                    </div>
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
                else {
                    echo "<div class='error'>Food not found.</div>";
                }
            
            ?>


            
            

            

            
        </div>
    </div>
    
    
    
    <?php include('../partials/footer.php'); ?>



    
</body>
</html>