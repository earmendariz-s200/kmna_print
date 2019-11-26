console.log("Inventario");

var tabla = $('#tablaListado').DataTable(settingsTable);

cargar_datos();

function cargar_datos(){
	tabla.clear().draw();
	var data = { };
	  var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/almacen/inventario/get_inventario.php", data);

	if(response[0].RESULT){
		var items = response[0].DATA;
		for (var i = 0 ; i < items.length ; i++) {
			 
			tabla.row.add([ 
		  					items[i].TPA_NMBR, 
		  					items[i].TIPO_MATERIAL,
		  					items[i].MAT_STCK
		  				]).draw();
		}
	} else {
		toastError(response[0].MESSAGE, 'Info', 3);
	}
}
