<?php include("config.php");
  
  $id = $_GET['id'];
  $status = $_GET['status'];
  $updatequery1 = "UPDATE user_form SET status=$status WHERE id=$id";
  mysqli_query($conn,$updatequery1);
  header('location:active_deactive.php');
?>
