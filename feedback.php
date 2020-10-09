<?php ob_start(); ?>
<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

?>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="/">Backlight Recordings</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link" href="admin_main">Main </a>
          <a class="nav-link" href="orders_table">Orders</a>
          <a class="nav-link active" href="feedback">Feedback<span class="sr-only">(current)</span></a>
        </div>
      </div>
    </nav>
  </header>
  <div class="container">
  <h1 class="text-center">Feedback from our Customers</h1>
  <?php
    if ($_SESSION['active']){
    $sql = "SELECT Feedback.FeedbackMsg, Users.OrderNumber, Users.PieceName FROM Feedback LEFT JOIN Users ON Feedback.UserID=Users.UserID;";
    if ($stmt = $conn->prepare($sql)) {
      $stmt->execute();
      $stmt->bind_result($feedback_msg, $order_num, $piece_name);
      while ($stmt->fetch()) {
          printf("<p>\"%s\" <br>  -  %s (%s)</p><br>",$feedback_msg, $order_num, $piece_name);
      }
      $stmt->close();
    }
    $conn -> close();
    }
    else {
        header("Location: admin");
    }
    ?>
  </div>
    <?php

include 'includes/html_foot.php'; ?>
<?php ob_flush(); ?>
