
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

 
get_forma_pago();
get_monedas();
get_clientes();
get_datos_empresa();
	


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


	function fnc_select(ctrl,uuid){

		$("#modal_documentos").modal("hide");

		inc_id = $("#id_uuid").val();
 		
 		var data = {uuid: uuid};
		var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/get_datos_uuid.php", data);	 
       	if(response[0].RESULT){
		
			var datos = response[0].DATA;  

			$("#folio_"+inc_id).val(datos.folio);
			$("#saldo_"+inc_id).val(datos.total_factura-datos.total_pagos);
			$("#importe_"+inc_id).val(datos.total_factura);
			$("#isulto_"+inc_id).val(0);


		} else {  

			toastError(response[0].MESSAGE, 'Info', 3);
		}



		$("#uuid_"+inc_id).val(uuid);
	}


	function get_documentos(id_dato){

		$("#id_uuid").val(id_dato);

		var cliente = $("#cbClientes").val();

 		if (cliente>0) {
 			$("#modal_documentos").modal("show");

 			var data = {cliente: cliente};
			var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/get_documentos.php", data);
			 
           	if(response[0].RESULT){

				var item = response[0].DATA;  
				$("#tablaListaDocumentos tbody").html(item);
				
			} else { 
				
				$("#tablaListaDocumentos tbody").html("");
				toastError(response[0].MESSAGE, 'Info', 3);
				
			}


 		} else{
			toastError("Favor de seleccionar un cliente", 'Info', 3);
		}


	}


	function get_datos_empresa(){
	  
		var data = { };
		var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/get_datos_empresa.php", data);
		if(response[0].RESULT){
	 
		 
				var item = response[0].DATA; 
				$("#txtRFC").val(item.rfc); 
				$("#txtRazonSocial").val(item.razon_social); 
				$("#txtCalle").val(item.calle); 
				$("#txtNumExt").val(item.num_ext); 
				$("#txtNumInt").val(item.num_int); 
				$("#txtColonia").val(item.colonia); 
				$("#txtLocalidad").val(item.localidad); 
				$("#txtCiudad").val(item.ciudad); 
				$("#txtEstado").val(item.estado); 
				$("#txtPais").val(item.pais); 
				$("#txtCP").val(item.codigo_postal);  

		}else{
 			toastError("Favor de seleccionar un clinte primero", 'Info', 3);
 		}
	}
 
 
 	function agregar_doc(){


 		var cliente = $("#cbClientes").val();

 		if (cliente>0) {

	 		var tds = $("#tabla_conceptos tr:first td").length; 
	      	var trs = $("#tabla_conceptos tr").length;
	      	var num = trs+1;

	      	var id = "uuid_"+num;
	      	var uuid = "<input onclick='get_documentos(\""+num+"\")' type='text' name='uuid_"+num+"' id='uuid_"+num+"' style='width: 100%;'>";
	      	var folio = "<input type='text' name='folio_"+num+"' id='folio_"+num+"' style='width: 100%;'>";
	      	var moneda = "<select name='moneda_' disabled id='moneda_"+num+"' style='width: 100%;'>  </select>";
	      	var mpago = "<select name='mpago_' disabled id='mpago_"+num+"' style='width: 100%;'>  </select>";
	      	var saldo = "<input type='numeric' name='saldo_"+num+"' id='saldo_"+num+"' style='width: 100%;'>";
	      	var importe = "<input type='numeric' name='importe_"+num+"' id='importe_"+num+"' style='width: 100%;'>";
	      	var isulto = "<input type='numeric' name='isulto_"+num+"' id='isulto_"+num+"' style='width: 100%;'>";

	      	var nuevaFila="<tr>";
	      	  nuevaFila+="<td> "+uuid+" </td>";
	          nuevaFila+="<td> "+folio+" </td>";
	          nuevaFila+="<td> "+moneda+"</td>"; 
	          nuevaFila+="<td> "+mpago+"</td>"; 
	          nuevaFila+="<td> "+saldo+"</td>"; 
	          nuevaFila+="<td> "+importe+"</td>"; 
	          nuevaFila+="<td> "+isulto+"</td>";  
	          nuevaFila+="<td>  <button type='button' class='btn btn-danger' onclick='delRow(this)'>  <i class='fa fa-times-circle'></i>  </button> </td>";
	      	  nuevaFila+="</tr>";
	 
	      	$("#tabla_conceptos").append(nuevaFila);

	      	var id_mpago = "mpago_"+num;
	      	var id_moneda = "moneda_"+num;
	      	
	      	get_monedas_inp(id_moneda);
		    get_metodo_pago_inp(id_mpago);

 		}else{

 			toastError("Favor de seleccionar un clinte primero", 'Info', 3);

 		}


      	 
      	/*
      	
      	var precioValue = ctrl_concepto.find(':selected').attr('data-precio');
  		var desc = $("#concepto option:selected").text();
  		var Cantidad = $this.find("td.txtCantidad"+id_concepto).html();

  		var ClaveUnidad = $this.find("#cbClvUnidad"+id_concepto).val();
  		var id_concepto = $this.find("#id_detalle_cot").val();
  		
      	 */

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
 
	 
	function get_clientes(){

		var data = { prospecto: "1,0" };
		var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/get_clientes.php", data);
		if(response[0].RESULT){
			$("#cbClientes").html("<option value='0'>[Seleccione Cliente]</option>");
			for(var i = 0; i < response[0].DATA.length; i++){
				var item = response[0].DATA[i];
				$("#cbClientes").append("<option value='"+item.CLI_IDINTRN+"'>"+item.CLI_NMCR+"</option>");
			}
		} else {
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


	function get_monedas_inp(inp){
	  
		var data = { };
		var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/get_datos_monedas.php", data);
		if(response[0].RESULT){ 
				var items = response[0].DATA; 
				var combohtml = "";
				for (var i = items.length - 1; i >= 0; i--) { 
					  combohtml += '<option value="'+items[i].c_Moneda +'" >'+items[i].Descripcion+"</option>";
				} 
				$("#"+inp).html(combohtml); 
				$("#"+inp).val("MXN"); 

		} else{
			toastError(response[0].MESSAGE, 'Info', 3);
		}
	}

	function get_metodo_pago_inp(inp){
	  
		var data = { };
		var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/get_datos_metodos_pago.php", data);
		if(response[0].RESULT){
	 
				var items = response[0].DATA; 
				var combohtml = "";
				for (var i = items.length - 1; i >= 0; i--) {
					  
					  combohtml += '<option value="'+items[i].c_MetodoPago +'" >'+items[i].Descripcion+"</option>";
				} 
				$("#"+inp).html(combohtml); 

		} else{
			toastError(response[0].MESSAGE, 'Info', 3);
		}
	}