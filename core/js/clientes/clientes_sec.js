

var tabla = $('#tablaClientes').DataTable(settingsTable);
var tabla_sucursal = $('#TablaSucursales').DataTable(settingsTable);
var tablaContacto = $('#tablaContacto').DataTable(settingsTable);

$.fn.raty.defaults.path = '../../../../assets/images/raty/';

cargar_sucursales();
cargar_contactos();


$('#credito_ranq').raty({
		score:  $("#hd_rank_credito").val(),
		hints:        ['Malo', 'Regular', 'Bueno'],
		number:       3,
		starHalf:     'star-half.png',
    	starOff:      'star-off.png',
    	starOn:       'star-on.png',
    	cancelOff:    'cancel-off.png',
    	cancelOn:     'cancel-on.png',
    	cancelPlace:  'left',
    	click: function(score, evt) {
		    //alert('score: ' + score);
		    $("#hd_rank_credito").val(score);
	  }
});



  
 $('#cli_credito_activo').change(function() {
        if($(this).is(":checked")) {
            $("#cli_limite_credito").prop("disabled",false);
        }else{  
        	$("#cli_limite_credito").prop("disabled",true);
        }   
    });


 $("#btnGuardar_cliente").click(function(){
 	if (validaRequeridos("form_cliente")) {
            	
         var ACTIVO = ($("#cli_activo").is(':checked') ? 1: 0);
         var URL = (($("#hd_id_cliente").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/agregar_cliente.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/editar_cliente.php"));
 		 
 		var parametros = {
                "cli_nombre" : $("#cli_nombre").val() 
                ,"cli_rfc" : $("#cli_rfc").val() 
                ,"cli_razon_social" : $("#cli_razon_social").val() 
                ,"cli_calle" : $("#cli_calle").val() 
                ,"cli_numext" : $("#cli_numext").val() 
                ,"cli_numint" : $("#cli_numint").val() 
                ,"cli_cp" : $("#cli_cp").val() 
                ,"cli_tipo" : $("#cli_tipo").val() 
                ,"cli_contacto" : $("#cli_contacto").val()
                ,"cli_activo" : ACTIVO
                ,"hd_id_cliente" : $("#hd_id_cliente").val()  
        };
        

         $.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: parametros,
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);

					var id_cliente_64 = window.btoa(response[0].DATA); 
					
					setTimeout( function(){
						 window.location = "cliente.php?v="+id_cliente_64;

					} , 3000);

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

 $("#btnGuadar_sucursal").click(function(){ 

 	if (validaRequeridos("form_sucursales")) { 

         var ACTIVO = ($("#suc_activo").is(':checked') ? 1: 0);
         var URL = (($("#hdSucursalID").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/agregar_sucursal.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/editar_sucursal.php"));
 		 
 		var parametros = {
                "suc_nombre" : $("#suc_nombre").val() 
                ,"suc_folio" : $("#suc_folio").val()
                ,"suc_descripcion" : $("#suc_descripcion").val() 
                ,"suc_calle" : $("#suc_calle").val() 
                ,"suc_numint" : $("#suc_numint").val() 
                ,"suc_numext" : $("#suc_numext").val() 
                ,"suc_codigopostal" : $("#suc_codigopostal").val() 
                ,"suc_mercado" : $("#suc_mercado").val()  
                ,"suc_activo" : ACTIVO
                ,"hd_id_cliente" : $("#hd_id_cliente").val() 
                ,"hdSucursalID" : $("#hdSucursalID").val() 
        }; 

         $.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: parametros,
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalSucursal").modal("hide");
					cargar_sucursales();
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


  $("#btnGuadar_contacto").click(function(){ 

 	if (validaRequeridos("form_contactos")) { 

         var ACTIVO = ($("#cont_activo").is(':checked') ? 1: 0);
         var URL = (($("#hdContactoID").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/agregar_contacto.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/editar_contacto.php"));
 		 
 		var parametros = {
                "cont_nombre" : $("#cont_nombre").val() 
                ,"cont_apellidop" : $("#cont_apellidop").val() 
                ,"cont_apellidom" : $("#cont_apellidom").val() 
                ,"cont_correo" : $("#cont_correo").val() 
                ,"cont_celular" : $("#cont_celular").val() 
                ,"cont_telefono" : $("#cont_telefono").val() 
                ,"cont_tipocontacto" : $("#cont_tipocontacto").val()  
                ,"cont_activo" : ACTIVO
                ,"cont_sucursales" : $("#cont_sucursales").val() 
                ,"hd_id_cliente" : $("#hd_id_cliente").val() 
                ,"hdContactoID" : $("#hdContactoID").val() 
        }; 

         $.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: parametros,
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalContactos").modal("hide");
					cargar_contactos();
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


  $("#btnGuardar_crediticio").click(function(){

  	

  	 var URL = window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/editar_historal_crediticio.php";
 	
 	var id_cliente = $("#hd_id_cliente").val();


 	if (id_cliente > 0) {

 			 var ACTIVO = ($("#cli_credito_activo").is(':checked') ? 1: 0);
		  	 var rank = $("#hd_rank_credito").val();
		  	 var cli_limite_credito = $("#cli_limite_credito").val();


		  	 var parametros = {
		                "cli_limite_credito" : cli_limite_credito
		                ,"ACTIVO" : ACTIVO
		                ,"rank" : rank
		                ,"hd_id_cliente" : $("#hd_id_cliente").val()  
		                ,"cli_forma_pago" : $("#cli_forma_pago").val()
		        }; 


		  	 $.ajax({
					type: "POST",
					url: URL,
					dataType: "json",
					data: parametros,
					success: function(response){
						if(response[0].RESULT){
							toastExito("Datos guardados correctamente.", 'Éxito', 3); 
						} else {
							toastError(response[0].MESSAGE, 'Error', 3);
						}
					}, 
					error: function(error){
						toastError(error.responseText, 'Error', 3);
					}
				}); 
	}else{

		toastError("Favor de primero agregar un cliente", 'Error', 3);
	}


  });




 
function check_numeros(evt) {
    evt = (evt) ? evt : window.event
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        //status = "This field accepts numbers only."
        toastError("Este campo solo acepta solo números", 'Error', 3);
        return false
    }
    status = ""
    return true
}



function agregar_sucursal(){
	
		$("#suc_folio").val("0");
		$("#suc_nombre").val("");
		$("#suc_descripcion").val(""); 
		$("#suc_calle").val(""); 
		$("#suc_numint").val(""); 
		$("#suc_numext").val(""); 
		$("#suc_codigopostal").val(""); 
		$("#suc_mercado").val("");  
		$("#hdSucursalID").val(0); 
		$("#suc_activo").attr('checked', true);

		$("#modalSucursal").modal("show");



}


function agregar_contacto(){
	$("#cont_nombre").val("");
	$("#cont_apellidop").val(""); 
	$("#cont_apellidom").val(""); 
	$("#cont_correo").val(""); 
	$("#cont_celular").val(""); 
	$("#cont_telefono").val(""); 
	$("#cont_tipocontacto").val(0);  
	$("#cont_sucursales").val();  
	$("#hdContactoID").val(0); 
	$("#cont_activo").attr('checked', true);

	$("#modalContactos").modal("show");

	
}

 

function cargar_datos(){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/get_clientes.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].CLI_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					
				 
					var id = utf8_to_b64(items[i].CLI_IDINTRN);
					var link_edicion = "cliente.php?v="+id;

					tabla.row.add([ 
									items[i].CLI_IDINTRN,
				  					"<a href='"+link_edicion+"'   onclick='editar("+items[i].CLI_IDINTRN+")'> "+ items[i].CLI_NMCR+ "</a>", 
				  					items[i].CLI_RFC,
				  					items[i].TIPO_CLIENTE,
				  					activo, 
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editar("+items[i].CLI_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
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

function cargar_sucursales(){
	tabla_sucursal.clear().draw();
	var id_cliente = $("#hd_id_cliente").val();

	if(id_cliente > 0){

		$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/get_table_sucursales_x_cliente.php",
		dataType: "json",
		type: "POST",
		data: {id:id_cliente},
		success: function(response){
				if(response[0].RESULT){

					var items = response[0].DATA; 

					for (var i = 0 ; i < items.length ; i++) {
						var activo = ((items[i].SUC_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
						
					 
						var id = utf8_to_b64(items[i].SUC_IDINTRN);
						//var link_edicion = "cliente.php?v="+id;

						tabla_sucursal.row.add([ 
										items[i].SUC_NMBR,
					  					items[i].SUC_DSCRPCN,
					  					items[i].SUC_CLL,
					  					items[i].SUC_CDGPSTL, 
					  					activo, 
					  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editar_sucursal("+items[i].SUC_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
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
	
}


function cargar_contactos(){
	tablaContacto.clear().draw();
	var id_cliente = $("#hd_id_cliente").val();

	if(id_cliente > 0){ 

			$.ajax({
				url: window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/get_table_contactos_x_cliente.php",
				dataType: "json",
				type: "POST",
				data: {id:id_cliente},
				success: function(response){
					if(response[0].RESULT){
		 
						var items = response[0].DATA; 

						for (var i = 0 ; i < items.length ; i++) {
							var activo = ((items[i].CNT_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
							
						 
							var id = utf8_to_b64(items[i].CNT_IDINTRN);
							//var link_edicion = "cliente.php?v="+id;

							var correo = "<a href='mailto:"+items[i].CNT_EML+"'>"+items[i].CNT_EML+"</a> ";
							var celular = "<a href='tel:"+items[i].CNT_CLLR+"'>"+items[i].CNT_CLLR+"</a> ";
							var tipo_contacto = "";
							

							if (items[i].CNT_CLLR > 1 ) {
								tipo_contacto = "De sucursal";
							}else{
								tipo_contacto = "De matriz";
							} 

							tablaContacto.row.add([ 
											items[i].CNT_NMBR + " " +items[i].CNT_APLLDPTRN+" "+items[i].CNT_APLLDMTRN,
						  					correo,
						  					celular,
						  					tipo_contacto, 
						  					activo, 
						  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editar_contacto("+items[i].CNT_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
						  				]).draw();

							console.log(items[i].SUC_NMBR);
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

}





function editar_sucursal(id_sucursal){

	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/get_data_sucursal_x_id.php",
		dataType: "json",
		data: { ID: id_sucursal },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.SUC_ACTV == 1) ? $("#suc_activo").attr('checked', true) : $("#suc_activo").attr('checked', false) );
				$("#suc_nombre").val(item.SUC_NMBR);
				$("#suc_descripcion").val(item.SUC_DSCRPCN); 
				$("#suc_calle").val(item.SUC_CLL); 
				$("#suc_numint").val(item.SUC_NUMRINTR); 
				$("#suc_numext").val(item.SUC_NMREXTR); 
				$("#suc_codigopostal").val(item.SUC_CDGPSTL); 
				$("#suc_mercado").val(item.MERCADOS_MER_IDMRCD);  
				$("#hdSucursalID").val(item.SUC_IDINTRN);  
				$("#suc_folio").val(item.SUC_FL);
				$("#modalSucursal").modal("show");

				if (item.SUC_FL == 0 || item.SUC_FL == "" || item.SUC_FL == "0") {
					set_folio();
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

function set_folio(){

	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/get_folio.php",
		dataType: "html",
		success: function(response){
			 $("#suc_folio").val(response);
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});

}




function editar_contacto(id_sucursal){

	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/get_data_contacto_x_id.php",
		dataType: "json",
		data: { ID: id_sucursal },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.CNT_ACTV == 1) ? $("#cont_activo").attr('checked', true) : $("#cont_activo").attr('checked', false) );
				$("#cont_nombre").val(item.CNT_NMBR);
				$("#cont_apellidop").val(item.CNT_APLLDPTRN); 
				$("#cont_apellidom").val(item.CNT_APLLDMTRN); 
				$("#cont_correo").val(item.CNT_EML); 
				$("#cont_celular").val(item.CNT_CLLR); 
				$("#cont_telefono").val(item.CNT_TLFN); 
				$("#cont_tipocontacto").val(item.CNT_TPCNTCT);  
				$("#cont_sucursales").val(item.SUCURSALES_SUC_IDINTRN);  
				$("#hdContactoID").val(item.CNT_IDINTRN);  

				$("#modalContactos").modal("show");
			} else {
				toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});

}


function carga_historial_credito(){

	var id_cliente = $("#hd_id_cliente").val();

	if (id_cliente > 1) {



	}else{
		toastError("Favor de primero agregar el cliente", 'Info', 3);
	}

}






function utf8_to_b64( str ) {
  return window.btoa(unescape(encodeURIComponent( str )));
}

function b64_to_utf8( str ) {
  return decodeURIComponent(escape(window.atob( str )));
}

 