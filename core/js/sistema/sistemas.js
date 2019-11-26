var tabla = $('#tablaSistemas').DataTable(settingsTable);

cargar_datos();

function cargar_datos(){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/getsistemas.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].SIS_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					tabla.row.add([ 
				  					items[i].SIS_CLV, 
				  					items[i].SIS_NMBR,
				  					items[i].SIS_URL, 
				  					activo, 
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editarSistema("+items[i].SIS_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
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


function agregarSistema(){
	$("#hdSitemaId").val(0);
	$("#modalSistemas").modal("show");
	$("#txtClaveSistema").val("");
	$("#txtNombreSistema").val("");
	$("#txtUrlSistema").val("");
	$("#ckActivo").attr('checked', true)
}

function editarSistema(ID_SISTEMA){
	$("#hdSitemaId").val(ID_SISTEMA);
	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/getsistemaxid.php",
		dataType: "json",
		data: { ID_SISTEMA: ID_SISTEMA },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.SIS_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				$("#txtClaveSistema").val(item.SIS_CLV);
				$("#txtNombreSistema").val(item.SIS_NMBR);
				$("#txtUrlSistema").val(item.SIS_URL);
				$("#modalSistemas").modal("show");
			} else {
				toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
}

$("#btnGuadarSistema").click(function(){
	if($("#txtClaveSistema").val() == "" || $("#txtNombreSistema").val() == "" || $("#txtUrlSistema").val() == ""){
		toastError('Es necesario capturar los datos del Sistema', 'Problema', 3);
	} else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var URL = (($("#hdSitemaId").val()== 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/guardarsistema.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/editarsistema.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: { 
					CLAVE: $("#txtClaveSistema").val(), 
					NOMBRE: $("#txtNombreSistema").val(), 
					ID_SISTEMA: $("#hdSitemaId").val(),
					URL_SISTEMA: $("#txtUrlSistema").val(),
					ACTIVO: ACTIVO 
				},
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalSistemas").modal("hide");
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

