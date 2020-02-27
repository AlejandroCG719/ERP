$(document).ready(function() {
  $('#frm-login').submit(function (e) {
    $("#btn-login").html('<i class="fa fa-clock-o"></i> Cargando..');
    e.preventDefault();
    var formData = $("#frm-login").serializeArray();
    console.log(formData);
    $.ajax({
      data: formData,
      type: 'POST',
      dataType: "text json",
      url: 'model/login.php',
      success: function (data) {
        $("#mensaje").empty();
        $("#mensaje").append(data.msj);
        if (data.valor == 1) {
          setTimeout(function () {
            window.location.href = "index.php";
          }, 2000);
        }else {
          $("#btn-login").html('Entrar');
        }
      },
      error: function (error) {
        console.log(error);
        $("#mensaje").html('<div class="alert alert-dismissable alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Warning!</strong>Ocurrio un Error, Por Favor Verifique su Conexión e Intente Nuevamente.</div>');
      }
    });
  });
});
