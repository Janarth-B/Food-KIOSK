<?php 
    include('../config/constants.php');

    if(isset($_GET['food_id']) && isset($_GET['food_image']) && isset($_GET['kiosk_id'])) {
        $foodId = $_GET['food_id'];
        $foodName = $_GET['food_name'];
        $foodImg = $_GET['food_image'];
        $kioskId = $_GET['kiosk_id'];

        if($foodImg != "") {
            $imgPath = "../images/menu/" . $foodImg;            
            $removeImg = unlink($imgPath);
            
            if($removeImg == false) {
                $_SESSION['upload'] = "<div>Failed to remove Food Image</div>";
                echo '<script>window.location = "'. SITEURL . 'foodAdmin/adminManageMenu.php?kiosk_id=' . $kioskId . '";</script>';
                die();
            }
        }

        $qrPath = "../images/qr/qr_" . $foodName . ".png";
        $removeQr = unlink($qrPath);

        $sql = "DELETE FROM food WHERE food_id=$foodId";
        $run = mysqli_query($conn, $sql);


        if($run == true) {
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
            echo '<script>window.location = "'. SITEURL . 'foodAdmin/adminManageMenu.php?kiosk_id=' . $kioskId . '";</script>';
        }
        else {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";
            echo '<script>window.location = "'. SITEURL . 'foodAdmin/adminManageMenu.php?kiosk_id=' . $kioskId . '";</script>';
        }

    }
    else {
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
        echo '<script>window.location = "'. SITEURL . 'foodAdmin/adminManageMenu.php?kiosk_id=' . $kioskId . '";</script>';
    }
?>