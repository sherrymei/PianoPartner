<?php ob_start(); ?>

<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

?>

<body>
  <?php
    if (isset($_SESSION["active"])){
   ?>

  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="/">Backlight Recordings</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link active" href="admin_main">Main <span class="sr-only">(current)</span></a>
          <a class="nav-link" href="orders_table">Orders </a>
          <a class="nav-link" href="feedback">Feedback</a>
        </div>
      </div>
    </nav>
  </header>
<?php
}
else {
  header("Location: admin");
  exit;
}
?>

   <script src=js/admin.js></script>
<?php include 'includes/html_foot.php'; ?>
<?php ob_flush(); ?>
