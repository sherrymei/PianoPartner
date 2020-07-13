<?php

include 'includes/connect_mysql.php';

header("Content-Type: application/json; charset=UTF-8");
$data = json_decode($_POST["data"], false);
$status = $data -> status;
$order_num = $data -> order_num;

$stmt = $conn->prepare("UPDATE users SET status_msg = ? WHERE order_num = ?");
$stmt->bind_param( 'si', $status, $order_num);
$stmt->execute();
$stmt->close();
$conn->close();

echo "JSON - " . json_encode($data);

 ?>
