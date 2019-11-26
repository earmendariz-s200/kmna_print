var tabla = $('#tablaRoles').DataTable(settingsTable);

cargar_datos();

function cargar_datos(){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/getroles.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].RLS_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					tabla.row.add([ 
				  					items[i].RLS_CLV, 
				  					items[i].RLS_NMBR, 
				  					activo, 
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editarRol("+items[i].RLS_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
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


function agregarRol(){
	$("#hdRolesId").val(0);
	$("#modalRoles").modal("show");
	$("#txtClaveRol").val("");
	$("#txtNombreRol").val("");
	$("#ckActivo").attr('checked', true)
}

function editarRol(ID_ROL){
	$("#hdRolesId").val(ID_ROL);
	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/getrolexid.php",
		dataType: "json",
		data: { ID_ROL: ID_ROL },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.RLS_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				$("#txtClaveRol").val(item.RLS_CLV);
				$("#txtNombreRol").val(item.RLS_NMBR);
				$("#modalRoles").modal("show");
			} else {
				toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
}

$("#btnGuadarRol").click(function(){
	if($("#txtClaveRol").val() == "" || $("#txtNombreRol").val() == ""){
		toastError('Es necesario capturar los datos del Rol', 'Problema', 3);
	} else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var URL = (($("#hdRolesId").val()== 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/guardarrol.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/editarrol.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: { 
					CLAVE: $("#txtClaveRol").val(), 
					NOMBRE: $("#txtNombreRol").val(), 
					ID_ROL: $("#hdRolesId").val(),
					ACTIVO: ACTIVO 
				},
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalRoles").modal("hide");
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

