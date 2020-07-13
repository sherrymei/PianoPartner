<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

include 'includes/connect_mysql.php';
session_start();

$order_num = $_SESSION["order"];

if ($stmt = $conn->prepare("SELECT order_num, full_name, mail_from, piece_name FROM users WHERE order_num = ?")){
  $stmt->bind_param( 'i', $order_num);
  $stmt->execute();
  $stmt->bind_result( $order_num, $full_name, $mail_from, $piece_name);
  $stmt->fetch();


  // Instantiation and passing `true` enables exceptions
  $mail = new PHPMailer(true);

  $body = '<p>Hi, ' . $full_name . ' </p><p> This is your order number: <b> ' . $order_num . '</b> for ' .$piece_name . '.</p>';

  $mail->SMTPDebug = 0;                      // Enable verbose debug output
  $mail->isSMTP();                                            // Send using SMTP
  $mail->Mailer     = "smtp";
  $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
  $mail->Username   = 'backlightrecordings@gmail.com';                // SMTP username
  $mail->Password   = 'bluemic_7';                             // SMTP password
  $mail->SMTPSecure = 'TLS';        // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
  $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

  //Recipients
  $mail->setFrom('backlightrecordings@gmail.com', 'Backlight Recordings');
  // $mail->addReplyTo('replyto@example.com', 'First Last');
  $mail->addAddress($mail_from, $full_name);                 // Add a recipient

  // Attachments
  // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
  // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

  // Content
  $mail->isHTML(true);                                  // Set email format to HTML
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
