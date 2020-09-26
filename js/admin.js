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

function deleteOrder(user_id){
	var order = document.getElementById("order"+user_id).innerHTML;
	var data = JSON.stringify({'order_num':order});
	var xmlhttp = new XMLHttpRequest();
  console.log(data);
	xmlhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
       console.log(xmlhttp.responseText);
       location.reload();
      }
    };
    xmlhttp.open("POST","delete_order.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("data=" + data);
}


function isVideo(recording){
  if (recording=="Video File" || recording=="YouTube Link")
    return true;
  else return false;
}



function saveStatus2Info(user_id,tempo,recording){
  console.log(user_id + " " + tempo + " " + recording);
  var order = document.getElementById("order"+user_id).innerHTML;
  var class_select = document.getElementById("classpiece");
  var class_piece = class_select.value;
  var pages_input = document.getElementById("pages");
  var pages = pages_input.value;
  var amount = 0;
  if (tempo=="standard"){
    switch (class_piece) {
      case "Beginner": amount = pages * 2; break;
      case "Amateur":  amount = pages * 4; break;
      case "Virtuoso": amount = pages * 6; break;
      default: amount = 0;
    }
    console.log("amount - " + amount);
    if (isVideo(recording) && amount<=20) {
      amount = 20;
    }
  }
  else if (tempo=="custom"){
    switch (class_piece) {
      case "Beginner": amount = pages * 3; break;
      case "Amateur":  amount = pages * 6; break;
      case "Virtuoso": amount = pages * 9; break;
      default: amount = 0;
    }
    console.log("amount - " + amount);
    if (isVideo(recording) && amount<=20){
      amount = 20;
    }
  }

  var data = JSON.stringify({'order_num':order, 'class_piece':class_piece, 'pages':pages, 'amount':amount});

  var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(data);
        var class_text = document.createElement("span");
        class_text.innerHTML = class_piece;
        class_select.parentNode.replaceChild(class_text, class_select);
        var pages_text = document.createElement("span");
        pages_text.innerHTML = pages;
        pages_input.parentNode.replaceChild(pages_text,pages_input);
        var amount_text = document.getElementById("amount");
        amount_text.innerHTML = "$" + amount;
      }
    };
    xmlhttp.open("POST","insert_payment.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("data=" + data);
}
