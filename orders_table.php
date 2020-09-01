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

  <?php


  // if ($_SESSION["active"]){

    ?>

    <p>Status 1 - Order Number</p>
    <p>Status 2 - Checkout</p>
    <p>Status 3 - Wait for an email notification</p>
    <p>Status 4 - Accompanist is recording</p>
    <p>Status 5 - Order is ready</p>

        <?php

        $array = array("Status1","Status2","Status3","Status4","Status5");

        /*
          for each status, create a table

        */



          for ($s = 0; $s < count($array); $s++){
            $status_msg = $array[$s];
            $sql = "SELECT * FROM Users WHERE StatusMsg = '$status_msg'";
            if ($stmt = $conn->query($sql)) {
              ?>
              <table class="table" id="status_table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col"><?php echo $status_msg; ?> </th>
                    <th scope="col">Order Number</th>
                    <th scope="col">Guest Name</th>
                    <th scope="col">Email Address</th>
                    <th scope="col">Piece Name</th>
                  </tr>
                </thead>
                <tbody>
              <?php
            while ($row = $stmt->fetch_assoc()) {
              $user_id = $row["UserID"];
                ?>

                <tr>
                  <td>
                  <button id="delete<?php echo $user_id;?>" class="btn btn-danger" onclick="deleteOrder(<?php echo $user_id;?>);">Delete</button>
                  </td>
                  <td><a id="order<?php echo $user_id;?>" href="order_info?userid=<?php echo $user_id;?>"><?php echo $row["OrderNumber"];?></a></td>
                  <td><?php echo $row["Nombre"]; ?></td>
                  <td><?php echo $row["Email"]; ?></td>
                  <td><?php echo $row["PieceName"]; ?></td>
                </tr>

                <?php



            }
            ?>
            </tbody>
          </table>
          <?php
          }
          else {
            echo "Error: " . $conn->error;
          }

        }
        ?>


    <?php

    $conn->close();
  // }
  // else {
  //   header("Location: admin");
  //   exit;
  // }

  ?>

  <script src=js/admin.js></script>
  <?php include 'includes/html_foot.php'; ?>
<?php ob_flush(); ?>
