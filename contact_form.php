<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

$data = json_decode($_POST["data"], false);

$name = test_input($data -> name) ;
$mail_from = test_input($data -> mail);
$subject = test_input($data -> subject);
$message = test_input($data -> message);

$status = "failed";
$response =  "";
$error = array();

if (empty($name) ) {
  $error["name"] = "Fill name field. ";
  $response .= "Fill name field. ";
}
if (empty($mail_from)) {
  $error["email"] = "Fill email field. ";
  $response .= "Fill email field. ";
}

if (!empty($name) and !empty($mail_from)){
  if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
    $error["name"] = "Invalid name - only letters and white space allowed.";
    $response .= "Invalid name - only letters and white space allowed.";
  }
  else {
    $response .= "";
  }
  if (!filter_var($mail_from, FILTER_VALIDATE_EMAIL)) {
    $error["email"] = "Invalid email format";
    $response .= "Invalid email format";
  }
  else {
    $response .= "";
  }

  if (empty($response)){

    $body = '<p>From: '.$name.'</p><p>'.$message.'</p>';

    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Mailer     = "smtp";
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    //TODO change username and password before pushing to GitHub
    $mail->Username   = 'username@gmail.com';
    $mail->Password   = 'password';
    $mail->SMTPSecure = 'TLS';
    $mail->Port       = 587;

    $mail->setFrom($mail_from);
    $mail->addReplyTo($mail_from, $name);
    $mail->addAddress('backlightrecordings@gmail.com', 'Backlight Recordings');

    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);

    if($mail->send()){
      $status = "success";
      $response = "Email is sent!";
    }
    else {
      $status = "failed";
      $response .= $mail->ErrorInfo;
    }
  }
}

exit(json_encode(array("status" => $status, "response" => $response, "error" => $error)));


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
