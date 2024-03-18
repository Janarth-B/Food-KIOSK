<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../lucasStyle.css">
        <style>
            .body_container {
                text-align: center;
            }
            .topUpButton {
                background-color: rgb(54, 156, 176);
                border: none;
                border-radius: 4px;
                height: 50px;
                width: 130px;
                color: white;
                font-size: 30px;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
<?php
        include('../partials/customerCardMenuBar.php');
        $connectDB = mysqli_connect("localhost", "root", "", "web_project");
        $user_id = $_SESSION['user_id'];
        $balanceAmount = mysqli_fetch_array(mysqli_query($connectDB, "SELECT * FROM registered_user WHERE user_id = '$user_id'"));
?>
        <div class="body_container">
            <img src="../images/QR.png" alt="membership card qr">
            <h1><b>Balance Amount: RM<?php echo $balanceAmount['registered_cardBalance']?></b></h1>
            <button type="button" name="topUp" class="topUpButton">Top Up</button>  
        </div>
    </body>
</html>