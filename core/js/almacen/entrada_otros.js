 var tabla = $('#tablaClientes').DataTable(settingsTable);

console.log("Entrada por otros conceptos");




  $("#file_nota_lb").dropzone({
            success : function(file, response) {
                console.log(file);
                console.log(response);
                if (response.trim() != '') { 

                    $("#hd_txt_nota").val(response.trim());
                     toastInfo("<h4>Su archivo esta precargado correctamente</h4>","Atención!");

                }else{
                    $("#hd_txt_nota").val("");
                     toastAdvertencia("<h4>Existe un problema al subir este archivo favor de verificar o subir otro</h4>","Error");
                }
            }
        });


   $("#file_factura_lb").dropzone({
            success : function(file, response) {
                console.log(file);
                console.log(response);
                if (response.trim() != '') { 

                    $("#hd_txt_factura").val(response.trim());
                     toastInfo("<h4>Su archivo esta precargado correctamente</h4>","Atención!");

                }else{
                    $("#hd_txt_factura").val("");
                     toastAdvertencia("<h4>Existe un problema al subir este archivo favor de verificar o subir otro</h4>","Error");
                }
            }
        });



 
get_materiales();

  

 $("#btn_guardar").click(function(){

 	var materiales=[];
 	var cantidades=[];
  
    $('#tablaMateriales tr').each(function(index, element){
        var id_material = $(element).find("td").eq(0).html(), 
            cantidad = $(element).find("td").eq(2).html();

            if (id_material > 0) {
            	materiales.push(id_material);
            	cantidades.push(cantidad);
            }  
    });
 
    	var nota = $("#txt_nota").val();
    	var motivo = $("#txt_motivo").val();

      var fecha = $("#txt_fecha").val();

    	var factura = $("#txt_factura").val();

    	var file_nota = $("#hd_txt_nota").val();
    	var file_factura = $("#hd_txt_factura").val();
  
      $("#btn_guardar").prop("disabled",true);

	   	var data = {
	   		motivo: motivo 
	   		,nota:nota
	   		,factura:factura
	   		,file_nota:file_nota
	   		,file_factura:file_factura
	   		,materiales:materiales
	   		,cantidades:cantidades
        ,fecha:fecha
	   		 };
		var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/almacen/entrada_otros/set_entrada.php", data);
		if(response[0].RESULT){
			  
			toastExito("se ha guardado correctamente la entrada", 'Info', 3);
			setTimeout(function(){ location.reload(); }, 3000);


		} else {
			toastError(response[0].MESSAGE, 'Info', 3);
		}




  });

$("#btn_add").click(function(){ 

     if (validaRequeridos("frm_entrada")) {

     	var cb_proveedores = $("#cb_proveedores").val();

     	//var cb_materiales = $("#cb_materiales").val();
     	var cb_materiales = $('#cb_materiales').select2('data')
		var texto_materiales = cb_materiales[0].text;
		var id_materiales = cb_materiales[0].id;



    
     	var cb_compra = $("#cb_compra").val();
     	var txt_nota = $("#txt_nota").val();
     	var txt_factura = $("#txt_factura").val();
     	var file_factura = $("#file_factura").val();
     	var file_nota = $("#file_nota").val();
     	var txt_cantidad = $("#txt_cantidad").val(); 

      

     	var tds=$("#tablaMateriales tr:first td").length; 


      	var trs=$("#tablaMateriales tr").length;
      	var nuevaFila="<tr>";
      	  nuevaFila+="<td> "+id_materiales+" </td>";
          nuevaFila+="<td> "+texto_materiales+" </td>";
          nuevaFila+="<td> "+txt_cantidad+"</td>"; 
          nuevaFila+="<td>  <button type='button' class='btn btn-danger' onclick='delRow(this)'>  <i class='fa fa-times-circle'></i>  </button> </td>";
      	  nuevaFila+="</tr>";



      	$("#tablaMateriales").append(nuevaFila);

      	$("#txt_cantidad").val(""); 


     }


     
});


 $('.solo_numero').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
      });


 $('.es_correo').blur(function (){
        var valor = this.value;


         if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor)){
            
          } else {
            this.value = "";
            toastError("<h4>La dirección de email es incorrecta!.</h4>","Error");

          } 

 });






 

