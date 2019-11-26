var tablaConceptosAcabados = $("#tablaConceptosAcabados").DataTable(settingsTable);
var tablaConceptosTerminados = $("#tablaConceptosTerminados").DataTable(settingsTable);
var tablaTotalesArea = $("#tablaTotalesArea").DataTable(settingsTable);
var tablaTotalesNetos = $("#tablaTotalesNetos").DataTable(settingsTable);
var tablaAlternativas = $("#tablaAlternativas").DataTable(settingsTable);


var ID_MATERIAL = 0;

$(document).ready(function() {
  var data = { ID: $("#hdIdConcepto").val() };
  var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/cotizaciones/get_concepto_cotizacion.php", data);
  if(response[0].RESULT){
    var item = response[0].DATA;
    $("#txtCantidadTrabajo").val(item[0].CDE_CNTD);
    $("#txtDescripcionTrabajo").val(item[0].CDE_DSCRPCN);
    $("#lstMateriales").html("");
    for(var i = 0; i < response[0].DATA.length; i++){
        $("#lstMateriales").append('<a href="javascript:;" class="list-group-item list-group-item-action" id="lstMaterial_'+item[i].CDM_IDINTRN+'" onclick="getmaterial('+item[i].CDM_IDINTRN+'); carga_insumos('+item[i].TPR_TPTRBJ+', '+item[i].CDM_IDINTRN+'); carga_terminados('+item[i].TPR_TPTRBJ+');">'+item[i].TPA_NMBR+' '+item[i].GPA_GRAMAJE+'</a>');
    }

    $("#hdTintas").val(item[0].CDM_TTS_FRNT);
    var cantidad = item[0].CDE_CNTD;
    $("#hdCantidad").val(cantidad);
    //calculo_costos(item[0].GXP_IDINTRN, cantidad);
  } else {
    toastError(response[0].MESSAGE, 'Info', 3);
  }
});

$("#cbMaquinaImpresion").change(function(){
  var id_maquina = $("#cbMaquinaImpresion").val();
  var data = { ID: id_maquina };
  var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/gettmaquinaxid.php", data);
  if(response[0].RESULT){
    var datos = response[0].DATA;
    console.log(datos);
    $("#hdCostoLaminaImpresora").val(datos.MAQ_CSTLMN);
    $("#hdCostoMillarImpresora").val(datos.MAQ_CSTMLLR);
    $("#hdAnchoMinimoImpresora").val(datos.MAQ_MNANCH);
    $("#hdAltoMinimoImpresora").val(datos.MAQ_MNALT);
    $("#hdAnchoMaximoImpresora").val(datos.MAQ_MXANCH);
    $("#hdAltoMaximoImpresora").val(datos.MAQ_MXALT);

    consulta_excedente(datos.MAQ_IDINTRN);
  } else {
    toastError(response[0].MESSAGE, 'Info', 3);
  }
});

var cuardernillos = 0;

function consulta_excedente(id_maquina){
  cuardernillos = parseInt($("#hdPaginas").val()) / (parseInt($("#txtBasePliegos").val()) * parseInt($("#txtAltoPliegos").val()));
  var c_cantidad = cuardernillos * parseInt($("#hdCantidad").val());
  var data = { ID_MAQUINA: id_maquina, CANTIDAD: c_cantidad };
  var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/cotizaciones/getmaquinaexcedente.php", data);
  if(response[0].RESULT){
    var datos = response[0].DATA;
    console.log(datos)
    var exc = datos[0].MAQ_PLIEGOS_MALOS_MIN * cuardernillos;
    $("#hdExcendente").val(exc);


  } else {
    toastError("Error de calculo, revise excedente.", 'Info', 3);
  }

}

function calcular_cantidad_material(){

}

function agrega_margen(){
  var margen_trabajo = $("#txtMargenTrabajo").val();
  var costo_trabajo = $("#txtCostoTrabajo").val();
  var cantidad = $("#hdCantidad").val();
  var monto_margen = (margen_trabajo / 100) * costo_trabajo;
  $("#txtMontoMargen").val(monto_margen);
  var new_costo_trabajo = parseFloat(costo_trabajo) + parseFloat(monto_margen);
  $("#txtCostoTrabajo").val(new_costo_trabajo);
  var new_precio_unitario = new_costo_trabajo / cantidad;
  $("#txtPrecioUnitario").val(new_precio_unitario);
}

