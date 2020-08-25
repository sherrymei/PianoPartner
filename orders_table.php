<?php ob_start(); ?>

<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

?>


<body>

  <?php

  if ($_SESSION["active"]){

    ?>

    <p>Status 1 - Order Number</p>
    <p>Status 2 - Checkout</p>
    <p>Status 3 - Wait for an email notification</p>
    <p>Status 4 - Accompanist is recording</p>
    <p>Status 5 - Order is ready</p>

    <table>
      <thead>
        <tr>
          <th>Status</th>
          <th>order Number</th>
          <th>Guest Name</th>
          <th>Email Address</th>
          <th>Piece Name</th>
        </tr>
      </thead>
      <tbody>
        <?php

        $sql = "SELECT * FROM Users";

        if ($stmt = $conn->query($sql)) {
          while ($row = $stmt->fetch_assoc()) {
            $user_id = $row["UserID"];
            ?>
            <tr>
              <td>
				<button id="delete<?php echo $user_id; ?>" onclick="deleteOrder(<?php echo $user_id; ?>);">Delete</button>
              </td>
              <td><a id="order<?php echo $user_id;?>" href="order_info?userid=<?php echo $user_id;?>"> <?php echo $row["OrderNumber"]; ?> </a></td>
              <td><?php echo $row["FullName"]; ?></td>
              <td><?php echo $row["Email"]; ?></td>
              <td><?php echo $row["PieceName"]; ?></td>
            </tr>
            <?php
          }
        }
        ?>
      </tbody>
    </table>

    <?php

    $conn->close();
  }
  else {
    header("Location: admin");
    exit;
  }

  ?>

  <script src=js/admin.js></script>
  <?php include 'includes/html_foot.php'; ?>
<?php ob_flush(); ?>
