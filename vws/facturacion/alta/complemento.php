<?php 
  session_start();

  if (!is_readable( realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/head.php")) {
    header("Location: ../../../../index.php");
      die(); 
}



  include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/head.php"; 
  include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/header.php";






?>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  




<div class="modal fade text-left" id="modal_documentos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-success white">
            <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-list"></i> Listado de facturas</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              <input type="hidden" name="id_uuid" id="id_uuid">
            </button>
            </div> 
          <div class="modal-body">  
                <table class="table" id="tablaListaDocumentos">
                <thead>
                  <tr>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Importe</th>
                    <th>PDF</th>
                    <th></th> 
                  </tr>
                </thead>
                <tbody> </tbody>
              </table> 
            </div>
            <div class="modal-footer">
            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button> 
            </div> 
          </div>
        </div>
</div>


<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <div class="row match-height">
          <div class="col-xl-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Datos del emisor</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="card-content">


                <div class="card-body">
                    <div class="row">
                      <div class="col-md-4">
                        <label>RFC:</label> 
                        <input type="text" id="txtRFC" disabled="disabled" class="form-control">
                      </div>
                      <div class="col-md-8">
                        <label>Razon Social:</label>
                        <input type="text" id="txtRazonSocial" disabled="disabled" class="form-control">
                      </div>
                    </div>
                    <div class="row" style="margin-top: 10px;" hidden>
                      <div class="col-md-6">
                        <label>Calle:</label>
                        <input type="text" id="txtCalle" disabled="disabled" class="form-control">
                      </div>
                      <div class="col-md-2">
                        <label>Num. Ext.</label>
                        <input type="text" id="txtNumExt" disabled="disabled" class="form-control">
                      </div>
                      <div class="col-md-2">
                        <label>Num. Int.</label>
                        <input type="text" id="txtNumInt" disabled="disabled" class="form-control">
                      </div>
                    </div>
                    <div class="row" style="margin-top: 10px;" hidden>
                      <div class="col-md-4">
                        <label>Colonia:</label>
                        <input type="text" id="txtColonia" disabled="disabled" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label>Localidad:</label>
                        <input type="text" id="txtLocalidad" disabled="disabled" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label>Ciudad:</label>
                        <input type="text" id="txtCiudad" disabled="disabled" class="form-control">
                      </div>
                    </div>
                    <div class="row" style="margin-top: 10px;" hidden>
                      <div class="col-md-4">
                        <label>Estado:</label>
                        <input type="text" id="txtEstado" disabled="disabled" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label>Pais:</label>
                        <input type="text" id="txtPais" disabled="disabled" class="form-control">
                      </div>

                      <div class="col-md-4">
                        <label>Codigo Postal:</label>
                        <input type="text" id="txtCP" disabled="disabled" class="form-control">
                      </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                      <div class="col-md-6">
                        <label>Regimen Fiscal:</label>
                        <select id="cbRegimenFiscal" class="form-control"> 
                          <option value="601">General de Ley Personas Morales</option>                  </select>
                        <!-- <input type="text" id="txtRegimenFiscal" class="form-control" value="REGIMEN GENERAL PARA PERSONA MORAL"> -->
                      </div>
                    </div>                  
                </div>

              </div>



            </div>
          </div>
        </div>



        <div class="row match-height">
          <div class="col-xl-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Datos del Receptor</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="card-content">  
                <div class="card-body"> 
                    <div class="row">
                      <div class="col-md-6">
                        <label>Cliente:</label>
                        <select id="cbClientes" class="form-control"> 
                         
                         </select> 
                      </div>
                    </div>                  
                </div>

              </div> 

            </div>
          </div>
        </div>
 
 

         <div class="row match-height">
          <div class="col-xl-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Datos de Factura</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>

                <input type="hidden" name="hdCotizacion"  id="hdCotizacion" value="125">
              </div>
              
              <div class="card-content">

                <div class="card-body">
                           
                      <div class="row" style="margin-top: 10px;">
                        <div class="col-md-2">
                          <label>Fecha</label>
                          <input type="date" class="form-control" id="txtFechaPago" value="<?php echo date('Y-m-d') ; ?>">
                        </div>
                       <div class="col-md-3">
                          <label>Forma Pago:</label>
                          <select id="cbFormaPago" class="form-control">
                            
                          </select>
                        </div>

                        <div class="col-md-2">
                          <label>Moneda:</label>
                          <select id="cbMoneda" class="form-control">
                          </select>
                        </div>


                        <div class="col-md-2">
                          <label>Monto:</label>
                          <input type="numeric" id="txtMonto" class="form-control" value="0">
                        </div> 


                      </div>
                     
                    


                      <div class="row" style="margin-top: 10px;">
                          <div class="col-sm-12">
                              <a class="btn btn-success pull-right" onclick="agregar_doc()" ><i class="fa fa-plus"></i> Agregar otro documento </a>
                          </div>
                      </div> 
                                   
                </div>
  
              </div> 


              <div class="card-content">
                <div class="card-body">

                    <table id="tabla_conceptos" class="table table-striped table-bordered" style="font-size: .8em;">
                        <thead> 
                          <th width="15%">UUID</th>
                          <th width="10%">Folio</th>
                          <th width="10%">Moneda</th>
                          <th width="10%">Metodo de pago</th>
                          <th width="10%">Saldo</th>
                          <th width="10%">Importe a pagar</th>
                          <th width="10%">Saldo insoluto</th>
                          <th width="8%"></th>
                        </thead>
                          <tbody>
                             
 

                          </tbody>
                        </table>

                            
                        <div class="row" style="margin-top: 10px;">
                          <div class="col-md-8 pull-right">
                            <button class="btn btn-primary btn-lg" id="btnFacturarS200" style="float: right;">Facturar</button>
                          </div>
                          <div class="col-md-4">
                            <table class="table table-striped">
                              <tbody>
                                <tr>
                                  <td><b>Subtotal</b></td>
                                  <td><span id="lblSubtotal">$ 14450.00</span></td>
                                </tr>
                                <tr>
                                  <td><b>IVA</b></td>
                                  <td><span id="lblIVA">$ 2312.00</span></td>
                                </tr>
                                <tr>
                                  <td><b>Total</b></td>
                                  <td><b><span id="lblTotal">$ 16762.00</span></b></td>
                                </tr>
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

<?php include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/footer.php"; ?>


  <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/util.js"></script> 
   <script src="<?php echo $URL_PRINCIPAL; ?>/assets/js/scripts/dropzone.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/facturacion/pagos.js"></script> 

 
