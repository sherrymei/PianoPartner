<?php

include 'includes/connect_mysql.php';

header("Content-Type: application/json; charset=UTF-8");

$json = json_decode(file_get_contents("php://input"));
$order_num = $json -> order_num;

if ($stmt1 = $conn->prepare("SELECT Amount FROM Payment WHERE OrderNumber = ?;")) {
  $stmt1->bind_param('i', $order_num);
  $stmt1->execute();
  $stmt1->bind_result($amount);
  $stmt1->fetch();
  $data -> amount = $amount;

$stmt1->close();
}
$conn->close();

echo json_encode($data);


  ?>
