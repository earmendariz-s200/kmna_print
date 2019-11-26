
 var STATUS200 = function() {
 

 	var tabla = $('#tabla_conceptos').DataTable(settingsTable);
	console.log("FACTURA");


	var subtotal = 1800;
 	var iva = 288;
 	var total = 2088;
 	var arrayconceptos = [];



	get_datos_empresa();
	get_uso_cfdi();
	get_metodo_pago();
	get_forma_pago();
	get_monedas();

	get_folio();



	     /*$.blockUI({
	            message: '<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Generando factura ...</div>',
	            fadeIn: 1000, 
	            overlayCSS: {
	                backgroundColor: '#FFF',
	                opacity: 0.8,
	                cursor: 'wait'
	            },
	            css: {
	                border: 0,
	                padding: 0,
	                color: '#FFF',
	                backgroundColor: '#333'
	            }
	        });
	     $.unblockUI();*/



	  $(".cb_autoc").autocomplete({
            source: function (request, response) {
                datos = [];
                var url_dato = window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/get_conceptos.php";
                datos.push({name: 'term', value: request.term});
                $.ajax({
                    url: url_dato,
                    dataType: "json",
                    data: datos,
                    success: function (data) {

                    	var item ;

                    	var obj;


                    	if(data[0].RESULT){

                    		item = data[0].DATA; 

                    		obj = JSON.parse(item);

                    	} else{

                    		item = data[0].DATA; 
                    		obj = JSON.parse(item);
							
						}


                        response(obj);
                    }
                });
            },
            minLength: 3,
            select: function (event, ui) {
                $(this).val(ui.item.label);
            }
    });




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

		} else{
			toastError(response[0].MESSAGE, 'Info', 3);
		}
	}


	function get_folio(){

		var data = { };
		var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/get_folio.php", data);
		if(response[0].RESULT){
	 
		 
				var item = response[0].DATA; 
				$("#txtFolio").val(item.maximo);  

		} else{
			toastError(response[0].MESSAGE, 'Info', 3);
		}
	}


	function get_uso_cfdi(){
	  
		var data = { };
		var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/get_datos_cfdi.php", data);
		if(response[0].RESULT){
	 
				var items = response[0].DATA; 
				var combohtml = "";
				for (var i = items.length - 1; i >= 0; i--) {
					  
					  combohtml += '<option value="'+items[i].c_UsoCFDI +'" >'+items[i].Descripcion+"</option>";
				} 
				$("#cbUsoCFDI").html(combohtml); 

		} else{
			toastError(response[0].MESSAGE, 'Info', 3);
		}
	}


	function get_metodo_pago(){
	  
		var data = { };
		var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/get_datos_metodos_pago.php", data);
		if(response[0].RESULT){
	 
				var items = response[0].DATA; 
				var combohtml = "";
				for (var i = items.length - 1; i >= 0; i--) {
					  
					  combohtml += '<option value="'+items[i].c_MetodoPago +'" >'+items[i].Descripcion+"</option>";
				} 
				$("#cbMetodoPago").html(combohtml); 

		} else{
			toastError(response[0].MESSAGE, 'Info', 3);
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







	$("#btnFacturarS200").click(function() {
		// Se comienza validaciones de facturacion
		var expreg = /^([A-Z脩\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))([A-Z\d]{3})?$/;
		var expregemail = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

		if($("#txtRFC").val() == "" ||  $("#txtRazonSocial").val() == "" || $("#txtCalle").val() == "" 
			|| $("#txtNumExt").val() == "" || $("#txtColonia").val() == "" 
			|| $("#txtCiudad").val() == "" || $("#txtEstado").val() == "" || $("#txtPais").val() == "" 
			|| $("#txtCP").val() == "") {
			$("#modalMensaje").html("Los datos fiscales de la empresa emisora son requeridos, verifique por favor.");
			$("#modal").modal("show");
		} else if(!expreg.test($("#txtRFC").val())) {
			$("#modalMensaje").html("El formato de RFC para la empresa es incorrecto, verifique por favor.");
			$("#modal").modal("show");
		} else if($("#txtRFC_c").val() == "" ||  $("#txtRazonSocial_c").val() == "" || $("#txtCalle_c").val() == "" 
			|| $("#txtNumExt_c").val() == "" || $("#txtColonia_c").val() == "" 
			|| $("#txtCiudad_c").val() == "" || $("#txtEstado_c").val() == "" || $("#txtPais_c").val() == "" 
			|| $("#txtCP_c").val() == "" || $("#txtEmail_c").val() == "") {
			$("#modalMensaje").html("Los datos fiscales del cliente son requeridos, verifique por favor.");
			$("#modal").modal("show");
		} else if(!expreg.test($("#txtRFC_c").val())) {
			$("#modalMensaje").html("El formato de RFC del cliente es incorrecto, verifique por favor.");
			$("#modal").modal("show");
		} else {
			    $.blockUI({
			        message: '<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Generando factura ...</div>',
		            fadeIn: 1000, 
		            overlayCSS: {
		                backgroundColor: '#FFF',
		                opacity: 0.8,
		                cursor: 'wait'
		            },
		            css: {
		                border: 0,
		                padding: 0,
		                color: '#FFF',
		                backgroundColor: '#333'
		            }
			    });
			facturarS200();
		}
	});


	function facturarS200(){

		 		var emisorRFC;
		 		var receptorRFC;
		 		if(DEBUG){
		 			emisorRFC = "TCM970625MB1";
		 			receptorRFC = "XAXX010101000";
		 		} else {
		 			emisorRFC = $("#txtRFC").val().toUpperCase();
		 			receptorRFC = $("#txtRFC_c").val().toUpperCase();
		 		}

		 		var arConceptos = [];
		 		var totalTraslados = 0;
		 		// iteracion de conceptos
		 		$('#tabla_conceptos > tbody  > tr').each(function() {
	 			
		 			$this = $(this);
		 			var id_concepto = $this.find("#id_detalle_cot").val();
		 			var ClaveProdServ = $this.find("#cbClvServicio"+id_concepto).val();

		 			var arreglo_clave_serv = ClaveProdServ.split(" - ");
		 			var servicio_producto = arreglo_clave_serv[0];

		 			var Cantidad = $this.find("td.txtCantidad"+id_concepto).html();
		 			var ClaveUnidad = $this.find("#cbClvUnidad"+id_concepto).val();
		 			var Unidad = $this.find("#txtUnidad"+id_concepto).html();
		 			var Descripcion = $this.find("#txtConcepto"+id_concepto).html();
					var ValorUnitario = $this.find("#txtPrecioU"+id_concepto).val();
					var Importe = $this.find("#txtImporte"+id_concepto).val();

					if($this.find("#ckIVA"+id_concepto).is(":checked")){
						var arImpuestos = [];
						var ImporteIva = Importe * 0.16;
						totalTraslados = totalTraslados + ImporteIva;
						var traslados = [];
						var traslado = {
							"Impuesto": "002",
							"TipoFactor": "Tasa",
							"TasaOCuota": "0.160000",
							"Importe": ImporteIva.toFixed(2),
							"Base": Importe
						};
						traslados.push(traslado);
					}
		 			var concepto = {
			            "ClaveProdServ": servicio_producto,
						"Cantidad": Cantidad,
						"ClaveUnidad": ClaveUnidad,
						"Unidad": Unidad,
						"Descripcion": Descripcion,
						"ValorUnitario": ValorUnitario,
						"Importe": parseFloat(Importe).toFixed(2),
						"Descuento": 0.00,
						"impuestos": {"traslados":traslados}
			        };
			        arConceptos.push(concepto);
		 		});

		 		console.log(arConceptos);

		        var numfolio = "";
	
		 		if ($("#txtFolio").val() == "" || $("#txtFolio").val() <= 0) {
		 			numfolio = $("#hdCotizacion").val();
		 		} else{
		 			numfolio = $("#txtFolio").val();
		 		}

		 		// CREACION DE JSON para WS de FacturaS200
		 		var jsonfactura = {
		 			"usuarioS200": emisorRFC,
					"sandbox": DEBUG,
					"factura":{
						"tipoCFDI": "Factura",
					    "CondicionesDePago": $("#txtCondicionPago").val(),
					 	"FormaPago": $("#cbFormaPago").val(),
					 	"lugarExpedicion": $("#txtCP").val().toUpperCase(),
					 	"descuento": 0.00,
					 	"subtotal": subtotal.toFixed(2),
					 	"total": total.toFixed(2),
					 	"MetodoPago": $("#cbMetodoPago").val(),
					 	"moneda": $("#cbMoneda").val(),
					 	"tipoCambio": $("#txtTipoCambio").val(),
					 	"TipoDeComprobante": "I",
					 	"serie": "",
					 	"folio": $("#txtFolio").val(),
					 	"observacion": "ORDEN DE COMPRA: "+$("#txtOrdenCompra").val(),
						"emisorRFC": emisorRFC,
						"emisorRazon": $("#txtRazonSocial").val().toUpperCase(),
						"emisorRegimen": $("#cbRegimenFiscal").val(),
						"receptorRFC": receptorRFC,
						"receptorRazon": $("#txtRazonSocial_c").val().toUpperCase(),
						"receptorUsoCFDI": $("#cbUsoCFDI").val(),
						"receptorCodigoPostal": $("#txtCP_c").val().toUpperCase(),
						"receptorPais": $("#txtPais_c").val().toUpperCase(),
						"receptorEstado": $("#txtEstado_c").val().toUpperCase(),
						"receptorMunicipio": $("#txtCiudad_c").val().toUpperCase(),
						"receptorLocalidad": $("#txtLocalidad_c").val().toUpperCase(),
						"receptorColonia": $("#txtColonia_c").val().toUpperCase(),
						"receptorNoExterior": $("#txtNumExt_c").val().toUpperCase(),
						"receptorNoInterior": $("#txtNumInt_c").val().toUpperCase(),
						"receptorCalle":  $("#txtCalle_c").val().toUpperCase(),
						"orden_compra": $("#txtOrdenCompra").val(),
						"receptorEmail": "",
						"conceptos": arConceptos,
						"traslados": [
							{
								"Impuesto": "002",
								"TipoFactor": "Tasa",
								"TasaOCuota": "0.160000",
								"Importe": totalTraslados.toFixed(2)
							}
						],
						"TotalImpuestosTras": totalTraslados.toFixed(2)
					}
		 		}
		 		
				$.ajax({
		           type: "POST",
		           url: "https://devlag.com/status200.mx/soluciones/FacturaS200/api/inc/index_33.php",
		           dataType: "json",
		           data: { jsonDatos: JSON.stringify(jsonfactura)},
		           success: function(d) {
		           		console.log(d);
		           		//var d = JSON.parse(datos);
		           		if(d[0].RESULT){

		           			$.unblockUI();


		           			$.blockUI({
						        message: '<h3>Guardando...</h3>'
						    });
						    var p = 0;
						    if($("#cbMetodoPago").val() == "PUE"){
						        p = 0;
						    } else {
						        p = 1;
						    }
						    
						   	var url_guarda_factura = window.location.origin+DIR_LOCAL_JS+"/core/ph/facturacion/guardafactura.php";

 
							$.ajax({
					           type: "POST",
					           url:url_guarda_factura, 
					           dataType: "html",
					           data: { 
					           	total: total.toFixed(2),
					           	subtotal: subtotal.toFixed(2),
					           	iva: iva.toFixed(2),
					           	UUID: d[0].UUID, 
					           	URLXML: d[0].XML, 
					           	folio:numfolio,
					           	URLPDF: d[0].PDF, 
					           	IDCOTIZACION: $("#hdCotizacion").val(), 
					           	conPagos: p },
					           success: function(r) {
					           		//console.log(r);
					           		$.unblockUI();
					           		$("#modalMensaje").html("La factura se ha generado correctamente.");
									$("#modal").modal("show");
									//setTimeout(function(){window.location = "../facturas/facturas.php";}, 3000);
					           },
					           error: function(error) { console.log(error); }
					       });

		           		} else {
							$("#modalMensaje").html(d[0].MESSAGE);
							$("#modal").modal("show");
							$.unblockUI();
		           		}
		           		
		           },
		           error: function(error) {
		           		console.log(error);
		           		$.unblockUI();
		           }
		       });

 	}




 }();