<?php ob_start(); ?>

<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

?>

<body>

  <p>Status 1 - Order Number</p>
  <p>Status 2 - Checkout</p>
  <p>Status 3 - Wait for an email notification</p>
  <p>Status 4 - Accompanist is recording</p>
  <p>Status 5 - Order is ready</p>

  <?php

    if ($_SESSION["active"]){

      $user_id = $_GET['userid'];
      $query = "SELECT * FROM Payment RIGHT JOIN Users ON Payment.OrderNumber = Users.OrderNumber WHERE Users.UserID='$user_id'";
      if ($result = $conn->query($query)) {
        while ($row = $result->fetch_assoc()){
          $status_row = $row["StatusMsg"];
          $class_row = $row["Class"];
          $tempo_row = $row["Tempo"];
          ?>

          <div class="order-details row"><span class="item"> Order Number:  </span> <span id="order<?php echo $user_id;?>"> <?php echo  $row["OrderNumber"];?> </span></div>
          <form method="post" onsubmit="saveStatus2Info(<?php echo $user_id .",'". $tempo_row;?>')">
            <fieldset>
              <div class="order-details">
                <div class="row">
                  <span class="item"> Status: </span>
                  <span class="span-select">
                    <select name="status" class="status" id="status<?php echo $user_id;?>" onchange="updateUserStatus(<?php echo $user_id;?>)">
                      <option value="Status1" <?php if ($status_row=='Status1') echo "selected"; ?>>Status 1</option>
                      <option value="Status2" <?php if ($status_row=='Status2') echo "selected"; ?>>Status 2</option>
                      <option value="Status3" <?php if ($status_row=='Status3') echo "selected"; ?>>Status 3</option>
                      <option value="Status4" <?php if ($status_row=='Status4') echo "selected"; ?>>Status 4</option>
                      <option value="Status5" <?php if ($status_row=='Status5') echo "selected"; ?>>Status 5</option>
                    </select>
                  </span>
                </div>
                <div class="row">
                  <span class="item"> Class of Piece: </span>
                  <span class="span-select">
                    <select name="classpiece" class="classpiece" id="classpiece">
                      <option value="blank" ></option>
                      <option value="Beginner" <?php if ($class_row=='Beginner') echo "selected"; ?>>Beginner</option>
                      <option value="Amateur"  <?php if ($class_row=='Amateur')  echo "selected"; ?>>Amateur</option>
                      <option value="Virtuoso" <?php if ($class_row=='Virtuoso') echo "selected"; ?>>Virtuoso</option>
                    </select>
                  </span>
                </div>
                <div class="row">
                  <span class="item">Pages:</span>
                  <span class="span-select"><input type="number" id="pages" name="pages" min="0" value="<?php echo $row['Pages']; ?>"></span>
                </div>
                <div class="row">
                  <span class="item">Amount:</span>
                  <span class="span-select"><span id="amount" name="amount">$<?php echo $row["Amount"]; ?></span>
                </div>
              </div>
              <div class="order-details">
                <div class="row"><span class="item"> Full Name:  </span> <span> <?php echo   $row["FullName"]; ?> </span></div>
                <div class="row"><span class="item"> Email Address:</span> <span> <?php echo   $row["Email"]; ?> </span></div>
                <div class="row"><span class="item"> Music Piece Name:  </span> <span> <?php echo   $row["PieceName"]; ?> </span></div>
                <div class="row"><span class="item"> IMSLP: </span> <span> <?php echo   $row["IMSLP"]; ?> </span></div>
                <div class="row"><span class="item"> Music file:  </span>  <span> <?php echo   $row["MusicFile"]; ?> </span></div>
                <div class="row"><span class="item"> Tuning Note: </span> <span> <?php echo   $row["TuningNote"]; ?> </span></div>
                <div class="row"><span class="item"> Note Type:  </span> <span> <?php echo   $row["NoteType"]; ?> </span></div>
                <div class="row"><span class="item"> BPM:  </span> <span> <?php echo   $row["BPM"]; ?> </span></div>
                <div class="row"><span class="item"> Custom BPM: </span> <span> <?php echo   $row["CustomBPM"]; ?> </span></div>
                <div class="row"><span class="item"> Custom file:  </span> <span> <?php echo   $row["Customfile"]; ?> </span></div>
                <div class="row"><span class="item"> Recording:  </span> <span> <?php echo   $row["Recording"]; ?> </span></div>
                <div class="row"><span class="item"> Question/Comments:  </span> <span> <?php echo   $row["Questions"]; ?> </span></div>
              </div>
              <div id="orderd"><button type="submit" name="submit" >Save</button></div>
            </fieldset>
          </form>

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


  <script src=js/admin.js></script>
  <?php include 'includes/html_foot.php'; ?>
<?php ob_flush(); ?>
