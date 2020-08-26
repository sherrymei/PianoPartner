<?php ob_start(); ?>
<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

?>

<body>

  <h1>Feedback from our Customers</h1>
  <?php
    if ($_SESSION['active']){
    $sql = "SELECT Feedback.FeedbackMsg, Users.OrderNumber, Users.PieceName FROM Feedback LEFT JOIN Users ON Feedback.OrderNumber=Users.OrderNumber;";
    if ($stmt = $conn->prepare($sql)) {
      $stmt->execute();
      $stmt->bind_result($feedback_msg, $order_num, $piece_name);
      while ($stmt->fetch()) {
          printf("<p>%s (%i)\n %s\n</p>",$piece_name, $order_num, $feedback_msg);
      }
      $stmt->close();
    }

    $conn -> close();
    }
    else {
        header("Location: admin");
    }

include 'includes/html_foot.php'; ?>
<?php ob_flush(); ?>
