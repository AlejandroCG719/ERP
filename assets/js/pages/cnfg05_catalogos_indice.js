var b = 0;
$(document).ready(function() {
  loadCatalogos();
  submit();
});
function loadCatalogos(){
  $.ajax({
    data: {},
    type: "post",
    dataType: "text",
    url: "model/tabla_catalogos.php",
    success: function (data) {
      if(b>0){
        var table = $('#tabla').DataTable();
        table.destroy();
        $("#tabla").empty();
      }else {
        b=1;
      }
      $("#tabla").append(data);
      dataTab('#tabla');
    },
    error: function (data) {
      console.log("error");
      console.log(data);
    }
  });
}
function dataTab(id){
  // -------------------------------
  // Initialize Data Tables
  // -------------------------------
  $(id).DataTable({
    "sPaginationType": "bootstrap",
    dom: 'T<"clear">lfrtip',
    "oLanguage": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      },
      "dom": 'T<"clear">lfrtip',
      "tableTools": {
        "sSwfPath": "/assets/css/datatable/swf/copy_csv_xls_pdf.swf",
        aButtons: [
          {
            sExtends: "collection",
            sButtonText: "Guardar",
            sButtonClass: "save-collection",
            aButtons: ['copy', 'csv', 'xls', 'pdf'],
          },
          {
            sExtends: "print",
            sButtonText: "Imprimir",
          }
        ]
      },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }
  });
  console.log();
  $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
  $('.dataTables_length select').addClass('form-control');
}

function submit(){
  $('#frm-catalogo').on('submit', function(event) {
    event.preventDefault();
    var data_form = $(this).serializeArray();
    $.ajax({
      data: data_form,
      type: "post",
      dataType: "json",
      url: "model/edit_catalogo.php",
      success: function (data) {
        $("#message").empty();
        if (data[0].error==true) {
          $("#message").append(
            '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>'+data[0].desc+'</strong></div>'
          );
        }else {
          $("#message").append(
            '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>'+data[0].desc+'</strong></div>'
          );
        }
        loadCatalogos();
        $('html, body').animate({scrollTop: 0}, 'slow');
      },
      error: function (data) {
        console.log("error");
        console.log(data);
      }
    });
  });
}