function calculo_costos(tipo_papel, cantidad){
  var costo_trabajo = $("#txtCostoTrabajo").val();
  var data = { MATERIAL: tipo_papel };
  var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/cotizaciones/get_costo_material.php", data);
  if(response[0].RESULT){
    console.log(response[0].DATA);
    var suma_costos = parseFloat($("#txtPrecioUnitario").val());
    for(var i = 0; i < response[0].DATA.length; i ++){
        suma_costos = suma_costos + parseFloat(response[0].DATA[i].MAT_CSTUNTR);
    }
    costo_trabajo = suma_costos * cantidad;
    $("#txtPrecioUnitario").val(suma_costos.toFixed(2));
    $("#txtCostoTrabajo").val(costo_trabajo.toFixed(2));
  }
}

function getmaterial(id_material){
  $(".list-group-item").removeClass("active");
  var lst = "#lstMaterial_"+id_material;
  $(lst).addClass("active");
  $("#divConfiguracionMaterial").show("fast");
  ID_MATERIAL = id_material;
  cargar_maquinas();
  var data = { ID: id_material };
  var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/cotizaciones/get_material_costeo.php", data);
  if(response[0].RESULT){
    var item = response[0].DATA;
    var lblMaterial = "";
    if(item.TPR_TPDSN == "1"){
      lblMaterial = "Solo diseño.";
      $("#hdAncho").val(item.CDE_MDD_ANCH_1);
      $("#hdAlto").val(item.CDE_MDD_ALT_1);
    } else {
      if(item.CDM_US_PRTD == "0"){
        lblMaterial = "Es Portada de "+item.CDM_PGNS+" páginas";
        $("#hdAncho").val(item.CDE_MDD_ANCH_2);
        $("#hdAlto").val(item.CDE_MDD_ALT_2);
      } else {
        lblMaterial = "Es Interior de "+item.CDM_PGNS+" páginas";
        $("#hdAncho").val(item.CDE_MDD_ANCH_1);
        $("#hdAlto").val(item.CDE_MDD_ALT_1);
      }
    }
    var base = (item.MEP_FORMACION_BASE != null ? item.MEP_FORMACION_BASE : "0" );
    $("#txtBasePliegos").val(base);
    var alto = (item.MEP_FORMACION_ALTO != null ? item.MEP_FORMACION_ALTO : "0" );
    $("#txtAltoPliegos").val(alto);

    $("#lblMaterial").html(lblMaterial);
    $("#hdPaginas").val(item.CDM_PGNS);
    $("#hdTipoPapel").val(item.TPA_IDINTRN);
  } else {
    toastError("Ocurrio un problema. "+response[0].MESSAGE, 'Info', 3);
  }
}

$(".radio_button").click(function(){
  alert("Ocurrio un problema al calcular opciones. Revise configuracion de calculos.");
});

function carga_insumos(tipo_trabajo){
  tablaConceptosAcabados.clear().draw();
  var data = { TIPO_TRABAJO: tipo_trabajo };
  var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/cotizaciones/get_insumos.php", data);
  if(response[0].RESULT){
    var items = response[0].DATA;
    var checked = '';
    for(var i = 0; i < items.length; i++){
      var checked = '';
      if(items[i].CCC_SLCCN == "1")
        checked = 'checked';
      tablaConceptosAcabados.row.add([
          '<input type="checkbox" id="ckPapel" value="'+items[i].CCO_IDINTRN+'" '+checked+'>',
          '<a href="javascript:;" onclick="editarInsumo('+items[i].CCO_IDINTRN+');"">'+items[i].CCO_NMBR+'</a>',
          0,
          items[i].UNI_NMBR,
          items[i].CCO_PRC,
          0,
          ''
      ]).draw();
    }

  } else {
    toastError("Ocurrio un problema, revise configuración.", 'Info', 3);
  }
}

function carga_terminados(tipo_trabajo){
    tablaConceptosTerminados.clear().draw();
    var data = { TIPO_TRABAJO: tipo_trabajo };
    var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/cotizaciones/get_terminados.php", data);
    if(response[0].RESULT){
      var items = response[0].DATA;
      for(var i = 0; i < items.length; i++){
        tablaConceptosTerminados.row.add([
            '<input type="checkbox" id="ckPapel" value="'+items[i].CCO_IDINTRN+'">',
            '<a href="javascript:;" onclick="editarInsumo('+items[i].CCO_IDINTRN+');"">'+items[i].CCO_NMBR+'</a>',
            0,
            items[i].UNI_NMBR,
            items[i].CCO_PRC,
            0,
            ''
        ]).draw();
      }

    } else {
      toastError("Ocurrio un problema, revise configuración.", 'Info', 3);
    }
  }

