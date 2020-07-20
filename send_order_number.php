<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

include 'includes/connect_mysql.php';
session_start();

$order_num = $_SESSION["order"];

if ($stmt = $conn->prepare("SELECT order_num, full_name, mail_from, piece_name FROM users WHERE order_num = ?")){
  $stmt->bind_param( 'i', $order_num);
  $stmt->execute();
  $stmt->bind_result( $order_num, $full_name, $mail_from, $piece_name);
  $stmt->fetch();

  $mail = new PHPMailer(true);

  $body = '<p>Hi, ' . $full_name . ' </p><p> This is your order number: <b> ' . $order_num . '</b> for ' .$piece_name . '.</p>';

  $mail->SMTPDebug = 0;
  $mail->isSMTP();
  $mail->Mailer     = "smtp";
  $mail->Host       = 'smtp.gmail.com';
  $mail->SMTPAuth   = true;
  //TODO CHANGE username and password before pushing to GitHub
  $mail->Username   = 'username@gmail.com';
  $mail->Password   = 'password';
  $mail->SMTPSecure = 'TLS';
  $mail->Port       = 587;

  $mail->setFrom('backlightrecordings@gmail.com', 'Backlight Recordings');
  $mail->addAddress($mail_from, $full_name);

  $mail->isHTML(true);
  $mail->Subject = 'Order Number';
  $mail->Body    = $body;
  $mail->AltBody = strip_tags($body);

  if(!$mail->send()){
    echo "Message could not be sent.  ";
    echo "Mailer Error: " . $mail->ErrorInfo;
    exit;
  }
  header("Location: status.php?order=".$order_num);
  $stmt->close();
}
$conn->close();



?>
