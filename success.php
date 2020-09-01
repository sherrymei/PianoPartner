<?php ob_start(); ?>
<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

  ?>
  <body>

	<?php

	if ($_GET['cm']){
		$order_num = $_GET['cm'];
		$paypal_status = $_GET['st'];
		$transactionID = $_GET['tx'];
		$amount = $_GET['amt'];
		$status = "Status3";
    $today = date("Y-m-d H:i:s");
		$_SESSION["order"] = $order_num;
		$stmt = $conn->prepare("UPDATE Users SET StatusMsg = ? WHERE OrderNumber = ?");
		$stmt->bind_param( 'si', $status, $order_num);
		$stmt->execute();

    $stmt = $conn->prepare("INSERT INTO Paypal (TransactionTime, OrderNumber, TransactionID, PaypalStatus, Amount)
    VALUES (?,?,?,?,?); ");

    $stmt -> bind_param("sissd",$today,$order_num,$transactionID,$paypal_status,$amount);
    $stmt -> execute();
		$stmt->close();
		$conn->close();
	}

  ?>
     <p>Success! You have paid for an accompaniment recording!</p>
     <div id="orderd"><a href='status?order=<?php echo $order_num ?>' class="button">EXIT</a></div>
	<?php include 'includes/html_foot.php'; ?>
<?php ob_flush(); ?>
