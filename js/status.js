var myFullpageStatus = new fullpage('#status_fullpage', {

});


function confSubmit() {
  if(!document.getElementById("accept").checked) {
    alert("Please read and accept the Terms and Conditions in order to continue.");
    return false;
  }
}
