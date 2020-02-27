$(document).ready(function() {
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  });
  $('[data-toggle="tooltip"]').tooltip();
  submit();
});
function submit(){
  $('#frm-cliente').on('submit', function(event) {
    $(document).skylo('start');
    setTimeout(function () {
      $(document).skylo('set', 50);
    }, 150);
    event.preventDefault();
    var campos = document.getElementsByClassName("form-control");
    for (var i = 0; i < campos.length; i++) {
      campos[i].removeAttribute("disabled");
    }
    var data_form = $(this).serializeArray();
    $.ajax({
      data: data_form,
      type: "post",
      dataType: "json",
      url: "model/edit_cliente.php",
      success: function (data) {
        setTimeout(function () {
          $(document).skylo('end');
        }, 300);
        $("#message").empty();
        if (data[0].error==true) {
          $("#message").append(
            '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>Ocurrio un Error, por favor verifique e intente nuevamente.</div>'
          )
        }else {
          document.getElementById("saveButton").setAttribute("disabled", "");
          for (var i = 0; i < campos.length; i++) {
            campos[i].setAttribute("disabled", "");
          }
          document.getElementById("saveButton").setAttribute("disabled", "");
          $("#message").append(
            '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>El Registro se Guardo con Éxito.</div>'
          )
        }
        $('html, body').animate({scrollTop: 0}, 'slow');
      },
      error: function (data) {
        console.log("error");
        console.log(data);
      }
    });
  });
}
