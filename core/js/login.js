$("#form-login").submit(function(){
	if($("#tex-usuario").val() == "" || $("#tex-password").val() == ""){
		toastError('Los datos de acceso son requerido. Verifique por favor.', 'Acceso incorrecto', 3);
	} else {
		$.ajax({
			type: "POST",
			url: window.location.origin+DIR_LOCAL_JS+"/core/ph/acceso/login.php",
			dataType: "json",
			data: { USUARIO: $("#tex-usuario").val(), PASSWORD: $("#tex-password").val() },
			success: function(response){
				if(response[0].RESULT){
					toastExito('Bienvenid@ a SISTEMA CARMONA', 'Acceso correcto', 3);
					setTimeout(function(){window.location = "vws/pimprenta/dash/";}, 3500);
				} else {
					toastError(response[0].MESSAGE, 'Acceso incorrecto', 3);
				}
			}, 
			error: function(error){
				toastError(error.responseText, 'Acceso incorrecto', 3);
			}
		});
	}
	return false;
});