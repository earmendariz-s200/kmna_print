var tabla = $('#tablaPlaca').DataTable(settingsTable);

function agregar() {
	$("#hdPlacasId").val(0);
	$("#txtClave").val("");
	$("#cbCliente").val("-1");
	$("#cbEstado").val("-1");
	$("#txtCosto").val("0");
	$("#txtTintas").val("0");
	$("#txtDescripcion").val("");
	$("#ckActivo").attr('checked', true);
	$("#modalPlaca").modal("show");
}

cargar_datos();

function get_clientes() {
	var data = { prospecto: "0,1" };
	var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/get_clientes.php", data);
	if(response[0].RESULT) {
		$("#cbCliente").append("<option value='-1' selected>[Seleccione Cliente]</option>");
		for(var i = 0; i < response[0].DATA.length; i++) {
			var item = response[0].DATA[i];
			$("#cbCliente").append("<option value='"+item.CLI_IDINTRN+"'>"+item.CLI_NMCR+"</option>");
		}
	}
	else {
		toastError(response[0].MESSAGE, 'Info', 3);
	}
}

function cargar_datos() {
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getplacas.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var id = utf8_to_b64(items[i].PLC_CLI_IDINTRN);
					var link_edicion = "../../clientes/registro/cliente.php?v="+id;

					var costo = formatMoney(Number(items[i].PLC_COSTO));
					var activo = ((items[i].PLC_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					var estado = ((items[i].PLC_ESTADO == 1) ? ("EXCELENTE") : ("DAÑADA"));
					tabla.row.add([
						items[i].PLC_CLAVE,
						"<a href='"+link_edicion+"'>"+items[i].CLI_NMCR+"</a>", 
						estado,
						items[i].PLC_DSCRPCN,
						costo,
						items[i].PLC_TNTS,
						activo,
						"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editar("+items[i].PLC_IDINTRN+")'><i class='fa fa-edit'></i></a>"
					]).draw();
				}
			} else {
				toastError(response[0].MESSAGE, 'Info', 3);
			}
			get_clientes();
		},
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
}

function editar(ID) {
	$("#hdPlacasId").val(ID);
	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getplacaxid.php",
		dataType: "json",
		data: { ID: ID },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.PLC_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				$("#txtClave").val(item.PLC_CLAVE);
				$("#cbCliente").val(item.PLC_CLI_IDINTRN);
				$("#cbEstado").val(item.PLC_ESTADO);
				$("#txtDescripcion").val(item.PLC_DSCRPCN);
				$("#txtCosto").val(item.PLC_COSTO);
				$("#txtTintas").val(item.PLC_TNTS);
				$("#modalPlaca").modal("show");
			} else {
				toastError(response[0].MESSAGE, 'Info', 3);
			}
		},
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
}

$("#btnGuadar").click(function() {
	if($("#txtClave").val() == "" || $("#txtCosto").val() == "" || $("#txtTintas").val() == "" || $("#cbEstado").val() == "-1" || $("#cbCliente").val() == "-1") {
		toastError('Es necesario capturar los datos de la placa', 'Problema', 3);
	}
	else if($("#txtCosto").val() < 0 || $("#txtTintas").val() < 0 ) {
		toastError('El costo y/o el número de tintas no puede ser menor a 0', 'Problema', 3);
	}
	else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var URL = (($("#hdPlacasId").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/guardarplaca.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/editarplaca.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: {
				CLAVE: $("#txtClave").val(),
				ID: $("#hdPlacasId").val(),
				IDCLIENTE: $("#cbCliente").val(),
				ESTADO: $("#cbEstado").val(),
				DESCRIPCION: $("#txtDescripcion").val(),
				COSTO: $("#txtCosto").val(),
				TINTAS:$("#txtTintas").val(),
				ACTIVO: ACTIVO
			},
			success: function(response) {
				if(response[0].RESULT) {
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalPlaca").modal("hide");
					cargar_datos();
				}
				else {
					toastError(response[0].MESSAGE, 'Error', 3);
				}
			},
			error: function(error){
				toastError(error.responseText, 'Error', 3);
			}
		});
	}
});

function utf8_to_b64( str ) {
  return window.btoa(unescape(encodeURIComponent( str )));
}

function formatMoney(number) {
	return number.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
}

