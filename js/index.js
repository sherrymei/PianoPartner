function sendEmail() {
  var name = document.getElementById("contact_name").value;
  var mail = document.getElementById("contact_email").value;
  var subject = document.getElementById("contact_subject").value;
  var message = document.getElementById("contact_message").value;
  var data = JSON.stringify({'name':name, 'mail':mail, 'subject':subject, 'message':message});

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      jsobj = JSON.parse(this.responseText);

      if (jsobj.status=="success"){
        document.getElementById("contact_name").style.border = '';
        document.getElementById("contact_email").style.border = '';
        document.getElementById("contact_form").reset();
      }
      else {
        if (jsobj.error["name"]){
          document.getElementById("contact_name").style.border = '1px solid red';
        }
        if (jsobj.error["email"]){
          document.getElementById("contact_email").style.border = '1px solid red';
        }
      }
      document.getElementById("message").innerHTML = jsobj.response;
    }
  };

  xmlhttp.open("POST","contact_form.php",true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send("data=" + data);

}


$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
