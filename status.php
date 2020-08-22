<?php ob_start(); ?>
<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

?>


<body>
  <script src="https://www.paypal.com/sdk/js?client-id=sb" data-sdk-integration-source="button-factory"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
 </script>


  <?php

  $order_num = "";
  if (isset($_GET["order"])) {
     $order_num = $_GET["order"];
     $_SESSION["order"] = $order_num;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['feedback']){
      $feedback = $_POST['feedback'];
      $sql = "INSERT INTO feedback (feedback_msg) VALUES ('$feedback');";
      $result = $conn->query($sql);
      if ($result) {
        header("Location: index.php");
      }
    }
  }


   ?>
<div id="status_fullpage">

  <div class="section">
    <!-- <div id="home_header">
      <a href="index.php"><img src ="images/pianopartner.png" id="icon_logo"></a>
    </div> -->
  <h3>Status information for Order # <?php echo $_SESSION["order"]; ?> </h3>
  <p id="status_bookmark">You can bookmark this page to check your status. </p>

  <div id="statusBox" >

  <?php

  if ($stmt1 = $conn->prepare("SELECT Users.StatusMsg, Users.Tempo, Users.Recording, Payment.Pages, Payment.Class, Payment.Amount FROM Users LEFT JOIN Payment ON Users.OrderNumber = Payment.OrderNumber WHERE Users.OrderNumber = ?;")){
    $stmt1->bind_param('i', $order_num);
    $stmt1->execute();
    $stmt1->bind_result($status_msg, $tempo, $recording, $pages, $class, $amount);
    $stmt1->fetch();


    switch ($status_msg) {
      case "Status1":
        ?>
          <p>Your order number is " <?php echo $order_num; ?>". Keep it in a safe place!</p>
          <p>We sent your order number to your email address.  </p>
          <p>Please wait up to 48 hours for our accompanist to respond to your inquiry.</p>
        <?php
        break;
      case "Status2":
        ?>
        <p>Your accompanist classifies this piece as <?php echo $class; ?> level piece that is <?php echo $pages; ?> pages long. </p>
        <p>You decided it to be <?php echo $tempo; ?> recording. </p>
        <p>You chose to receive the <?php echo $recording; ?>.</p>
        <p>Amount Due: $<?php echo $amount; ?>.00 </p>

        <!-- <div id="paypal-button-container"></div> -->
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" onsubmit="return confSubmit();">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="JG7HJE92MG5W8">
        <label for="accept"><input id="accept" type="checkbox">I agree to the <a href="terms_and_conditions">Terms and Conditons</a></label>
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>


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
        <p>You can provide any feedback here or by replying to your email. Feedback will be only be viewed by us and be used for improveement. </p>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <textarea class="input-1-2" name="feedback"></textarea><br>
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
 <div id="orderd"><a href='index.php' class="button">EXIT</a></div>
 </div>
</div>



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="fullpage.js/vendors/scrolloverflow.js"></script>
  <script src="fullpage.js/dist/fullpage.js"></script>
  <script src=js/status.js></script>

</body>

</html>
<?php ob_flush(); ?>
