function TempoDisplay(){
  var tempodiv1 = document.getElementById('tempo_div1');
  var tempodiv2 = document.getElementById('tempo_div2');
  tempodiv1.innerHTML = tempodiv2.innerHTML = "";


  if (document.getElementById('standard').checked){

    var row_div = document.createElement("div");
    row_div.setAttribute("class", "row");

    var col_6_div = document.createElement("div");
    col_6_div.setAttribute("class", "col-sm-6");

    var col_1_div = document.createElement("div");
    col_1_div.setAttribute("class", "col-sm-1");

    var col_5_div = document.createElement("div");
    col_5_div.setAttribute("class", "col-sm-5");

    var note_div = document.createElement("div");
    note_div.setAttribute("class", "form-group");

    var note_text = document.createTextNode("Type of Note: ");

    var note_label = document.createElement("label");
    note_label.setAttribute("for","note_type");

    note_label.appendChild(note_text);

    var note_select = document.createElement("select");
    note_select.setAttribute("name","note_type");
    note_select.setAttribute("id","note_type");
    note_select.setAttribute("class","form-control");

    var none_option = document.createElement("option");
    var half_note_option = document.createElement("option");
    var quarter_note_option = document.createElement("option");
    var eighth_note_option = document.createElement("option");

    none_option.setAttribute("value","none");
    half_note_option.setAttribute("value", "Half Note");
    quarter_note_option.setAttribute("value","Quarter Note");
    eighth_note_option.setAttribute("value","Eighth Note");

    var half_note_text = document.createTextNode("𝅗𝅥  Half Note");
    var quarter_note_text = document.createTextNode("𝅘𝅥  Quarter Note");
    var eighth_note_text = document.createTextNode("𝅘𝅥𝅮  Eighth Note");

    var equal_text = document.createTextNode("=");

    half_note_option.appendChild(half_note_text);
    quarter_note_option.appendChild(quarter_note_text);
    eighth_note_option.appendChild(eighth_note_text);

    note_select.appendChild(none_option);
    note_select.appendChild(half_note_option);
    note_select.appendChild(quarter_note_option);
    note_select.appendChild(eighth_note_option);

    // note_div.appendChild(note_label);
    note_div.appendChild(note_select);

    var bpm_div = document.createElement("div");
    bpm_div.setAttribute("class","form-group");

    var bpm_text = document.createTextNode("BPM:")

    var bpm_label = document.createElement("label");
    bpm_label.setAttribute("for","bpm");

    var bpm_number = document.createElement("input");
    bpm_number.setAttribute("id","bpm");
    bpm_number.setAttribute("type","number");
    bpm_number.setAttribute("name","bpm");
    bpm_number.setAttribute("min","40");
    bpm_number.setAttribute("max","200")
    bpm_number.setAttribute("required","");
    bpm_number.setAttribute("class", "form-control");
    bpm_number.setAttribute("placeholder","200");

    bpm_label.appendChild(bpm_text);

    // bpm_div.appendChild(bpm_label);
    bpm_div.appendChild(bpm_number);

    col_6_div.appendChild(note_div);
    col_1_div.appendChild(equal_text);
    col_5_div.appendChild(bpm_div);

    row_div.appendChild(col_6_div);
    row_div.appendChild(col_1_div);
    row_div.appendChild(col_5_div);

    tempodiv1.appendChild(row_div);

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
      custom_bpm_textarea.setAttribute("class", "form-control");

      custom_file_label.setAttribute("for","customfile");
      custom_file_input.setAttribute("type", "file");
      custom_file_input.setAttribute("id","customfile");
      custom_file_input.setAttribute("name","customfile");
      custom_file_input.setAttribute("class","form-control-file");


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
  imslp.value = imslp.value=="" ? "" : imslp.value;
}
