<?php ob_start(); ?>
<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();


	if (isset($_GET['order'])){
    $status = "Status3";
		$order_num = $_GET['order'];
		$_SESSION["order"] = $order_num;
		date_default_timezone_set('EST');
		$today = date("Y-m-d H:i:s");
		$stmt = $conn->prepare("UPDATE Users SET StatusMsg = ?, StatusChange = ? WHERE OrderNumber = ?");
		$stmt->bind_param( 'ssi', $status, $today, $order_num);
		$stmt->execute();
		$stmt->close();
		$conn->close();
	}

  ?>
  <body>
  <nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="/"><img src="images/IMG-4514.png" width="50" ></a>
  </nav>
		<div class="text-center">
     <p>Success! You have paid for an accompaniment recording!</p>
     <a href='status?order=<?php echo $order_num ?>' class="button">EXIT</a>
	 </div>

	<?php
	include 'includes/user_foot.php';
	include 'includes/html_foot.php';
	?>
<?php ob_flush(); ?>
