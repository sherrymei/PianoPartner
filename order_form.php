<?php

include 'includes/connect_mysql.php';
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Piano Partner</title>
  <meta name="author" content="">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
  <link rel="stylesheet" type="text/css" href="fullpage.js/dist/fullpage.css">
  <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.3/build/pure-min.css" integrity="sha384-cg6SkqEOCV1NbJoCu11+bm0NvBRc8IYLRGXkmNrqUBfTjmMYwNKPWBTIKyw9mHNJ" crossorigin="anonymous">
</head>

<body>
  <?php
  $error_msg = "";
  $tracking_num = $full_name = $mail_from = $piece_name = $imslp = $music_file = $tuning_note = $tempo =  $bpm = $custom_bpm = $note_type = $recording = $questions = "";

//$city = mysqli_real_escape_string($link, $city);
  if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty($_POST["full_name"])){
      $error_msg .= "Your name is required. <br/>";
    }
    else {
      $full_name = test_input($_POST['full_name']);
      if (!preg_match("/^[a-zA-Z ]*$/",$full_name)) {
        $error_msg .= "Your name is only letters and white space allowed.  <br/>";
      }
      $full_name = mysqli_real_escape_string($conn, $full_name);
      echo "full name: " . $full_name;
    }

    if (empty($_POST["email"])){
      $error_msg .= "Your email address is required. <br/>";
    }
    else {
      $mail_from = test_input($_POST['email']);
      if (!filter_var($mail_from, FILTER_VALIDATE_EMAIL)) {
        $error_msg .= "Invalid email format. <br/>";
      }
      $mail_from = mysqli_real_escape_string($conn, $mail_from);
      echo "email: " . $mail_from;
    }

    if (empty($_POST["piece_name"])){
      $error_msg .= "Please input the name of the piece.<br/>";
    }
    else {
      $piece_name = test_input($_POST['piece_name']);
      if (!preg_match("/^[a-zA-Z '#]*$/",$piece_name)) {
        $error_msg .= "Your piece name is only letters, apostrophes, # and white space allowed. <br/>";
      }
      $piece_name = mysqli_real_escape_string($conn, $piece_name);
      echo "piece name: " . $piece_name;
    }

    if (empty($_POST["imslp"])) {
      $fileName = $_FILES['musicfile']['name'];
      $fileTmpName = $_FILES['musicfile']['tmp_name'];
      $fileSize = $_FILES['musicfile']['size'];
      $fileError = $_FILES['musicfile']['error'];
      $fileType = $_FILES['musicfile']['type'];

      $fileExt = explode('.',$fileName);
      $fileActualExt = strtolower(end($fileExt));
      $allowed = array('application/pdf');
      if ($fileError == 0){
        if (in_array($fileType, $allowed)) {
          if ($fileSize<100000){
            $fileNewName = uniqid('',true).".".$fileActualExt;
            $fileDestination = 'uploads/'.$fileNewName;
            move_uploaded_file($fileTmpName,$fileDestination);
            //  header("Location: something.php?uploadsuccess");
            $music_file = $fileDestination;
          }
          else {
            $error_msg .= "Your file is too big!<br/>";
          }
        }
        else {
          $error_msg .= "This file is not allowed!<br/>";
        }
      }
      else {
        if ($fileError == 4) {
          $error_msg .= "IMSLP missing or No file uploaded!<br/>";
        }
        else {
          $error_msg .= "There was an error uploading your file!<br/>";
        }
      }
    }

    else {
      $imslp = test_input($_POST['imslp']);
      if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$imslp)) {
        $error_msg .= "Invalid URL. Please follow the format: https://imslp.org. <br/>";
      }
      $imslp = mysqli_real_escape_string($conn, $imslp);
      echo "imslp link: " . $imslp;
    }

    if (!isset($_POST["tuning_note"])){
      $error_msg .= "Please select a tuning note. <br/>";
    }
    else {
      $tuning_note = test_input($_POST['tuning_note']);
    }

    if (!isset($_POST["note_type"])){
      $error_msg .= "Please select a note type. <br/>";
    }
    else {
      $note_type = test_input($_POST['note_type']);
    }

    if (!isset($_POST["tempo"])){
      $error_msg .= "Please select consistent BPM or custom. <br/>";
    }
    else {
      $tempo = test_input($_POST["tempo"]);
      if ($tempo == "consistent" && empty($_POST["bpm"])){
        $error_msg .= "Please indicate the beats per minute for your tempo. <br/>";
      }
      else if ($tempo == "consistent"){
        $bpm = test_input($_POST['bpm']);

        if ($bpm<40 || $bpm>200){
          $error_msg .=  "BPM must be greater than or equal to 40 and less than or equal to 200";
        }
      }
      if ($tempo == "custom" && empty($_POST["custom_bpm"])){
        $error_msg .= "Please let us know that you will be sending an email in the description box. <br/>";
      }
      else if ($tempo == "custom"){
        $custom_bpm = test_input($_POST['custom_bpm']);
        $custom_bpm = mysqli_real_escape_string($conn, $custom_bpm);
        echo "custom tempo: " . $custom_bpm;
      }
    }

    if (!isset($_POST["format"])){
      $error_msg .= "Please select how you want to receive your accompaniment recording. <br/>";
    }
    else {
      $recording = test_input($_POST['format']);
    }

    if (empty($_POST["question"])){
      $error_msg .= "";
    }
    else {
      $questions = test_input($_POST['question']);
      $questions = mysqli_real_escape_string($conn, $questions);
      echo "Question/Comments: " . $questions;
    }


    if ( $error_msg == "") {

      $tracking_num = mt_rand(1000000,mt_getrandmax());

      $sql = "INSERT INTO users (tracking_num, full_name, mail_from, piece_name, imslp, music_file, tuning_note, bpm, custom_bpm, note_type, recording, questions)
      SELECT $tracking_num, '$full_name', '$mail_from', '$piece_name', '$imslp', '$music_file', '$tuning_note', $bpm, '$custom_bpm', '$note_type', '$recording', '$questions'
      WHERE NOT EXISTS (SELECT * FROM users
        WHERE tracking_num=$tracking_num ) LIMIT 1;";
      $result = mysqli_query($conn,$sql);


      if ($result) {
        $_SESSION["tracking"] = $tracking_num;
        //header("Location: success.php");

      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
      mysqli_close($conn);
    }

  }



