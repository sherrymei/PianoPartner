<?php ob_start(); ?>
<?php

include 'includes/html_head.php';
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-default fixed-top">
      <a class="navbar-brand" href="/"><img src="images/IMG-4514.png" alt="IMG-4514" width="50" ></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link active" href="/">Home <span class="sr-only">(current)</span></a>
          <a class="nav-link" href="#objective_section">Objective</a>
          <a class="nav-link" href="#order_section">Order</a>
          <a class="nav-link" href="#about_section">About Us</a>
          <a class="nav-link" href="#contact_section">Contact Us</a>
        </div>
      </div>
    </nav>
  </header>
  <div class="container-fluid">
    <div id="status_check_row">
      <div class="row">
        <div class="col-md black-back">
        </div>
        <div class="col-md">
          <div class="float-right">
            <form class="form-inline" method="GET" id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              <span><?php echo $error_msg ?></span>
              <label for="order_num">Check your status: </label>
              <input type="text" id="order_num" name="order_num" placeholder="Order Number" aria-label="Search" class="form-control mr-sm-2">
              <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div id="home_section" >
      <div class="row ">
        <div class="col-md-6 m-0 px-0">
          <div class="black-back">

            <div id="main_picture">
              <img src="images/front.jpg" alt="front" class="img-fluid" width="600">
            </div>
            <h1 class="main_h1"> BACKLIGHT</h1> <hr class="solid">   <h1 class="main_h1">RECORDINGS</h1>
          </div>
        </div>
        <div class=" col-md-6">
          <p class="text-center" id="slogan">Professional acoustic grand piano recordings for practice and performance</p>

        </div>
      </div>
    </div>
  </div>
  <div class="body-container ">
    <div class="container">
      <div class="card border-0 shadow my-5">
        <div class="card-body p-5">
          <div id="objective_section">
            <h1>We Want You to Feel the Spotlight</h1>
            <p>We all want to feel like we’re the soloist standing in the spotlight,
              but sometimes it’s difficult to feel that when you’re practicing by yourself or preparing an audition.
              Whether it’s a concerto, sonata or an aria, we can provide you  with a studio piano accompaniment track recorded by our professional piano accompanist.
              Pursuing the spotlight should not put strain on your schedule or finances.
            </p>
            <div class="row">
              <div class="col-md-6">
                <div class="text-center">
                  <img src="images/obj-1.jpg"  class="img-fluid rounded-img" alt="obj" >

                </div>

              </div>
              <div class="col-md-6">
                <span class="persuasion">Extremely Convenient</span>
                <p>
                  You can use this recording anywhere and anytime.
                  For normal practice, an accompanist recording can help enhance your practice on a day to day basis.
                </p>
              </div>
            </div>
            <div class="row">

              <div class="col-md-6">
                <span  class="persuasion">Affordable Prices</span>
                <p>
                  A typical one hour session with an accompanist can run you up to $60/hour, whereas a one-time payment can get you a high quality piano recording.
                </p>
              </div>
              <div class="col-md-6">
                <div class="text-center">
                  <img src="images/obj-2.jpg"  class="img-fluid rounded-img " alt="obj" >

                </div>

              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="text-center">
                  <img src="images/obj-3.jpg"  class="img-fluid rounded-img" alt="obj"   >

                </div>

              </div>
              <div class="col-md-6">
                <span  class="persuasion">Fully Customizable</span>
                <p> Each accompaniment track will be made specially for you. You let us know what you would like tempo wise, dynamic wise, and format wise. We can also align the playing style to your practice. Our video is so convenient you can follow along without sheet music.
                </p>
              </div>
            </div>
            <p>Our goal here at Backlight Recordings is to help shine that light on your performance to support you in your musical expressions by delivering a resource that can help you advance your performance to another level!
            </p>
            <p><a href="https://www.youtube.com/watch?v=XX7TL7FXBWU&t">Here</a> is our YouTube video Franz Schubert's Ave Maria recorded by our accompanist.</p>

          </div>
          <img id="order-divider" src="images/IMG-4510.png" class="img-fluid" alt="IMG-4510">
          <div  id="order_section">
            <h1 class="text-center"> Ordering Process </h1>

            <p> Just like any musical ensemble, musicians need to work together to create a wonderful performance, so we want to replicate that same mindset
              so that’s why we’re offering you an obligation-free chance before we settle on this partnership.  </p>
              <div>
                <div class="row">
                  <div class="col-md-1">
                    <h2>1</h2>
                  </div>
                  <div class="col-md-6">
                    <p> Let us know what you need by submitting an order form. we will respond to all of your questions and provide a final price within 48 hours.
                      You will receive an order number after submission. You can check back on your status using your order number. If you think we’re the right fit for you, that’s great! We’re honored!   </p>
                    </div>
                    <div class="col-md-4">
                      <div class="text-center">
                        <img src="images/form.png"  class="img-fluid" alt="form" width="100">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2 col-sm-4">
                      <div class="text-center bordered">
                        <p class="class-level">Simple</p>
                        <span>Standard
                          <button type="button" class="btn" data-toggle="tooltip" data-placement="right" title="one constant tempo per every tempo marking or you can leave it to the accompanist’s interpretation">
                            <img src="images/icons8-info-24.png" alt="info" width="12">
                          </button>
                        </span>
                        <p>$2 / page</p>
                        <span>Custom
                          <button type="button" class="btn" data-toggle="tooltip" data-placement="right" title="fluid tempo, please describe what you would like or provide a recording our accompanist can play to match you">
                            <img src="images/icons8-info-24.png" alt="info" width="12">
                          </button>
                        </span><p>$3 / page</p>
                      </div>

                    </div>
                    <div class="col-md-2 col-sm-4">
                      <div class="text-center bordered">
                        <p class="class-level">Amateur</p>
                        <span>Standard
                          <button type="button" class="btn" data-toggle="tooltip" data-placement="right" title="one constant tempo per every tempo marking or you can leave it to the accompanist’s interpretation">
                            <img src="images/icons8-info-24.png" alt="info" width="12">
                          </button>
                        </span><p>$4 / page</p>
                        <span>Custom
                          <button type="button" class="btn" data-toggle="tooltip" data-placement="right" title="fluid tempo, please describe what you would like or provide a recording our accompanist can play to match you">
                            <img src="images/icons8-info-24.png" alt="info" width="12">
                          </button>
                        </span><p>$6 / page</p>

                      </div>
                    </div>
                    <div class="col-md-2 col-sm-4">
                      <div class="text-center bordered">
                        <p class="class-level">Virtuoso</p>
                        <span>Standard
                          <button type="button" class="btn" data-toggle="tooltip" data-placement="right" title="one constant tempo per every tempo marking or you can leave it to the accompanist’s interpretation">
                            <img src="images/icons8-info-24.png" alt="info" width="12">
                          </button>
                        </span><p>$6 / page</p>
                        <span>Custom
                          <button type="button" class="btn" data-toggle="tooltip" data-placement="right" title="fluid tempo, please describe what you would like or provide a recording our accompanist can play to match you">
                            <img src="images/icons8-info-24.png" alt="info"  width="12">
                          </button>
                        </span><p>$9 / page</p>

                      </div>
                    </div>

                    <div class="col-md-1">
                      <h2>2</h2>
                    </div>

                    <div class="col-md-5">
                      <p>Based on the level of difficulty of the accompaniment part, our accompanist will let you know the difficulty level.
                        For example, Schubert's Ave Maria would be considered simple whereas Beethoven's Kreutzer sonata would be considered virtuoso. </p>
                        <p>Minimum $20 for a video</p>
                        <p class="text-muted">Further inquiries or disagreements will be answered before proceeding with the final payment. </p>
                      </div>

                    </div>
                    <div class="row">

                      <div class="col-md-1">
                        <h2>3</h2>
                      </div>
                      <div class="col-md-6">
                        <p>  Once we receive your order payment safe and securely through Paypal, we’ll get right to preparing your recording. On average, please wait up to a week for audio recordings and up to 2 weeks for video recordings.  </p>
                      </div>
                      <div class="col-md-4">
                        <div class="text-center">
                          <img src="images/IMG_0070.png"   class="img-fluid" alt="IMG_0070" width="100">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="text-center">
                          <img src="images/IMG_0071.png"  class="img-fluid" alt="IMG_0071" width="100">
                        </div>
                      </div>
                      <div class="col-md-1">
                        <h2>4</h2>
                      </div>
                      <div class="col-md-6">
                        <p>  Once your order is ready, we will email the file or link to you. If you choose to have the video on YouTube, we will set the video as private.</p>
                      </div>

                    </div>

                  </div>

                  <div class="text-center"><a href='order_form' class="btn" ><img src="images/IMG-4509.JPG" alt="IMG-4509" width="120"></a></div>
                </div>
                <div  id="about_section">
                  <div class="row">
                    <div class="col-md-2">
                      <h1 class="text-center"> About Us </h1>
                    </div>

                  </div>
                  <div class="row">
                    <div class="col-md">
                      <img src="images/IMG-4272.JPG" class="img-fluid"  alt="IMG-4272" width="300">
                    </div>

                    <div class="col-md">
                      <p>
                        All our studio recordings are recorded on our concert grand piano played by our professional piano accompanist who has been accompanying all different instrumentalists and vocalists during their recitals, conservatory auditions, and concerto competitions for almost a decade. She has worked with very young students starting from the suzuki program to professional instrumentalists.
                      </p>
                    </div>
                    <div class="col-md text-right">
                      <img src="images/IMG-4274.JPG" class="img-fluid"  alt="IMG-4274" width="300">
                    </div>
                  </div>
                </div>



              <div id="contact_section">
                <div>
                  <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                      <div id="contact_div">

                        <h1 class="text-center">Contact Us</h1>
                        <form id="contact_form">
                          <fieldset>
                            <div class="form-group">
                              <div class="col-lg">
                                <input type="text" name="name" placeholder="Name" id="contact_name" class="form-control" onkeydown="return event.key != 'Enter';">
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-lg">
                                <input type="text" name="mail" placeholder="Email" id="contact_email" class="form-control" onkeydown="return event.key != 'Enter';">
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-lg">
                                <input type="text" name="subject" placeholder="Subject" id="contact_subject" class="form-control" onkeydown="return event.key != 'Enter';">
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-lg">
                                <textarea name="message" placeholder="Message" id="contact_message" class="form-control" rows="8"></textarea>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="text-center">
                                <button type="button" name="submit" class="btn btn-outline-dark" onclick="sendEmail()">Send</button>
                              </div>
                            </div>
                            <p id="message"></p>
                          </fieldset>
                        </form>
                      </div>
                    </div>
                    <div class="col-lg-2">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <?php include 'includes/user_foot.php'; ?>

      <script src=js/index.js></script>
      <?php include 'includes/html_foot.php'; ?>
      <?php ob_flush(); ?>
