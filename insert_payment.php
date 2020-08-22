<?php

include 'includes/connect_mysql.php';

header("Content-Type: application/json; charset=UTF-8");
$data = json_decode($_POST["data"], false);
$order_num = $data -> order_num;
$class_piece = $data -> class_piece;
$pages = $data -> pages;
$amount = $data -> amount;

$stmt = $conn->prepare("INSERT INTO Payment (OrderNumber,Pages,Class,Amount,Terms) VALUES(?,?,?,?,0)");
$stmt->bind_param( 'iisd', $order_num,$pages,$class_piece,$amount);
$stmt->execute();
$stmt->close();
$conn->close();

echo "JSON - " . json_encode($data);

 ?>
