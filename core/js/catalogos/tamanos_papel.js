var tabla = $('#tablaTamanos').DataTable(settingsTable);

function agregar(){
	$("#hdId").val(0);
	$("#modalTamanos").modal("show");
	$("#txtNombre").val("");
	$("#txtAncho").val("");
	$("#txtAlto").val("");
	$("#ckActivo").attr('checked', true)
}


cargar_datos();

function cargar_datos(){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/gettamanospapel.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].MEP_ACTV == "1") ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					tabla.row.add([
				  					items[i].MEP_NMBR,
				  					items[i].ANCHO+" x "+items[i].ALTO,
				  					items[i].COLUMNAS,
										items[i].FILAS,
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editar("+items[i].MEP_IDINTRN+")'><i class='fa fa-edit'></i></a>"
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
	$("#hdId").val(ID);
	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/gettamanospapelxid.php",
		dataType: "json",
		data: { ID: ID },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.MEP_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				$("#txtNombre").val(item.MEP_NMBR);
				$("#txtAncho").val(item.MEP_ANCH);
				$("#txtAlto").val(item.MEP_ALT);
				$("#txtFormacionBase").val(item.MEP_FORMACION_BASE);
				$("#txtFormacionAlto").val(item.MEP_FORMACION_ALTO);
				$("#modalTamanos").modal("show");
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
	if($("#txtNombre").val() == "" || $("#txtAncho").val() == "" || $("#txtAlto").val() == ""){
		toastError('Es necesario capturar los datos del Tamaño de papel', 'Problema', 3);
	} else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var URL = (($("#hdId").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/guardartamanopapel.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/editartamanopapel.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: {
					NOMBRE: $("#txtNombre").val(),
					ANCHO: $("#txtAncho").val(),
					ALTO: $("#txtAlto").val(),
					FORMACION_BASE: $("#txtFormacionBase").val(),
					FORMACION_ALTO: $("#txtFormacionAlto").val(),
					ACTIVO: ACTIVO,
					ID: $("#hdId").val()
				},
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalTamanos").modal("hide");
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
