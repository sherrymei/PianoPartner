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
          <a class="nav-link " href="admin_main">Main </a>
          <a class="nav-link" href="orders_table">Orders </a>
          <a class="nav-link" href="feedback">Feedback</a>
          <a class="nav-link active" href="paypal_log">Paypal Log <span class="sr-only">(current)</span> </a>
        </div>
      </div>
    </nav>
  </header>

  <main class="container">
    <?php
    if ($_SESSION['active']){
    $sql = "SELECT * FROM Paypal;";
    if ($stmt = $conn->prepare($sql)) {
      $stmt->execute();
      $stmt->bind_result($transaction_time, $order_num, $transaction_id, $paypal_status, $amount_paid);
      while ($stmt->fetch()) {
          printf("<p>%s (%s) - At %s, order #%s paid $%d</p>",$paypal_status,$transaction_id,$transaction_time,$order_num,$amount_paid);
      }
      $stmt->close();
    }
    $conn -> close();
    }
    else {
        header("Location: admin");
    }
     ?>
  </main>

   <script src=js/admin.js></script>
<?php include 'includes/html_foot.php'; ?>
<?php ob_flush(); ?>
