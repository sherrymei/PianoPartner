function updateUserStatus(user_id) {
    var status = document.getElementById("status"+user_id).value;
    var order = document.getElementById("order"+user_id).innerHTML;
    var data = JSON.stringify({'status':status, 'order_num':order});

    var xmlhttp = new XMLHttpRequest();
	   xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
			location.reload();
       }
    };
    xmlhttp.open("POST","update_status.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("data=" + data);

}


function saveStatus2Info(user_id,tempo){
  var order = document.getElementById("order"+user_id).innerHTML;
  var class_piece = document.getElementById("classpiece").value;
  var pages = document.getElementById("pages").value;
  var amount = 0;
  if (tempo=="standard"){
    switch (class_piece) {
      case "Beginner": amount = pages * 2; break;
      case "Amateur":  amount = pages * 4; break;
      case "Virtuoso": amount = pages * 6; break;
    }
  }
  else if (tempo=="custom"){
    switch (class_piece) {
      case "Beginner": amount = pages * 3; break;
      case "Amateur":  amount = pages * 6; break;
      case "Virtuoso": amount = pages * 9; break;
    }
  }
  var data = JSON.stringify({'order_num':order, 'class_piece':class_piece, 'pages':pages, 'amount':amount});

  var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(data);
        document.getElementById("classpiece").style.display = "none";
        document.getElementById("pages").style.display = "none";
      }
    };
    xmlhttp.open("POST","insert_payment.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("data=" + data);

}
