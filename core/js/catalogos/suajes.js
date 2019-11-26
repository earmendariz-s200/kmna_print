var tabla = $('#tablaSuajes').DataTable(settingsTable);

cargar_datos();

function agregar(){
  var data = { };
  var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getnumerosuaje.php", data);
  if(response[0].RESULT){
    $("#hdSuajeId").val(0);
    $("#txtNoSuaje").val(parseInt(response[0].DATA.NUMERO)+1);
    getClientes();
    $("#txtDescripcion").val("");
    $("#cbEstado").val(1);
    $("#txtCosto").val(0);
    $("#txtFormas").val(0);
    $("#txtPlacas").val(0);
    $("#ckActivo").attr('checked', true);
    $("#modalSuajes").modal("show");
  } else {
    toastError(response[0].MESSAGE, 'Error', 3);
  }
}

function cargar_datos(){
  tabla.clear().draw();
  var data = { };
  var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/get_suajes.php", data);
  if(response[0].RESULT){
    var items = response[0].DATA;
    for (var i = 0 ; i < items.length ; i++) {
      var activo = ((items[i].COL_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
      tabla.row.add([
                items[i].SUA_NMRSJ,
                items[i].CLI_RZNSCL,
                items[i].SUA_DSCRPCN,
                items[i].SUA_ESTD,
                "<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editar("+items[i].SUA_IDINTRN+")'><i class='fa fa-edit'></i></a>"
              ]).draw();
    }
  } else {
    toastError(response[0].MESSAGE, 'Error', 3);
  }
}

function editar(id_suaje){
  var data = { ID_SUAJE: id_suaje };
  var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/get_suajes_id.php", data);
  if(response[0].RESULT){
    var item = response[0].DATA;
    $("#hdSuajeId").val(id_suaje);
    $("#txtNoSuaje").val(item.SUA_NMRSJ);
    getClientes();
    setTimeout(function(){ $("#cbClientes").val(item.CLI_IDINTRN); }, 1000);
    $("#txtDescripcion").val(item.SUA_DSCRPCN);
    $("#cbEstado").val(item.SUA_ESTD);
    $("#txtCosto").val(item.SUA_CST);
    $("#txtFormas").val(item.SUA_FRMS);
    $("#txtPlacas").val(item.SUA_PLCS);
    $("#modalSuajes").modal("show");
  } else {
    toastError(response[0].MESSAGE, 'Error', 3);
  }
}


function getClientes(){
  $("#cbClientes").html("");
  var data = { prospecto: "0" };
  var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/clientes/get_clientes.php", data);
  if(response[0].RESULT){
    for(var i = 0; i < response[0].DATA.length; i ++){
      $("#cbClientes").append("<option value='"+response[0].DATA[i].CLI_IDINTRN+"'>"+response[0].DATA[i].CLI_RZNSCL+"</option>");
    }
  } else {
    toastError(response[0].MESSAGE, 'Error', 3);
  }
}

$("#btnGuadar").click(function(){
  var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
  var data = {
              ID: $("#hdSuajeId").val(),
              NUMERO: $("#txtNoSuaje").val(),
              CLIENTE: $("#cbClientes").val(),
              ESTADO: $("#cbEstado").val(),
              DESCRIPCION: $("#txtDescripcion").val(),
              COSTO: $("#txtCosto").val(),
              FORMAS: $("#txtFormas").val(),
              PLACAS: $("#txtPlacas").val(),
              ACTIVO: ACTIVO
            };
  var URL = (($("#hdSuajeId").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/guarda_suajes.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/editar_suaje.php"));
  var response = sendRequest(URL, data);
  if(response[0].RESULT){
    console.log(response);
    cargar_datos()
    $("#modalSuajes").modal("hide");
    toastExito("Datos guardados correctamente.", 'Éxito', 3);
  } else {
    toastError(response[0].MESSAGE, 'Error', 3);
  }
});
