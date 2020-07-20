<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

?>


<body>
  <script src="https://www.paypal.com/sdk/js?client-id=AY9te3wD5b7VZxZgkqt8eZH-cXSInfVfvhe4rgCzC_RnudPNDaSajsDU1avOC8I_LPVzfvIzjHYWYkmX" data-sdk-integration-source="button-factory"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
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
    <div id="home_header">
      <a href="index.php"><img src ="images/pianopartner.png" id="icon_logo"></a>
    </div>
  <h3>Status information for Order # <?php echo $_SESSION["order"]; ?> </h3>
  <p id="status_bookmark">You can bookmark this page to check your status. </p>

  <div id="statusBox" >

  <?php

  if ($stmt1 = $conn->prepare("SELECT status_msg FROM users WHERE order_num = ?")){
    $stmt1->bind_param('i', $order_num);
    $stmt1->execute();
    $stmt1->bind_result($status_msg);
    $stmt1->fetch();


    switch ($status_msg) {
      case "Status1":
        ?>
        <p>Your order number is " <?php echo $order_num; ?>". Keep it in a safe place!</p>
        <p>We sent your order number to your email address.  </p>
        <p>Accompanist is deciding the difficulty for your piece</p>
        <?php
        break;
      case "Status2":
        ?>
        <p>Please proceed to checkout</p>
        <div id="paypal-button-container"></div>
        <?php
        break;
      case "Status3":
        ?>
        <p>Accompanist is recording your piece</p>
        <?php
        break;
      case "Status4":
        ?>
        <p>Your order is ready. Please check your inbox.</p>
        <p>You can provide any feedback here anonymously or by replying to your email. </p>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <textarea class="input-1-2" name="feedback"></textarea><br>
          <button type="submit" class="pure-button">SEND</button>
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
