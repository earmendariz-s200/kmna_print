
var STATUS200 = function() {

var tabla = $('#tablaClientes').DataTable(settingsTable);

cargar_listado();

 
function cargar_listado(){

 
	tabla.destroy(); 
  		// 1 - facturada 
  		// 2 - pagada
  		// 3 - pendiende de c
  		// 4 - cancelada
	   	var data = {estatus: 4};
		var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/get_listado.php", data);
		if(response[0].RESULT){

				var items = response[0].DATA;

				$('#tablaListado').DataTable(
					{ 	
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
						  }},
				        data: items,
				        destroy: true,
				        columns: [
				            { title: "Folio" },
				            { title: "Total" },
				            { title: "Cotización" },
				            { title: "Fecha" },
				            { title: "Cliente" },
				            { title: "PDF" },
				            { title: "XML" }, 
				            { title: "Opciones" } 
				        ]
				    });
 			

		} else {
			toastError(response[0].MESSAGE, 'Info', 3);
		}
  

	 
}


 }();