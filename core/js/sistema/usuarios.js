var tabla = $('#tablaUsuarios').DataTable(settingsTable);

cargar_datos();

function cargar_datos(){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/getusuarios.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].USR_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					tabla.row.add([ 
				  					items[i].USR_CLV, 
				  					items[i].USR_NMBR+" "+items[i].USR_APLLDPTRN+" "+items[i].USR_APLLDMTRN, 
				  					items[i].RLS_NMBR, 
				  					activo, 
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editarUsuario("+items[i].USR_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
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


function agregarUsuario(){
	$("#hdUsuarioId").val(0);
	$("#modalUsuarios").modal("show");
	$("#txtClaveUsuario").val("");
	$("#txtPasswordUsuario").val("");
	$("#txtNombreUsuario").val("");
	$("#txtApellidoPUsuario").val("");
	$("#txtApellidoMUsuario").val("");
	$("#cbRol").val(0);
	$("#ckActivo").attr('checked', true);
	$("#ckPrivilegios").attr('checked', false);

	
}

function editarUsuario(ID_USUARIO){
	$("#hdUsuarioId").val(ID_USUARIO);
	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/getusuarioxid.php",
		dataType: "json",
		data: { ID_USUARIO: ID_USUARIO },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.USR_ACTV == "1") ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				((item.USR_PRVLGS == "1") ? $("#ckPrivilegios").attr('checked', true) : $("#ckPrivilegios").attr('checked', false) );


				$("#txtClaveUsuario").val(item.USR_CLV);
				$("#txtPasswordUsuario").val(response[0].PSSWRD);
				$("#txtNombreUsuario").val(item.USR_NMBR);
				$("#txtApellidoPUsuario").val(item.USR_APLLDPTRN);
				$("#txtApellidoMUsuario").val(item.USR_APLLDMTRN);
				$("#cbRol").val(item.ROLES_RLS_IDINTRN);
				$("#modalUsuarios").modal("show");
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
	if($("#txtClaveUsuario").val() == "" || $("#txtPasswordUsuario").val() == "" || $("#txtNombreUsuario").val() == "" || $("#txtApellidoPUsuario").val() == "" || $("#cbRol").val() == ""){
		toastError('Es necesario capturar los datos del Usuario', 'Problema', 3);
	} else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var PRIVILEGIOS = ($("#ckPrivilegios").is(':checked') ? 1: 0);
		var URL = (($("#hdUsuarioId").val()== 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/guardarusuario.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/editarusuario.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: { 
					CLAVE: $("#txtClaveUsuario").val(), 
					PASSWORD: $("#txtPasswordUsuario").val(),
					NOMBRE: $("#txtNombreUsuario").val(), 
					PATERNO: $("#txtApellidoPUsuario").val(), 
					MATERNO: $("#txtApellidoMUsuario").val(), 
					ID_USUARIO: $("#hdUsuarioId").val(),
					ID_ROL: $("#cbRol").val(),
					PRIVILEGIOS : PRIVILEGIOS,
					ACTIVO: ACTIVO 
				},
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalUsuarios").modal("hide");
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

