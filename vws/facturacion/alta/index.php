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
                    <div class="row" style="margin-top: 10px;">
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
                    <div class="row" style="margin-top: 10px;">
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
                    <div class="row" style="margin-top: 10px;">
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
                <h4 class="card-title">Datos del cliente</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>
              
              <div class="card-content">

 
                <div class="card-body"> 


                    <div class="row">
                      <div class="col-md-4">
                        <label>RFC:</label>
                        <input type="text" id="txtRFC_c" disabled="disabled" class="form-control" value="SDS180413271">
                      </div>
                      <div class="col-md-8">
                        <label>Razon Social:</label>
                        <input type="text" id="txtRazonSocial_c" disabled="disabled" class="form-control" value="">
                      </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                      <div class="col-md-6">
                        <label>Calle:</label>
                        <input type="text" id="txtCalle_c" class="form-control" value="">
                      </div>
                      <div class="col-md-2">
                        <label>Num. Ext.</label>
                        <input type="text" id="txtNumExt_c" class="form-control" value="">
                      </div>
                      <div class="col-md-2">
                        <label>Num. Int.</label>
                        <input type="text" id="txtNumInt_c" class="form-control">
                      </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                      <div class="col-md-4">
                        <label>Colonia:</label>
                        <input type="text" id="txtColonia_c" class="form-control" value="">
                      </div>
                      <div class="col-md-4">
                        <label>Localidad:</label>
                        <input type="text" id="txtLocalidad_c" class="form-control" value="">
                      </div>
                      <div class="col-md-4">
                        <label>Ciudad:</label>
                        <input type="text" id="txtCiudad_c" class="form-control" value="">
                      </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                      <div class="col-md-4">
                        <label>Estado:</label>
                        <input type="text" id="txtEstado_c" class="form-control" value="">
                      </div>
                      <div class="col-md-4">
                        <label>Pais:</label>
                        <input type="text" id="txtPais_c" class="form-control" value="">
                      </div>
                      <div class="col-md-4">
                        <label>Codigo Postal:</label>
                        <input type="text" id="txtCP_c" class="form-control" value="">
                      </div>
                    </div>

                    

                    <div class="row" style="margin-top: 10px">

                      <div class="col-md-4">
                        <label>Uso de CFDI:</label>
                        <select id="cbUsoCFDI" class="form-control">
                        
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
                          <label>Folio</label>
                          <input type="text" id="txtFolio" class="form-control" value="">
                        </div>
                        <div class="col-md-3">
                          <label>Orden de Compra</label>
                          <input type="text" id="txtOrdenCompra" class="form-control" value="">
                        </div>
                      </div>
                     
                      <div class="row" style="margin-top: 10px;">
                        <div class="col-md-3">
                          <label>Método Pago</label>
                          <select id="cbMetodoPago" class="form-control"> 
                           
                          </select>
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
                          <label>Tipo de Cambio:</label>
                          <div class="input-group input-group-sm input-group-minimal">
                            <span class="input-group-addon">
                              <i class="fa fa-dollar"></i>
                            </span>
                            <input type="text" id="txtTipoCambio" class="form-control" value="1.00">
                          </div>
                        </div>

                        <div class="col-md-2">
                          <label>Condiciones de Pago:</label>
                          <input type="text" id="txtCondicionPago" class="form-control" value="CONTADO">
                        </div> 
                      </div> 
                                   
                </div>
  
              </div> 


              <div class="card-content">
                <div class="card-body">

                    <table id="tabla_conceptos" class="table table-striped table-bordered" style="font-size: .8em;">
                        <thead>
                          <th width="1%"></th>
                          <th width="8%">Cantidad</th>
                          <th width="10%">Clave U.</th>
                          <th width="8%">Unidad</th>
                          <th width="29%">Clave Serv.</th>
                          <th width="20%">Concepto</th>
                          <th width="10%">Precio U.</th>
                          <th width="5%">IVA ?</th>
                          <th width="9%">Importe</th>
                        </thead>
                        <tbody>
                            
                                

                          <!--<tr role="row" class="odd">
                              <td class="sorting_1"><input type="hidden" id="id_detalle_cot" value="6674"></td>
                              <td class="txtCantidad6674">1.00</td>
                              <td><select id="cbClvUnidad6674" class="form-control" style="max-width: 80px;"><option value="E48">Unidad de servicio</option><option value="KGM">Kilogramo</option><option value="NT">Tonelada</option><option value="XUN">Unidad</option></select></td>
                              <td><label id="txtUnidad6674">Unidad</label></td>
                              <td>
                              <input type="text" class="form-control cb_autoc ui-autocomplete-input" id="cbClvServicio6674" style="width: 300px; max-width: 350px;" autocomplete="off">

                               </td>
                              <td><label id="txtConcepto6674">REVISTA DE </label></td>
                              <td><input type="text" id="txtPrecioU6674" disabled="" class="form-control" value="1800.00" style="max-width: 80px;"></td>
                              <td><input type="checkbox" id="ckIVA6674" checked="" class="form-control" value="6674"></td>
                              <td><input type="text" id="txtImporte6674" disabled="" class="form-control" value="1800" style="max-width: 80px;"></td>
                            </tr>-->

                            
 

                            </tbody>
                        </table>

                          <div class="row">
                            <div class="col-xs-6"></div>
                            <div class="col-xs-6"></div>
                          </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                          <div class="col-md-8">
                            <button class="btn btn-primary btn-lg" id="btnFacturarS200">Facturar</button>
                          </div>
                          <div class="col-md-4">
                            <table class="table table-striped">
                              <tbody>
                                <tr>
                                  <td><b>Subtotal</b></td>
                                  <td><span id="lblSubtotal">$ 0.00</span></td>
                                </tr>
                                <tr>
                                  <td><b>IVA</b></td>
                                  <td><span id="lblIVA">$ 0.00</span></td>
                                </tr>
                                <tr>
                                  <td><b>Total</b></td>
                                  <td><b><span id="lblTotal">$ 0.00</span></b></td>
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
 <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/facturacion/alta.js"></script> 

 
