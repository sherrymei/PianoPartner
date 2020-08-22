<?php ob_start(); ?>
<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

  if ($_SESSION["order"]){
    $order_num = $_SESSION["order"];
    $status = "Status3";
    $stmt = $conn->prepare("UPDATE Users SET StatusMsg = ? WHERE OrderNumber = ?");
    $stmt->bind_param( 'si', $status, $order_num);
    $stmt->execute();
    $stmt->close();
    $conn->close();
  }

  ?>
  <body>
     <p>Success! You have paid for an accompaniment recording!</p>
     <div id="orderd"><a href='index.php' class="button">EXIT</a></div>
  </body>
  </html>
<?php ob_flush(); ?>