function get_materiales() {
 
		 
	var URL_AJAX_MATERIALES = window.location.origin+DIR_LOCAL_JS+"/core/ph/almacen/entrada/get_materiales.php";
	$.ajax({
		type: "POST",
		url: URL_AJAX_MATERIALES,
		dataType: "json",
			success: function(response){
			if(response[0].RESULT){ 

				 	var data_json = response[0].DATA;
					var data = []; 

					for (var i = data_json.length - 1; i >= 0; i--) { 

            if (data_json[i].MAT_ANCH == "0.0000") {
              var texto = data_json[i].TPA_NMBR   ;
            }else{

              var texto = data_json[i].TPA_NMBR +   " - " + data_json[i].MAT_ANCH+ "x" + data_json[i].MAT_ALT;
            }

						
						data.push({"id":data_json[i].MAT_IDINTRN, "text":texto});
					} 

			 	  	$("#cb_materiales").select2({
				      data: data
				  	});
	 
			} else {
				toastError(response[0].MESSAGE, 'Error', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});

}






cargar_datos();

function cargar_datos(){


  table = $('#tablaListado').DataTable();
  table.destroy();

    var txt_fecha_ini = $("#txt_fecha_ini").val();
    var txt_fecha_fin = $("#txt_fecha_fin").val();

  
      var data = {
        folio: ""
        ,fecha_inicio:txt_fecha_ini
        ,fecha_fin:txt_fecha_fin
        ,factura:"" 
         };
    var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/almacen/entrada_otros/get_historial.php", data);
    if(response[0].RESULT){


        var items = response[0].DATA;


        $('#tablaListado').DataTable({
                data: items,
                destroy: true,
                "responsive": true,
                columns: [
                    { title: "Folio" },
                    { title: "Fecha" },
                    { title: "Nota" },
                    { title: "Factura" },
                    { title: "Motivo" },
                     
                ]
            });
  
       


    } else {
      toastError(response[0].MESSAGE, 'Info', 3);
    }
  

   
}


function editar(ID){
	$("#hdColoresId").val(ID);
	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/get_colores_xid.php",
		dataType: "json",
		data: { ID: ID },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;

				console.log(item);
				((item.COL_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				$("#txtNombre").val(item.COL_NMBR); 
				$("#modalColores").modal("show");
			} else {
				toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
}





    function mayus(e) {
        e.value = e.value.toUpperCase();
    }

   
 
    
      function check_rfc(dato_rfc,campo){
        var rfc         = dato_rfc.trim().toUpperCase();
        var rfcCorrecto = rfcValido(rfc);  
        if (rfcCorrecto) {
           $(campo).removeClass("inpError");
           
        }else{
          $(campo).val("");
          $(campo).focus();
          $(campo).addClass("inpError");
          toastError("<h4>Favor de teclear un RFC correcto</h4>","Error");
        }
          
      }

      function visible_cargador_nota(mensaje){

        if (mensaje.length > 0) {

          //var mensaje_corregido = makeSlug(mensaje);

          //$("#txt_nota").val(mensaje_corregido);
          //$("#hd_txt_nota").val(mensaje_corregido); 
          $("#div_carga_nota").show("fast");

        }

      }


      function visible_cargador_factura(mensaje){
        if (mensaje.length > 0) {

          //var mensaje_corregido = makeSlug(mensaje);

          //$("#txt_factura").val(mensaje_corregido);
          //$("#hd_txt_factura").val(mensaje_corregido); 
          $("#div_carga_factura").show("fast");


        }
      }


      function makeSlug(text) {
        var a = 'àáäâèéëêìíïîòóöôùúüûñçßÿœæŕśńṕẃǵǹḿǘẍźḧ·/_,:;';
        var b = 'aaaaeeeeiiiioooouuuuncsyoarsnpwgnmuxzh------';
        var p = new RegExp(a.split('').join('|'), 'g');

        return text.toString().toLowerCase().replace(/\s+/g, '-')
            .replace(p, function (c) {
                return b.charAt(a.indexOf(c));
            })
            .replace(/&/g, '-y-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
      }




      function rfcValido(rfc, aceptarGenerico = true) {
          const re       = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
          var   validado = rfc.match(re);

          if (!validado)  
              return false; 
          const digitoVerificador = validado.pop(),
                rfcSinDigito      = validado.slice(1).join(''),
                len               = rfcSinDigito.length, 
                diccionario       = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
                indice            = len + 1;
          var   suma,
                digitoEsperado; 
          if (len == 12) suma = 0
          else suma = 481; 
          for(var i=0; i<len; i++)
              suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
          digitoEsperado = 11 - suma % 11;
          if (digitoEsperado == 11) digitoEsperado = 0;
          else if (digitoEsperado == 10) digitoEsperado = "A"; 
          if ((digitoVerificador != digitoEsperado)
           && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
              return false;
          else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
              return false;
          return rfcSinDigito + digitoVerificador;
      }

 


      function validaRequeridos($idContent){
                $("#"+$idContent+" .requerido").removeClass("inpError");

                var $inpReq = $("#"+$idContent+" .requerido").filter(function() {

                  if($.trim($(this).val()) == "" || $.trim($(this).val()) == "0" ){

                    console.log($(this));

                    return  true;
                  }
                });
                if($inpReq.length > 0){
                    $inpReq.addClass("inpError");
                    toastError("<h4>Favor de completar campos obligatorios</h4>","Error");
                    return false;
                }
                return true;
      }



	function agregar(){
		 
	}



	function fnc_modl_proveedor(){

		$("#modl_proveedor").modal("show");

	}


  function delRow(currElement) {
       var parentRowIndex = currElement.parentNode.parentNode.rowIndex;
       document.getElementById("tablaMateriales").deleteRow(parentRowIndex);
  }

  function insRow(id) {
      var filas = document.getElementById("tablaMateriales").rows.length;
      var x = document.getElementById(id).insertRow(filas);
      var y = x.insertCell(0);
      var z = x.insertCell(1);
      y.innerHTML = '<input type="text" id="fname">';
      z.innerHTML ='<button id="btn" name="btn" > Delete</button>';
  }

 
 


