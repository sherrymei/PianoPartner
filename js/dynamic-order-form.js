function TempoDisplay(){
  var tempodiv1 = document.getElementById('tempo_div1');
  var tempodiv2 = document.getElementById('tempo_div2');
  tempodiv1.innerHTML = tempodiv2.innerHTML = "";


  if (document.getElementById('standard').checked){

    var bpm_text = document.createTextNode("Beats per Minute:");
    var note_text = document.createTextNode("Type of Note:");

    var bpm_label = document.createElement("label");
    var bpm_number = document.createElement("input");

    var note_label = document.createElement("label");

    var half_note_text = document.createTextNode("𝅗𝅥");
    var quarter_note_text = document.createTextNode("𝅘𝅥");
    var eighth_note_text = document.createTextNode("𝅘𝅥𝅮");

    var half_note_label = document.createElement("label");
    var quarter_note_label = document.createElement("label");
    var eighth_note_label = document.createElement("label");

    var half_note_radio = document.createElement("input");
    var quarter_note_radio = document.createElement("input");
    var eighth_note_radio = document.createElement("input");



    bpm_number.setAttribute("id","bpm");
    bpm_number.setAttribute("type","number");
    bpm_number.setAttribute("name","bpm");
    bpm_number.setAttribute("min","40");
    bpm_number.setAttribute("max","200")
    bpm_number.setAttribute("required","");

    half_note_label.setAttribute("for","half_note");
    quarter_note_label.setAttribute("for","quarter_note");
    eighth_note_label.setAttribute("for","eighth_note");

    half_note_radio.setAttribute("type","radio");
    half_note_radio.setAttribute("id","half_note");
    half_note_radio.setAttribute("name","note_type");
    half_note_radio.setAttribute("value","half_note");

    quarter_note_radio.setAttribute("type","radio");
    quarter_note_radio.setAttribute("id","quarter_note");
    quarter_note_radio.setAttribute("name","note_type");
    quarter_note_radio.setAttribute("value","quarter_note");

    eighth_note_radio.setAttribute("type","radio");
    eighth_note_radio.setAttribute("id","eighth_note");
    eighth_note_radio.setAttribute("name","note_type");
    eighth_note_radio.setAttribute("value","eighth_note");

    bpm_label.appendChild(bpm_text);
    note_label.appendChild(note_text);

    half_note_label.appendChild(half_note_radio);
    half_note_label.appendChild(half_note_text);

    quarter_note_label.appendChild(quarter_note_radio);
    quarter_note_label.appendChild(quarter_note_text);

    eighth_note_label.appendChild(eighth_note_radio);
    eighth_note_label.appendChild(eighth_note_text);


    tempodiv1.appendChild(note_label);
    tempodiv1.appendChild(half_note_label);
    tempodiv1.appendChild(quarter_note_label);
    tempodiv1.appendChild(eighth_note_label);
    tempodiv1.appendChild(bpm_label);
    tempodiv1.appendChild(bpm_number);

  }
  else if (document.getElementById('custom').checked){

      var custom_span = document.getElementById("custom_span");
      custom_span.innerHTML = "";

      var custom_bpm_label = document.createElement("label");
      var custom_bpm_textarea = document.createElement("textarea");
      var custom_file_label = document.createElement("label");
      var custom_file_input = document.createElement("input");

      var custom_span_text = document.createTextNode(" - Provide a description or upload a recording");
      var custom_bpm_text = document.createTextNode("Describe your desired tempo:");
      var custom_file_text = document.createTextNode("Select a recording of solo performance:");


      custom_bpm_label.setAttribute("for","custom_bpm");
      custom_bpm_textarea.setAttribute("id","custom_bpm");
      custom_bpm_textarea.setAttribute("name","custom_bpm");
      custom_bpm_textarea.setAttribute("class", " input-1-2");

      custom_file_label.setAttribute("for","customfile");
      custom_file_input.setAttribute("type", "file");
      custom_file_input.setAttribute("id","customfile");
      custom_file_input.setAttribute("name","customfile");
      custom_file_input.setAttribute("class","input-1-2");


      custom_bpm_label.appendChild(custom_bpm_text);
      custom_file_label.appendChild(custom_file_text);
      tempodiv2.appendChild(custom_bpm_label);
      tempodiv2.appendChild(custom_bpm_textarea);
      tempodiv2.appendChild(custom_file_label);
      tempodiv2.appendChild(custom_file_input);
      custom_span.appendChild(custom_span_text);
  }
}


function onFocus() {
  var imslp = document.getElementById("imslp");
  imslp.value = imslp.value=="" ? imslp.placeholder : imslp.value;
}
