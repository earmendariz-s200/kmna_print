var tabla = $('#tablaModulos').DataTable(settingsTable);

cargar_datos();

function cargar_datos(){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/getmodulos.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].MDL_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					tabla.row.add([ 
				  					items[i].MDL_CLV, 
				  					items[i].MDL_NMBR, 
				  					items[i].MDL_URL, 
				  					items[i].SIS_NMBR, 
				  					activo, 
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editarModulo("+items[i].MDL_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
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

$('#modalModulos').on('show.bs.modal', function () {
	$('.icp-auto').iconpicker();
 });

function agregarModulo(){
	$("#hdModuloId").val(0);
	$("#modalModulos").modal("show");
	$("#txtClaveModulo").val("");
	$("#txtNombreModulo").val("");
	$("#txtIcono").val("");
	$("#txtURLModulo").val("");
	$("#cbSistemas").val(0);
	$("#ckActivo").attr('checked', true)
}

function editarModulo(ID_MODULO){
	$("#hdModuloId").val(ID_MODULO);
	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/getmoduloxid.php",
		dataType: "json",
		data: { ID_MODULO: ID_MODULO },
		success: function(response){
		    console.log(response);
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.MDL_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				$("#txtClaveModulo").val(item.MDL_CLV);
				$("#txtNombreModulo").val(item.MDL_NMBR);
				$("#txtURLModulo").val(item.MDL_URL);
				$("#txtIcono").val(item.MDL_ICN);
				$("#cbSistemas").val(item.SISTEMAS_SIS_IDINTRN);
				$("#modalModulos").modal("show");
			} else {
				toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
}

$("#btnGuadarModulo").click(function(){
	if($("#txtClaveModulo").val() == "" || $("#txtNombreModulo").val() == "" || $("#txtURLModulo").val() == "" || $("#cbSistemas").val() == "0"){
		toastError('Es necesario capturar los datos del Modulo', 'Problema', 3);
	} else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var URL = (($("#hdModuloId").val()== 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/guardarmodulo.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/editarmodulo.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: { 
					CLAVE: $("#txtClaveModulo").val(), 
					NOMBRE: $("#txtNombreModulo").val(), 
					ID_MODULO: $("#hdModuloId").val(),
					URL_MODULO: $("#txtURLModulo").val(),
					ICON: $("#txtIcono").val(),
					ID_SISTEMA: $("#cbSistemas").val(),
					ACTIVO: ACTIVO 
				},
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalModulos").modal("hide");
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

