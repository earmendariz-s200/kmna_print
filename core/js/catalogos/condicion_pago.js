var tabla = $('#tablaCondiciones').DataTable(settingsTable);


function agregar(){
	$("#hdId").val(0);
	$("#modalCondicion").modal("show");
	$("#txtNombre").val("");
	$("#txtDescripcion").val("");
	$("#ckActivo").attr('checked', true)
}



cargar_datos();

function cargar_datos(){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getcondiciones.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].CPA_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					tabla.row.add([ 
				  					items[i].CPA_NMBR,
				  					items[i].CPA_DSCRPCN, 
				  					activo, 
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editar("+items[i].CPA_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
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
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getcondicionxid.php",
		dataType: "json",
		data: { ID: ID },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.CPA_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				$("#txtNombre").val(item.CPA_NMBR);
				$("#txtDescripcion").val(item.CPA_DSCRPCN);
				$("#modalCondicion").modal("show");
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
	if($("#txtNombre").val() == "" ){
		toastError('Es necesario capturar los datos de la Condición', 'Problema', 3);
	} else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var URL = (($("#hdId").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/guardarcondicion.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/editarcondicion.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: {  
					NOMBRE: $("#txtNombre").val(), 
					DESCRIPCION: $("#txtDescripcion").val(), 
					ID: $("#hdId").val(),
					ACTIVO: ACTIVO 
				},
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalCondicion").modal("hide");
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