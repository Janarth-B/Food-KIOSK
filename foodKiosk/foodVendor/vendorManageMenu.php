<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk1 Add Delete Menu</title>
   
    
</head>
<body>
    <?php include('../partials/vendorMenuBar.php'); ?>
    <?php
        // if(isset($_GET['kiosk_id'])) {

            // $kioskId = $_GET['kiosk_id'];
            //find kiosk Id
            $vendor_id = $_SESSION['vendor_id'];
            $kioskIdQuery = mysqli_query($conn, "SELECT kiosk_id FROM kiosk WHERE vendor_id = '$vendor_id'");
            $kisokIdRs = mysqli_fetch_array($kioskIdQuery);
            $kioskId = $kisokIdRs['kiosk_id'];
            //
            $result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM food WHERE kiosk_id= $kioskId");
            $row = mysqli_fetch_assoc($result);
            $rows = $row['count'];  
            
            $sql2 = "SELECT * FROM kiosk WHERE kiosk_id= $kioskId";
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
            <div class="col-8">
                Today <?php echo $kioskOpenHour; ?>:00-<?php echo $kioskCloseHour; ?>:00
            </div>
            <div class="col-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="d-inline-block me-1">Close</div>
                    <div class="form-check form-switch d-inline-block">
                        <label class="form-check-label" for="kioskStatus">Open</label>
                        <input <?php if($kioskStatus=="Open") {echo "checked";} ?> class="form-check-input" type="checkbox" role="switch" id="kioskStatus">
                        <input type="hidden" name="kioskId" id="kioskId" value="<?php echo $kioskId; ?>">                   
                    </div>
                </form>         
            </div>
        </div>
    </div>

    <?php            
                    }
                }
        
        // POST from js & Update kioskStatus in database 
        if(isset($_POST['kioskStatus'])) {
            $kioskStatus = $_POST['kioskStatus'] == "Open" ? "Open" : "Close";
            $kioskId = $_POST['kioskId'];
        
            $sql = "UPDATE kiosk SET kiosk_status = '$kioskStatus' WHERE kiosk_id = $kioskId";
            $run = mysqli_query($conn, $sql);
        }
                

    ?>


    <?php
        if(isset($_SESSION['add'])) {
            $foodName = $_SESSION['add'];
    ?>           
    
    <!-- Added Modal -->
    <div class="modal fade" id="notifyAddedSuccess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary" id="notifyAddedSuccess">Menu Added!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Your Menu was Added Successfully. Press OK to continue.
                </div>
                <div class="modal-footer">
                <form id="menuForm">
                    <input type="hidden" class="form-control form-control-sm" name="foodName" id="foodName" value="<?php echo $foodName; ?>">
                    <button type="submit" name="submit" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </form>
                </div>
            </div>
        </div>
    </div>
   

    
    

    <?php
            echo    "<script>
                        $(document).ready(function(){
                            $('#notifyAddedSuccess').modal('show');
                        });     
                    </script>";
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
            $foodName = $_SESSION['update'];
    ?>

    <!-- Updated Modal -->
    <div class="modal fade" id="notifyUpdatedSuccess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-success" id="notifyUpdatedSuccess">Menu Updated!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Your Menu was Updated Successfully. Press OK to continue.
                </div>
                <div class="modal-footer">
                <form id="menuForm">
                    <input type="hidden" class="form-control form-control-sm" name="foodName" id="foodName" value="<?php echo $foodName; ?>">
                    <button type="submit" name="submit" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    <?php
            echo    "<script>
                        $(document).ready(function(){
                            $('#notifyUpdatedSuccess').modal('show');
                        });     
                    </script>";
            unset($_SESSION['update']);
        }
    ?>


    <div class="container my-4 search-bar">
        <div class="row">
            <div class="col-8">
                <form class="d-flex" action="<?php echo SITEURL; ?>foodVendor/vendorFoodSearch.php" method="POST" role="search">
                    <input type="hidden" name="kioskId" value="<?php echo $kioskId; ?>">
                    <input class="form-control w-25 shadow transition" type="search" name="search" placeholder="Search" aria-label="Search">
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
                        $sql = "SELECT * FROM food WHERE kiosk_id= $kioskId";
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
            

            <form class="all <?php echo $foodCategory;?>" action="delete_food.php" method="GET">
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
                                                <img src="../images/qr/qr_<?php echo $foodName; ?>.png" style="width: 35px;" alt="">
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
                                                      
                                                    <a href="<?php echo SITEURL;?>foodVendor/vendorDeleteFood.php?food_id=<?php echo $foodId; ?>&food_name=<?php echo $foodName; ?>&food_image=<?php echo $foodImg; ?>&kiosk_id=<?php echo $kioskId; ?>" class="btn border-0 rounded mx-2 transition" style="--bs-btn-padding-y: .2rem; --bs-btn-padding-x: .75rem; --bs-btn-font-size: .9rem;">
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
                    }                                                   
                // }
                // else {
                //     echo "<script>window.location.href='adminManageMenu.php'</script>";
                // }       
            ?>



            
            

            

            
        </div>
    </div>

    <!-- Checkbox to open/close kiosk to POST data to php-->
    <script>
        $("#kioskStatus").on( "change", function() {
            var kioskStatus = $(this).prop("checked") ? "Open" : "Close";
            var kioskId = $("#kioskId").val();
            $.ajax({
                type: "POST",
                url: "vendorManageMenu.php",
                data: {kioskStatus: kioskStatus, kioskId: kioskId}
            });
        });
    </script>
    
    <!-- Generate qr code & download to local -->
    <script src="../node_modules/qrcode.min.js"></script>
    <script>
        $( "#menuForm" ).on( "submit", function( e ) {
            e.preventDefault();
            const url = document.querySelector("#foodName").value;
            let qrDiv = document.createElement('div');
            let qrcode = new QRCode(qrDiv, {
              text: url
            });
        
            downloadQR(url, qrDiv);
            location.reload();
        });
      
        function downloadQR(qrValue, qrDiv) {
            var link = document.createElement('a');
            link.download = 'qr_' + qrValue + '.png';
            link.href = qrDiv.children[0].toDataURL();
            link.click();
        }
    </script>

    <?php include('../partials/footer.php'); ?>

</body>
</html>