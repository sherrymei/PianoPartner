 <?php

 $dbServername = "localhost";
 $dbUserName = "root";
 $dbPassword = "SQLserver@42";
 $dbName = "pianopartner";

 $conn = mysqli_connect($dbServername, $dbUserName, $dbPassword, $dbName);

 if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
 }


  // if ($conn->connect_error) {
  //   die("Connection failed: " . $conn->connect_error);
  // }

  // if (!$conn) {
  //     echo "Error: Unable to connect to MySQL." . PHP_EOL;
  //     echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
  //     echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
  //     exit;
  // }
  //
  // echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
  // echo "Host information: " . mysqli_get_host_info($conn) . PHP_EOL;

  // mysqli_close($conn);

  // phpinfo();



 ?>


 <?php
// $servername = "localhost";
// $username = "root";
// $mysql_native_password = "SQLserver@42";
//
// // Create connection
// $conn = new mysqli($servername, $username, $password);
// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }
//
// // Create database
// $sql = "CREATE DATABASE myDB";
// if ($conn->query($sql) === TRUE) {
//   echo "Database created successfully";
// } else {
//   echo "Error creating database: " . $conn->error;
// }
//
// $conn->close();
?>
