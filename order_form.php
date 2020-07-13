<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();

?>



<body>
  <?php
  $f_name_error = $l_name_error = $email_error = $p_name_error = $imslp_error = $file_error = $tune_note_error = $tempo_error = $bpm_error = $custom_error = $note_type_error = $recording_error = '';
  $order_num = $full_name = $first_name = $last_name = $mail_from = $piece_name = $imslp = $music_file = $tuning_note = $tempo =  $bpm = $custom_bpm = $note_type = $recording = $questions = "";


//$city = mysqli_real_escape_string($link, $city);
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["first_name"])){
      $f_name_error .= "Your first name is required. <br/>";
    }
    else {
      $first_name = test_input($_POST['first_name']);
      if (!preg_match("/^[a-zA-Z ]*$/",$first_name)) {
        $f_name_error .= "Your first name is only letters and white space allowed.  <br/>";
      }
      $first_name = $conn->real_escape_string($first_name);
    }

    if (empty($_POST["last_name"])){
      $l_name_error .= "Your last name is required. <br/>";
    }
    else {
      $last_name = test_input($_POST['last_name']);
      if (!preg_match("/^[a-zA-Z ]*$/",$last_name)) {
        $l_name_error .= "Your last name is only letters and white space allowed.  <br/>";
      }
      $last_name = $conn->real_escape_string($last_name);
    }

    if (empty($_POST["email"])){
      $email_error .= "Your email address is required. <br/>";
    }
    else {
      $mail_from = test_input($_POST['email']);
      if (!filter_var($mail_from, FILTER_VALIDATE_EMAIL)) {
        $email_error .= "Invalid email format. <br/>";
      }
      $mail_from = $conn->real_escape_string($mail_from);
    }

    if (empty($_POST["piece_name"])){
      $p_name_error .= "Please input the name of the piece.<br/>";
    }
    else {
      $piece_name = test_input($_POST['piece_name']);
      if (!preg_match("/^[a-zA-Z '#]*$/",$piece_name)) {
        $p_name_error .= "Your piece name is only letters, apostrophes, # and white space allowed. <br/>";
      }
      $piece_name = $conn->real_escape_string($piece_name);
    }

    $fileName = $_FILES['musicfile']['name'];
    $fileTmpName = $_FILES['musicfile']['tmp_name'];
    $fileSize = $_FILES['musicfile']['size'];
    $fileError = $_FILES['musicfile']['error'];
    $fileType = $_FILES['musicfile']['type'];

    if (is_uploaded_file($fileTmpName)){
      $fileExt = explode('.',$fileName);
      $fileActualExt = strtolower(end($fileExt));
      $allowed = array('application/pdf');
      if ($fileError == 0){
        if (in_array($fileType, $allowed)) {
          if ($fileSize<100000){
            $fileNewName = uniqid('',true).".".$fileActualExt;
            $fileDestination = 'uploads/'.$fileNewName;
            move_uploaded_file($fileTmpName,$fileDestination);
            $music_file = $fileDestination;
          }
          else {
            $file_error .= "Your file is too big!<br/>";
          }
        }
        else {
          $file_error .= "This file is not allowed!<br/>";
        }
      }
      else {
          $file_error .= "There was an error uploading your file!<br/>";
      }
    }

    if (empty($_POST["imslp"]) && $fileError == 4) {
      $imslp_error .= "no file uploaded or imslp  link is missing.";
    }
    else if (empty($_POST["imslp"]) && $fileError == 0){
        $imslp_error .= "";
    }
    else {
      $imslp = test_input($_POST['imslp']);
      if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$imslp)) {
        $imslp_error .= "Invalid URL. Please follow the format: https://imslp.org <br/>";
      }
      $imslp = $conn->real_escape_string($imslp);
    }

    if (!isset($_POST["tuning_note"])){
      $tune_note_error .= "Please select a tuning note. <br/>";
    }
    else {
      $tuning_note = test_input($_POST['tuning_note']);
    }

    if (!isset($_POST["note_type"])){
      $note_type_error .= "Please select a note type. <br/>";
    }
    else {
      $note_type = test_input($_POST['note_type']);
    }

    if (!isset($_POST["tempo"])){
      $tempo_error .= "Please select standard BPM or custom. <br/>";
    }
    else {
      $tempo = test_input($_POST["tempo"]);
      if ($tempo == "standard" && empty($_POST["bpm"])){
        $bpm_error .= "Please indicate the beats per minute for your tempo. <br/>";
      }
      else if ($tempo == "standard"){
        $bpm = test_input($_POST['bpm']);

        if ($bpm<40 || $bpm>200){
          $bpm_error .=  "BPM must be greater than or equal to 40 and less than or equal to 200";
        }
      }
      if ($tempo == "custom" && empty($_POST["custom_bpm"])){
        $custom_error .= "Please provide a description of your custom tempo or let us know that you will be sending an email. <br/>";
      }
      else if ($tempo == "custom"){
        $bpm = 0;
        $custom_bpm = test_input($_POST['custom_bpm']);
        $custom_bpm = $conn->real_escape_string($custom_bpm);
      }
    }

    if (!isset($_POST["format"])){
      $recording_error .= "Please select how you want to receive your accompaniment recording. <br/>";
    }
    else {
      $recording = test_input($_POST['format']);
    }

    if ($_POST["question"]){
      $questions = test_input($_POST['question']);
      $questions = $conn->real_escape_string($questions);
    }

    $error_array = array($f_name_error , $l_name_error , $email_error , $p_name_error , $imslp_error , $file_error , $tune_note_error , $tempo_error , $bpm_error , $custom_error , $note_type_error , $recording_error);

    if (has_no_error_messages($error_array)) {

      $order_num = mt_rand(1000000,mt_getrandmax());
      $full_name = $first_name . " " . $last_name;
      $status_msg = "Status1";

      $sql = "INSERT INTO users (status_msg, order_num, full_name, mail_from, piece_name, imslp, music_file, tuning_note, bpm, custom_bpm, note_type, recording, questions)
      SELECT '$status_msg', '$order_num', '$full_name', '$mail_from', '$piece_name', '$imslp', '$music_file', '$tuning_note', '$bpm', '$custom_bpm', '$note_type', '$recording', '$questions'
      WHERE NOT EXISTS (SELECT * FROM users
        WHERE order_num=$order_num ) LIMIT 1;";

      if ($conn->query($sql)) {
        $_SESSION["order"] = $order_num;
        header("Location: send_order_number.php");
        exit;
      }
      else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
      $conn->close();
    }

  }


