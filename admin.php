<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

?>


<body>

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
        <th>IMSLP</th>
        <th>Music File</th>
        <th>Tuning Note</th>
        <th>Note Type</th>
        <th>BPM</th>
        <th>Custom BPM</th>
        <th>Recording</th>
        <th>Questions/Comments</th>
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
             <td id="order<?php echo $user_id;?>"> <?php echo $row["order_num"]; ?> </td>
             <td><?php echo $row["full_name"]; ?> </td>
             <td><?php echo $row["mail_from"]; ?> </td>
             <td><?php echo $row["piece_name"]; ?> "</td>
             <td><a target="_blank" href="<?php echo $row["imslp"];      ?>"><?php echo $row["imslp"]; ?></td>
             <td><a target="_blank" href="<?php echo $row["music_file"]; ?>"><?php echo $row["music_file"]; ?> </a></td>
             <td><?php echo $row["tuning_note"]; ?> </td>
             <td><?php echo $row["note_type"]; ?> </td>
             <td><?php echo $row["bpm"]; ?> </td>
             <td><?php echo $row["custom_bpm"]; ?> </td>
             <td><?php echo $row["recording"]; ?> </td>
             <td><?php echo $row["questions"]; ?> </td>
             </tr>
             <?php
        }
      }
      else {
        ?>
        <tr><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td></tr>
        <?php
      }
      ?>
    </tbody>
  </table>

  <?php

  $conn->close();

  ?>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="fullpage.js/vendors/scrolloverflow.js"></script>
  <script src="fullpage.js/dist/fullpage.js"></script>
  <script src=js/admin.js></script>
</body>

</html>
