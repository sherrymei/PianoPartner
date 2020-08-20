<?php ob_start(); ?>

<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

?>

<body>
  <div class="order-details">

    <?php

    if ($_SESSION["active"]){

      $user_id = $_GET['userid'];

      $query = "SELECT * FROM users WHERE user_id='$user_id'";

      if ($result = $conn->query($query)) {
        while ($row = $result->fetch_assoc()){
          $status_row = $row["status_msg"];
          ?>

          <div class="row"><span class="item"> Order Number:  </span> <span id="order<?php echo $user_id;?>"> <?php echo   $row["order_num"]; ?> </span></div>
          <div class="row"><span class="item"> Full Name:  </span> <span> <?php echo   $row["full_name"]; ?> </span></div>
          <div class="row"><span class="item"> Email Address:</span> <span> <?php echo   $row["mail_from"]; ?> </span></div>
          <div class="row"><span class="item"> Music Piece Name:  </span> <span> <?php echo   $row["piece_name"]; ?> </span></div>
          <div class="row"><span class="item"> IMSLP: </span> <span> <?php echo   $row["imslp"]; ?> </span></div>
          <div class="row"><span class="item"> Music file:  </span>  <span> <?php echo   $row["music_file"]; ?> </span></div>
          <div class="row"><span class="item"> Tuning Note: </span> <span> <?php echo   $row["tuning_note"]; ?> </span></div>
          <div class="row"><span class="item"> Note Type:  </span> <span> <?php echo   $row["note_type"]; ?> </span></div>
          <div class="row"><span class="item"> BPM:  </span> <span> <?php echo   $row["bpm"]; ?> </span></div>
          <div class="row"><span class="item"> Custom BPM: </span> <span> <?php echo   $row["custom_bpm"]; ?> </span></div>
          <div class="row"><span class="item"> Custom file:  </span> <span> <?php echo   $row["custom_file"]; ?> </span></div>
          <div class="row"><span class="item"> Recording:  </span> <span> <?php echo   $row["recording"]; ?> </span></div>
          <div class="row"><span class="item"> Question/Comments:  </span> <span> <?php echo   $row["questions"]; ?> </span></div>
        </div>
        <div>
          <div class="row">
			
            <span class="item" id="status-span"> Status </span>
            <span class="span-select">
              <select name="status" class="status" id="status<?php echo $user_id;?>" onchange="updateUserStatus(<?php echo $user_id;?>)">
                <option value="Status1" <?php if ($status_row=='Status1') echo "selected"; ?>>Status 1</option>
                <option value="Status2" <?php if ($status_row=='Status2') echo "selected"; ?>>Status 2</option>
                <option value="Status3" <?php if ($status_row=='Status3') echo "selected"; ?>>Status 3</option>
                <option value="Status4" <?php if ($status_row=='Status4') echo "selected"; ?>>Status 4</option>
              </select>
            <span>
          </div>
		  <div class="row"> 
			<span class="item">	</span>
		  </div>
          <?php
            }
            $result->free();
          }
          $conn->close();

        }
        else {
          header("Location: admin");
          exit;
        }

        ?>


      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script src="fullpage.js/vendors/scrolloverflow.js"></script>
      <script src="fullpage.js/dist/fullpage.js"></script>
      <script src=js/admin.js></script>

    </body>

    </html>
    <?php ob_flush(); ?>
