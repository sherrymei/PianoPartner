<?php ob_start(); ?>
<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

  if (isset($_GET["order"])) {
     $order_num = $_GET["order"];
     $_SESSION["order"] = $order_num;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['feedback']) {
      $feedback = $_POST['feedback'];
      $order_num = $_SESSION["order"];
      $user_id = $_POST['user'];
      if ($stmt0 = $conn->prepare("INSERT INTO Feedback (UserID,FeedbackMsg) VALUES (?,?)")){
        $stmt0 ->bind_param("is", $user_id, $feedback);
        $stmt0 ->execute();
        $stmt0 ->close();
      }
      else {
        echo $stmt->error;
      }
      $conn->close();
    }
  }


   ?>
   <body>
<script src="https://www.paypal.com/sdk/js?client-id=AWetKhh9l71-TRMr1SHcDyOHxGIMZ9NGIrXkBMftMyRHzOCErjc--mebUzxIoQYOXMMzvbJbjiBRFdyc"></script>
<!-- <script src="https://www.paypal.com/sdk/js?client-id=AY9te3wD5b7VZxZgkqt8eZH-cXSInfVfvhe4rgCzC_RnudPNDaSajsDU1avOC8I_LPVzfvIzjHYWYkmX"></script> -->
     <nav class="navbar navbar-dark bg-dark">
       <a class="navbar-brand" href="/"><img src="images/IMG-4514.png" width="50" ></a>
     </nav>
     <div class="container">


       <div id="status-section">
         <div class="text-center">

         <img src="images/order.png" class="img-fluid" width="200">

         <h3>Order # <span id="order-no"><?php echo $_SESSION["order"]; ?></span> </h3>
         <img src="images/IMG-4506.png" class="img-fluid" width="300">
         <p>Thank you for ordering with us at Backlight Recordings! </p>
          <p> You can bookmark this page to check your status. </p>
           <h5 >- Status Information -</h5>

  <?php

  if ($stmt1 = $conn->prepare("SELECT Users.UserID, Users.StatusMsg, Users.Tempo, Users.Recording, Payment.Pages, Payment.Class, Payment.Amount FROM Users LEFT JOIN Payment ON Users.OrderNumber = Payment.OrderNumber WHERE Users.OrderNumber = ?;")){
    $stmt1->bind_param('i', $order_num);
    $stmt1->execute();
    $stmt1->bind_result($user_id, $status_msg, $tempo, $recording, $pages, $class, $amount);
    $stmt1->fetch();

    switch ($status_msg) {
      case "Status1":
        ?>
          <p>Your order number is <?php echo $order_num; ?>. Keep it in a safe place!</p>
          <p>We sent your order number to your email address. Please also check your junk or spam folder. </p>
          <p>Please wait up to 48 hours for our accompanist to respond to your inquiry.</p>
        <?php
        break;
      case "Status2":
        ?>
        <p>Your accompanist classifies this piece as a <?php echo $class; ?> level piece that is <?php echo $pages; ?> page(s) long. </p>
        <p>You decided it to be a <?php echo $tempo; ?> recording. </p>
        <p>You chose to receive a <?php echo $recording; ?>.</p>
        <p>Amount Due: $<span id="amount"><?php echo $amount; ?></span>.00</p>
        <div id="paypal-button-container"></div>
        <?php
        break;
      case "Status3":
        ?>
        <p> Please wait for an email notification from us confirming receipt of your payment to proceed to the next stage of your order. </p>
        <?php
        break;
      case "Status4":
        ?>
        <p>Accompanist is recording your piece. Please wait up to 1 week for audio recordings and 2 weeks for video recordings. </p>
        <?php
        break;
      case "Status5":
        ?>
        <p>Your order is ready. Please check your inbox.</p>
        <p>You can provide any feedback here or by replying to your email. Feedback will be only be viewed by us and be used for improvement. </p>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <textarea class="input-1-2" name="feedback"></textarea><br>
          <input type="hidden" name="user" value="<?php echo $user_id;?>"/>
          <button type="submit">SEND</button>
        </form>
        <?php
        break;
      default:
        ?>
         <p>Please complete the order form.</p>
        <?php
    }
    $stmt1->close();
  }
  $conn->close();

   ?>

 </div>
</div>

 </div>
</div>
<?php include 'includes/user_foot.php'; ?>
  <script src=js/status.js></script>
  <?php include 'includes/html_foot.php'; ?>
<?php ob_flush(); ?>
