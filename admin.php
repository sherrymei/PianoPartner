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
            echo "<tr>";
            echo "<td>
            <select name=\"status\" class=\"status\" id=\"status" . $user_id . "\" onchange='updateUserStatus(" . $user_id . ");'>
              <option value=\"Status1\" "; if ($status_row=='Status1') echo "selected"; echo ">Status 1</option>
              <option value=\"Status2\" "; if ($status_row=='Status2') echo "selected"; echo ">Status 2</option>
              <option value=\"Status3\" "; if ($status_row=='Status3') echo "selected"; echo ">Status 3</option>
              <option value=\"Status4\" "; if ($status_row=='Status4') echo "selected"; echo ">Status 4</option>
            </select>
            </td>";
            echo "<td id=\"order" . $user_id . "\">" . $row["order_num"] .  "</td>";
            echo "<td>" . $row["full_name"] .  "</td>";
            echo "<td>" . $row["mail_from"] .  "</td>";
            echo "<td>" . $row["piece_name"] .  "</td>";
            echo "<td><a target=\"_blank\" href=\"" . $row["imslp"] . "\">" . $row["imslp"] . "</td>";
            echo "<td><a target=\"_blank\" href=\"" . $row["music_file"] . "\">" . $row["music_file"] .  "</a></td>";
            echo "<td>" . $row["tuning_note"] .  "</td>";
            echo "<td>" . $row["note_type"] .  "</td>";
            echo "<td>" . $row["bpm"] .  "</td>";
            echo "<td>" . $row["custom_bpm"] .  "</td>";
            echo "<td>" . $row["recording"] .  "</td>";
            echo "<td>" . $row["questions"] .  "</td>";
            echo "</tr>";
        }
      }
      else {
        echo "<tr><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td></tr>";
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
