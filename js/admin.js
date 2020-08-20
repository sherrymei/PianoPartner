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
