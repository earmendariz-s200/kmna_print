var tabla = $('#tablaMaquina').DataTable(settingsTable);

function agregar(){
	$("#hdMaquinasId").val(0);
	$("#txtNombre").val("");
	$("#txtCostoLamina").val("0");
	$("#txtCostoMillar").val("0");
	$("#ckActivo").attr('checked', true)
	$("#ckBarnizar").attr('checked', false)
	$("#txtTintas").val("0");
	$("#txtVelocidad").val("0");
	$("#txtAnchoMin").val("0");
	$("#txtAltoMin").val("0");
	$("#txtAnchoMax").val("0");
	$("#txtAltoMax").val("0");
	$("#txtTamanoPinza").val("0");
	$("#txtEspacioDesbaste").val("0");
	$("#txtEspacioLaterales").val("0");
	$("#txtEspacioCola").val("0");

	$("#modalMaquina").modal("show");

}

cargar_datos();

function cargar_datos(){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getmaquinas.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].MAQ_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					var barnizar = ((items[i].MAQ_BRNZR == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));

					tabla.row.add([
				  					items[i].MAQ_NMBR,
										items[i].MAQ_CSTLMN,
				  					items[i].MAQ_TNTS,
				  					barnizar,
				  					activo,
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editar("+items[i].MAQ_IDINTRN+")'><i class='fa fa-edit'></i></a>"
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

function get_tintas(){
	$("#cbTintas").html("");
	var data = { };
	var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/get_colores.php", data);
	if(response[0].RESULT){
		for(var i = 0; i < response[0].DATA.length; i++){
			var item = response[0].DATA[i];
			$("#cbTintas").append("<option value='"+item.COL_IDINTR+"'>"+item.COL_NMBR+"</option>");
		}
	} else {
		toastError(response[0].MESSAGE, 'Info', 3);
	}

}


function editar(ID){
	$("#hdMaquinasId").val(ID);
	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/gettmaquinaxid.php",
		dataType: "json",
		data: { ID: ID },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.MAQ_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				((item.MAQ_BRNZR == 1) ? $("#ckBarnizar").attr('checked', true) : $("#ckBarnizar").attr('checked', false) );

				$("#txtNombre").val(item.MAQ_NMBR);
				$("#txtCostoLamina").val(item.MAQ_CSTLMN);
				$("#txtCostoMillar").val(item.MAQ_CSTMLLR);
				$("#txtTintas").val(item.MAQ_TNTS);
				$("#txtVelocidad").val(item.MAQ_VLCDD);
				$("#txtAnchoMin").val(item.MAQ_MNANCH);
				$("#txtAltoMin").val(item.MAQ_MNALT);
				$("#txtAnchoMax").val(item.MAQ_MXANCH);
				$("#txtAltoMax").val(item.MAQ_MXALT);
				$("#txtTamanoPinza").val(item.MAQ_PNZ);
				$("#txtEspacioDesbaste").val(item.MAQ_ESPCDSCST);
				$("#txtEspacioLaterales").val(item.MAQ_ESPCLTRL);
				$("#txtEspacioCola").val(item.MAQ_ESPCCL);

				$("#modalMaquina").modal("show");
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
	if($("#txtNombre").val() == "" || $("#txtDescripcion").val() == ""){
		toastError('Es necesario capturar los datos de la maquina', 'Problema', 3);
	} else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var BARNIZAR = ($("#ckBarnizar").is(':checked') ? 1: 0);
		var URL = (($("#hdMaquinasId").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/guardarmaquina.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/editarmaquina.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: {
					ID: $("#hdMaquinasId").val(),
					NOMBRE: $("#txtNombre").val(),
					COSTO_LAMINA: $("#txtCostoLamina").val(),
					COSTO_MILLAR: $("#txtCostoMillar").val(),
					BARNIZAR: BARNIZAR,
					ACTIVO: ACTIVO,
					TINTAS: $("#txtTintas").val(),
					VELOCIDAD: $("#txtVelocidad").val(),
					ANCHO_MINIMO: $("#txtAnchoMin").val(),
					ALTO_MINIMO: $("#txtAltoMin").val(),
					ANCHO_MAXIMO: $("#txtAnchoMax").val(),
					ALTO_MAXIMO: $("#txtAltoMax").val(),
					TAMANO_PINZA: $("#txtTamanoPinza").val(),
					ESPACIO_DESBASTE: $("#txtEspacioDesbaste").val(),
					ESPACIO_LATERALES: $("#txtEspacioLaterales").val(),
					ESPACIO_COLA: $("#txtEspacioCola").val()
				},
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalMaquina").modal("hide");
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
