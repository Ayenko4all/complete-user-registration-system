<?php

require_once 'vendor/autoload.php';
require_once 'config/constants.php';

// Create the Transport --this is an email serve that is reponsible for recieving and forwarding mail
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'TLS'))
  ->setUsername(EMAIL)
  ->setPassword(PASSWORD);

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

function sendVerificationEmail($email, $token){

  global $mailer;

  $body = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Verify email</title>
</head>
<body>
  <div class="wrapper">
    <p>
      Thank you for signing up on out website. Please click on the link below to verify your email.
    </p>
    <a href="http://localhost/complete%20user%20registration/index.php?token=' . $token . '">
    Verify your email address</a>
  </div>
</body>
</html>';

  // Create a message
  $message = (new Swift_Message('Verifty your email address'))
    ->setFrom(EMAIL)
    ->setTo($email)
    ->setBody($body, 'text/html');

  // Send the message
  $result = $mailer->send($message);
  if($result){
    echo "send";
  }else {
    echo  "Not send";
  }

}