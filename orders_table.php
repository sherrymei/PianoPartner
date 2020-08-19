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

    <p>Status 1 - Your order number is __. Accompanist is deciding the difficulty for your piece</p>
    <p>Status 2 - Please proceed to checkout</p>
    <p>Status 3 - Accompanist is recording your piece</p>
    <p>Status 4 - Your order is ready. Please check your inbox. You can provide any feedback here or by replying to your email</p>

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

        $sql = "SELECT * FROM users";

        if ($stmt = $conn->query($sql)) {
          while ($row = $stmt->fetch_assoc()) {
            $status_row = $row["status_msg"];
            $user_id = $row["user_id"];
            ?>
            <tr>
              <td>
                <select name="status" class="status" id="status<?php echo $user_id;?>" onchange="updateUserStatus(<?php echo $user_id;?>)">
                  <option value="Status1" <?php if ($status_row=='Status1') echo "selected"; ?>>Status 1</option>
                  <option value="Status2" <?php if ($status_row=='Status2') echo "selected"; ?>>Status 2</option>
                  <option value="Status3" <?php if ($status_row=='Status3') echo "selected"; ?>>Status 3</option>
                  <option value="Status4" <?php if ($status_row=='Status4') echo "selected"; ?>>Status 4</option>
                </select>
              </td>
              <td><a id="order<?php echo $user_id;?>" href="order_info.php?userid=<?php echo $user_id;?>"> <?php echo $row["order_num"]; ?> </a></td>
              <td><?php echo $row["full_name"]; ?></td>
              <td><?php echo $row["mail_from"]; ?></td>
              <td><?php echo $row["piece_name"]; ?></td>
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
    header("Location: admin.php");
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
