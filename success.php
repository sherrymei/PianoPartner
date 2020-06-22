<?php

include 'includes/connect_mysql.php';
session_start();

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>

<body>
<h1>SUCCESS!</h1>

<p> Your tracking number is <?php echo $_SESSION["tracking"] ?>. Please keep it in a safe place! Please wait for accompanist response. </p>
</body>
</html>
