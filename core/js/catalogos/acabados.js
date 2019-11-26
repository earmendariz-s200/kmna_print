var tabla = $('#tablaAcabados').DataTable(settingsTable);

function agregar(){
	$("#hdAcabadoId").val(0);
	$("#modalAcabado").modal("show");
	$("#txtNombreAcabado").val("");
	$("#ckActivo").attr('checked', true)
}


cargar_datos();

function cargar_datos(){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getacabados.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].ACB_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					tabla.row.add([ 
				  					items[i].ACB_NMBR, 
				  					activo, 
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editar("+items[i].ACB_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
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


function editar(ID){
	$("#hdAcabadoId").val(ID);
	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getacabadosxid.php",
		dataType: "json",
		data: { ID: ID },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.ACB_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				$("#txtNombreAcabado").val(item.ACB_NMBR);
				$("#modalAcabado").modal("show");
			} else {
				toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
}


$("#btnGuadar").click(function(){
	if($("#txtNombreAcabado").val() == "" ){
		toastError('Es necesario capturar los datos del Acabado', 'Problema', 3);
	} else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var URL = (($("#hdAcabadoId").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/guardaracabado.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/editaracabado.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: {  
					NOMBRE: $("#txtNombreAcabado").val(), 
					ID_ACABADO: $("#hdAcabadoId").val(),
					ACTIVO: ACTIVO 
				},
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalAcabado").modal("hide");
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
