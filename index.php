<?php

include 'includes/connect_mysql.php';
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Piano Partner</title>
  <meta name="author" content="">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/stylesheet.css" >
  <link rel="stylesheet" type="text/css" href="fullpage.js/dist/fullpage.css" />
  <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.3/build/pure-min.css" integrity="sha384-cg6SkqEOCV1NbJoCu11+bm0NvBRc8IYLRGXkmNrqUBfTjmMYwNKPWBTIKyw9mHNJ" crossorigin="anonymous">
</head>

<body>

  <?php

  $tracking_num = $error_msg = "";

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $tracking_num = $_GET["tracking_num"];
    if (empty($tracking_num)){
      $error_msg = "";
    }
    else if (!preg_match("/^[0-9]+$/",$tracking_num)) {
      $error_msg .= "Your tracking number is only numbers allowed.<br/>";
    }
    else {
      $_SESSION["tracking"] = $tracking_num;
      header("Location: status.php?tracking=". $tracking_num);
    }
  }

  ?>

  <div id="fullpage">
    <div id="header">
      <div id="tracking">
        <form method="GET" class="pure-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <span><?php echo $error_msg ?></span>
          <label for="tracking_num">Check your status: </label>
          <input type="text" id="tracking_num" name="tracking_num" placeholder="Tracking Number">
          <button type="submit" name="submit" class="pure-button pure-button-primary">Submit</button>
        </form>
      </div>
    </div>
    <div class="section">

      <h1> Piano Partner</h1>
      <p>Online store for piano accompaniment to all classical and custom pieces</p>
    </div>
    <div class="section">
      <h3>About</h3>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/Zlm7X7tJXhs" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"  allowfullscreen ></iframe>
      <p>What's the purpose? Classical karaoke</p>
      <p>When you are a solo player, it's kind of difficult to imagine playing as part of a whole when you require an accompanist during your perforamnces</p>
      <p>The offer here(recording) is not to replace true accompanists as they wil follow you as you perform and support you as you creatively perform as a soloist - the perpose of these recording is to give an overal sense of practicing with the whole.</p>
    </div>
    <div class="section">
      <h3> Order </h3>
      <p> Difficulty is subject to pianist interpretation at the end </p>
      <p>Step 1:This form information will be sent us. Automatic response of we received it </p>
      <p>Step 2: Respond with my indication of Level and price and answers to any questions that you or I may have along with Paypal account, let you know how long it’ll take before i can get recording to you</p>
      <p>Step 3:You will pay via Paypal Automatic response that we have received payment</p>
      <p>Step 4:Respond you with a private Youtube link, please give us any feedback to help better serve you and create better products</p>

      <!-- <button type="button" name="order_button" value="order">Order</button> -->
      <a href='order_form.php' class="button-xlarge pure-button pure-button-primary">Order</a>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="fullpage.js/vendors/scrolloverflow.js"></script>
  <script src="fullpage.js/dist/fullpage.js"></script>
  <script src=js/index.js></script>
</body>

</html>
