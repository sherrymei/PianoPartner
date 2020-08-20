<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

include 'includes/connect_mysql.php';


$order_num = $_SESSION["order"];

if ($stmt = $conn->prepare("SELECT order_num, full_name, mail_from, piece_name, tuning_note, note_type, bpm, custom_bpm, recording, questions  FROM users WHERE order_num = ?")){
  $stmt->bind_param( 'i', $order_num);
  $stmt->execute();
  $stmt->bind_result( $order_num, $full_name, $mail_from, $piece_name, $tuning_note, $note_type, $bpm, $custom_bpm, $recording, $questions);
  $stmt->fetch();

  $mail = new PHPMailer(true);

  $body = '<p>Hi, ' . $full_name . ' </p><br><p> This is your order number: <b> ' . $order_num . '</b>.</p><br>'.
  '<h4>Order Summary</h4>'.
  '<p>Name of Piece: <span></span>' . $piece_name . '</p>'.
  '<p>Tuning Note: <span></span>' . $tuning_note . '</p>'.
  '<p>Note Type: <span></span>' . $note_type . '</p>'.
  '<p>Tempo: <span></span>' . $custom_bpm . $bpm . '</p>'.
  '<p>Recording Type: <span></span>' . $recording . '</p>'.
  '<p>Questions/Comments: <span></span>' . $questions . '</p>'.
  '<br><br>'.
  '<p>Backlight Recordings</p>'
  ;

  $mail->SMTPDebug = 0  ;
  $mail->isSMTP();
  $mail->Mailer     = "smtp";
  $mail->Host       = 'mail.backlightrecordings.com';
  // $mail->SMTPAuth   = true;
  $mail->Username   = 'orders@backlightrecordings.com';
  $mail->Password   = 'Satisfaction485';
  $mail->SMTPSecure = 'SSL';
  $mail->Port       = 465;

  $mail->setFrom('orders@backlightrecordings.com', 'Backlight Recordings');
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
  else {
    header("Location: status/order/" . $order_num);
  }
  $stmt->close();
}
$conn->close();
?>
