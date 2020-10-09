<?php

include 'includes/connect_mysql.php';

// header("Content-Type: application/json; charset=UTF-8");
$data = json_decode($_POST["data"], false);
$status = $data -> status;
$order_num = $data -> order_num;
$email = $data -> email;
date_default_timezone_set('EST');
$today = date("Y-m-d H:i:s");

$stmt = $conn->prepare("UPDATE Users SET StatusMsg = ?, StatusChange = ? WHERE OrderNumber = ?");
$stmt->bind_param( 'ssi', $status, $today, $order_num);
$stmt->execute();
$body = '<p>The status of your recent order has changed. Please check the status <a href="https://backlightrecordings.com/status?order='.$order_num.'">here</a>
or you can copy and paste the following link.</p>
<p>https://backlightrecordings.com/status?order='.$order_num.'</p>
<br>
<p>Backlight Recordings</p>'
;
$subject = "BacklightRecordings: Your Order Status";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: BacklightRecordings <orders@backlightrecordings.com>" . "\r\n";
ob_start();
$mailsend = mail("$email","$subject","$body","$headers");
ob_end_clean();
$stmt->close();
$conn->close();

echo "JSON - " . json_encode($data);

 ?>
