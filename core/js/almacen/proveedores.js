var tabla = $('#tablaProveedores').DataTable(settingsTable);

cargar_datos();

function agregar(){

	$("#txtRFC").val("");
	$("#txtRazonSocial").val("");
	$("#txtCalle").val("");
	$("#txtNumExterior").val("");
	$("#txtNumInterior").val("");
	$("#txtCP").val("");
	$("#hdId").val(0);
	$("#modalProveedor").modal("show");
}

function cargar_datos(){
	tabla.clear().draw();
	var data = { };
	var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/almacen/proveedores/getproveedores.php", data);

	if(response[0].RESULT){
		var items = response[0].DATA;
		for (var i = 0 ; i < items.length ; i++) {
			var activo = ((items[i].PRV_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
			tabla.row.add([ 
		  					items[i].PRV_RFC, 
		  					items[i].PRV_RZNSCL,
		  					activo, 
		  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editar("+items[i].PRV_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
		  				]).draw();
		}
	} else {
		toastError(response[0].MESSAGE, 'Info', 3);
	}
}


function editar(ID){
	$("#hdId").val(ID);
	var data = { ID: ID };
	var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/almacen/proveedores/getproveedorxid.php", data);
	if(response[0].RESULT){
		var item = response[0].DATA;
		((item.PRV_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
		$("#txtRFC").val(item.PRV_RFC);
		$("#txtRazonSocial").val(item.PRV_RZNSCL);
		$("#txtCalle").val(item.PRV_CLL);
		$("#txtNumExterior").val(item.PRV_NMREXTRN);
		$("#txtNumInterior").val(item.PRV_NMRINTRN);
		$("#txtCP").val(item.PRV_CDGPSTL);
		$("#modalProveedor").modal("show");
	} else {
		toastError(response[0].MESSAGE, 'Info', 3);
	}
}

$("#btnGuadar").click(function(){
	if($("#txtRFC").val() == "" || $("#txtRazonSocial").val() == ""){
		toastError('Es necesario capturar los datos del proveedor', 'Problema', 3);
	} else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var URL = (($("#hdId").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/almacen/proveedores/guardarproveedor.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/almacen/proveedores/editarproveedor.php"));
		var data = { 
			PRV_RFC:$("#txtRFC").val()
			,PRV_RZNSCL:$("#txtRazonSocial").val()
			,PRV_CLL:$("#txtCalle").val()
			,PRV_NMREXTRN:$("#txtNumExterior").val()
			,PRV_NMRINTRN:$("#txtNumInterior").val()
			,PRV_CDGPSTL:$("#txtCP").val()
			,ACTIVO:ACTIVO
			,ID_PROVEEDOR:$("#hdId").val() 

		};
		var response = sendRequest(URL, data);
		if(response[0].RESULT){
			toastExito("Datos guardados correctamente.", 'Éxito', 3);
			$("#modalProveedor").modal("hide");
			cargar_datos();
		} else {
			toastError(response[0].MESSAGE, 'Error', 3);
		}
	}
});


