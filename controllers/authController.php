<?php
session_start();

require "config/db.php";
require_once "emailController.php";

$errors = [];
$username = '';
$email = '';

if (isset($_POST['signup-btn'])) {

  //collecting users data from form input fields
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $cpassword = $_POST['cpassword'];

  //validation for form input field
  if (empty($username)) {
    $errors['username'] = "Username required";
  }
  if (empty($email)) {
    $errors['email'] = "Email required";
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Email address is invalid";
  }
  if (empty($password)) {
    $errors['password'] = "Password required";
  }
  if ($password !== $cpassword) {
    $errors['password'] = "The two password do not match";
  }

  //checking if email has been taken by another user
  $emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
  $stmt = $conn->prepare($emailQuery);
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $userCount = $result->num_rows;
  $stmt->close();
  if ($userCount > 0) {
    $errors['email'] = "Email already exists";
  }

  if (count($errors) === 0) {

    //Hashing our password 
    $password = password_hash($password, PASSWORD_BCRYPT);
    //this will genetrate a uniqe randon string
    $token = bin2hex(random_bytes(50));
    $verified = false;

    //insert into user table
    $sql = "INSERT INTO users(username,email,verified,token,password) VALUES(?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssbss', $username, $email, $verified, $token, $password);

    if ($stmt->execute()) {
      //login user
      $user_id = $conn->insert_id;
      $_SESSION['id'] = $user_id;
      $_SESSION['username'] = $username;
      $_SESSION['email'] = $email;
      $_SESSION['verified'] = $verified;
    
      sendVerificationEmail($email, $token);
      //flash message
      $_SESSION['message'] = "You are now logged in!";
      $_SESSION['alert-class'] = "alert-success";
      header("location: index.php");
      exit();
    } else {
      $errors['db_error'] = "Database error: failed to register";
    }
  }
}

/* Login */
if (isset($_POST['login-btn'])) {

  //collecting users data from form input fields
  $username = $_POST['username'];

  $password = $_POST['password'];
  

  //validation for form input field
  if (empty($username)) {
    $errors['username'] = "Username required";
  }
  
  if (empty($password)) {
    $errors['password'] = "Password required";
  }

  if (count($errors) === 0) {

    $sql = "SELECT * FROM users WHERE email=? || username=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      //login in
      $_SESSION['id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['verified'] = $user['verified'];

      //flash message
      $_SESSION['message'] = "You are now logged in!";
      $_SESSION['alert-class'] = "alert-success";
      header("location: index.php");
      exit();
    } else {
      $errors['login error'] = "Wrong credentials";
    }
  }
 
}

//logout
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['id']);
  unset($_SESSION['username']);
  unset($_SESSION['email']);
  unset($_SESSION['verified']);
  header("location: login.php");
  eixt();
}