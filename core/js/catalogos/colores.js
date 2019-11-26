var tabla = $('#tablaColores').DataTable(settingsTable);

function agregar(){
	$("#hdColoresId").val(0);
	$("#modalColores").modal("show");
	$("#txtNombre").val("");
	$("#ckActivo").attr('checked', true)
}


cargar_datos();

function cargar_datos(){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/get_colores.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].COL_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					tabla.row.add([
				  					items[i].COL_NMBR,
										items[i].COL_VLR,
				  					activo,
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editar("+items[i].COL_IDINTR+")'><i class='fa fa-edit'></i></a>"
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
	$("#hdColoresId").val(ID);
	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/get_colores_xid.php",
		dataType: "json",
		data: { ID: ID },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.COL_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				$("#txtNombre").val(item.COL_NMBR);
				$("#txtValor").val(item.COL_VLR);
				$("#modalColores").modal("show");
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
	if($("#txtNombre").val() == ""){
		toastError('Es necesario capturar el nombre del color', 'Problema', 3);
	} else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var URL = (($("#hdColoresId").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/guarda_colores.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/editar_colores.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: {
					NOMBRE: $("#txtNombre").val(),
					VALOR: $("#txtValor").val(),
					ID: $("#hdColoresId").val(),
					ACTIVO: ACTIVO
				},
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalColores").modal("hide");
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
