<?php ob_start(); ?>

<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

?>

<body>

  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="/">Backlight Recordings</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link" href="admin_main">Main </a>
          <a class="nav-link active" href="orders_table">Orders <span class="sr-only">(current)</span></a>
          <a class="nav-link" href="feedback">Feedback</a>
          <a class="nav-link" href="paypal_log">Paypal Log</a>
        </div>
      </div>
    </nav>
  </header>

   <main>
  <p>Status 1 - Order Number</p>
  <p>Status 2 - Checkout</p>
  <p>Status 3 - Wait for an email notification</p>
  <p>Status 4 - Accompanist is recording</p>
  <p>Status 5 - Order is ready</p>
  <div class="container">

  <?php

    if (isset($_SESSION["active"])){

      $user_id = $_GET['userid'];
      $query = "SELECT * FROM Payment RIGHT JOIN Users ON Payment.OrderNumber = Users.OrderNumber WHERE Users.UserID=?";
      if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()){
          $status_row = $row["StatusMsg"];
          $class_row = $row["Class"];
          $tempo_row = $row["Tempo"];
          $recording_row = $row["Recording"];
          ?>

          <div class="row justify-content-around"><div class="col-4"> Order Number:  </div> <div id="order<?php echo $user_id;?>" class="col-4"> <?php echo  $row["OrderNumber"];?> </div></div>
          <div class="dropdown-divider"></div>
          <form method="post" onsubmit="saveStatus2Info(<?php echo $user_id .",'". $tempo_row . "','". $recording_row;?>');return false;">
            <fieldset>
                <div class="row justify-content-around">
                  <div class="col-4"> Status: </div>
                  <div class="col-4">
                    <select name="status" class="" id="status<?php echo $user_id;?>" onchange="updateUserStatus(<?php echo $user_id;?>)">
                      <option value="Status1" <?php if ($status_row=='Status1') echo "selected"; ?>>Status 1</option>
                      <option value="Status2" <?php if ($status_row=='Status2') echo "selected"; ?>>Status 2</option>
                      <option value="Status3" <?php if ($status_row=='Status3') echo "selected"; ?>>Status 3</option>
                      <option value="Status4" <?php if ($status_row=='Status4') echo "selected"; ?>>Status 4</option>
                      <option value="Status5" <?php if ($status_row=='Status5') echo "selected"; ?>>Status 5</option>
                    </select>
                  </div>
                </div>
                <?php
                if ($status_row=='Status1'){
                ?>
                <div class="row">
                </div>
                <?php
              }
                else if ($status_row=='Status2'){
                ?>
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around">
                  <div class="col-4"> Class of Piece: </div>
                  <div class="col-4">
                    <select name="classpiece" class="" id="classpiece">
                      <option value="blank" ></option>
                      <option value="Beginner" <?php if ($class_row=='Beginner') echo "selected"; ?>>Beginner</option>
                      <option value="Amateur"  <?php if ($class_row=='Amateur')  echo "selected"; ?>>Amateur</option>
                      <option value="Virtuoso" <?php if ($class_row=='Virtuoso') echo "selected"; ?>>Virtuoso</option>
                    </select>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around">
                  <div class="col-4">Pages:</div>
                  <div class="col-4"><input type="number" id="pages" name="pages" min="0" value="<?php echo $row['Pages']; ?>"></div>
                </div>

                <?php
              }
              else {
                ?>
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around"><div class="col-4"> Class of Piece:</div><div class="col-4"> <?php echo $class_row; ?> </div></div>
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around"><div class="col-4">Pages:</div><div class="col-4"><?php echo $row['Pages']; ?></div></div>
                <?php
              }
              ?>
              <div class="dropdown-divider"></div>
              <div class="row justify-content-around">
                <div class="col-4">Amount:</div>
                <div  class="col-4" id="amount" name="amount">$<?php echo $row["Amount"]; ?></div>
              </div>
              <div class="order-details">
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around"><div class="col-4"> Full Name:  </div> <div class="col-4"> <?php echo   $row["Nombre"]; ?> </div></div>
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around"><div class="col-4"> Email Address:</div> <div class="col-4"> <?php echo   $row["Email"]; ?> </div></div>
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around"><div class="col-4"> Music Piece Name:  </div> <div class="col-4"> <?php echo   $row["PieceName"]; ?> </div></div>
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around"><div class="col-4"> IMSLP: </div> <div class="col-4"> <a href="<?php echo   $row["IMSLP"]; ?>"><?php echo   $row["IMSLP"]; ?> </a></div></div>
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around"><div class="col-4"> Music file:  </div>  <div class="col-4"> <a href="<?php echo   $row["MusicFile"]; ?>"> <?php echo   $row["MusicFile"]; ?> </a> </div></div>
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around"><div class="col-4"> Tuning Note: </div> <div class="col-4"> <?php echo   $row["TuningNote"]; ?> </div></div>
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around"><div class="col-4"> Note Type:  </div> <div class="col-4"> <?php echo   $row["NoteType"]; ?> </div></div>
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around"><div class="col-4"> BPM:  </div> <div class="col-4"> <?php echo   $row["BPM"]; ?> </div></div>
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around"><div class="col-4"> Custom Tempo: </div> <div class="col-4"> <?php echo   $row["CustomBPM"]; ?> </div></div>
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around"><div class="col-4"> Custom file:  </div> <div class="col-4"><a href="<?php echo   $row["CustomFile"]; ?>"> <?php echo   $row["CustomFile"]; ?> </a></div></div>
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around"><div class="col-4"> Recording:  </div> <div class="col-4"> <?php echo   $row["Recording"]; ?> </div></div>
                <div class="dropdown-divider"></div>
                <div class="row justify-content-around"><div class="col-4"> Question/Comments:  </div> <div class="col-4"> <?php echo   $row["Questions"]; ?> </div></div>
                <div class="dropdown-divider"></div>
              </div>
              <?php
              if ($status_row=='Status2'){
                ?>
              <button type="submit" name="submit" class="btn btn-primary" >Save</button>
              <?php
            }
            ?>
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

</div>
</main>

  <script src=js/admin.js></script>
  <?php include 'includes/html_foot.php'; ?>
<?php ob_flush(); ?>
