function confSubmit() {
  if(!document.getElementById("accept").checked) {
    alert("Please read and accept the Terms and Conditions in order to continue.");
    return false;
  }
}
var order_num = document.getElementById("order-no").innerHTML;
paypal.Buttons({
  style: {
    shape: 'pill',
    color: 'black',
    layout: 'vertical',
    label: 'paypal',

  },
  createOrder: function (data, actions) {
    const json = { "order_num": order_num };
    return fetch('payment.php', {
            method: 'post',
            headers: {
            'content-type': 'application/x-www-form-urlencoded'
            },
            body: JSON.stringify(json),
        }).then(function(res) {
            return res.json();
        }).then(function(data) {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: data.amount
              }
            }]
          });
        });
  },
  onApprove: function(data, actions) {
    return actions.order.capture().then(function(details) {
      window.location.href = "success?order=" + order_num;
    });
  },
  onCancel: function (data) {
    window.location.href = "status?order=" + order_num;
  }
}).render('#paypal-button-container');
