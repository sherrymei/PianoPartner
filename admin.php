<?php

include 'includes/connect_mysql.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Piano Partner</title>
  <meta name="author" content="">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/stylesheet.css" >
  <link rel="stylesheet" type="text/css" href="fullpage.js/dist/fullpage.css" />
  <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.3/build/pure-min.css" integrity="sha384-cg6SkqEOCV1NbJoCu11+bm0NvBRc8IYLRGXkmNrqUBfTjmMYwNKPWBTIKyw9mHNJ" crossorigin="anonymous">
</head>

<body>

  <table class="pure-table pure-table-bordered">
    <thead>
        <tr>
            <th>Tracking Number</th>
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
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
    //     (tracking_num, full_name, mail_from, piece_name, imslp, music_file, tuning_note, bpm, custom_bpm, note_type, recording, questions)

    // <a href="url">link text</a>
        while($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row["tracking_num"] .  "</td>";
          echo "<td>" . $row["full_name"] .  "</td>";
          echo "<td>" . $row["mail_from"] .  "</td>";
          echo "<td>" . $row["piece_name"] .  "</td>";
          echo "<td>" . $row["imslp"] .  "</td>";
          echo "<td><a href=\"" . $row["music_file"] . "\">" . $row["music_file"] .  "</a></td>";
          echo "<td>" . $row["tuning_note"] .  "</td>";
          echo "<td>" . $row["note_type"] .  "</td>";
          echo "<td>" . $row["bpm"] .  "</td>";
          echo "<td>" . $row["custom_bpm"] .  "</td>";
          echo "<td>" . $row["recording"] .  "</td>";
          echo "<td>" . $row["questions"] .  "</td>";
          echo "</tr>";
        }
      } else {
        echo "0 results";
      }
      ?>
    </tbody>
</table>

  <?php

  mysqli_close($conn);

   ?>


   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
   <script src="fullpage.js/vendors/scrolloverflow.js"></script>
   <script src="fullpage.js/dist/fullpage.js"></script>
   <script src=js/index.js></script>
 </body>

 </html>
