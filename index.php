<?php ob_start(); ?>
<?php

include 'includes/html_head.php';
include 'includes/user_nav.php';
session_start();

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
        header("Location: status?order=". $order_num);
        exit;
      }
    }
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

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
			  <a class="nav-link active" href="#home_section">Home <span class="sr-only">(current)</span></a>
			  <a class="nav-link" href="#objective_section">Objective</a>
			  <a class="nav-link" href="#order_section">Order</a>
			  <a class="nav-link" href="#about_section">About Us</a>
			  <a class="nav-link" href="#contact_section">Contact US</a>
			</div>
		  </div>
		</nav>
	</header>

  <div class="container">
  
    <div >
      <form  class="form-inline" method="GET" id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <span><?php echo $error_msg ?></span>
        <label for="order_num">Check your status: </label>
        <input type="text" id="order_num" name="order_num" placeholder="Order Number" aria-label="Search" class="form-control mr-sm-2">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
    <div id="home_section">
      <h1 class="text-center"> Backlight Recordings</h1>
      <p class="text-center">Professional acoustic grand piano recordings for practice and performance</p>
    </div>
    <div id="objective_section">
      <h1 class="text-center">Objective</h1>
      <p>We all want to feel like we’re the soloist standing in the spotlight, but it’s difficult to feel that way when you’re practicing or performing by yourself. Whether you’re practicing at home by yourself or recording for an audition, we can help provide you with a studio piano accompaniment track recorded by our professional piano accompanist. Whether you’re playing a concerto or a sonata, our accompanist will be able to provide you a recording of the accompaniment at a tempo you’re comfortable with.
      </p>
      <p>A typical one hour session with an accompanist can run you up to $60/hour whereas we can provide you with a recording you can use anywhere and anytime. For live performances, we do recommend you hire a professional accompanist as they will adjust their playing to match every nuance of your playing, but for normal practice, an accompanist recording can help enhance your practice on a day to day basis.
      </p>
      <p>We can provide you with a audio or even a video that you can read and play along with. Take a look at some examples.
      </p>
      <p>Our goal here at Backlight Recordings is to help shine that light on your performance from behind to support you in your musical expressions.
      </p>
    </div>
    <div  id="order_section">
      <h1 class="text-center"> How to Order Your Own </h1>
      <p> Fill out the order form. You will receive an order number for the status of your order. You can check back on your status using your order number. When we receive your form, please wait up to 48 hours for our accompanist to review your order and respond to any questions you may have and provide a final price. Then please proceed to pay through Paypal. Once we receive your payment, please wait up to a week for audio recordings and up to 2 weeks for video recordings. After, the accompanist will upload the file or link for you only. You can only access the YouTube video with your Google account. If you choose an audio file or video file, you can download it and play it offline wherever you go. </p>

      <table id="rates_table">
        <caption>RATES</caption>
        <thead>
          <tr>
            <th>Difficulty</th>
            <th>Standard</th>
            <th>Custom</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <td colspan="3">$20 Flat Rate for a video that's $20 and under</td>
          </tr>
          <tr>
            <td colspan="3">above $20, audio and video at no extra cost</td>
          </tr>
        </tfoot>
        <tbody>
          <tr><!-- First row -->
            <td class="td_lvl">Beginner</td>
            <td>$2.00/page</td>
            <td>$3.00/page</td>
          </tr>
          <tr><!-- Second row -->
            <td class="td_lvl">Amateur</td>
            <td>$4.00/page</td>
            <td>$6.00/page</td>
          </tr>
          <tr><!-- Third row -->
            <td class="td_lvl">Virtuoso</td>
            <td>$6.00/page</td>
            <td>$9.00/page</td>
          </tr>
        </tbody>
      </table>
      <div id="orderd"><a href='order_form' class="button" >Order</a></div>
    </div>
    <div  id="about_section">
      <h1 class="text-center"> About </h1>
      <p>
        All our studio recordings are recorded from our grand piano played by our professional piano accompanist who has been accompanying all different instrumentalists during their recitals, conservatory auditions, and concerto competitions for almost a decade. She has worked with very young students starting from the suzuki program to professional instrumentalists.
      </p>
    </div>
    <div  id="contact_section">
      <h1 class="text-center">Contact Us</h1>
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
	<?php include 'includes/user_foot.php'; ?>
  
  <script src=js/index.js></script>
<?php include 'includes/html_foot.php'; ?>
<?php ob_flush(); ?>
