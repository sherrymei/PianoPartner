<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

?>

<body>

  <h1>Feedback from our Customers</h1>
  <?php
    $sql = "SELECT feedback_msg FROM feedback;";
    if ($stmt = $conn->prepare($sql)) {
      $stmt->execute();
      $stmt->bind_result($feedback_msg);
      while ($stmt->fetch()) {
          printf("<p>%s\n</p>", $feedback_msg);
      }
      $stmt->close();
    }

$conn -> close();

   ?>



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="fullpage.js/vendors/scrolloverflow.js"></script>
  <script src="fullpage.js/dist/fullpage.js"></script>
</body>

</html>
