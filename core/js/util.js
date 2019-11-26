// TODO : Cambiar directorio
DIR_LOCAL_JS = "/carmona";
// VARIABLE PARA FACTURACION TRUE = PRUEBA
var DEBUG = true;

function toastError(mensaje, titulo, tiempo){
	toastr.error(mensaje, titulo, { "showMethod": "slideDown", "hideMethod": "slideUp",  timeOut: (tiempo*1000) });
}

function toastExito(mensaje, titulo, tiempo){
	toastr.success(mensaje, titulo, { "showMethod": "slideDown", "hideMethod": "slideUp",  timeOut: (tiempo*1000) });
}

function toastAdvertencia(mensaje, titulo, tiempo){
  toastr.warning(mensaje, titulo, { "showMethod": "slideDown", "hideMethod": "slideUp",  timeOut: (tiempo*1000) });
}

function toastInfo(mensaje, titulo, tiempo){
	toastr.info(mensaje, titulo, { "showMethod": "slideDown", "hideMethod": "slideUp",  timeOut: (tiempo*1000) });
}

var settingsTable = {
 "responsive": true,
 "destroy": true,
 "psgingType": "full_numbers",
 "scrollCollapse": true,
 "aoColumnDefs": [{
  'bSortable': false,
  'aTargets': [0]
}],
"order": [
[0, "asc"]
],
"language": {
  "decimal":        "",
  "emptyTable":     "No hay datos disponibles para mostrar",
  "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
  "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
  "infoFiltered":   "(filtrado de _MAX_ registros)",
  "infoPostFix":    "",
  "thousands":      ",",
  "lengthMenu":     "Mostrar _MENU_ registros",
  "loadingRecords": "Cargando...",
  "processing":     "Procesando...",
  "search":         "Buscar: ",
  "zeroRecords":    "NO hay resultados de busqueda",
  "paginate": {
    "first":      "Primero",
    "last":       "Último",
    "next":       "Siguiente",
    "previous":   "Anterior"
  },
  "aria": {
    "sortAscending":  ": activate to sort column ascending",
    "sortDescending": ": activate to sort column descending"
  }
}
};


var settingsTable_desc = {
 "responsive": true,
 "destroy": true,
 "psgingType": "full_numbers",
 "scrollCollapse": true,
 "aoColumnDefs": [{
  'bSortable': false,
  'aTargets': [0]
}],
"order": [
[0, "desc"]
],
"language": {
  "decimal":        "",
  "emptyTable":     "No hay datos disponibles para mostrar",
  "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
  "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
  "infoFiltered":   "(filtrado de _MAX_ registros)",
  "infoPostFix":    "",
  "thousands":      ",",
  "lengthMenu":     "Mostrar _MENU_ registros",
  "loadingRecords": "Cargando...",
  "processing":     "Procesando...",
  "search":         "Buscar: ",
  "zeroRecords":    "NO hay resultados de busqueda",
  "paginate": {
    "first":      "Primero",
    "last":       "Último",
    "next":       "Siguiente",
    "previous":   "Anterior"
  },
  "aria": {
    "sortAscending":  ": activate to sort column ascending",
    "sortDescending": ": activate to sort column descending"
  }
}
};


function sendRequest(path_file_php, send_data){
	$.blockUI({ message: "Cargando..." } );
  var response;
  $.ajax({
    type: "POST",
    url: path_file_php,
    dataType: "json",
    data: send_data,
		async: false,
    success: function(r){
      response = r;
			setTimeout(function(){ $.unblockUI(); }, 1000);
    },
    error: function(e){
      toastError(e, "ERROR REQUEST", 5);
			setTimeout(function(){ $.unblockUI(); }, 1000);
    }
  });
  return response;
}
