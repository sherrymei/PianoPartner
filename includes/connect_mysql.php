 <?php

 $dbServername = "servername";
 $dbUserName = "username";
 $dbPassword = "password";
 $dbName = "databasename";

 $conn = new mysqli($dbServername, $dbUserName, $dbPassword, $dbName);

 if (mysqli_connect_errno()) {
     printf("Connect failed: %s\n", mysqli_connect_error());
     exit();
 }

?>
