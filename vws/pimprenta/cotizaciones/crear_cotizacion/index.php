<?php
session_start();
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/head.php";
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/header.php";
?>
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
      <div class="row match-height">
        <div class="col-sm-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <div class="col-sm-10">
                <h3 class="card-title">Registro de Venta</h3>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="col-sm-2">
                <span class="badge badge-default badge-info m-0"><h3 id="lblEstatusCotizacion">PRE-COTIZACIÓN</h3></span>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body" style="margin-top: -30px;">
                <div class="row">
                  <div class="col-sm-2">
                    <label>Folio:</label>
                    <input type="number" name="txtFolioCotizacion" id="txtFolioCotizacion" class="form-control" disabled="disabled" style="height: 45px;">
                  </div>
                  <div class="col-sm-4"></div>
                  <div class="col-sm-2" style="margin-top: 20px;">
                    <label>Cotización Urgente: <input type="checkbox" name="txtUrgenteCotizacion" id="txtUrgenteCotizacion"></label>
                  </div>
                  <div class="col-sm-2">
                    <label>Fecha:</label>
                    <input type="date" name="txtFechaCotizacion" id="txtFechaCotizacion" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                  </div>
                  <div class="col-sm-2">
                    <label>Valido Hasta:</label>
                    <input type="date" name="txtValidaHasta" id="txtValidaHasta" class="form-control"  value="<?php echo date("Y-m-d", strtotime("+ 1 month ", strtotime("NOW"))); ?>" disabled="disabled">
                  </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                  <div class="col-sm-3">
                    <label>Cliente:</label>
                    <select class="form-control" id="cbClientes" name="cbClientes"></select>
                  </div>
                  <div class="col-sm-1" style="margin-top: 30px;">
                    <a href="<?php echo $_SESSION["DIR_LOCAL"]; ?>/vws/pimprenta/clientes/registro/cliente.php" class="btn btn-success" target="_blank"><i class="fa fa-plus"></i></a>
                    <button type="button" class="btn btn-info" onclick="get_clientes();"><i class="fa fa-refresh"></i></button>
                  </div>
                  <div class="col-sm-3">
                    <label>Atención a:</label>
                    <select class="form-control" id="cbContacto" name="cbContacto">
                      <option value="0">[Seleccione Contacto]</option>
                    </select>
                  </div>
                  <div class="col-sm-1" style="margin-top: 30px;">
                    <a href="<?php echo $_SESSION["DIR_LOCAL"]?>/vws/pimprenta/clientes/registro/cliente.php" class="btn btn-success" id="agregarContacto" target="_blank"><i class="fa fa-plus"></i></a>
                    <button type="button" class="btn btn-info" onclick="get_contactos()"><i class="fa fa-refresh"></i></button>
                  </div>
                  <div class="col-sm-3">
                    <label>Asesor de ventas:</label>
                    <select class="form-control" id="cbVendedor" name="cbVendedor">
                      <option value="0">[Seleccione Asesor]</option>
                    </select>
                  </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                  <div class="col-sm-3">
                    <label>Condición de pago:</label>
                    <select class="form-control" id="cbCondicionPago" name="cbCondicionPago">
                      <option value="0">[Seleccione Condición de Pago]</option>
                    </select>
                  </div>
                  <div class="col-sm-3">
                  </div>
                  <div class="col-sm-6" style="margin-top: 20px;">
                    <button class="btn btn-success" id="btnGuardarCotizacion" style="display: none;">Guardar Cotización</button>
                  </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                  <div class="col-sm-12">
                    <ul class="nav nav-tabs nav-top-border no-hover-bg">
                      <li class="nav-item">
                        <a class="nav-link active" id="base-tab11" data-toggle="tab" aria-controls="tab11"
                        href="#tab11" aria-expanded="true">Trabajos Cotizados</a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" id="base-tab13" data-toggle="tab" aria-controls="tab13" href="#tab13"
                        aria-expanded="false">Observaciones Generales</a>
                      </li>
                    </ul>
                    <div class="tab-content px-1 pt-1">
                      <div role="tabpanel" class="tab-pane active" id="tab11" aria-expanded="true" aria-labelledby="base-tab11">
                       <div class="row" style="margin-bottom: 35px;">
                         <div class="col-sm-2">
                          <button class="btn btn-success" id="btnAgregarDetalle"><i class="fa fa-plus"></i> Agregar detalle</button>
                        </div>
                      </div>
                      <table class="table table-striped table-bordered" id="tablaDetalleCotizacion" >
                        <thead>
                          <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 10%;">Tipo producto</th>
                            <th style="width: 10%;">Es Urgente</th>
                            <th style="width: 50%;">Descripción</th>
                            <th style="width: 10%;">Precio unitario</th>
                            <th style="width: 10%;">Precio Venta</th>
                            <th style="width: 5%;"></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane" id="tab13" aria-labelledby="base-tab13">
                      <div class="row">
                        <div class="col-md-10">
                          <div class="form-group">
                            <label>Capture Observaciones generales:</label>
                            <textarea id="txtObservacionesGenerales" class="form-control" cols="6" rows="4"></textarea>
                          </div>
                        </div>
                        <div class="col-md-8">
                          <button type="button" class="btn btn-success" id="btnAgregarObservaciones">Agregar</button>
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
    </div>
  </div>