function has_no_error_messages($data_array){

  for ($i = 0; $i<count($data_array); $i++){
    if($data_array[$i]) return false;
  }

  return true;

}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


<main>
  <div id="home_header">
    <a href="index.php"><img src ="images/pianopartner.png" id="icon_logo"></a>
  </div>

  <h1>ORDER FORM<h1>
  <h3>We'll create what you need</h3>

  <p> Fill out the information below.
    After you submit this form, you'll wait for the accompanist to decide the price for your custom depending on difficulty and how soon you'll receive it.
    After you pay, the accompanist will record it and email it to you with the option of a private YouTube link or a downloadable video file.
    Please give us any feedback after you receive your track.
  </p>

  <form class="" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
    <fieldset>
      <legend>Personal Information:</legend>
      <div class="">
        <label for="first_name">First Name: <span class="form-error"><?php echo $f_name_error;?> </span></label>
        <input type="text" name="first_name" id="first_name" class="input-1-2" value="<?php echo stripslashes($first_name);?>">
        <label for="last_name">Last Name:<span class="form-error"><?php echo $l_name_error;?> </span></label>
        <input type="text" name="last_name" id="last_name" class="input-1-2" value="<?php echo stripslashes($last_name);?>">
      </div>
      <div class="">
        <label for="email">Email:<span class="form-error"><?php echo $email_error;?> </span></label>
        <input type="email" id="email" name="email" class="input-1-2" value="<?php echo stripslashes($mail_from);?>">
      </div>
    </fieldset>
    <fieldset>
      <legend>Music Piece Information:</legend>
      <div class="">
        <label for="piece_name">Name of piece:<span class="form-error"><?php echo $p_name_error;?> </span></label>
        <input type="text" name="piece_name" id="piece_name" class="input-1-2" value="<?php echo stripslashes($piece_name);?>">
      </div>
      <p>Provide link to IMSLP or upload sheet music for accompaniment part</p>
      <div class="">
        <label for="imslp">IMSLP:<span class="form-error"><?php echo $imslp_error;?> </span></label>
        <input type="url" id="imslp" name="imslp" class="input-1-2" placeholder="https://imslp.org/" onfocus="onFocus();" value="<?php echo stripslashes($imslp);?>">
      </div>
      <div class="">
        <label for="musicfile">Select a file:<span class="form-error"><?php echo $file_error;?> </span></label>
        <input type="file" id="musicfile" name="musicfile" class="input-1-2">
      </div>
    </fieldset>
    <fieldset>
      <legend>Tuning and Tempo</legend>
      <span class="form-error"></span>
      <div>
        <label>Choose a tuning note:<span class="form-error"><?php echo $tune_note_error;?> </span></label>
        <label for="a"  class=""><input type="radio" id="a" name="tuning_note" value="a" <?php if (isset($tuning_note) && $tuning_note == "a") echo "checked"; ?>>A</label>
        <label for="bb"  class=""><input type="radio" id="bb" name="tuning_note" value="bb" <?php if (isset($tuning_note) && $tuning_note == "bb") echo "checked"; ?>>B&#9837;</label>
        <label for="c"  class=""><input type="radio" id="c" name="tuning_note" value="c" <?php if (isset($tuning_note) && $tuning_note == "c") echo "checked"; ?>>C</label>
      </div>
      <label>Tempo:<span class="form-error"><?php echo $tempo_error;?> </span></label>
      <label for="standard"  class=""><input type="radio" id="standard" name="tempo" onclick="TempoDisplay()" value="standard" <?php if (isset($tempo) && $tempo == "standard") echo "checked"; ?>>Standard</label>
      <div id = "tempo_div1" class="tempo_div"></div>
      <?php
      //
      if (isset($tempo) && $tempo == "standard"){
        echo '<div class="tempo_div">';
        echo '<label>Choose a type of note:<span class="form-error">'.$note_type_error.'</span></label>';
        echo '<label for="half_note"><input type="radio" id="half_note" name="note_type" value="half_note"';       if (isset($note_type) && $note_type == "half_note") echo 'checked'; echo ' >&#119134;</label>
          <label for="quarter_note"><input type="radio" id="quarter_note" name="note_type" value="quarter_note"';  if (isset($note_type) && $note_type == "quarter_note") echo 'checked'; echo ' >&#119135;</label>
          <label for="eighth_note"><input type="radio" id="eighth_note" name="note_type" value="eighth_note"';     if (isset($note_type) && $note_type == "eighth_note") echo 'checked'; echo ' >&#119136;</label>';
        echo '<label for="bpm">Beats per Minute: <span class="form-error">'. $bpm_error .'</span></label>';
        echo '<input id="bpm" type="number" name="bpm" class="beats" min="40" max="200" value='. $bpm .' required>';
        echo '</div>';
      }
      ?>
      <label for="custom"  class=""><input type="radio" id="custom" name="tempo" onclick="TempoDisplay()" value="custom" <?php if (isset($tempo) && $tempo == "custom") echo "checked"; ?>>Custom</label>
      <div id = "tempo_div2" class="tempo_div"></div>
      <?php
      if (isset($tempo) && $tempo == "custom"){
        echo '<div class="tempo_div">
        <label for="custom_bpm">Describe your desired tempo:<span class="form-error">'. $custom_error .'</span></label>
        <textarea id="custom_bpm" name="custom_bpm" class="input-1-2">' . stripslashes($custom_bpm) . '</textarea>
        <p>You can also send your recording of a solo performance to align accompaniment with to contact@pianopartner.com</p>
        </div>';
      }
      ?>
    </fieldset>
    <fieldset>
      <legend>What format do you want to receive your accompaniment part?</legend>
      <span class="form-error"><?php echo $recording_error;?> </span>
      <div>
        <label for="audiofile" class=""><input type="radio" id="audiofile" name="format" value="AudioFile" <?php if (isset($recording) && $recording == "AudioFile") echo "checked"; ?>>Downloadable Audio File</label>
        <label for="videofile" class=""><input type="radio" id="videofile" name="format" value="VideoFile" <?php if (isset($recording) && $recording == "VideoFile") echo "checked"; ?>>Downloadable Video File</label>
        <label for="YouTubeLink" class=""><input type="radio" id="YouTubeLink" name="format" value="YouTubeLink" <?php if (isset($recording) && $recording == "YouTubeLink") echo "checked"; ?>>Private YouTube Link</label>
      </div>
    </fieldset>
    <fieldset>
      <legend>Questions or Comments?</legend>
      <div>
        <textarea name="question" id="question" class="input-1-2"><?php echo stripslashes($questions);?></textarea>
      </div>
    </fieldset>
    <button type="submit" name="submit" class="">Submit</button>
  </form>
</main>
<script src=js/dynamic-order-form.js></script>
</body>

</html>
