var tabla = $('#tablaFormaContacto').DataTable(settingsTable);

function agregar(){
	$("#hdTipoId").val(0);
	$("#modalFormaContacto").modal("show");
	$("#txtNombreTipo").val(""); 
	$("#ckActivo").attr('checked', true)
}


cargar_datos();

function cargar_datos(){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/getFormaContacto.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].FRC_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					tabla.row.add([ 
				  					items[i].FRC_NMBR,  
				  					activo, 
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editar("+items[i].FRC_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
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
	$("#hdTipoId").val(ID);
	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/getFormaContactoxID.php",
		dataType: "json",
		data: { ID: ID },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.FRC_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				$("#txtNombreTipo").val(item.FRC_NMBR);
				$("#modalFormaContacto").modal("show");
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
	if($("#txtNombreTipo").val() == ""){
		toastError('Es necesario capturar los datos del Forma de contacto', 'Problema', 3);
	} else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var URL = (($("#hdTipoId").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/guardarFormaContacto.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/editarFormaContacto.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: {  
					NOMBRE: $("#txtNombreTipo").val(), 
					ID_TIPO: $("#hdTipoId").val(),
					ACTIVO: ACTIVO 
				},
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalFormaContacto").modal("hide");
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
