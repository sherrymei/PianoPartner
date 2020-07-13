 <?php

 $dbServername = "localhost";
 $dbUserName = "root";
 $dbPassword = "SQLserver@42";
 $dbName = "pianopartner";

 $conn = new mysqli($dbServername, $dbUserName, $dbPassword, $dbName);

 if (mysqli_connect_errno()) {
     printf("Connect failed: %s\n", mysqli_connect_error());
     exit();
 }

?>
