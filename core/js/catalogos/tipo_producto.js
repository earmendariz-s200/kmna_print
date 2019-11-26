var tabla = $('#tablaTipoProducto').DataTable(settingsTable);

function agregar(){
	$("#hdTipoId").val(0);
	$("#modalTipoProducto").modal("show");
	$("#txtNombreTipo").val("");
	$("#txtDescripcion").val("");
	$("#ckActivo").attr('checked', true)
}


cargar_datos();

function cargar_datos(){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/gettipoproductos.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].TPR_ACTV == "1") ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					var diseno = ((items[i].TPR_TPDSN == "1") ? ('<span class="badge badge-default badge-info m-0">Con Diseño</span>') : ('<span class="badge badge-default badge-warning m-0">Paginado</span>'));
					var tipo_trabajo = "";
					if(items[i].TPR_TPTRBJ == 1){
						tipo_trabajo = "EDITORIAL";
					} else if(items[i].TPR_TPTRBJ == 2) {
						tipo_trabajo = "FISCAL O TALONARIO";
					} else {
						tipo_trabajo = "COMERCIAL";
					}


					tabla.row.add([
				  					items[i].TPR_NMBR,
				  					tipo_trabajo,
				  					diseno,
				  					activo,
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editar("+items[i].TPR_IDINTRN+")'><i class='fa fa-edit'></i></a>"
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
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/gettipoproductoxid.php",
		dataType: "json",
		data: { ID: ID },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.TPR_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				$("#txtNombreTipo").val(item.TPR_NMBR);
				$("#cbTipoTrabajo").val(item.TPR_TPTRBJ);
				$("#txtTipoDiseño").val(item.TPR_TPDSN);
				$("#modalTipoProducto").modal("show");
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
		toastError('Es necesario capturar los datos del Tipo de Producto', 'Problema', 3);
	} else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var URL = (($("#hdTipoId").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/guardartipoproducto.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/editartipoproducto.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: {
					NOMBRE: $("#txtNombreTipo").val(),
					ID_TIPO: $("#hdTipoId").val(),
					TIPO_TRABAJO: $("#cbTipoTrabajo").val(),
					TIPO_DISENO: $("#txtTipoDiseño").val(),
					ACTIVO: ACTIVO
				},
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalTipoProducto").modal("hide");
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
