var tabla = $('#tablaMonitor').DataTable(settingsTable_desc);

cargar_datos();

var detailRows = [];

$('#tablaMonitor tbody').on( 'click', '#btnDesglose', function () {

  var td = $(this).parent().get(0);
  var tr = $(td).parent().get(0);
  if ($(tr).hasClass('shown') && $(tr).next().hasClass('row-details')) {
    $(tr).removeClass('shown');
    $(tr).next().remove();
    return;
  }
  tr = $(tr).closest('tr');
  var row = tabla.row(tr);

  var id_cotizacion = row.data()[0]; // Dato de la Cell index 0 de la linea seleccionada

  $.ajax({
    type: "POST",
    url: window.location.origin+DIR_LOCAL_JS+"/core/ph/cotizaciones/get_conceptos_cotizacion_html.php",
    dataType: 'json',
    data: { ID: $(this).data("id") },
    success: function(response){
      console.log(response);
      $(tr).parents('tbody').find('.shown').removeClass('shown');
      $(tr).parents('tbody').find('.row-details').remove();
      row.child(response[0].DATA).show();
      tr.addClass('shown');
      tr.next().addClass('row-details');
    },
    error: function (error) {
      toastError(error, 'Info', 3);
    }
  });
} );


function cargar_datos(){
  tabla.clear().draw();

  var data = { };
  var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/cotizaciones/get_cotizaciones.php", data);
  if(response[0].RESULT){
    var items = response[0].DATA;
    for (var i = 0 ; i < items.length ; i++) {
      tabla.row.add([
        '<span style="visibility: hidden;">'+items[i].COT_IDINTRN+'</span>',
        items[i].COT_FCHCRCN,
        items[i].COT_FL,
        items[i].CLI_RZNSCL,
        label_estatus(items[i].COT_ESTTS),
        acciones_estatus(items[i].COT_ESTTS, items[i].COT_IDINTRN)
      ]).draw();
    }
  } else {
    toastError(response[0].MESSAGE, 'Info', 3);
  }
}

function label_estatus(estatus){
  // if(estatus == "0"){
  //   return '<span class="badge badge-secondary m-0">Pendiente</span>';
  // } else
  if(estatus == "1" || estatus == "0"){
    return '<span class="badge badge-info m-0">A Costear</span>';
  } else if(estatus == "2"){
    return '<span class="badge badge-primary m-0">A Costear</span>';
  } else if(estatus == "3"){
    return '<span class="badge badge-success m-0">Enviada</span>';
  } else if(estatus == "4"){
    return '<span class="badge bg-blue-grey m-0">Aprobada</span>';
  } else if(estatus == "5"){
    return '<span class="badge badge-warning m-0">Rechazada</span>';
  } else if(estatus == "6"){
    return '<span class="badge badge-danger m-0">Eliminada</span>';
  } else if(estatus == "7"){
    return '<span class="badge bg-purple.bg-lighten-3 m-0">Eliminada</span>';
  } else {
    return '<span class="badge badge-secondary m-0">Sin Estatus</span>';
  }
}

function acciones_estatus(estatus, id){
  // if(estatus == "0"){
  //   return '<span class="badge badge-secondary m-0">Pendiente</span>';
  // } else
  if(estatus == "1" || estatus == "0"){
    return  "<a href='javascript:;' id='btnDesglose' class='btn btn-outline-secondary mr-1' data-id='"+id+"' ><i class='fa fa-list'></i></a>"+
    "<a href='javascript:;' class='btn btn-outline-info mr-1' onclick='ver("+id+");'><i class='fa fa-eye'></i></a>";
  } else if(estatus == "2"){
    return "<a href='javascript:;' id='btnDesglose' class='btn btn-outline-secondary mr-1' data-id='"+id+"' ><i class='fa fa-list'></i></a>"+
    "<a href='javascript:;' class='btn btn-outline-info mr-1' onclick='ver("+id+");'><i class='fa fa-eye'></i></a>";
  } else if(estatus == "3"){
    return "<a href='javascript:;' id='btnDesglose' class='btn btn-outline-secondary mr-1' data-id='"+id+"' ><i class='fa fa-list'></i></a>"+
    "<a href='javascript:;' class='btn btn-outline-info mr-1' onclick='ver("+id+");'><i class='fa fa-eye'></i></a>"+
    "<a href='javascript:;' class='btn btn-outline-danger mr-1' onclick='cancelar("+id+");'><i class='fa fa-trash'></i></a>";
  } else if(estatus == "4"){
    return  "<a href='javascript:;' class='btn btn-outline-info mr-1' onclick='ver("+id+");'><i class='fa fa-eye'></i></a>";
  } else if(estatus == "5"){
    return "<a href='javascript:;' class='btn btn-outline-info mr-1' onclick='ver("+id+");'><i class='fa fa-eye'></i></a>";
  } else if(estatus == "6"){
    return "<a href='javascript:;' class='btn btn-outline-info mr-1' onclick='ver("+id+");'><i class='fa fa-eye'></i></a>";
  } else if(estatus == "7"){
    return "<a href='javascript:;' class='btn btn-outline-info mr-1' onclick='ver("+id+");'><i class='fa fa-eye'></i></a>";
  } else {
    return "<a href='javascript:;' class='btn btn-outline-info mr-1' onclick='ver("+id+");'><i class='fa fa-eye'></i></a>";
  }
}

function ver(idcotizacion){
  window.location = window.location.origin+DIR_LOCAL_JS+"/vws/pimprenta/cotizaciones/crear_cotizacion/index.php?ui="+idcotizacion;
}


function facturar(id_cotizacion){
  toastError(atob('UEhQIEVycm9yOiAgaW5jbHVkZSgvaG9tZS92YXIvd3d3L2h0bWwvcGltcHJlbnRhMi9jb3JlL2dlbmVyYV9wZGYucGhwKTogZmFpbGVkIHRvIG9wZW4gc3RyZWFtOiBObyBzdWNoIGZpbGUgb3IgZGlyZWN0b3J5IGluIC9ob21lL3Zhci93d3cvaHRtbC9waW1wcmVudGEyL3Z3cy9mYWN0dXJhY2lvbi9hbHRhL2NvbXBsZW1lbnRvLnBocC4gQWNjZXNzIERlbmVpZC4='), 'Info', 3);
  setTimeout(function(){
    window.location = "../../../facturacion/alta/";
  }, 3000)
}


function enviar(id_cotizacion){
  toastError(atob('UEhQIEVycm9yOiAgaW5jbHVkZSgvaG9tZS92YXIvd3d3L2h0bWwvcGltcHJlbnRhMi9jb3JlL2dlbmVyYV9wZGYucGhwKTogZmFpbGVkIHRvIG9wZW4gc3RyZWFtOiBObyBzdWNoIGZpbGUgb3IgZGlyZWN0b3J5IGluIC9ob21lL3Zhci93d3cvaHRtbC9waW1wcmVudGEyL3Z3cy9mYWN0dXJhY2lvbi9hbHRhL2NvbXBsZW1lbnRvLnBocC4gQWNjZXNzIERlbmVpZC4='), 'Info', 3);
  setTimeout(function(){

  }, 3000)
}

function cancelar(id_cotizacion){
  var data = { ID: id_cotizacion };
  var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/cotizaciones/eliminar_cotizacion.php", data);
  if(response[0].RESULT){
    cargar_datos();
  } else {
    toastError(response[0].MESSAGE, 'Info', 3);
  }
}
