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

  $tracking_num = "";
  if (isset($_GET["tracking"])) {
     $tracking_num = $_GET["tracking"];
  }
  $_SESSION["tracking"] = $tracking_num;

   ?>

  <p>Status information for Tracking Number <?php echo $_SESSION["tracking"]; ?> </p>

  <?php

  //TODO grab status information from the database

   ?>

  <p>You can bookmark this page for your status. </p>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="fullpage.js/vendors/scrolloverflow.js"></script>
  <script src="fullpage.js/dist/fullpage.js"></script>
  <script src=js/index.js></script>
</body>

</html>