var alternativas_array = [];
function alternativas(){

  clearCanvas();
  alternativas_array = [];
  if(ID_MATERIAL == 0 ){
    toastError("Por favor seleccione el material.", 'Info', 3);
  } else if($("#cbMaquinaImpresion").val() == 0) {
    toastError("Por favor seleccione la maquina.", 'Info', 3);
  } else {
    $("#modalAlternativas").modal("show");
    var data = { TIPO_PAPEL: $("#hdTipoPapel").val()  }
    tablaAlternativas.clear().draw();
    var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/cotizaciones/getalternativas_impresion.php", data);
    if(response[0].RESULT){
      var datos = response[0].DATA;
      for(var i = 0; i < datos.length; i++){
        //var cuardernillos = parseInt($("#hdPaginas").val()) / parseInt(datos[i].DIVISIONES);
        //cuardernillos = parseInt($("#hdPaginas").val()) / (parseInt($("#txtBasePliegos").val()) * parseInt($("#txtAltoPliegos").val()));
        var pliegos_medida_corte = cuardernillos * parseInt($("#hdCantidad").val()) + parseInt($("#hdExcendente").val());
        var diseno_ancho = parseFloat($("#hdAncho").val()) + parseFloat(datos[i].SOBRA_ANCHO);
        var diseno_alto = parseFloat($("#hdAlto").val()) + parseFloat(datos[i].SOBRA_ALTO);
        var medida_diseno = diseno_ancho.toFixed(2) + " x " + diseno_alto.toFixed(2);

        var area_diseno = parseFloat($("#hdAncho").val()) * parseFloat($("#hdAlto").val());
        var area_medida_extendida = parseFloat(datos[i].ANCHO) * parseFloat(datos[i].ALTO);
        var formas = area_medida_extendida / area_diseno;

        var pos1_1 = parseFloat(datos[i].ANCHO) * parseFloat(datos[i].ALTO);
        var pos1_2 = parseFloat($("#hdAncho").val()) * parseFloat($("#hdAlto").val());
        var pos1 = pos1_1 / pos1_2;
        var pos2_1 =parseFloat(datos[i].ANCHO) * parseFloat(datos[i].ALTO);
        var pos2_2 = parseFloat($("#hdAlto").val()) * parseFloat($("#hdAncho").val());
        var pos2 = pos2_1 / pos2_2;


        if(Math.floor(pos1) < Math.floor(pos2)){
          var ancho_sel =  parseFloat(datos[i].ANCHO);
          var alto_sel =  parseFloat(datos[i].ALTO);
          var canvas_diseno_ancho = diseno_ancho;
          var canvas_diseno_alto = diseno_alto;
          var caben = pos1;
          var desperdicio_ancho = parseFloat(datos[i].ANCHO) % parseFloat($("#hdAncho").val());
          var desperdicio_alto = parseFloat(datos[i].ALTO) % parseFloat($("#hdAlto").val());

        } else {
          var ancho_sel =  parseFloat(datos[i].ALTO);
          var alto_sel =  parseFloat(datos[i].ANCHO);
          var canvas_diseno_ancho = diseno_alto;
          var canvas_diseno_alto = diseno_ancho;
          var caben = pos2;
          var desperdicio_ancho = parseFloat(datos[i].ALTO) % parseFloat($("#hdAncho").val());
          var desperdicio_alto = parseFloat(datos[i].ANCHO) % parseFloat($("#hdAlto").val());
          var desperdicio = desperdicio_ancho * desperdicio_alto;
        }

        var caben = parseInt($("#txtBasePliegos").val()) * parseInt($("#txtAltoPliegos").val());

        var desperdicio = ((area_diseno * caben ) / area_medida_extendida) * 100;
        //var desperdicio = (area_diseno * caben );

        var pliegos_medida_extendida = pliegos_medida_corte / caben;
        var costo_material = parseFloat(datos[i].PRECIO) * pliegos_medida_extendida;

        var paginas_cuadernillo = parseInt($("#hdPaginas").val()) / cuardernillos;
        var item_array =  {
                            "index": i,
                            "pliegos_medida_corte": pliegos_medida_corte,
                            "medida_diseno": medida_diseno,
                            "formas":  parseInt(datos[i].CABE_EXT_ANCHO),
                            "pliegos_medida_extendida": pliegos_medida_extendida,
                            "caben": caben,
                            "precio": parseFloat(datos[i].PRECIO).toFixed(2),
                            "costo_material": parseFloat(costo_material).toFixed(2),
                            "cuardernillos":  Math.floor(cuardernillos),
                            "paginas": parseInt($("#hdPaginas").val()),
                            "paginas_cuadernillo": Math.floor(paginas_cuadernillo),
                            "desperdicio": desperdicio.toFixed(2),
                            "pliego_ancho": ancho_sel,
                            "pliego_alto": alto_sel,
                            "canvas_diseno_ancho": canvas_diseno_ancho,
                            "canvas_diseno_alto": canvas_diseno_alto,
                            "formas": formas
                          };
        alternativas_array.push(item_array);
        tablaAlternativas.row.add([
          '<input type="hidden" id="hdIndexAlt" value="'+i+'">'+parseInt(pliegos_medida_corte),
          medida_diseno,
          parseInt(datos[i].CABE_EXT_ANCHO),
          parseInt(pliegos_medida_extendida),
          parseFloat(datos[i].ANCHO).toFixed(2) + " x " + parseFloat(datos[i].ALTO).toFixed(2),
          Math.floor(caben),
          parseFloat(datos[i].PRECIO).toFixed(2),
          parseInt(desperdicio_ancho),
          parseInt(desperdicio_alto),
          parseFloat(costo_material).toFixed(2),
          ''
        ]).draw();
        tablaAlternativas.order( [ 9, 'asc' ] ).draw();
      }
    } else {
      toastError("Ocurrio un problema, revise configuración.", 'Info', 3);
    }
  }

}

