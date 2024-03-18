<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Update Menu</title>
</head>
<body>
    <?php include('../partials/adminMenuBar.php') ?>

    <?php 
        if(isset($_GET['food_id'])) {
            $foodId = $_GET['food_id'];
            $sql = "SELECT * FROM food WHERE food_id= $foodId";
            $run = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($run);

            $kioskId = $row['kiosk_id'];
            $foodName = $row['food_name'];
            $foodDescription = $row['food_description'];
            $foodPrice = $row['food_price'];
            $foodCurrentImg = $row['food_image'];
            $foodQuantity = $row['food_remainingQuantity'];
            $foodCategory = $row['food_category'];
            $foodAvailability = $row['food_availability'];

        
    ?>
    

    <div class="container">
        <div class="row">
            <div class="col-10 offset-1">
                <div class="border shadow p-5 mb-5">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                        <legend class="mb-3 fw-bold fs-3">UPDATE FOOD BASIC INFORMATION</legend>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm fs-6">Current Food Image</label>
                            <div class="col-sm-10" style="height: 100px;">
                                <?php
                                    if($foodCurrentImg == "") {
                                        echo "<div class='error'>Image not Available.</div>";
                                    }
                                    else {
                                ?>
                                        <img class="h-100" src="<?php echo SITEURL; ?>images/menu/<?php echo $foodCurrentImg; ?>" alt="No Image">
                                <?php

                                    }
                                ?>                  
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="foodImg" class="col-sm-2 col-form-label col-form-label-sm fs-6">Select New Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="foodImg" name="foodImg"/>                      
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="foodName" class="col-sm-2 col-form-label col-form-label-sm fs-6">Food Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" id="foodName" name="foodName" value="<?php echo $foodName; ?>" maxlength="40">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="foodPrice" class="col-sm-2 col-form-label col-form-label-sm fs-6">Food Price (RM)</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control form-control-sm" id="foodPrice" name="foodPrice" value="<?php echo $foodPrice; ?>" min="0" step="0.01">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="foodCategory" class="col-sm-2 col-form-label col-form-label-sm fs-6">Food Category</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="foodCategory" name="foodCategory" aria-label="Default select example">
                                    <option disabled>Category</option>
                                    <option <?php if($foodCategory=="rice") {echo "selected";} ?> value="rice">Rice</option>
                                    <option <?php if($foodCategory=="mee") {echo "selected";} ?> value="mee">Mee</option>
                                    <option <?php if($foodCategory=="bread") {echo "selected";} ?> value="bread">Bread</option>
                                    <option <?php if($foodCategory=="porridge") {echo "selected";} ?> value="porridge">Porridge</option>
                                    <option <?php if($foodCategory=="sides") {echo "selected";} ?> value="sides">Sides</option>
                                    <option <?php if($foodCategory=="soup") {echo "selected";} ?> value="soup">Soup</option>
                                    <option <?php if($foodCategory=="drink") {echo "selected";} ?> value="drink">Drink</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="foodDescription" class="col-sm-2 col-form-label col-form-label-sm fs-6">Food Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="foodDescription" name="foodDescription" rows="3" maxlength="40"><?php echo $foodDescription; ?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm fs-6">Availability(Today)</label>
                            <div class="col-sm-10 align-content-center my-auto">
                                <div class="form-check form-check-inline">
                                  <input <?php if($foodAvailability=="Available") {echo "checked";} ?> class="form-check-input" name="foodAvailability" id="available" type="radio" value="Available">
                                  <label class="form-check-label" for="available">Available</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input <?php if($foodAvailability=="Non-Available") {echo "checked";} ?> class="form-check-input" name="foodAvailability" id="non-available" type="radio" value="Non-Available" onclick="zeroQuantity()">
                                  <label class="form-check-label" for="non-available">Non-Available</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="foodQuantity" class="col-sm-2 col-form-label col-form-label-sm fs-6">Quantity(Today)</label>
                            <div class="col-sm-10 my-auto">
                                <input type="number" class="form-control form-control-sm" id="foodQuantity" value="<?php echo $foodQuantity; ?>" name="foodQuantity">
                            </div>
                        </div>

                        <input type="hidden" name="foodId" id="foodId" value="<?php echo $foodId; ?>">
                        <input type="hidden" name="kioskId" id="kioskId" value="<?php echo $kioskId; ?>">
                        <input type="hidden" name="currentImg" id="currentImg" value="<?php echo $foodCurrentImg; ?>">

                        <div class="row">
                            <div class="col-3 offset-9 btn-group">
                                <a href="<?php echo SITEURL; ?>foodAdmin/adminManageMenu.php?kiosk_id=<?php echo $kioskId; ?>" class="btn btn-light rounded transition border border-dark mx-2" style="--bs-btn-padding-y: .2rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .9rem;">Cancel</a>
                                <button class="btn btn-primary rounded transition" type="submit" name="submit" style="--bs-btn-padding-y: .2rem; --bs-btn-padding-x: .75rem; --bs-btn-font-size: .9rem;">Update</button>
                            </div>
                        </div>
                    
                    </form> 
    <?php
        }
    ?>

                    <?php
                        if(isset($_POST['submit'])) {
                            $foodId = $_POST['foodId'];
                            $kioskId = $_POST['kioskId'];
                            $foodName = $_POST['foodName'];
                            $currentImg = $_POST['currentImg'];
                            $foodPrice = $_POST['foodPrice'];
                            $foodCategory = $_POST['foodCategory'];
                            $foodDescription = $_POST['foodDescription'];
                            $foodAvailability = $_POST['foodAvailability'];
                            $foodQuantity = $_POST['foodQuantity'];
                            // Define $foodImg here
                            $foodImg = $currentImg;
                        
                            if(isset($_FILES['foodImg']['name'])) {
                                $foodImg = $_FILES['foodImg']['name'];
                            
                                if($foodImg != "") {
                                    $image_info = explode(".", $foodImg);
                                    $ext = end($image_info);
                                    $foodImg = "Food_Name_" . rand(0000, 9999) . "." . $ext;
                                
                                    $src = $_FILES['foodImg']['tmp_name'];
                                    $dst = "../images/menu/" . $foodImg;
                                    $upload = move_uploaded_file($src, $dst);
                                
                                    if($upload == false) {
                                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                                        echo '<script>window.location = "'. SITEURL . 'foodAdmin/adminAddNewMenu.php?kiosk_id=' . $kioskId . '";</script>';
                                        die();
                                    }
                                
                                    if($currentImg != "") {
                                        $imgPath = "../images/menu/" . $currentImg;                                      
                                        $removeImg = unlink($imgPath);

                                        if($removeImg == false) {
                                            $_SESSION['upload'] = "<div>Failed to remove Food Image</div>";
                                            echo '<script>window.location = "'. SITEURL . 'foodAdmin/adminAddNewMenu.php?kiosk_id=' . $kioskId . '";</script>';
                                            die();
                                        }
                                    }
                                }
                                else {
                                    $foodImg = $currentImg;
                                }
                            }
                        
                            $qrPath = "../images/qr/qr_" . $foodName . ".png";
                            $removeQr = unlink($qrPath);
                        
                            $sql2 = "UPDATE food SET kiosk_id = $kioskId, food_name = '$foodName', food_image = '$foodImg', food_description = '$foodDescription', food_price = $foodPrice, food_remainingQuantity = $foodQuantity, food_category = '$foodCategory', food_availability = '$foodAvailability' WHERE food_id = $foodId";
                            $run2 = mysqli_query($conn, $sql2);
                        
                            if($run2 == true) {
                                $_SESSION['update'] = $foodName;
                                echo '<script>window.location = "'. SITEURL . 'foodAdmin/adminManageMenu.php?kiosk_id=' . $kioskId . '";</script>';
                            }
                            else {
                                $_SESSION['update'] = "<div class='error'>Failed to Update Food..</div>";
                                echo '<script>window.location = "'. SITEURL . 'foodAdmin/adminManageMenu.php?kiosk_id=' . $kioskId . '";</script>';
                            }
                        }
                    ?>  
                </div>
            </div>
        </div>
    </div>


    

</body>
</html>

