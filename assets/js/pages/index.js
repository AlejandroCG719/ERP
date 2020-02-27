$(document).ready(function() {
  cierreMes();
});

function cierreMes(){
  $.ajax({
    data: {},
    type: "post",
    dataType: "text",
    url: "model/cierre_mes.php",
    success: function (data) {
      console.log(data)
    },
    error: function (data) {
      console.log("error cierre mes");
      console.log(data);
    }
  });
}
