<?php

$connectDB = mysqli_connect('localhost', 'root', '', 'web_project');

session_start();

if(isset($_POST['submit'])){

   $phoneNum = $_POST['phoneNum'];

   $select = " SELECT * FROM registered_or_general_user WHERE registered_phoneNum = '$phoneNum'";

   $result = mysqli_query($connectDB, $select);

   if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        $_SESSION['user_id'] = $row['user_id'];
   }else{
        $insert = "INSERT INTO registered_or_general_user VALUES ('', '$phoneNum')";
        mysqli_query($connectDB, $insert);
        $select = " SELECT * FROM registered_or_general_user WHERE registered_phoneNum = '$phoneNum'";
        $result = mysqli_query($connectDB, $select);
        $row = mysqli_fetch_array($result);
        $_SESSION['user_id'] = $row['user_id'];
   }
   $_SESSION['guest'] = 'yes';
   $_SESSION['user_name'] = true;
   header('location:../foodCustomer/customerViewKiosk.php');

};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <!-- <img src="images/ump.jpeg" alt=""> -->
   <div class="form-container">
      
    <form action="" method="post">
      <h3>visit as guest</h3>
      <input type="text" name="phoneNum" required placeholder="enter your phone number">
      <input type="submit" name="submit" value="login now" class="form-btn">
   </form>

</div>

</body>
</html>