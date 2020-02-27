var b = 0;
$(document).ready(function() {
  loadBitacora();
});
function loadBitacora(){
  $.ajax({
    data: {},
    type: "post",
    dataType: "text",
    url: "model/tabla_bitacora.php",
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
      "order": "desc",
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
        "sSortDescending": ": Activar para ordenar la columna de manera descendente",
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente"
      }
    }
  });
  console.log();
  $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
  $('.dataTables_length select').addClass('form-control');
}
