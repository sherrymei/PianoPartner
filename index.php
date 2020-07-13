<?php

include 'includes/html_head.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

?>

<body>

  <?php

  $order_num = $error_msg = "";

  if (session_status() == PHP_SESSION_ACTIVE) {
    session_unset();
    session_destroy();
  }

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (empty($_GET["order_num"])){
      $error_msg = "";
    }
    else{
      $order_num = test_input($_GET["order_num"]);
      if (!preg_match("/^[0-9]+$/",$order_num)) {
        $error_msg .= "Your order number is only numbers allowed.<br/>";
      }
      else {
        $_SESSION["order"] = $order_num;
        header("Location: status.php?order=". $order_num);
      }
    }
  }

  ?>

  <ul id="menu">

    <li><a href="index.php"><img src ="images/pianopartner.png" id="icon_logo"></a></li>
    <li data-menuanchor="about"><a href="#about">About</a></li>
    <li data-menuanchor="order"><a href="#order">Order</a></li>
    <li data-menuanchor="contact"><a href="#contact">Contact</a></li>
  </ul>


  <div id="fullpage">
    <div id="header">
      <form method="GET" id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <span><?php echo $error_msg ?></span>
        <label for="order_num">Check your status: </label>
        <input type="text" id="order_num" name="order_num" placeholder="Order Number">
        <button type="submit" name="submit" class="">Submit</button>
      </form>
    </div>
    <div class="section" id="home_section">
      <h1 id="main_h1"> Backlight Recordings</h1>
      <p>Online store for piano accompaniment to all classical and custom pieces</p>
    </div>
    <div class="section" id="about_section">
      <h1>About</h1>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/Zlm7X7tJXhs" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"  allowfullscreen ></iframe>
      <p>What's the purpose? Classical karaoke.
        When you are a solo player, it's kind of difficult to imagine playing as part of a whole when you require an accompanist during your perforamnces.
        The offer here(recording) is not to replace true accompanists as they wil follow you as you perform and support you as you creatively perform as a soloist - the perpose of these recording is to give an overal sense of practicing with the whole.</p>
      </div>
      <div class="section" id="order_section">
        <h1> Order Customs </h1>
        <p> Difficulty is subject to pianist interpretation at the end </p>
        <p><span class="step">Step 1: </span>This form information will be sent us. Automatic response of we received it </p>
        <p><span class="step">Step 2: </span>Respond with my indication of Level and price and answers to any questions that you or I may have along with Paypal account, let you know how long it’ll take before i can get recording to you</p>
        <p><span class="step">Step 3: </span>You will pay via Paypal Automatic response that we have received payment</p>
        <p><span class="step">Step 4: </span>Respond you with a private Youtube link, please give us any feedback to help better serve you and create better products</p>
        <div id="orderd"><a href='order_form.php' class="button" >Order</a></div>
      </div>
      <div class="section" id="contact_section">
        <h1>Contact Us</h1>
        <form id="contact_form">
          <fieldset>
            <input type="text" name="name" placeholder="Full Name" id="contact_name" class="input-1-2" onkeydown="return event.key != 'Enter';">
            <input type="text" name="mail" placeholder="Email" id="contact_email" class="input-1-2" onkeydown="return event.key != 'Enter';">
            <input type="text" name="subject" placeholder="Subject" id="contact_subject" class="input-1-2" onkeydown="return event.key != 'Enter';">
            <textarea name="message" placeholder="Message" id="contact_message" class="input-1-2"></textarea>
            <button type="button" name="submit" class="" onclick="sendEmail()">Submit</button>
            <p id="message"></p>
          </fieldset>
        </form>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="fullpage.js/vendors/scrolloverflow.js"></script>
    <script src="fullpage.js/dist/fullpage.js"></script>
    <script src=js/index.js></script>
  </body>

  </html>
