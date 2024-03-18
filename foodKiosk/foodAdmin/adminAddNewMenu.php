<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Menu</title>

    
</head>
<body>
    <?php include('../partials/adminMenuBar.php'); ?>

    <?php
        if(isset($_GET['kiosk_id'])) {
            $kioskId = $_GET['kiosk_id'];
        }
    ?>
    

    <div class="container">
        <div class="row">
            <div class="col-10 offset-1">
                <div class="border shadow p-5 mb-5">

                    <?php
                        if(isset($_SESSION['upload'])) {
                            echo $_SESSION['upload'];
                            unset($_SESSION['upload']);
                        } 
                    ?>

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                        <legend class="mb-3 fw-bold fs-3">ADD NEW MENU</legend>
                        <div class="row mb-3">
                            <label for="foodImg" class="col-sm-2 col-form-label col-form-label-sm fs-6">Food Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" for="foodImg" name="foodImg" id="foodImg"/>                      
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="foodName" class="col-sm-2 col-form-label col-form-label-sm fs-6">Food Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" name="foodName" id="foodName" placeholder="Nasi Goreng" maxlength="40">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="foodPrice" class="col-sm-2 col-form-label col-form-label-sm fs-6">Food Price (RM)</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control form-control-sm" name="foodPrice" id="foodPrice" placeholder="12.00" min="0" step="0.01">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="foodCategory" class="col-sm-2 col-form-label col-form-label-sm fs-6">Food Category</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="foodCategory" id="foodCategory" aria-label="Default select example">
                                    <option selected disabled>Category</option>
                                    <option value="rice">Rice</option>
                                    <option value="mee">Mee</option>
                                    <option value="bread">Bread</option>
                                    <option value="porridge">Porridge</option>
                                    <option value="sides">Sides</option>
                                    <option value="soup">Soup</option>
                                    <option value="drink">Drink</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="foodDescription" class="col-sm-2 col-form-label col-form-label-sm fs-6">Food Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="foodDescription" id="foodDescription" rows="3" placeholder="Write your food description here..." maxlength="40" pattern="[A-za-z,]"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="availability" class="col-sm-2 col-form-label col-form-label-sm fs-6">Availability(Today)</label>
                            <div class="col-sm-10 align-content-center my-auto">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" name="foodAvailability" id="available" type="radio" value="Available" onclick="zeroQuantity()">
                                  <label class="form-check-label">Available</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" name="foodAvailability" id="non-available" type="radio" value="Non-Available" onclick="zeroQuantity()">
                                  <label class="form-check-label">Non-Available</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="foodQuantity" class="col-sm-2 col-form-label col-form-label-sm fs-6">Quantity(Today)</label>
                            <div class="col-sm-10 my-auto">
                                <input type="number" class="form-control form-control-sm" name="foodQuantity" id="foodQuantity">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3 offset-9 btn-group">
                                <input type="hidden" name="kioskId" value="<?php echo $kioskId; ?>">
                                <a href="<?php echo SITEURL; ?>foodAdmin/adminManageMenu.php?kiosk_id=<?php echo $kioskId; ?>" class="btn btn-light rounded transition border border-dark mx-2" type="submit" style="--bs-btn-padding-y: .2rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .9rem;">Cancel</a>
                                <button class="btn btn-primary rounded transition" type="submit" name="submit" style="--bs-btn-padding-y: .2rem; --bs-btn-padding-x: .75rem; --bs-btn-font-size: .9rem;">Add</button>
                            </div>
                        </div>
                    
                    </form>

                    <?php
                        if(isset($_POST['submit'])) {
                            $kioskId = $_POST['kioskId'];
                            $foodName = $_POST['foodName'];
                            $foodPrice = $_POST['foodPrice'];
                            $foodCategory = $_POST['foodCategory'];
                            $foodDescription = $_POST['foodDescription'];
                            $foodQuantity = $_POST['foodQuantity'];
                        
                            if(isset($_POST['foodAvailability'])) {
                                $foodAvailability = $_POST['foodAvailability'];
                            }
                            else {
                                $foodAvailability = "Non-Available";
                            }
                        
                            if($foodAvailability == "Non-Available") {
                                $foodQuantity = 0;
                            }
                        
                        
                        
                            if(isset($_FILES['foodImg']['name'])) {
                                $image_name = $_FILES['foodImg']['name'];
                            
                                if($image_name != "") {

                                    $image_info = explode(".", $image_name);
                                    $ext = end($image_info);
                                
                                    $image_name = "Food_Name_" . rand(0000, 9999) . "." . $ext;
                                
                                    $src = $_FILES['foodImg']['tmp_name'];
                                
                                    $dst = "../images/menu/" . $image_name;
                                
                                    $upload = move_uploaded_file($src, $dst);

                                    if($upload == false) {
                                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                                        echo '<script>window.location = "'. SITEURL . 'foodAdmin/adminAddNewMenu.php?kiosk_id=' . $kioskId . '";</script>';
                                        die();
                                    }
                                }
                            }
                            else {
                                $image_name = "";
                            }
                        
                            $sql = "INSERT INTO food(food_id, kiosk_id, food_name, food_description, food_price, food_image, 
                                    food_remainingQuantity, food_category, food_availability) VALUES('', '$kioskId', '$foodName', 
                                    '$foodDescription', '$foodPrice', '$image_name', '$foodQuantity', '$foodCategory', '$foodAvailability')";

                            $run = mysqli_query($conn, $sql);

                            if($run == true) {
                                $_SESSION['add'] = $foodName;
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