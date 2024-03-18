<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk1 Add Delete Menu</title>

    <link rel="stylesheet" href="../node_modules/categoryStyle.css">
   
    
</head>
<body>
    <?php include('../partials/adminMenuBar.php'); ?>

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

    <div class="container">
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">

            <?php
                $sql = "SELECT * FROM kiosk";

                $run = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($run);

                if($count > 0) {
                    while($row = mysqli_fetch_assoc($run)) {
                        $kioskId = $row['kiosk_id'];
                        $kioskName = $row['kiosk_name'];
                        $kioskBusinessDay = $row['kiosk_businessDay'];
                        $kioskOpenHour = $row['kiosk_openHour'];
                        $kioskCloseHour = $row['kiosk_closeHour'];
                        $kioskImg = $row['kiosk_picture'];
                        $kioskStatus = $row['kiosk_status'];
                        $kioskDescription = $row['kiosk_description'];
                       
            ?>

            <form action="">
                <div class="col">
                    <a href="<?php echo SITEURL;?>foodAdmin/adminManageMenu.php?kiosk_id=<?php echo $kioskId; ?>" class="no-underline text-reset">
                        <div class="card shadow my-kiosk transition p-2" style="height: 400px;">
                            <img src="../images/kiosk/<?php echo $kioskImg; ?>" class="card-img-top" alt="..." style="height: 250px;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $kioskName; ?></h5>
                                <p class="card-text text-secondary"><?php echo $kioskDescription; ?></p>
                                <p class="card-text <?php if($kioskStatus=="Open") {echo "text-primary";} else {echo "text-danger";} ?>"><?php echo $kioskStatus; ?></p>
                            </div>
                        </div>
                    </a>               
                </div>                  
            </form>

            <?php            
                    }
                }
                else {
                    echo "<div class='error'>Kiosk not Added yet.</div>";
                }
            ?>
            
        </div>
    </div>
    

   
    
    
    



    <?php include('../partials/footer.php'); ?>

</body>
</html>