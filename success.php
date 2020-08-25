<?php ob_start(); ?>
<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

/*   if ($_SESSION["order"]){
    $order_num = $_SESSION["order"];
    $status = "Status3";
    $stmt = $conn->prepare("UPDATE Users SET StatusMsg = ? WHERE OrderNumber = ?");
    $stmt->bind_param( 'si', $status, $order_num);
    $stmt->execute();
    $stmt->close();
    $conn->close();
  } */
  

  ?>
  <body>
	
	<?php
	  	echo $_GET['cm'];
		echo $_GET['st'];
		echo $_GET['tx'];
		echo $_GET['amt'];
  
	if ($_GET['cm']){
		$order_num = $_GET['cm'];
		$paypal_status = $_GET['st'];
		$transactionID = $_GET['tx'];
		$amount = $_GET['amt'];
		$status = "Status3";
		$_SESSION["order"] = $order_num;
		$stmt = $conn->prepare("UPDATE Users SET StatusMsg = ? WHERE OrderNumber = ?");
		$stmt->bind_param( 'si', $status, $order_num);
		$stmt->execute();
		$stmt->close();
		$conn->close();
	}

  ?>
     <p>Success! You have paid for an accompaniment recording!</p>
     <div id="orderd"><a href='status?order=<?php echo $order_num ?>' class="button">EXIT</a></div>
	<?php include 'includes/html_foot.php'; ?>
<?php ob_flush(); ?>
