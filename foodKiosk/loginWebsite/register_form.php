<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }else{

      if($pass != $cpass){
         $error[] = 'password not matched!';
      }else{
         $insert = "INSERT INTO user_form(name, email, password, user_type, status) VALUES('$name','$email','$pass','$user_type', 1)";
         mysqli_query($conn, $insert);
         //////////
         $connectDB = mysqli_connect('localhost', 'root', '', 'web_project');
         if($user_type == 'user') {
            $insert3 = "INSERT INTO registered_or_general_user VALUES ('', '012-3456789')";
            mysqli_query($connectDB, $insert3);
            $insert2 = "INSERT INTO registered_user VALUES ((SELECT MAX(user_id) FROM registered_or_general_user), '$name', '$pass', '$email', 10, 10)";
            mysqli_query($connectDB, $insert2);
         } else if($user_type == 'vendor') {
            $insert4 = "INSERT INTO food_vendor VALUES ('', 1, '$name', '$pass', '$email', '019-8765432', 'approve')";
            mysqli_query($connectDB, $insert4);
         } else if($user_type == 'admin') {
            $insert5 = "INSERT INTO administrator VALUES ('', '$name', '$pass', '$email', '011-1111111')";
            mysqli_query($connectDB, $insert5);
         }
         /////////
         header('location:login_form.php');
      }
   }

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
      <h3>register now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" required placeholder="enter your name">
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="password" name="cpassword" required placeholder="confirm your password">
      <select name="user_type">
         <option value="user">User</option>
         <option value="admin">Admin</option>
         <option value="staff">Staff/Student</option>
         <option value="vendor">Food Vendor</option>
      </select>
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="login_form.php">login now</a></p>
   </form>

</div>

</body>
</html>