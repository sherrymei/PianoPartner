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
            $status_row = $row["StatusMsg"];
            $user_id = $row["UserID"];
            ?>
            <tr>
              <td>
                <select name="status" class="status" id="status<?php echo $user_id;?>" onchange="updateUserStatus(<?php echo $user_id;?>)">
                  <option value="Status1" <?php if ($status_row=='Status1') echo "selected"; ?>>Status 1</option>
                  <option value="Status2" <?php if ($status_row=='Status2') echo "selected"; ?>>Status 2</option>
                  <option value="Status3" <?php if ($status_row=='Status3') echo "selected"; ?>>Status 3</option>
                  <option value="Status4" <?php if ($status_row=='Status4') echo "selected"; ?>>Status 4</option>
                  <option value="Status5" <?php if ($status_row=='Status5') echo "selected"; ?>>Status 5</option>
                </select>
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


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="fullpage.js/vendors/scrolloverflow.js"></script>
  <script src="fullpage.js/dist/fullpage.js"></script>
  <script src=js/admin.js></script>
</body>

</html>
<?php ob_flush(); ?>
