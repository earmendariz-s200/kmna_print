var tabla = $('#tablaProgramas').DataTable(settingsTable);

cargar_datos();

function cargar_datos(){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/getprogramas.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].PRG_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					tabla.row.add([ 
				  					items[i].PRG_CLV, 
				  					items[i].PRG_NMBR, 
				  					items[i].PRG_URL, 
				  					items[i].MDL_NMBR,
				  					items[i].SIS_NMBR, 
				  					activo, 
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editarPrograma("+items[i].PRG_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
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

$("#cbSistemas").change(function(){
	$("#cbModulos").html("");
	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/getmodulosxsistema.php",
		dataType: "json",
		data: { ID_SISTEMA: $("#cbSistemas").val() },
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				var options = '<option value="0">[Seleccione el modulos]</option>';
				for (var i = 0 ; i < items.length ; i++) {
					options += '<option value="'+items[i].MDL_IDINTRN+'">'+items[i].MDL_NMBR+'</option>';
				}
				$("#cbModulos").html(options);
			} else {
				toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
});



function agregarPrograma(){
	$("#hdProgramaId").val(0);
	$("#modalProgramas").modal("show");
	$("#txtClavePrograma").val("");
	$("#txtNombrePrograma").val("");
	$("#txtURLPrograma").val("");
	$("#cbModulos").val(0);
	$("#cbSistemas").val(0);
	$("#ckActivo").attr('checked', true)
}

function editarPrograma(ID_PROGRAMA){
	$("#hdProgramaId").val(ID_PROGRAMA);
	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/getprogramaxid.php",
		dataType: "json",
		data: { ID_PROGRAMA: ID_PROGRAMA },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.MDL_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				$("#txtClavePrograma").val(item.PRG_CLV);
				$("#txtNombrePrograma").val(item.PRG_NMBR);
				$("#txtURLPrograma").val(item.PRG_URL);
				$("#cbSistemas").val(item.SISTEMAS_SIS_IDINTRN);
				$("#cbSistemas").trigger("change");

				setTimeout(function(){ $("#cbModulos").val(item.MODULOS_MDL_IDINTRN); }, 1000);

				$("#modalProgramas").modal("show");
			} else {
				toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
}

$("#btnGuadarPrograma").click(function(){
	if($("#txtClavePrograma").val() == "" || $("#txtNombrePrograma").val() == "" || $("#txtURLPrograma").val() == "" || $("#cbModulos").val() == "0" || $("#cbSistemas").val() == "0"){
		toastError('Es necesario capturar los datos del Programa', 'Problema', 3);
	} else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var URL = (($("#hdProgramaId").val()== 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/guardarprograma.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/editarprograma.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: { 
					CLAVE: $("#txtClavePrograma").val(), 
					NOMBRE: $("#txtNombrePrograma").val(), 
					ID_PROGRAMA: $("#hdProgramaId").val(),
					URL_PROGRAMA: $("#txtURLPrograma").val(),
					ID_MODULO: $("#cbModulos").val(),
					ACTIVO: ACTIVO 
				},
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalProgramas").modal("hide");
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

