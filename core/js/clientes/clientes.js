var tabla = $('#tablaClientes').DataTable(settingsTable);

function agregar(){
	$("#hdTipoId").val(0);
	$("#modalTipoCliente").modal("show");
	$("#txtNombreTipo").val("");
	$("#txtDescripcion").val("");
	$("#ckActivo").attr('checked', true)
}


cargar_datos(0);

function cargar_datos(tipo){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/get_clientes.php",
		dataType: "json",
		type:"POST",
		data: {prospecto:tipo},
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].CLI_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					
				 
					var id = utf8_to_b64(items[i].CLI_IDINTRN);
					var link_edicion = "cliente.php?v="+id;

					tabla.row.add([ 
									items[i].CLI_IDINTRN,
				  					"<a href='"+link_edicion+"'   onclick='editar("+items[i].CLI_IDINTRN+")'> "+ items[i].CLI_NMCR+ "</a>", 
				  					items[i].CLI_RFC,
				  					items[i].TIPO_CLIENTE,
				  					activo, 
				  					"<a href='"+link_edicion+"' class='btn btn-outline-secondary mr-1'  ><i class='fa fa-edit'></i></a>" 
				  				]).draw();
				}
			} else {
				toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
}





function utf8_to_b64( str ) {
  return window.btoa(unescape(encodeURIComponent( str )));
}

function b64_to_utf8( str ) {
  return decodeURIComponent(escape(window.atob( str )));
}



$("#btnGuadar").click(function(){
	if($("#txtNombreTipo").val() == "" || $("#txtDescripcion").val() == ""){
		toastError('Es necesario capturar los datos del Tipo de Cliente', 'Problema', 3);
	} else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var URL = (($("#hdTipoId").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/guardartipocliente.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/editartipocliente.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: {  
					NOMBRE: $("#txtNombreTipo").val(), 
					ID_TIPO: $("#hdTipoId").val(),
					DESCRIPCION: $("#txtDescripcion").val(),
					ACTIVO: ACTIVO 
				},
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalTipoCliente").modal("hide");
					cargar_datos();
				} else {
					toastError(response[0].MESSAGE, 'Error', 3);
				}
			}, 
			error: function(error){
				toastError(error.responseText, 'Error', 3);
			}
		});
	}
});