</div>
</div>

<div class="modal fade text-left" id="modalDetalle" tabindex="-1" role="dialog" aaria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document" style="min-width: 75%">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detalle de Concepto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hdId" value="<?php echo $_GET["ui"]; ?>">
        <div class="row">
          <div class="col-sm-2">
            <label>Tipo de Producto:</label>
            <select class="form-control" id="cbTipoProductoDetalle" name="cbTipoProductoDetalle" onchange="get_tipodiseno(); generaDescripcion();" style="width: 100%;">
            </select>
          </div>
          <div class="col-sm-2">
            <label>Nombre de Producto:</label>
            <input type="text" id="txtTagDetalle" class="form-control" >
          </div>
          <div class="col-sm-2">
            <label>Cantidad:</label>
            <input type="number" name="txtCantidadDetalle" id="txtCantidadDetalle" class="form-control" value="1" min="1" >
          </div>
          <div class="col-sm-3">
            <label>Trabajo:</label>
            <select id="cbTipoTrabajoDetalle" class="form-control select2" style="width: 100%;">
              <option value="0">Sangrado</option>
              <option value="1">Con margen blanco</option>
            </select>
          </div>
          <div class="col-sm-2">
            <label>Urgente: <input type="checkbox" name="ckUrgenteDetalle" name="ckUrgenteDetalle"></label>
          </div>
        </div>
        <div class="row" style="margin-top: 20px; display: none;" id="div-datos-detalle">
          <input type="hidden" id="hdIdDetalle" value="0" >
          <div class="col-sm-12">
            <ul class="nav nav-tabs nav-top-border no-hover-bg">
              <li class="nav-item">
                <a class="nav-link active" id="base-tab1_1" data-toggle="tab" aria-controls="tab1_1"
                href="#tab1_1" aria-expanded="true">Generales</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="base-tab1_2" data-toggle="tab" aria-controls="tab1_2" href="#tab1_2"
                aria-expanded="false">Materiales</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="base-tab1_3" data-toggle="tab" aria-controls="tab1_3" href="#tab1_3"
                aria-expanded="false">Acabados</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="base-tab1_4" data-toggle="tab" aria-controls="tab1_4" href="#tab1_4"
                aria-expanded="false">Terminados</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="base-tab1_5" data-toggle="tab" aria-controls="tab1_5" href="#tab1_5"
                aria-expanded="false">Observaciones</a>
              </li>
            </ul>
            <div class="tab-content px-1 pt-1" style="min-height: 50px;;">
              <div role="tabpanel" class="tab-pane active" id="tab1_1" aria-expanded="true" aria-labelledby="base-tab1_1" >
                <div class="row">
                  <div class="col-sm-3">
                    <label>Medida de Página en Interior:</label>
                    <!--<select id="cbMedida1" class="form-control" onchange="generaDescripcion();" style="width: 100%;">-->
                    <select class="form-control" id="cbMedida1">
                      <option value="0">Estandar</option>
                      <option value="1">Personalizado</option>
                    </select>
                  </div>
                  <div class="col-sm-3 div_medida1_estandar">
                    <label>Estandar:</label>
                    <select class="form-control" id="cbTamanoPapel1Detalle"></select>
                  </div>
                  <div class="col-sm-3 div_medida1_personalizado" style="display: none;">
                    <label>Ancho:</label>
                    <input type="number" id="txtAncho" class="form-control" value="0" min="0">
                  </div>
                  <div class="col-sm-3 div_medida1_personalizado" style="display: none;">
                    <label>Alto:</label>
                    <input type="number" id="txtAlto" class="form-control" value="0" min="0">
                  </div>
                </div>

                <div class="row" id="div_diseño2" style="display: none; margin-top: 20px;">
                  <div class="col-sm-3">
                    <label>Medida de Página en Portada:</label>
                    <!--<select id="cbMedida2" class="form-control" style="width: 100%;">-->
                    <select class="form-control" id="cbMedida2">
                      <option value="0">Estandar</option>
                      <option value="1">Personalizado</option>
                    </select>
                  </div>
                  <div class="col-sm-3 div_medida2_estandar">
                    <label>Estandar:</label>
                    <select class="form-control" id="cbTamanoPapel2Detalle"></select>
                  </div>
                  <div class="col-sm-3 div_medida2_personalizado" style="display: none;">
                    <label>Ancho:</label>
                    <input type="number" id="txtAncho2" value="0" class="form-control" >
                  </div>
                  <div class="col-sm-3 div_medida2_personalizado" style="display: none;">
                    <label>Alto:</label>
                    <input type="number" id="txtAlto2" value="0" class="form-control" >
                  </div>
                </div>

                <div class="row" style="margin-top: 20px;">
                  <div class="col-sm-3">
                    <label>Orientación del Encuadernado:</label>
                    <select class="form-control" id="cbOrientacionDetalle" style="width: 100%;">
                      <option value="0">Horizontal</option>
                      <option value="1">Vertical</option>
                    </select>
                  </div>
                  <div class="col-sm-3" style="margin-top: 20px;">
                    <button type="button" class="btn btn-primary" id="btnAgregarDetalleGeneral">Agregar</button>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab1_2" aria-labelledby="base-tab1_2">
                <div class="row" id="div_diseno1" style="margin-bottom: 20px; display: none;">
                  <div class="col-sm-2">
                    <label>Diseños:</label>
                    <input type="number" id="txtNumeroDisenos" class="form-control" value="1" step="1" min="1">
                  </div>
                </div>
                <div class="row" id="div-diseno2" style="display: none;">
                  <div class="col-sm-3">
                    <label>Utilizar para: </label>
                    <select id="cbDiseno2Utiliza" class="form-control" style="width: 100%;">
                      <option value="0">Portada</option>
                      <option value="1">Interior</option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <label>Paginas: </label>
                    <input type="number" id="txtDiseno2Paginas" class="form-control" value="4" min="2" step="2">
                  </div>
                  <div class="col-sm-2">
                    <label>Medida como: </label>
                    <select class="form-control" id="cbDiseno2MedidaComo" style="width: 100%;">
                      <option value="0">Página</option>
                      <option value="1">Hoja Simple</option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <label><input type="checkbox" id="ckDiseno2SonIguales"> son iguales</label>
                  </div>
                </div>

                <div class="row" style="margin-top: 15px; margin-bottom: 15px;">
                  <div class="col-sm-4">
                    <label>Tipo de papel:</label>
                    <select class="form-control" id="cbTipoPapelDiseno" style="width: 100%;"></select>
                  </div>
                  <div class="col-sm-2">
                    <label>Gramaje:</label>
                    <select class="form-control" id="cbGramajeDiseno" style="width: 100%;">
                      <option value="0">[Seleccione Gramaje]</option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <label>Tintas frente:</label>
                    <select class="form-control" id="cbTintasFrenteDiseno" style="width: 100%;"></select>
                  </div>
                  <div class="col-sm-2">
                    <label>Tintas vuelta:</label>
                    <select class="form-control" id="cbTintasVueltaDiseno" style="width: 100%;"></select>
                  </div>
                  <div class="col-sm-2" style="margin-top: 20px;">
                    <button class="btn btn-success" type="button" id="btnAgregarMaterial">Agregar</button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="row">
                      <div class="col-sm-4">
                        <input type="checkbox" name="chkMedidaDiferente" id="chkMedidaDiferente">
                        <label for="chkMedidaDiferente">Medida diferente</label>
                      </div>
                      <div class="col-sm-4 medidas hidden">
                        <label>Ancho:</label>
                        <input type="number" class="form-control" name="txtMedidaAncho" id="txtMedidaAncho" value="0.00" />
                      </div>
                      <div class="col-sm-4 medidas hidden">
                        <label>Alto:</label>
                        <input type="number" class="form-control" name="txtMedidaAlto" id="txtMedidaAlto" value="0.00" />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <input type="checkbox" name="chkIdenficarMeterial" id="chkIdenficarMeterial">
                    <label for="chkIdenficarMeterial"> Identificar material</label>
                    <input type="hidden" class="form-control" name="txtIdentificarMaterial" id="txtIdentificarMaterial" />
                  </div>
                </div>
                <br />
                <div id="tablaDetalleM2" style="display: none;">
                  <table class="table table-striped table-bordered" id="tablaDetalleMateriales2">
                  <thead>
                    <tr>
                      <th style="width: 20%;">Utilizar para</th>
                      <th style="width: 10%;">Páginas</th>
                      <th style="width: 30%;">Tipo de papel</th>
                      <th style="width: 10%;">Gramaje</th>
                      <th style="width: 10%;">Tintas frente</th>
                      <th style="width: 10%;">Tintas vuelta</th>
                      <th style="width: 10%;"></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
                </div>
                <div id="tablaDetalleM1" style="display: none;">
                  <table class="table table-striped table-bordered" id="tablaDetalleMateriales1">
                  <thead>
                    <tr>
                      <th style="width: 20%;">Diseños</th>
                      <th style="width: 30%;">Tipo de papel</th>
                      <th style="width: 10%;">Gramaje</th>
                      <th style="width: 10%;">Tintas frente</th>
                      <th style="width: 10%;">Tintas vuelta</th>
                      <th style="width: 10%;"></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
                </div>
              </div>
              <div class="tab-pane" id="tab1_3" aria-labelledby="base-tab1_3">
                <div class="row">
                  <div class="col-sm-3">
                    <label>Materiales:</label>
                    <select id="cbMaterialesAcabados" class="form-control" style="width:100%"></select>
                  </div>
                  <div class="col-sm-9">
                    <table class="table table-striped table-bordered" id="tablaDetalleAcabados">
                      <thead>
                        <tr>
                          <th>Incluye</th>
                          <th style="min-width: 500px;">Nombre</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab1_4" aria-labelledby="base-tab1_4">
                <table class="table table-striped table-bordered" id="tablaDetalleTerminados">
                  <thead>
                    <tr>
                      <th>Incluye</th>
                      <th style="min-width: 500px;">Nombre</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="tab1_5" aria-labelledby="base-tab1_5">
                <div class="row">
                  <div class="col-sm-12">
                    <label>Capturar Observaciones:</label>
                    <textarea class="form-control" cols="6" rows="4" id="txtObservacionesDetalle"></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <textarea class="form-control" cols="4" rows="4" id="txtDetalleCotizacion" disabled="disabled"></textarea>
        <button type="button" class="btn btn-success" id="btnGuardarConcepto">Agregar Concepto</button>
        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<?php include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/footer.php"; ?>
<script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/util.js"></script>
<script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/cotizaciones/cotizaciones.js"></script>
