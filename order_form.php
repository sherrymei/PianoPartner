<?php ob_start(); ?>
<?php

include 'includes/connect_mysql.php';
include 'includes/html_head.php';
session_start();



$name_error = $email_error = $p_name_error = $imslp_error = $musicfile_error = $tune_note_error = $tempo_error = $bpm_error = $custom_error = $note_type_error = $recording_error = "";
$order_num = $nombre = $email = $piece_name = $imslp = $music_file = $tuning_note = $tempo =  $bpm = $custom_bpm = $custom_file = $note_type = $recording = $questions = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["nombre"])){
    $name_error .= "Your first name is required. <br/>";
  }
  else {
    $nombre = test_input($_POST['nombre']);
    if (!preg_match("/^[a-zA-Z ]*$/",$nombre)) {
      $name_error .= "Your first name is only letters and white space allowed.  <br/>";
    }
  }


  if (empty($_POST["email"])){
    $email_error .= "Your email address is required. <br/>";
  }
  else {
    $email = test_input($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_error .= "Invalid email format. <br/>";
    }
  }

  if (empty($_POST["piece_name"])){
    $p_name_error .= "Please input the name of the piece.<br/>";
  }
  else {
    $piece_name = test_input($_POST['piece_name']);
    if (!preg_match("/^[a-zA-Z '#]*$/",$piece_name)) {
      $p_name_error .= "Your piece name is only letters, apostrophes, # and white space allowed. <br/>";
    }
  }

  $music_file_name = $_FILES['musicfile']['name'];
  $music_file_tmp_name = $_FILES['musicfile']['tmp_name'];
  $music_file_size = $_FILES['musicfile']['size'];
  $music_file_error = $_FILES['musicfile']['error'];
  $music_file_type = $_FILES['musicfile']['type'];

  if (is_uploaded_file($music_file_tmp_name)){
    $fileExt = explode('.',$music_file_name);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('application/pdf');
    if ($music_file_error == 0){
      if (in_array($music_file_type, $allowed)) {
        if ($music_file_size<100000){
          $fileNewName = uniqid('',true).".".$fileActualExt;
          $fileDestination = 'uploads/'.$fileNewName;
          move_uploaded_file($music_file_tmp_name,$fileDestination);
          $music_file = $fileDestination;
        }
        else {
          $musicfile_error .= "Your file is too big!<br/>";
        }
      }
      else {
        $musicfile_error .= "This file is not allowed!<br/>";
      }
    }
    else {
      $musicfile_error .= "There was an error uploading your file!<br/>";
    }
  }

  if (empty($_POST["imslp"]) && $music_file_error == 4) {
    $imslp_error .= "no file uploaded or imslp  link is missing.";
  }
  else if (empty($_POST["imslp"]) && $music_file_error == 0){
    $imslp_error .= "";
  }
  else {
    $imslp = test_input($_POST['imslp']);
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$imslp)) {
      $imslp_error .= "Invalid URL. Please follow the format: https://imslp.org <br/>";
      }
    }

    if (!isset($_POST["tuning_note"])){
      $tune_note_error .= "Please select a tuning note. <br/>";
    }
    else {
      $tuning_note = test_input($_POST['tuning_note']);
    }


    $custom_file_name = $_FILES['customfile']['name'];
    $custom_file_tmp_name = $_FILES['customfile']['tmp_name'];
    $custom_file_size = $_FILES['customfile']['size'];
    $custom_file_error = $_FILES['customfile']['error'];
    $custom_file_type = $_FILES['customfile']['type'];

    if (is_uploaded_file($custom_file_tmp_name)){
      $fileExt = explode('.',$custom_file_name);
      $fileActualExt = strtolower(end($fileExt));
      $allowed = array('audio/mpeg', 'audio/x-mp3', 'audio/wav', 'audio/x-wav');
      if ($custom_file_error == 0){
        if (in_array($custom_file_type, $allowed)) {
          if ($custom_file_size<13000000){
            $fileNewName = uniqid('',true).".".$fileActualExt;
            $fileDestination = 'uploads/'.$fileNewName;
            move_uploaded_file($custom_file_tmp_name,$fileDestination);
            $custom_file = $fileDestination;
          }
          else {
            $custom_error .= "Your file is too big!<br/>";
          }
        }
        else {
          $custom_error .= "This file is not allowed!<br/>";
        }
      }
      else {
        $custom_error .= "There was an error uploading your file!<br/>";
      }
    }

    if (!isset($_POST["tempo"])){
      $tempo_error .= "Please select standard BPM or custom. <br/>";
    }
    else {
      $tempo = test_input($_POST["tempo"]);
      if ($tempo == "standard"){
        if (!isset($_POST["note_type"])){
          $note_type_error .= "Please select a note type. <br/>";
        }
        else {
          $note_type = test_input($_POST['note_type']);
        }
        if (empty($_POST["bpm"])){
          $bpm_error .= "Please indicate the beats per minute for your tempo. <br/>";
        }
        else {
          $bpm = test_input($_POST['bpm']);
          if ($bpm<40 || $bpm>200){
            $bpm_error .=  "BPM must be greater than or equal to 40 and less than or equal to 200";
          }
        }
      }
      else if ($tempo == "custom"  && $custom_file_error == 4){
        if(empty($_POST["custom_bpm"])){
          $custom_error .= "Please provide a description of your custom tempo OR upload a recording of a solo performance to align accompaniment with. <br/>";
        }
        else{
          $bpm = 0;
          $custom_bpm = test_input($_POST['custom_bpm']);
        }
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

    }

    $error_array = array($name_error , $email_error , $p_name_error , $imslp_error , $musicfile_error , $tune_note_error , $tempo_error , $bpm_error , $custom_error , $note_type_error , $recording_error);

    if (has_no_error_messages($error_array)) {

      $order_num = mt_rand(1000000,mt_getrandmax());
      $status_msg = "Status1";

      $sql = "INSERT INTO Users (StatusMsg, OrderNumber, Nombre, Email, PieceName, IMSLP, MusicFile, TuningNote, Tempo, BPM, CustomBPM, CustomFile, NoteType, Recording, Questions)
      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
      if ($stmt = $conn->prepare($sql)) {
        $stmt -> bind_param("sisssssssisssss",$status_msg, $order_num, $nombre, $email, $piece_name, $imslp, $music_file, $tuning_note, $tempo, $bpm, $custom_bpm, $custom_file, $note_type, $recording, $questions);
        $stmt -> execute();
        $_SESSION["order"] = $order_num;
        $body = '<p>Hi, ' . $nombre . ' </p><br><p> This is your order number: <b> ' . $order_num . '</b>.</p><br>'.
        '<h4>Order Summary</h4>'.
        '<p>Name of Piece: <span></span>' . $piece_name . '</p>'.
        '<p>Tuning Note: <span></span>' . $tuning_note . '</p>'.
        '<p>Note Type: <span></span>' . $note_type . '</p>'.
        '<p>Tempo: <span></span>' . $custom_bpm . $bpm . '</p>'.
        '<p>Recording Type: <span></span>' . $recording . '</p>'.
        '<p>Questions/Comments: <span></span>' . $questions . '</p>'.
        '<br>Please wait up to 48 hours to hear back from us.<br>'.
        '<p>Thank you for ordering with us!</p>'.
        '<p>Backlight Recordings</p>'
        ;
        $subject = "BacklightRecordings: Your Order Number";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: orders@backlightrecordings.com" . "\r\n" . "CC: backlightrecordings@gmail.com";
        ob_start();
        $mailsend = mail("$email","$subject","$body","$headers");
        ob_end_clean();
        header("Location: status?order=" . $order_num);
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
  <body>
    <header>
      <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="/"><img src="images/IMG-4514.png" width="50" ></a>
      </nav>
    </header>
    <main>
      <div class="container">
        <div class="text-center">
        <h1 >Order Form</h1>
        <img src="images/IMG-4511.png" width="400" class="img-fluid">
      </div>
        <form class="" id="form_section" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
          <p> Fill out the information below. </p>
          <p> Click   <button type="button" class="btn btn-secondary" disabled><img src="https://img.icons8.com/android/24/FFFFFF/info.png" class="info_icon"></button> for more information about that section of the form.</p>
          <fieldset>
            <div class="form-group">
              <legend>Personal Information</legend>
            </div>
            <div class="form-group">
              <label for="nombre">Name: <span class="form-error"><?php echo $name_error;?> </span></label>
              <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo stripslashes($nombre);?>">
            </div>
            <div class="form-group">
              <label for="email">Email:<span class="form-error"><?php echo $email_error;?> </span><span class="text-muted">(If you want a private Youtube link, your email address must be connected to a Google account.)</span></label>
              <input type="email" id="email" name="email"class="form-control" value="<?php echo stripslashes($email);?>">
            </div>
          </fieldset>
          <fieldset>
            <legend>Music Piece Information</legend>
            <div class="form-group">
              <label for="piece_name">Name of piece:<span class="form-error"><?php echo $p_name_error;?> </span><span  class="text-muted">(please specify movement when applicable)</span></label>
              <input type="text" name="piece_name" id="piece_name" class="form-control" value="<?php echo stripslashes($piece_name);?>">
            </div>
            <p>Provide link to IMSLP or upload accompaniment sheet music</p>
            <div class="form-group">
              <label for="imslp">IMSLP:<span class="form-error"><?php echo $imslp_error;?> </span></label>
              <input type="url" id="imslp" name="imslp" class="form-control" placeholder="https://imslp.org/" onfocus="onFocus();" value="<?php echo stripslashes($imslp);?>">
            </div>
            <div class="form-group">
              <label for="musicfile">Select a file:<span class="form-error"><?php echo $musicfile_error;?> </span></label>
              <input type="file" id="musicfile" name="musicfile" class="form-control-file">
            </div>
          </fieldset>
          <fieldset>
            <legend>Tuning and Tempo
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal2"><img src="https://img.icons8.com/android/24/FFFFFF/info.png" class="info_icon"></button>
            </legend>
            <div>
              <label>Choose a tuning note:<span class="form-error"><?php echo $tune_note_error;?> </span></label>
              <div class="form-check"><label for="a"  class="form-check-label"><input type="radio" id="a" class="form-check-input" name="tuning_note" value="A" <?php if (isset($tuning_note) && $tuning_note == "A") echo "checked"; ?>>A</label></div>
              <div class="form-check"><label for="bb" class="form-check-label"><input type="radio" id="bb" class="form-check-input" name="tuning_note" value="Bb" <?php if (isset($tuning_note) && $tuning_note == "Bb") echo "checked"; ?>>B&#9837;</label></div>
              <div class="form-check"><label for="c"  class="form-check-label"><input type="radio" id="c" class="form-check-input" name="tuning_note" value="C" <?php if (isset($tuning_note) && $tuning_note == "C") echo "checked"; ?>>C</label></div>
              <div class="form-check"><label for="na" class="form-check-label"><input type="radio" id="na" class="form-check-input" name="tuning_note" value="NA" <?php if (isset($tuning_note) && $tuning_note == "NA") echo 'checked'; ?>  >N/A</label></div>
            </div>
            <label>Tempo:<span class="form-error"><?php echo $tempo_error;?> </span></label>
            <div class="form-check">
              <label for="standard"  class="form-check-label">
                <input type="radio" id="standard" class="form-check-input" name="tempo" onclick="TempoDisplay()" value="standard" <?php if (isset($tempo) && $tempo == "standard") echo "checked"; ?>>Standard <span classs="form-text text-muted">(one constant tempo per every tempo marking or you can leave it to the accompanist’s interpretation)</span>
              </label>
            </div>
            <div id = "tempo_div1" class="tempo_div"></div>
            <?php
            if (isset($tempo) && $tempo == "standard"){
              ?>
              <div class="tempo_div">
                <label>Choose a type of note:<span class="form-error"><?php echo $note_type_error; ?></span></label>
                <div class="form-check"><label for="half_note" class="form-check-label"><input type="radio" id="half_note" class="form-check-input" name="note_type" value="Half Note" <?php if (isset($note_type) && $note_type == "Half Note") echo 'checked'; ?> > &#119134; - Half Note</label></div>
                <div class="form-check"><label for="quarter_note" class="form-check-label"><input type="radio" id="quarter_note" class="form-check-input" name="note_type" value="Quarter Note" <?php if (isset($note_type) && $note_type == "Quarter Note") echo 'checked'; ?> > &#119135; - Quarter Note</label></div>
                <div class="form-check"><label for="eighth_note" class="form-check-label"><input type="radio" id="eighth_note" class="form-check-input" name="note_type" value="Eighth Note" <?php if (isset($note_type) && $note_type == "Eighth Note") echo 'checked'; ?>  >&#119136; - Eighth Note</label></div>

                <div class="form-group"> <label for="bpm" class="col-form-label">Beats per Minute: <span class="form-error"><?php echo $bpm_error; ?></span></label>
                  <input id="bpm" class="form-control col-sm-2" type="number" name="bpm" class="beats" min="40" max="200" value='<?php echo $bpm; ?>' required>
                </div>
              </div>
              <?php
            }
            ?>
            <div class="form-check">
              <label for="custom"  class="form-check-label">
                <input type="radio" id="custom" class="form-check-input" name="tempo" onclick="TempoDisplay()" value="custom" <?php if (isset($tempo) && $tempo == "custom") echo "checked"; ?>>Custom <span classs=" form-text text-muted">(fluid tempo)</span>
                <span id="custom_span"><?php if (isset($tempo) && $tempo == "custom") echo " - Provide a description or upload a recording"; ?></span>
                <div class="form-error"> <?php echo $custom_error ?> </div>
              </label>
            </div>
            <div id = "tempo_div2" class="tempo_div"></div>
            <?php
            if (isset($tempo) && $tempo == "custom"){
              ?>
              <div class="tempo_div">
                <label for="custom_bpm">Describe your desired tempo:</label>
                <textarea id="custom_bpm" name="custom_bpm" class="form-control"><?php echo stripslashes($custom_bpm);?></textarea>
                <label for="customfile">Select a recording of solo performance:<span class="form-error"> <?php echo  $custom_error; ?> </span></label>
                <input type="file" id="customfile" name="customfile" class="form-control-file">
              </div>
              <?php
            }
            ?>
          </fieldset>
          <fieldset>
            <legend>What format do you want to receive your accompaniment recording?
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal3"><img src="https://img.icons8.com/android/24/FFFFFF/info.png" class="info_icon"></button>
            </legend>
            <span class="form-error"><?php echo $recording_error;?> </span>
            <div>
              <div class="form-check"><label for="audiofile" class="form-check-label"><input type="radio" class="form-check-input" id="audiofile" name="format" value="Audio File" <?php if (isset($recording) && $recording == "Audio File") echo "checked"; ?>>Downloadable Audio File (.mp3)</label></div>
              <div class="form-check"><label for="videofile" class="form-check-label"><input type="radio" class="form-check-input"  id="videofile" name="format" value="Video File" <?php if (isset($recording) && $recording == "Video File") echo "checked"; ?>>Downloadable Video File (.mov)</label></div>
              <div class="form-check"><label for="YouTubeLink" class="form-check-label"><input type="radio" class="form-check-input" id="YouTubeLink" name="format" value="YouTube Link" <?php if (isset($recording) && $recording == "YouTube Link") echo "checked"; ?>>Private YouTube Link</label></div>
            </div>
          </fieldset>
          <fieldset>
            <legend>Any questions or special requests?</legend>
            <div>
              <textarea name="question" id="question" class="form-control"><?php echo stripslashes($questions);?></textarea>
            </div>
          </fieldset>
          <p class="form-text text-muted">Note: You will not be billed at this time. Once form is received, please wait up to 48 hours to hear a response from us on the bill.</p>
          <p class="form-text text-muted">By clicking on Submit Order Form, you agree to our <a href="privacy_policy">Privacy Policy.</a></p>
          <div class="text-center"><button type="submit" name="submit" id="submit" class="btn"><img class="rounded" src="images/IMG-4507.JPG" width="180"></button></div>


          <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModal2Label">Tempo</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Standard Tempo notes:</p>
                  <p>Unless you send a custom recording of your playing---</p>
                  <ul>
                    <li>Fermatas will be held for twice the duration of the note</li>
                    <li>Ritardando and accelerando will be up to the proxy of the accompanist to the defined speed you indicated for that section or you may indicate in your order inquiry to omit them</li>
                    <!-- <li>For cadenzas, you should pause the recording and fast forward to the time provided to match the a-tempo marking before your next entrance</li> -->
                  </ul>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModal3Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModal3Label">Choosing between Audio/Video and Youtube</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>If you choose Youtube, different parts of your recording will be broken up in chapters in the video.</p>
                  <p>If you choose audio or video file, we will give you timestamps for you to seek manually.</p>
                  <p>If you choose a video file or Youtube, it will be a minimum of $20. </p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </main>
    <?php include 'includes/user_foot.php'; ?>
    <script src=js/dynamic-order-form.js></script>
    <?php include 'includes/html_foot.php'; ?>

    <?php ob_flush(); ?>
