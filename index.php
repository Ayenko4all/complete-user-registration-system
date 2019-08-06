<?php require_once "controllers/authController.php";
if (!isset($_SESSION['id'])) {
  header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/bootstrap.css">

  <title>Home page</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4 offset-md-4 form-div login">
        <?php if(isset($_SESSION['message'])) : ?>
          <div class="alert <?php echo $_SESSION['alert-class']; ?>">
            <?php 
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            unset($_SESSION['alert-class']);
            ?>
          </div>
        <?php endif; ?>

        <h3>welcome, <?= $_SESSION['username']; ?></h3>

        <a href="index.php?logout=1" class="logout">Logout</a>
        <?php if (!$_SESSION['verified']) : ?>
          <div class="alert alert-warning">
            You need to verify your account.
            Sign in to your email account and click on the verification link we emailed you at
            <strong> <?= $_SESSION['email']; ?></strong>
          </div>
        <?php endif; ?>

        <?php if ($_SESSION['verified']) : ?>
          <button class="btn btn-primary btn-lg btn-block">I am verified!</button>
        <?php endif; ?>

      </div>
    </div>
  </div>
</body>

</html>