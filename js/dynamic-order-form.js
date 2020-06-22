function TempoDisplay(){
  var tempodiv1 = document.getElementById('tempo_div1');
  var tempodiv2 = document.getElementById('tempo_div2');
  tempodiv1.innerHTML = tempodiv2.innerHTML = "";


  if (document.getElementById('constant').checked){

    // var note_type = document.createElement("label");

    // var half_note_label = document.createElement("label");
    // var quarter_note_label = document.createElement("label");
    // var eighth_note_label = document.createElement("label");
    var bpm_label = document.createElement("label");

    // var half_note_radio = document.createElement("input");
    // var quarter_note_radio = document.createElement("input");
    // var eighth_note_radio = document.createElement("input");
    var bpm_number = document.createElement("input");


    // var half_note_text = document.createElement("span");
    // var quarter_note_text = document.createElement("span");
    // var eighth_note_text = document.createElement("span");
    var bpm_text = document.createTextNode("Beats per Minute:");

    // half_note_text.innerHTML = "&#119134;";
    // quarter_note_text.innerHTML = "&#119135;";
    // eighth_note_text.innerHTML = "&#119136;";


    // half_note_label.setAttribute("for","half_note");
    // quarter_note_label.setAttribute("for","quarter_note");
    // eighth_note_label.setAttribute("for","eighth_note");

    // half_note_radio.setAttribute("id","half_note");
    // half_note_radio.setAttribute("type","radio");
    // half_note_radio.setAttribute("name","note_type");
    // half_note_radio.setAttribute("value","half_note");
    // quarter_note_radio.setAttribute("id","quarter_note");
    // quarter_note_radio.setAttribute("type","radio");
    // quarter_note_radio.setAttribute("name","note_type");
    // quarter_note_radio.setAttribute("value","quarter_note");
    // eighth_note_radio.setAttribute("id","eighth_note");
    // eighth_note_radio.setAttribute("type","radio");
    // eighth_note_radio.setAttribute("name","note_type");
    // eighth_note_radio.setAttribute("value","eighth_note");
    bpm_number.setAttribute("id","bpm");
    bpm_number.setAttribute("type","number");
    bpm_number.setAttribute("name","bpm");
    //bpm_number.setAttribute("class","beats");
    bpm_number.setAttribute("min","40");
    bpm_number.setAttribute("max","200")
    bpm_number.setAttribute("required","");
//value="<?php echo $piece_name;?>"
    // half_note_label.appendChild(half_note_radio);
    // half_note_label.appendChild(half_note_text);
    // quarter_note_label.appendChild(quarter_note_radio);
    // quarter_note_label.appendChild(quarter_note_text);
    // eighth_note_label.appendChild(eighth_note_radio);
    // eighth_note_label.appendChild(eighth_note_text);
    bpm_label.appendChild(bpm_text);

    // tempodiv1.appendChild(half_note_label);
    // tempodiv1.appendChild(quarter_note_label);
    // tempodiv1.appendChild(eighth_note_label);
    tempodiv1.appendChild(bpm_label);
    tempodiv1.appendChild(bpm_number);

  }
  else if (document.getElementById('custom').checked){
      //document.getElementById('custom').disabled = true;
      //document.getElementById("bpm").required = false;

      var custom_bpm_label = document.createElement("label");
      var custom_bpm_textarea = document.createElement("textarea");
      var send_recording_p = document.createElement("p");

      var custom_bpm_text = document.createTextNode("Describe your desired tempo:");
      var send_recording_text = document.createTextNode("You can also send your recording of a solo performance to align accompaniment with to contact@pianopartner.com")

      custom_bpm_label.setAttribute("for","custom_bpm");
      custom_bpm_textarea.setAttribute("id","custom_bpm");
      custom_bpm_textarea.setAttribute("name","custom_bpm");
      custom_bpm_textarea.setAttribute("class", " input-1-2");

      custom_bpm_label.appendChild(custom_bpm_text);
      send_recording_p.appendChild(send_recording_text);
      tempodiv2.appendChild(custom_bpm_label);
      tempodiv2.appendChild(custom_bpm_textarea);
      tempodiv2.appendChild(send_recording_p);
  }
}



// <div>
//   <label>Type of Note</label>
//   <label for="half_note"  class="pure-radio"><input type="radio" id="half_note" name="note_type" value="half_note">&#119134;</label>
//   <label for="quarter_note"  class="pure-radio"><input type="radio" id="quarter_note" name="note_type" value="quarter_note"></label>
//   <label for="eighth_note"  class="pure-radio"><input type="radio" id="eighth_note" name="note_type" value="eighth_note">&#119136;</label>
// </div>
// <div>
//   <label for="bpm">Beats per Minute:</label>
//   <input type="number" name="bpm" id="bpm">
// </div>
// <div class="pure-control-group">
//   <label for="custom_bpm">Custom Tempo:</label>
//   <textarea id="custom_bpm" name="custom_bpm"></textarea>
// </div>