$('#tablaAlternativas tbody').on( 'click', 'tr', function () {
  if ( $(this).hasClass('selected') ) {
      $(this).removeClass('selected');
  }
  else {
    tablaAlternativas.$('tr.selected').removeClass('selected');
      $(this).addClass('selected');
  }
  seleccionAlt($(this).find("#hdIndexAlt").val());
} );

function seleccionAlt(index){
  clearCanvas();
  var canvas = document.getElementById("CanvasPliegos");
  var ctx = canvas.getContext("2d");

  console.log(alternativas_array[index]);
  $("#lblDesperdicio").html(alternativas_array[index].desperdicio+"%");
  $("#lblPaginasMaterial").html(alternativas_array[index].paginas);
  $("#lblPaginasCuadernillo").html(alternativas_array[index].paginas_cuadernillo);
  $("#lblCuadernillosRequeridos").html(alternativas_array[index].cuardernillos);

  var ancho_canvas = (500 / 100) * alternativas_array[index].pliego_ancho;
  var alto_canvas = (300 / 100) * alternativas_array[index].pliego_alto;

  var ancho_canvas_diseno = (500 / 100) * alternativas_array[index].canvas_diseno_ancho;
  var alto_canvas_diseno = (300 / 100) * alternativas_array[index].canvas_diseno_alto;

  var margen_canvas_ancho = (500 - ancho_canvas) / 2;

  if (canvas.getContext) {

    ctx.fillStyle = "rgb(0,0,200)";
    ctx.fillRect (margen_canvas_ancho, 0, ancho_canvas, alto_canvas);


    for(var x = 0; x < $("#txtBasePliegos").val(); x++){
      for(var y = 0; y < $("#txtAltoPliegos").val(); y++){
        if(x==0){
          var p_x = margen_canvas_ancho;
        } else {
          var p_x = margen_canvas_ancho + (ancho_canvas_diseno*x);
        }
          var p_y = (alto_canvas_diseno*y)
          ctx.rect(p_x, p_y, ancho_canvas_diseno, alto_canvas_diseno);
          ctx.fillStyle = "#FFFFFF";
          ctx.fill();
          ctx.lineWidth = 1;
          ctx.strokeStyle = "black";
          ctx.stroke();
      }
    }
  }
}


function clearCanvas(){
  var canvas = document.getElementById("CanvasPliegos");
  var ctx = canvas.getContext("2d");
  ctx.clearRect(0, 0, canvas.width,canvas.height);
  ctx.beginPath();
}

function drawBorder(ctx,xPos, yPos, width, height, thickness = 1)
{
  ctx.fillStyle='#000';
  ctx.fillRect(xPos - (thickness), yPos - (thickness), width + (thickness * 2), height + (thickness * 2));
}

function cargar_maquinas(){
  $("#cbMaquinaImpresion").html("<option value='0'>[Seleccione Maquina]</option>");
  var data = { TINTAS : $("#hdTintas").val(), PAPEL : $("#hdTipoPapel").val() };
  var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/cotizaciones/getmaquinas_cotizacion.php", data);
  if(response[0].RESULT){
    var items = response[0].DATA;
    for (var i = 0 ; i < items.length ; i++) {
      $("#cbMaquinaImpresion").append('<option value="'+items[i].MAQ_IDINTRN+'">'+items[i].MAQ_NMBR+'</option>');
    }
  } else {
    toastError(response[0].MESSAGE, 'Info', 3);
  }
}
