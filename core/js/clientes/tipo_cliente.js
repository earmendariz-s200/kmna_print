var tabla = $('#tablaTipoClientes').DataTable(settingsTable);

function agregar(){
	$("#hdTipoId").val(0);
	$("#modalTipoCliente").modal("show");
	$("#txtNombreTipo").val("");
	$("#txtDescripcion").val("");
	$("#ckActivo").attr('checked', true)
}


cargar_datos();

function cargar_datos(){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/gettipoclientes.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].TIC_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					tabla.row.add([ 
				  					items[i].TIC_NMBR, 
				  					items[i].TIC_DSCRPCN,
				  					activo, 
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editar("+items[i].TIC_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
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
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/gettipoclientexid.php",
		dataType: "json",
		data: { ID: ID },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.TIC_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				$("#txtNombreTipo").val(item.TIC_NMBR);
				$("#txtDescripcion").val(item.TIC_DSCRPCN);
				$("#modalTipoCliente").modal("show");
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
