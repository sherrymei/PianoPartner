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

   ?>



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="fullpage.js/vendors/scrolloverflow.js"></script>
  <script src="fullpage.js/dist/fullpage.js"></script>
</body>

</html>
<?php ob_flush(); ?>
