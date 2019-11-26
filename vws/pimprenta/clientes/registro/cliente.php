<?php
session_start();
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/head.php";
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/header.php";


$id_cliente = 0;
$cli_nombre = "";
$cli_rfc = "";
$cli_razon_social ="";
$cli_tipo = "";
$cli_contacto = "";
$cli_mercados = "";
$cli_activo ="";
$cli_calle = "";
$cli_cp = "";
$cli_numext = "";
$cli_numint = "";

$credito_activo = "";
$estatus_credito = 2;
$limite_credito = 0;




$consumos_visible = "hidden";
$sucursales_visible = "hidden";
$contactos_visible = "hidden";

if (isset($_GET["v"])) {
      $id_cliente = $_GET["v"];
      $id_cliente = base64_decode($id_cliente);


    $db->query('SELECT * FROM CLIENTES WHERE CLI_IDINTRN='.$id_cliente);
    $row_cliente = $db->fetch();

    $cli_nombre = $row_cliente[0]["CLI_NMCR"];
    $cli_rfc = $row_cliente[0]["CLI_RFC"];
    $cli_razon_social = $row_cliente[0]["CLI_RZNSCL"];
    $cli_tipo = $row_cliente[0]["TIPOS_CLIENTES_TIC_IDINTRN"];
    $cli_contacto = $row_cliente[0]["FORMAS_CONTACTO_FRC_IDINTRN"];
    $cli_mercados = $row_cliente[0]["cli_mercados"];
    $cli_activo = $row_cliente[0]["CLI_ACTV"];
    $cli_calle = $row_cliente[0]["CLI_CLL"];
    $cli_cp = $row_cliente[0]["CLI_CDGPSTL"];
    $cli_numext = $row_cliente[0]["CLI_NMREXTRR"];
    $cli_numint = $row_cliente[0]["CLI_NMRINTRN"];
    $cli_forma_pago =  $row_cliente[0]["CONDICIONES_CPA_IDINTRN"];
    $estatus_credito = $row_cliente[0]["CLI_ESTTS_CRDT"];

    if ($row_cliente[0]["CLI_CRDT_CTV"] > 0) {
      $credito_activo = "checked";
    }

    $limite_credito = $row_cliente[0]["CLI_LMT_CRDT"];

    $consumos_visible = "";
    $sucursales_visible = "";
    $contactos_visible = "";



    $db->query("SELECT
                USR_IDINTRN,
                CONCAT(USR_NMBR,' ',USR_APLLDPTRN,' ',USR_APLLDMTRN) AS NOMBRE,
                USR_ACTV,
                USR_PRVLGS
              FROM
                USUARIOS
              WHERE USR_IDINTRN = ".$_SESSION["USR_IDINTRN"]);
    $row_user = $db->fetch();



    $user_privilegio = $row_user[0]["USR_PRVLGS"];
    $panel_visible = "display: none;";

    if ($user_privilegio > 0) {
      $panel_visible = "display: block;";
    }


}











?>



<link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/vendors/css/extensions/raty/jquery.raty.css">
<style type="text/css">
   .inpError {
     border: 1px solid #ff0a0a !important;
   }

</style>
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
      <div class="row match-height">




        <div class="col-lg-3 col-md-3">
          <div class="card" >
            <div class="card-header">
              <h4 class="card-title"><?php echo $cli_nombre; ?></h4>
              <a class="heading-elements-toggle"><i class="fa fa-ellipsis font-medium-3"></i></a>
                  <div class="heading-elements">

              </div>
            </div>
            <div class="card-content collapse show">
              <div class="card-body">
                <div class="list-group">
                  <a href="#" class="list-group-item list-group-item-action" onclick="menu_visible(1)"><i class="fa fa-user-circle menu-icon" aria-hidden="true"></i> Perfil  </a>
                  <a href="#"  class="list-group-item list-group-item-action" onclick="menu_visible(2)" style="<?php echo $panel_visible; ?>"><i class="fa fa-line-chart menu-icon" aria-hidden="true"></i>  Historial crediticio</a>
                  <a href="# " <?php echo $consumos_visible; ?> class="list-group-item list-group-item-action" onclick="menu_visible(4)"> <i class="fa fa-file-text menu-icon" aria-hidden="true"></i> Consumos</a>


                </div>
              </div>
            </div>
          </div>
        </div>

        <!--//tab_perfil
        //tab_credito
        //tab_consumos
        //tab_otros-->

        <div class="col-xl-9 col-lg-9" id="tab_perfil">
          <div class="card" style="height: 307px;">
            <div class="card-header">
              <h4 class="card-title">Perfil</h4>
            </div>
            <div class="card-content">
              <div class="card-body">

                <ul class="nav nav-tabs nav-justified">
                  <li class="nav-item">
                    <a class="nav-link active show" id="clientes-tab" data-toggle="tab" href="#clientes" aria-controls="clientes" role="tab" aria-selected="true">Datos de cliente</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" <?php echo $sucursales_visible; ?> id="sucursales-tab" data-toggle="tab" href="#sucursales" aria-controls="sucursales" role="tab" aria-selected="false">Sucursales</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link"  <?php echo $contactos_visible; ?>  id="contactos-tab" data-toggle="tab" href="#contactos" aria-controls="contactos">Contactos</a>
                  </li>
                </ul>
                <div class="tab-content px-1 pt-1">
                  <div class="tab-pane in active show" id="clientes" aria-labelledby="clientes-tab" role="tab" aria-selected="true">

                    <form class="form" id="form_cliente">

                      <input type="hidden" id="hd_id_cliente" value="<?php echo $id_cliente; ?>">


                      <div class="form-body">
                        <h4 class="form-section"><i class="ft-user"></i> Datos generales</h4>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="projectinput1">Nombre</label>
                              <input type="text" id="cli_nombre" class="form-control requerido" placeholder="Nombre " value="<?php echo $cli_nombre; ?>">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="projectinput2">RFC</label>
                              <input type="text" id="cli_rfc" class="form-control requerido" maxlength="13" onblur="check_rfc(this.value,this)" value="<?php echo $cli_rfc; ?>" >
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="projectinput1">Razon social</label>
                              <input type="text" id="cli_razon_social" class="form-control" placeholder="Razon social" value="<?php echo $cli_razon_social; ?>" >
                            </div>
                          </div>

                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="projectinput5">Tipo cliente</label>
                              <select id="cli_tipo"   class="form-control requerido">
                                  <?php
                                      $db->query('SELECT * FROM TIPOS_CLIENTES WHERE TIC_ACTV=1');
                                      $rows = $db->fetch();
                                      foreach($rows as $row => $value){
                                        if ($cli_tipo == $value["TIC_IDINTRN"]) {
                                        echo '<option value="'.$value["TIC_IDINTRN"].'" selected>'.$value["TIC_NMBR"].'</option>';
                                        }else{
                                         echo '<option value="'.$value["TIC_IDINTRN"].'">'.$value["TIC_NMBR"].'</option>';
                                        }
                                      }
                                  ?>
                              </select>
                            </div>
                          </div>



                        </div>


                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cli_contacto">Forma de contacto</label>
                                <select id="cli_contacto"   class="form-control requerido">

                                   <option value="0">[Selecciona Forma de Contacto]</option>
                                   <?php
                                      $db->query('SELECT * FROM FORMAS_CONTACTO WHERE FRC_ACTV=1');
                                      $rows = $db->fetch();
                                      foreach($rows as $row => $value){

                                         if ($cli_contacto == $value["FRC_IDINTRN"]) {
                                           echo '<option value="'.$value["FRC_IDINTRN"].'" selected>'.$value["FRC_NMBR"].'</option>';
                                         }else{
                                           echo '<option value="'.$value["FRC_IDINTRN"].'">'.$value["FRC_NMBR"].'</option>';
                                         }

                                      }
                                    ?>
                                </select>
                              </div>
                            </div>
                          </div>

                        <div class="row">
                          <div class="col-md-6">
                             <div class="form-group">
                              <div class="controls">
                                <div class="skin skin-square">
                                  <input type="checkbox"  id="cli_activo" class="required" <?php echo ($cli_activo>0) ? "checked":" "; ?> >
                                  <label for="cli_activo">Cliente activo</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                             <div class="form-group">
                              <div class="controls">
                                <div class="skin skin-square">
                                   <label >Antigüedad</label><strong><p class="text-capitalize" style="font-size: 1.3rem;" id="cli_antiguedad"> <?php echo $cli_antiguedad; ?> </p> </strong>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <h4 class="form-section"><i class="fa fa-paperclip"></i> Dirección</h4>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="cli_calle">Dirección</label>
                              <input type="text" id="cli_calle" class="form-control " maxlength="200" placeholder="Calle" value="<?php echo $cli_calle; ?>"  >
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="cli_cp">Código postal</label>
                              <input type="text" id="cli_cp" class="form-control  solo_numero"  maxlength="5" placeholder="Código postal" value="<?php echo $cli_cp; ?>" >
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="cli_numext">Numero exterior</label>
                              <input type="text" id="cli_numext" class="form-control " placeholder="Número exterior" value="<?php echo $cli_numext; ?>"  >
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="cli_numint">Numero interior</label>
                              <input type="text" id="cli_numint" class="form-control" placeholder="Número interior"  value="<?php echo $cli_numint; ?>"   >
                            </div>
                          </div>
                        </div>

                      </div>

                      <div class="form-actions">
                        <button type="button" class="btn btn-warning mr-1">
                          <i class="ft-x"></i> Cancelar
                        </button>
                        <button type="button" class="btn btn-success" id="btnGuardar_cliente">
                          <i class="fa fa-check-square-o"></i> Guardar
                        </button>
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane" id="sucursales" aria-labelledby="sucursales-tab" role="tab" aria-selected="false">

                     <div class="card-content">
                      <div class="card-body">

                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-actions">
                              <button type="button" class="btn btn-primary" onclick="agregar_sucursal()">
                                <i class="fa fa-check-square-o"></i> Nueva sucursal
                              </button>
                            </div>
                          </div>
                        </div>
                        <br/>
                        <div class="row">
                          <div class="col-md-12">
                            <table class="table table-striped table-bordered" style="width: 100% !important;" id="TablaSucursales">
                              <thead>
                                <tr>
                                  <th style="width: 40%;">Nombre</th>
                                  <th style="width: 20%;">Descripción</th>
                                  <th style="width: 15%;">Calle</th>
                                  <th style="width: 10%;">Código postal</th>
                                  <th style="width: 10%;">Activo</th>
                                  <th style="width: 15%;">Acciones</th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                        </div>

                      </div>
                    </div>

                  </div>

                  <div class="tab-pane" id="contactos" aria-labelledby="contactos-tab" role="tab" aria-selected="false">

                     <div class="card-content">
                      <div class="card-body">

                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-actions">
                              <button type="button" class="btn btn-primary" onclick="agregar_contacto()">
                                <i class="fa fa-check-square-o"></i> Nuevo contacto
                              </button>
                            </div>
                          </div>
                        </div>
                        <br/>
                        <div class="row">
                          <div class="col-md-12">
                            <table class="table table-striped table-bordered"  style="width: 100% !important;" id="tablaContacto">
                              <thead>
                                <tr>
                                  <th style="width: 40%;">Nombre Completo</th>
                                  <th style="width: 20%;">Correo</th>
                                  <th style="width: 15%;">Celular</th>
                                  <th style="width: 10%;">Tipo</th>
                                  <th style="width: 10%;">Activo</th>
                                  <th style="width: 15%;">Acciones</th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                        </div>

                      </div>
                    </div>


                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>


       <div class="col-xl-9 col-lg-9" id="tab_credito" style="display: none;">
          <div class="card" style="height: 307px;">
            <div class="card-header">
              <h4 class="card-title">Historial crediticio</h4>

               <input type="hidden" id="hd_rank_credito" value="<?php echo $estatus_credito; ?>">

            </div>
            <div class="card-content">
              <div class="card-body">

                <div class="row">
                  <div class="col-md-4 col-sm-12">
                      <div class="card">
                          <div class="card-content">
                              <div class="card-body">
                                  <h4 class="mb-1">Estatus crediticio</h4>
                                  <div id="credito_ranq"></div>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                       <div class="form-group">
                        <div class="controls">
                          <div class="skin skin-square">
                            <input type="checkbox" value="" id="cli_credito_activo" class="" <?php echo $credito_activo; ?> >
                            <label for="cli_credito_activo">Credito activo</label>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>


                <div class="row">
                   <div class="col-md-6">
                      <div class="form-group">
                        <label for="cli_limite_credito">Limite de credito</label>
                        <input type="text" id="cli_limite_credito" class="form-control" value="<?php echo $limite_credito; ?>" placeholder="0" disabled >
                      </div>
                    </div>

                      <div class="col-md-6">
                            <div class="form-group">
                              <label for="projectinput5">Condiciones de pago</label>
                              <select id="cli_forma_pago"   class="form-control requerido">
                                  <?php
                                      $db->query('SELECT `CPA_IDINTRN`,`CPA_NMBR`FROM CONDICIONES WHERE CPA_ACTV = 1');
                                      $rows = $db->fetch();
                                      foreach($rows as $row => $value){
                                        if ($cli_forma_pago == $value["CPA_IDINTRN"]) {
                                        echo '<option value="'.$value["CPA_IDINTRN"].'" selected>'.$value["CPA_NMBR"].'</option>';
                                        }else{
                                         echo '<option value="'.$value["CPA_IDINTRN"].'">'.$value["CPA_NMBR"].'</option>';
                                        }
                                      }
                                  ?>
                              </select>
                            </div>
                          </div>


                </div>


                  <div class="row">
                   <div class="col-md-6">
                      <button type="button" class="btn btn-success" id="btnGuardar_crediticio">
                          <i class="fa fa-check-square-o"></i> Guardar
                        </button>
                    </div>
                </div>






              </div>
            </div>
          </div>
      </div>

      </div>

    </div>
  </div>
</div>




<div class="modal fade text-left" id="modalSucursal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Regristro de sucursales</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form class="form" id="form_sucursales">
            <input type="hidden" id="hdSucursalID" value="0">
            <div class="row">
              <div class="col-sm-8">
                <label>Nombre:</label>
                <input type="text" id="suc_nombre" class="form-control requerido">
              </div>

              <div class="col-sm-4">
                <label>Folio Microsip:</label>
                <input type="text" id="suc_folio" class="form-control" value='0'>
              </div>

            </div>
            <div class="row" style="margin-top: 10px;">
              <div class="col-sm-12">
                <label>Descripción:</label>
                <textarea class="form-control requerido" cols="6" rows="4" id="suc_descripcion"></textarea>
              </div>
            </div>

            <div class="row" style="margin-top: 10px;">
              <div class="col-sm-12">
                <label>Calle:</label>
                <input type="text" id="suc_calle" class="form-control requerido">
              </div>

            </div>

            <div class="row" style="margin-top: 10px;">
              <div class="col-sm-6">
                <label>Numero interior:</label>
                <input type="text" id="suc_numint" class="form-control">
              </div>

              <div class="col-sm-6">
                <label>Numero exterior:</label>
                <input type="text" id="suc_numext" class="form-control requerido">
              </div>
            </div>

            <div class="row" style="margin-top: 10px;">
              <div class="col-sm-6">
                <label>Código postal:</label>
                <input type="text" id="suc_codigopostal" class="form-control requerido solo_numero">
              </div>

            </div>

             <div class="row" style="margin-top: 10px;">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="suc_mercado">Mercado</label>
                  <select id="suc_mercado"   class="form-control requerido">
                      <option value="0">[Selecciona el Mercado]</option>
                       <?php
                          $db->query('SELECT * FROM MERCADOS WHERE MER_ACTV=1');
                          $rows = $db->fetch();
                          foreach($rows as $row => $value){
                               echo '<option value="'.$value["MER_IDMRCD"].'" selected>'.$value["MER_NMBR"].'</option>';
                          }
                        ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="row" style="margin-top: 10px;">
              <div class="col-sm-6">
                <label><input type="checkbox" id="suc_activo" checked="checked"> Activo</label>
              </div>
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-outline-primary" id="btnGuadar_sucursal">Guardar</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade text-left" id="modalContactos" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Regristro de contactos</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form" id="form_contactos">

          <input type="hidden" id="hdContactoID" value="0">
          <div class="row">
            <div class="col-sm-12">
              <label>Nombre:</label>
              <input type="text" id="cont_nombre" class="form-control requerido">
            </div>
          </div>

          <div class="row" style="margin-top: 10px;">
            <div class="col-sm-6">
              <label>Apellido paterno:</label>
              <input type="text" id="cont_apellidop" class="form-control requerido">
            </div>

            <div class="col-sm-6">
              <label>Apellido materno:</label>
              <input type="text" id="cont_apellidom" class="form-control">
            </div>
          </div>


          <div class="row" style="margin-top: 10px;">
            <div class="col-sm-6">
              <label>Correo:</label>
              <input type="text" id="cont_correo" class="form-control requerido es_correo">
            </div>


          </div>

          <div class="row" style="margin-top: 10px;">
            <div class="col-sm-6">
              <label>Celular:</label>
              <input type="text" id="cont_celular" class="form-control requerido solo_numero">
            </div>

            <div class="col-sm-6">
              <label>Telefono:</label>
              <input type="text" id="cont_telefono" class="form-control solo_numero">
            </div>
          </div>

           <div class="row" style="margin-top: 10px;">


             <div class="col-md-6">
              <div class="form-group">
                <label for="cont_tipocontacto">Tipo de contacto</label>
                <select id="cont_tipocontacto"   class="form-control requerido">
                  <option value="1">Contacto de matriz</option>
                  <option value="2">Contacto de sucursal</option>
                </select>
              </div>
            </div>


            <div class="col-md-6">
              <div class="form-group">
                <label for="cont_sucursales">Sucursales</label>
                <select id="cont_sucursales"   class="form-control">
                     <option value="0">[MATRIZ]</option>
                     <?php
                        $db->query('SELECT * FROM SUCURSALES WHERE SUC_ACTV=1 AND CLIENTES_CLI_IDINTRN = '.$id_cliente);
                        $rows = $db->fetch();
                        foreach($rows as $row => $value){
                             echo '<option value="'.$value["SUC_IDINTRN"].'" selected>'.$value["SUC_NMBR"].'</option>';
                        }
                      ?>
                </select>
              </div>
            </div>

          </div>

        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-6">
            <label><input type="checkbox" id="cont_activo" checked="checked"> Activo</label>
          </div>
        </div>


       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-outline-primary" id="btnGuadar_contacto">Guardar</button>
      </div>

    </div>
  </div>
</div>


<?php include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/footer.php"; ?>
  <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/util.js"></script>
  <script src="<?php echo $URL_PRINCIPAL; ?>assets/vendors/js/extensions/jquery.raty.js"></script>
  <script type="text/javascript"src="<?php echo $URL_PRINCIPAL; ?>assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
  <script src="<?php echo $URL_PRINCIPAL; ?>assets/js/scripts/extensions/rating.js"></script>

  <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/clientes/clientes_sec.js"></script>








  <script type="text/javascript">


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


      function menu_visible(n){

        switch(n) {
            case 1:
                 $("#tab_perfil").show("slow");
                 $("#tab_credito").hide("slow");
                break;
            case 2:
                $("#tab_perfil").hide("slow");
                 $("#tab_credito").show("slow");
                 carga_historial_credito();
                break;

            case 3:

                break;
            default:

        }

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






  </script>
