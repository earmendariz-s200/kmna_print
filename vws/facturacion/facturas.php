<?php
// Obtenemos el id de facturas
$id = $_GET['id'];
 
session_start();

if (!is_readable( realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/head.php")) {
    header("Location: ../../../../index.php");
      die(); 
}


include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/head.php"; 
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/header.php";



?>







<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <input type="hidden" name="hd_tipo" id="hd_tipo" value="<?php echo $id; ?>">
    <div class="content-body">
      <div class="row match-height">
        <div class="col-xl-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <div class="col-sm-10">
                <h3 class="card-title">Nuevas facturas</h3>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a> 
              </div> 
              <div class="pull-left col-sm-2">
                  <a class="btn btn-success" href="../alta/complemento.php" ><i class="fa fa-plus"></i> Registrar complemento de pago</a>
              </div>


            </div>
            <div class="card-content"> 
              <div class="card-body"> 
                <table class="table table-striped table-bordered" id="tablaListado">
                  <thead>
                    <tr>  
                      <th style="width: 15%;">Folio</th>
                       <th style="width: 15%;">Total</th>
                      <th style="width: 15%;">Cotización</th>
                      <th style="width: 15%;">Fecha</th>  
                      <th style="width: 15%;">Cliente</th>  
                      <th style="width: 15%;">PDF</th>  
                      <th style="width: 15%;">XML</th> 
                       <th style="width: 15%;">Opciones</th> 
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




<div class="modal fade text-left" id="modalComplementos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-success white">
            <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-list"></i> Listado de complementos</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
           
          <div class="modal-body"> 
                
                <table class="table" id="tablaListaPagos">
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>Importe</th>
                    <th>PDF</th>
                    <th>XML</th>
                    <th>Enviar</th>
                     <th></th>
                  </tr>
                </thead>
                <tbody>Aún no existen pagos registrados</tbody>
              </table>
              
             
            </div>
            <div class="modal-footer">
            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>

            </div>
           
          </div>
        </div>
</div>


 



<div class="modal fade text-left" id="modalCorreo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" aria-hidden="true">
    <div class="modal-dialog " role="document">
    <div class="modal-content ">
      <div class="modal-header bg-success white">
      <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-envelope"></i> Enviar correo</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
       <input type="hidden" id="hd_factura_correo" value="0">
       <input type="hidden" id="hd_input_complemento" value="0">

      <div class="modal-body"> 
        <div class="row">
          <div class="col-md-12">
            <label>Para:</label>
            <input type="email" id="txtEmail" class="form-control" placeholder="Correo Electrónico" value="">
          </div>
          <div class="col-md-12">
            <label>CC:</label>
            <input type="email" id="txtEmailCC" class="form-control" placeholder="Con copia para (Correo Electrónico)">
          </div>
          <div class="col-md-12">
            <label>Mensaje:</label>
            <textarea class="form-control" rows="4" cols="6" id="txtMensaje">Por medio de este correo electronico le hacemos llegar su factura. Muchas gracias por todo. Saludos!</textarea>
          </div>
        </div> 
       
      </div>
      <div class="modal-footer">
      <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
      <button type="button"  id="btn_enviar_factura" class="btn btn-outline-success">Enviar</button>
      </div> 
    </div>
  </div>
</div>

 


<div class="modal fade text-left" id="modalNuevoComplemento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success white">
      <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-list-alt"></i> Nuevo complemento</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      
      <input type="hidden" id="hd_factura_complemento" value="">
      <input type="hidden" id="hd_UUID" value="">

       <div class="modal-body">
          <div class="row">
            <div class="col-md-4">CP de Expedición:</div>
            <div class="col-md-4"><input type="text" class="form-control" id="txtCPExpedicionPago" value=""></div>
          </div>
          <div class="row" style="margin-top: 10px;">
            <div class="col-md-4">Fecha de pago:</div>
            <div class="col-md-4"><input type="date" class="form-control" id="txtFechaPago" value="<?php echo date('Y-m-d') ; ?>"></div>
            <div class="col-md-4"><input type="time" class="form-control" id="txtHoraPago"  value="<?php echo date('H:i:s') ; ?>"></div>
          </div>
          <div class="row" style="margin-top: 10px;">
            <div class="col-md-4">Forma de pago:</div>
            <div class="col-md-4">
              <select id="cbFormaPago" class="form-control">
              
              </select>
            </div>
          </div>
          <div class="row" style="margin-top: 10px;">
            <div class="col-md-4">Importe: $</div>
            <div class="col-md-4"><input type="number" min="0" step="0.01" class="form-control" id="txtImportePago" value="0.00"></div>
          </div>
          <div class="row" style="margin-top: 10px;">
            <div class="col-md-4">Moneda:</div>
            <div class="col-md-4">
              <select id="cbMoneda" class="form-control">
              </select>
            </div>
          </div>


        </div>

        <div class="modal-footer">
        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn_complemento" class="btn btn-outline-success">Realizar complemento</button>
        </div> 

       
      </div>
      
  </div>
</div>




  
<?php include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/footer.php"; ?>
  <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/util.js"></script> 
   <script src="<?php echo $URL_PRINCIPAL; ?>/assets/js/scripts/dropzone.js"></script>
 <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/facturacion/listado_facturas.js"></script>

 
