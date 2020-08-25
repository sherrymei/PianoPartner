<?php

include 'includes/connect_mysql.php';

header("Content-Type: application/json; charset=UTF-8");
$data = json_decode($_POST["data"], false);
$order_num = $data -> order_num;

$stmt = $conn->prepare("DELETE FROM Users WHERE OrderNumber = ?");
$stmt->bind_param( 'i', $order_num);
$stmt->execute();
$stmt->close();
$conn->close();

echo "JSON - " . json_encode($data);

 ?>
