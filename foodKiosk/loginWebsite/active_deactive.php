<?php include("config.php");?>
<!DOCTYPE html>
<html>
<head>
  <title>STUDENT PROFILE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <br><br>

<div class="container">
      <a href="login_form.php" class="btn">login</a>
      <a href="register_form.php" class="btn">register</a>
      <a href="logout.php" class="btn">logout</a>
      <a href="admin_page.php" class="btn">dashboard</a>
  <!-- <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <a href='registration.php' class='btn btn-square btn-primary'>ADD NEW</a> 
  </div> -->
  <div class="text-center"><h1>ALL DETAILS</h1></div><br>
<table class="table table-striped table-hover table-bordered border-primary text-center">
  <thead>
    <tr>
      <th scope="col">Sl No.</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Ph No.</th>
      <th scope="col">Status</th>
      
    </tr>
  </thead>
  <tbody>
    <?php   
    $view = mysqli_query($conn, "SELECT * from user_form");
    while($data = mysqli_fetch_assoc($view)){ 
          $id = $data['id'];
          $name = $data['name'];
          $email = $data['email'];
          $user_type = $data['user_type'];
      ?>

      <tr>
        <td><?php echo $id ; ?></td>
        <td><?php echo $name ; ?></td>
        <td><?php echo $email ; ?></td>
        <td><?php echo $user_type ; ?></td>
        <td>
          <?php 

           if($data['status']==1) {
             echo '<p><a href="active.php?id='.$data['id'].'&status=0" class="btn btn-success">Active</a></p>';
           }
           else
           {
            echo '<p><a href="active.php?id='.$data['id'].'&status=1" class="btn btn-danger">Deactive</a></p>';
           }

          ?>
        </td>
      </tr>
    
  
   <?php  } ?>
  </tbody>
</table>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>