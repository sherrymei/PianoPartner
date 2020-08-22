<?php

$data = json_decode($_POST["data"], false);

$name = test_input($data -> name) ;
$email = test_input($data -> mail);
$subject = test_input($data -> subject);
$message = test_input($data -> message);

$status = "failed";
$response =  "";
$error = array();

if (empty($name) ) {
  $error["name"] = "Fill name field. ";
  $response .= "Fill name field. ";
}
if (empty($email)) {
  $error["email"] = "Fill email field. ";
  $response .= "Fill email field. ";
}

if (!empty($name) and !empty($email)){
  if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
    $error["name"] = "Invalid name - only letters and white space allowed.";
    $response .= "Invalid name - only letters and white space allowed.";
  }
  else {
    $response .= "";
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error["email"] = "Invalid email format";
    $response .= "Invalid email format";
  }
  else {
    $response .= "";
  }

  if (empty($response)){

    $body = '<p>From: '.$name.'</p><p>'.$message.'</p>';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: ". $email ."\r\n";
    $success = mail("contact@backlightrecordings.com","$subject","$body","$headers");
    if (!$success) {
      $status = "failed";
      $response = error_get_last()['message'];
    }
    else {
      $status = "success";
      $response = "Email is sent!";
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