function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


<main>
  <form class="pure-form pure-form-stacked" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
    <p><?php echo $error_msg ?></p>
    <fieldset>
      <legend>Personal Information:</legend>
      <div class="pure-control-group">
        <label for="full_name">Full Name: (First Last)</label>
        <input type="text" name="full_name" id="full_name" class="input-1-2" value="<?php echo stripslashes($full_name);?>">
      </div>
      <div class="pure-control-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="input-1-2" value="<?php echo stripslashes($mail_from);?>">
      </div>
    </fieldset>
    <fieldset>
      <legend>Music Piece Information:</legend>
      <div class="pure-control-group">
        <label for="piece_name">Name of piece:</label>
        <input type="text" name="piece_name" id="piece_name" class="input-1-2" value="<?php echo stripslashes($piece_name);?>">
      </div>
      <p>Provide link to IMSLP or upload sheet music for accompaniment part</p>
      <div class="pure-control-group">
        <label for="imslp">IMSLP:</label>
        <input type="url" id="imslp" name="imslp" class="input-1-2" placeholder="https://imslp.org/" onfocus="this.value='https://imslp.org/';" value="<?php echo stripslashes($imslp);?>">
      </div>
      <div class="pure-control-group">
        <label for="musicfile">Select a file:</label>
        <input type="file" id="musicfile" name="musicfile" class="input-1-2">
      </div>
    </fieldset>
    <fieldset>
      <legend>Tuning and Tempo</legend>
      <div>
        <label>Choose a tuning note:</label>
        <label for="a"  class="pure-radio"><input type="radio" id="a" name="tuning_note" value="a" <?php if (isset($tuning_note) && $tuning_note == "a") echo "checked"; ?>>A</label>
        <label for="bb"  class="pure-radio"><input type="radio" id="bb" name="tuning_note" value="bb" <?php if (isset($tuning_note) && $tuning_note == "bb") echo "checked"; ?>>B&#9837;</label>
        <label for="c"  class="pure-radio"><input type="radio" id="c" name="tuning_note" value="c" <?php if (isset($tuning_note) && $tuning_note == "c") echo "checked"; ?>>C</label>
      </div>
      <div>
        <label>Choose a type of note:</label>
        <label for="half_note"  class="pure-radio"><input type="radio" id="half_note" name="note_type" value="half_note" <?php if (isset($note_type) && $note_type == "half_note") echo "checked"; ?>>&#119134;</label>
        <label for="quarter_note"  class="pure-radio"><input type="radio" id="quarter_note" name="note_type" value="quarter_note" <?php if (isset($note_type) && $note_type == "quarter_note") echo "checked"; ?>>&#119135;</label>
        <label for="eighth_note"  class="pure-radio"><input type="radio" id="eighth_note" name="note_type" value="eighth_note" <?php if (isset($note_type) && $note_type == "eighth_note") echo "checked"; ?> >&#119136;</label>
      </div>
      <label>Beats per Minute:</label>
      <label for="constant"  class="pure-radio"><input type="radio" id="constant" name="tempo" onclick="TempoDisplay()" value="consistent" <?php if (isset($tempo) && $tempo == "consistent") echo "checked"; ?>>Consistent</label>
      <div id = "tempo_div1" ></div>
      <?php
      //
      if (isset($tempo) && $tempo == "consistent"){
        echo '<label for="bpm">Beats per Minute: </label>
        <input id="bpm" type="number" name="bpm" class="beats" min="40" max="200" value='. $bpm .' required>';
      }
      ?>
      <label for="custom"  class="pure-radio"><input type="radio" id="custom" name="tempo" onclick="TempoDisplay()" value="custom" <?php if (isset($tempo) && $tempo == "custom") echo "checked"; ?>>Custom</label>
      <div id = "tempo_div2" ></div>
      <?php
      if (isset($tempo) && $tempo == "custom"){
        echo '<label for="custom_bpm">Describe your desired tempo:</label>
        <textarea id="custom_bpm" name="custom_bpm" class="input-1-2">' . stripslashes($custom_bpm) . '</textarea>
        <p>You can also send your recording of a solo performance to align accompaniment with to contact@pianopartner.com</p>';
      }
      ?>
    </fieldset>
    <fieldset>
      <legend>YouTube link or Video File?</legend>
      <div>
        <label for="YouTubeLink" class="pure-radio"><input type="radio" id="YouTubeLink" name="format" value="YouTubeLink" <?php if (isset($recording) && $recording == "YouTubeLink") echo "checked"; ?>>Private YouTube Link</label>
        <label for="videofile" class="pure-radio"><input type="radio" id="videofile" name="format" value="VideoFile" <?php if (isset($recording) && $recording == "VideoFile") echo "checked"; ?>>Downloadable Video File</label>
      </div>
    </fieldset>
    <fieldset>
      <legend>Questions or Comments?</legend>
      <div>
        <textarea name="question" id="question" class="input-1-2"><?php echo stripslashes($questions);?></textarea>
      </div>
    </fieldset>
    <button type="submit" name="submit" class="pure-button pure-button-primary">Submit</button>
  </form>
</main>
<script src=js/dynamic-order-form.js></script>
</body>

</html>

<!-- login with order number -->
