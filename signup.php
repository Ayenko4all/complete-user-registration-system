<?php require_once "controllers/authController.php";?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/style.css">
 <link rel="stylesheet" href="css/bootstrap.css">

 <title>Document</title>
</head>

<body>
 <div class="container">
  <div class="row">
   <div class="col-md-4 offset-md-4 form-div">
    <form action="signup.php" method="post">
     <h3 class="text-center">Register</h3>
    <?php if(count($errors) > 0):?>
     <div class="alert alert-danger">
      <?php foreach($errors as $error):?>
      <li><?=$error;?></li>
      <?php endforeach;?>
     </div>
    <?php endif;?>

     <div class="form-group">
      <label for="username">Username</label>
      <input type="text" name="username" class="form-control form-control-lg" value="<?=$username;?>">
     </div>
     <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="email" class="form-control form-control-lg" value="<?=$email;?>">
     </div>
     <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="password" class="form-control form-control-lg">
     </div>
     <div class="form-group">
      <label for="cpassword">Confirm Password</label>
      <input type="password" name="cpassword" class="form-control form-control-lg">
     </div>
     <div class="form-group">
      <button type="submit" name="signup-btn" class="btn btn-primary btn-block btn-lg">Sign Up</button>
     </div>
     <p class="text-center">Alraedy a memeber?<a href="login.php">Sign In</a></p>
    </form>
   </div>
  </div>
 </div>
</body>

</html>