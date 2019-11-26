
var jsonpago;
var importeAnterior;
var importeTotalCotizacion;
var importeTotalPagos;
var emisorRFC;
var emisorRazon;
var emisorRegimen;
var receptorRFC;
var receptorRazon;
var docRelacionado;
var folioPago;



var STATUS200 = function() {

var tabla = $('#tablaClientes').DataTable(settingsTable);



cargar_listado();
get_forma_pago();
get_monedas();



	$("#btn_enviar_factura").click(function(){

		$.blockUI({
            message: '<h3>Enviando Factura...</h3>'
        });

		var email = $("#txtEmail").val();
		var emailcc = $("#txtEmailCC").val();
		var texto = $("#txtMensaje").val();
		var id_fac = $("#hd_factura_correo").val();

		var complemento = $("#hd_input_complemento").val();

		if (complemento > 0 ) {

			var data = {id_fac: id_fac,email:email,emailcc:emailcc,texto:texto};
			var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/EnviarPago.php", data);
			if(response == 1){ 
				
				$("#modalCorreo").modal("hide");	
				$.unblockUI(); 
				toastExito("Se envio satisfactoriamente el correo.", 'Éxito', 3);
				

			} else { 
				$("#modalCorreo").modal("hide");
				$.unblockUI();
				toastError(response[0].MESSAGE, 'Info', 3);
				
			}

		}else{

			var data = {id_fac: id_fac,email:email,emailcc:emailcc,texto:texto};
			var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/EnviarFactura.php", data);
			if(response == 1){ 
				$("#modalCorreo").modal("hide");	
				$.unblockUI(); 
				toastExito("Se envio satisfactoriamente el correo.", 'Éxito', 3);
				
			} else { 
				$("#modalCorreo").modal("hide");	
				$.unblockUI();
				toastError(response[0].MESSAGE, 'Info', 3);
				
			}

		}

		
		

	});



	$("#btn_complemento").click(function(){

		$("#modalNuevoComplemento").modal("hide");
		
		$.blockUI({
	        message: '<h3>Generando pago...</h3>'
	    });


		console.log(importeAnterior);
		console.log(importeTotalCotizacion);
		console.log(importeTotalPagos);

 
	    importeAnterior = importeTotalCotizacion - importeTotalPagos; 
	    jsonpago = {
	        "usuarioS200": emisorRFC, // emisorRFC
	        "sandbox": DEBUG, // false
	        "factura": { 
	            "tipoCFDI": "P", 
	            "FechaPagoP": $("#txtFechaPago").val()+"T"+$("#txtHoraPago").val(),
	            "FormaPagoP": $("#cbFormaPago").val(),
	            "lugarExpedicion": $("#txtCPExpedicionPago").val(),
	            "ImpPagado": parseFloat($("#txtImportePago").val()).toFixed(2),
	            "ImpSaldoAnt": parseFloat(importeAnterior).toFixed(2), 
	            "ImpSaldoInsoluto": parseFloat(importeAnterior -parseFloat($("#txtImportePago").val())).toFixed(2),
	            "Parcialidad": "1",
	            "MetodoPago": "PPD",
	            "monedaP": $("#cbMoneda").val(), 
	            "monedaDoc": "MXN", 
	            "serie": "", 
	            "folio": folioPago+"-P",
	            "emisorRFC": emisorRFC, 
	            "emisorRazon": emisorRazon, 
	            "emisorRegimen": "601", 
	            "receptorRFC": receptorRFC,  // receptorRFC
	            "receptorRazon": receptorRazon, 
	            "receptorUsoCFDI": "P01", 
	            "docRelacionado": docRelacionado 
	        }
	    }

	     $.ajax({
           type: "POST",
           url: "https://devlag.com/status200.mx/soluciones/FacturaS200/api/inc/index_33_pg.php",
           dataType: "json",
           data: { jsonDatos: JSON.stringify(jsonpago)},
           success: function(d) {
           		console.log(d);
           		if(d[0].RESULT){
           		    
           			$.unblockUI();
           			$.blockUI({
				        message: '<h3>Guardando...</h3>'
				    });


				    var url_pago =  window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/guardapago.php";
 
					$.ajax({
			           type: "POST",
			           url: url_pago,
			           dataType: "html",
			           data: {  FECHA: $("#txtFechaPago").val()+" "+$("#txtHoraPago").val(), 
			                    IMPORTE: parseFloat($("#txtImportePago").val()).toFixed(2), 
			                    UUID: d[0].UUID, 
			                    URLXML: d[0].XML, 
			                    URLPDF: d[0].PDF, 
			                    UUID_FACTURA: docRelacionado 
			           },
			           success: function(r) {
			           		console.log(r);
			           		$.unblockUI();
			           		toastExito("Se realizo el complemento correctamente.", 'Éxito', 3);
							
			           },
			           error: function(error) { console.log(error); }
			       });
                    	$.unblockUI();
           		} else {

					toastError(d[0].MESSAGE, 'Info', 3);
					$.unblockUI();

           		}
           		
           },
           error: function(error) {
           		console.log(error);
           		$.unblockUI();
           }
       });



	});



	 
	function cargar_listado(){

	 
		tabla.destroy(); 
	  		// 1 - facturada 
	  		// 2 - pagada
	  		// 3 - pendiende de c
	  		// 4 - cancelada
	  		// 
	  		var status = $("#hd_tipo").val();
		   	var data = {estatus: status};
			var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/get_listado.php", data);
			if(response[0].RESULT){

					var items = response[0].DATA;

					$('#tablaListado').DataTable(
						{ 	
							"language": { 
							  "decimal":        "",
							  "emptyTable":     "No hay datos disponibles para mostrar",
							  "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
							  "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
							  "infoFiltered":   "(filtrado de _MAX_ registros)",
							  "infoPostFix":    "",
							  "thousands":      ",",
							  "lengthMenu":     "Mostrar _MENU_ registros",
							  "loadingRecords": "Cargando...",
							  "processing":     "Procesando...",
							  "search":         "Buscar: ",
							  "zeroRecords":    "NO hay resultados de busqueda",
							  "paginate": {
							    "first":      "Primero",
							    "last":       "Último",
							    "next":       "Siguiente",
							    "previous":   "Anterior"
							  },
							  "aria": {
							    "sortAscending":  ": activate to sort column ascending",
							    "sortDescending": ": activate to sort column descending"
							  }},
					        data: items,
					        destroy: true,
					        columns: [
					            { title: "Folio" },
					            { title: "Total" },
					            { title: "Cotización" },
					            { title: "Fecha" },
					            { title: "Cliente" },
					            { title: "PDF" },
					            { title: "XML" }, 
					            { title: "Opciones" } 
					        ]
					    });
	 			

			} else {
				toastError(response[0].MESSAGE, 'Info', 3);
			}
	  

		 
	}
 
 




 }();



	function fnc_mod(arg,id) {

		switch(arg) {
		  case 0: 
		  		modal_correo(arg,id);
		    break;
		  case 1:  // desmarcar como pagada
		  		cambia_estatus(1,id);
		    break;
	 
		  case 2: // marcar como pagada
		  		cambia_estatus(2,id);
		    break;

		  case 4:  // cancelar factura
		  		cambia_estatus(4,id);
		    break;

		  case 5: // modal para complemento de pago
		  		modal_complemento(arg,id);
		    break;

		  case 6: // modal para ver complementos
		  		modal_ver_complemento(arg,id);
		    break;
		  default:
	     
		}
		
	}


	function modal_correo(status,id_fac){
		$("#hd_factura_correo").val(id_fac);
		 
		//si es 99 es para enviar correo para complementos de pago 
		if (status == 99) {
			$("#hd_input_complemento").val(1);
		}else{
			$("#hd_input_complemento").val(0);
		}

		$("#modalCorreo").modal("show");
	}

	function modal_complemento(status,id_fac){
		$("#hd_factura_complemento").val(id_fac);
		$("#modalNuevoComplemento").modal("show");

	 	var data = {id_fac: id_fac};
		var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/get_facturaUUID.php", data);
		if(response[0].RESULT){

			var item = response[0].DATA; 

			$("#txtCPExpedicionPago").val(item.codigo_postal);
			docRelacionado = item.UUID; 
	    	folioPago = item.folio; 

			importeTotalCotizacion =  parseFloat(item.total_factura).toFixed(2);
			importeTotalPagos = item.total_pagos;
			
			emisorRazon = item.razon_social;
			
			receptorRazon = item.CLI_RZNSCL;
			importeAnterior = importeTotalCotizacion - importeTotalPagos;
			$("#txtImportePago").val(importeAnterior);


			if(DEBUG){
	 			emisorRFC = "TCM970625MB1";
	 			receptorRFC = "XAXX010101000";
	 		} else {
	 			emisorRFC = item.rfc;
	 			receptorRFC = item.CLI_RFC;
	 		}


		}else{

		}

		 

	}





	function modal_ver_complemento(status,id_fac){
		$("#hd_listado_complementos").val(id_fac);
		$("#modalComplementos").modal("show");


		var data = {id_fac: id_fac};
		var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/get_pagos.php", data);
		if(response[0].RESULT){

			var items = response[0].DATA; 
			console.log(items);

			$("#tablaListaPagos tbody").html(items);

			 

		} else {
			toastError(response[0].MESSAGE, 'Info', 3);
		}

	}

	function cambia_estatus(status,id_fac){

		if (status == 4) {

			if(DEBUG){
            	emisorRFC = "ESI920427886";
	        } else {
	            emisorRFC = "-";
	        }

	        var jsonfactura = {
	            "emisorRFC": emisorRFC,
	            "sandbox": DEBUG,
	            "UUID": $("#hdFolioC").val()
	        }

	        $.ajax({
	           type: "POST",
	           url: "https://devlag.com/status200.mx/soluciones/FacturaS200/api/inc/cancel.php",
	           dataType: "json",
	           data: { jsonDatos: JSON.stringify(jsonfactura) },
	           success: function(RE) {

	            	var dato = RE[0].MESSAGE; 
  					var n = dato.includes("300");
  					console.log(RE);


  					if(RE[0].RESULT){ 

						var data = {id_fac: id_fac,estatus:status};
	            		var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/cambia_estatus.php", data);
	             		if(response[0].RESULT){
							if(response[0].RESULT){
							setTimeout( function(){
						 		location.reload();
							} , 3000);
							toastExito("Se cambio el estatus satisfactoriamente .", 'Éxito', 3);
						} else {
							toastError(response[0].MESSAGE, 'Info', 3);
						}
						} else {
							toastError(response[0].MESSAGE, 'Info', 3);
						}


					} else {
						toastError(RE[0].MESSAGE, 'Info', 3);
					}
 

	           },
	           error: function(error) { console.log(error); }
	        });


		}else{ 
	            	var data = {id_fac: id_fac,estatus:status};
	            	var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/cambia_estatus.php", data);
	             	if(response[0].RESULT){
						 
						if(response[0].RESULT){
							setTimeout( function(){
						 		location.reload();
							} , 3000);
							toastExito("Se cambio el estatus satisfactoriamente .", 'Éxito', 3);
						} else {
							toastError(response[0].MESSAGE, 'Info', 3);
						}

					} else {
						toastError(response[0].MESSAGE, 'Info', 3);
					}

		} 

	}


	function get_forma_pago(){
	  
		var data = { };
		var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/get_datos_formas_pago.php", data);
		if(response[0].RESULT){
	 
				var items = response[0].DATA; 
				var combohtml = "";
				for (var i = items.length - 1; i >= 0; i--) {
					  
					  combohtml += '<option value="'+items[i].c_FormaPago +'" >'+items[i].Descripcion+"</option>";
				} 
				$("#cbFormaPago").html(combohtml); 



		} else{
			toastError(response[0].MESSAGE, 'Info', 3);
		}
	}

	function get_monedas(){
	  
		var data = { };
		var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/get_datos_monedas.php", data);
		if(response[0].RESULT){
	 
				var items = response[0].DATA; 
				var combohtml = "";
				for (var i = items.length - 1; i >= 0; i--) {
					  
					  combohtml += '<option value="'+items[i].c_Moneda +'" >'+items[i].Descripcion+"</option>";
				} 
				$("#cbMoneda").html(combohtml); 

					$("#cbMoneda").val("MXN"); 

		} else{
			toastError(response[0].MESSAGE, 'Info', 3);
		}
	}