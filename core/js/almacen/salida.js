 

console.log("Ajustes");
 



 
get_materiales();

  

 $("#btn_guardar").click(function(){
 
      var motivo = $("#motivo").val();
      var cantidad = $("#txt_cantidad").val(); 
      var materiales = $("#cb_materiales").val();


      if (validaRequeridos("frm_salida")) {

          $("#btn_guardar").prop("disabled",true);

            var data = {
                motivo: motivo
                ,cantidad:cantidad
                ,materiales:materiales
                 };
            var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/almacen/salidas/set_salidas.php", data);
            if(response[0].RESULT){
                
              toastExito("se ha guardado correctamente la salida", 'Info', 3);
              setTimeout(function(){ location.reload(); }, 3000);


            } else {
              toastError(response[0].MESSAGE, 'Info', 3);
            }



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





cargar_datos();

function cargar_datos(){


  table = $('#tablaListado').DataTable();
  table.destroy();

$('#tablaListado tbody').html("");

 
    var txt_fecha_ini = $("#txt_fecha_ini").val();
    var txt_fecha_fin = $("#txt_fecha_fin").val();

  
      var data = { 
         fecha_inicio:txt_fecha_ini
        ,fecha_fin:txt_fecha_fin          };
    var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/almacen/salidas/get_historial.php", data);
    if(response[0].RESULT){


        var items = response[0].DATA;

        console.log(items);

        $('#tablaListado').DataTable({
                data: items,
                destroy: true,
                columns: [
                    { title: "Folio" },
                    { title: "Fecha" }, 
                    { title: "Material" },
                    { title: "Cantidad" },
                    { title: "Tipo Ajuste" },
                    { title: "Motivo" } 
                ]
            });
  
       


    } else {
      toastError(response[0].MESSAGE, 'Info', 3);
    }
  

   
}

 

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

						//var texto = data_json[i].TPA_NMBR + " " + data_json[i].GPA_GRAMAJE + " - " + data_json[i].MAT_ANCH+ "x" + data_json[i].MAT_ALT;
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
                    toastError("<h4>Favor de completar campos obligatorios para realizar el ajuste</h4>","Error",5);
                    return false;
                }
                return true;
      }


  
 
 


