<?php
session_start();
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/head.php";
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/header.php";
?>
<input type="hidden" id="hdPaginas" value="0">
<input type="hidden" id="hdTintas" value="0">
<input type="hidden" id="hdTipoPapel" value="0">
<input type="hidden" id="hdCantidad" value="0">
<input type="hidden" id="hdAncho" value="0">
<input type="hidden" id="hdAlto" value="0">


<input type="hidden" id="hdCostoLaminaImpresora" value="0">
<input type="hidden" id="hdCostoMillarImpresora" value="0">
<input type="hidden" id="hdAnchoMinimoImpresora" value="0">
<input type="hidden" id="hdAltoMinimoImpresora" value="0">
<input type="hidden" id="hdAnchoMaximoImpresora" value="0">
<input type="hidden" id="hdAltoMaximoImpresora" value="0">

<input type="hidden" id="hdExcendente" value="0">

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
                <h3 class="card-title">Información del trabajo</h3>
                <input type="hidden" id="hdIdConcepto" value="<?php echo $_GET["id"]; ?>">
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body" style="margin-top: -30px;">
                <div class="row">
                  <div class="col-sm-2">
                    <label>Cantidad:</label>
                    <input type="number" name="txtCantidadTrabajo" id="txtCantidadTrabajo" class="form-control" disabled="disabled" style="height: 45px;">
                  </div>
                  <div class="col-sm-10">
                    <label>Descripción:</label>
                    <textarea class="form-control" cols="6" rows="4" id="txtDescripcionTrabajo" disabled></textarea>
                  </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                  <div class="col-sm-2">
                    <label>Margen:</label>
                    <input type="number" name="txtMargenTrabajo" id="txtMargenTrabajo" class="form-control" value="0" onblur="agrega_margen();" >
                  </div>
                  <div class="col-sm-2">
                    <label>Monto por Margen:</label>
                    <input type="number" class="form-control" id="txtMontoMargen" name="txtMontoMargen" value="0" >
                  </div>
                  <div class="col-sm-2">
                    <label>Costo del Trabajo</label>
                    <input type="number" class="form-control" disabled id="txtCostoTrabajo" name="txtCostoTrabajo" value="0" >
                  </div>
                  <div class="col-sm-2">
                    <label>Precio unitario del trabajo:</label>
                    <input type="number" class="form-control" disabled id="txtPrecioUnitario" name="txtPrecioUnitario" value="0" >
                  </div>
                  <div class="col-sm-2">

                  </div>
                  <div class="col-sm-2">
                    <button class="btn btn-success btn-lg" id="btnAceptarConcepto" style="margin-top: 20px; ">Aceptar</button>
                    <button class="btn btn-danger btn-lg" id="btnCancelarConcepto" style="margin-top: 20px; ">Cancelar</button>
                  </div>
                </div>
                <div class="row" style="margin-top: 20px;" >
                  <div class="col-sm-2">
                    <br><br><br><br><br>
                    <a class="btn btn-info btn-block" href="javascript:;" onclick="alternativas();"><i class="fa fa-print"></i><br>Alternativas de impresión</a>
                    <br><br><br><br><br>
                    <a class="btn btn-warning btn-block" href="javascript:;" onclick="calcular();"><i class="fa fa-dollar"></i><br>Calcular Costo</a>
                  </div>
                  <div class="col-sm-10">
                    <ul class="nav nav-tabs nav-top-border no-hover-bg">
                      <li class="nav-item">
                        <a class="nav-link active" id="base-tab11" data-toggle="tab" aria-controls="tab11"
                        href="#tab11" aria-expanded="true">Desglose de Material</a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" id="base-tab12" data-toggle="tab" aria-controls="tab12" href="#tab12"
                        aria-expanded="false">Totales por área</a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" id="base-tab13" data-toggle="tab" aria-controls="tab13" href="#tab13"
                        aria-expanded="false">Totales Netos</a>
                      </li>
                    </ul>
                    <div class="tab-content px-1 pt-1">
                      <div role="tabpanel" class="tab-pane active" id="tab11" aria-expanded="true" aria-labelledby="base-tab11">
                        <div class="row" style="margin-bottom: 35px;">
                          <div class="col-sm-4">
                            <div class="list-group">
                              <h3>Lista de Materiales</h3>
                              <div id="lstMateriales">
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-8" id="divConfiguracionMaterial" style="display: none;">
                            <label>Material: </label> <b><span id="lblMaterial" style="font-size: 1.5em;">Es portada de 4 páginas</span></b>
                            <ul class="nav nav-tabs nav-top-border no-hover-bg">
                              <li class="nav-item">
                                <a class="nav-link active" id="base-conf" data-toggle="tab" aria-controls="tabConf"
                                href="#tabConf" aria-expanded="true">Configuración de material</a>
                              </li>

                              <li class="nav-item">
                                <a class="nav-link" id="base-opc" data-toggle="tab" aria-controls="tabOpc" href="#tabOpc"
                                aria-expanded="false">Opciones avanzadas</a>
                              </li>

                              <li class="nav-item">
                                <a class="nav-link" id="base-cons" data-toggle="tab" aria-controls="tabCons" href="#tabCons"
                                aria-expanded="false">Consideraciones adicionales</a>
                              </li>
                            </ul>

                            <div class="tab-content px-1 pt-1">
                              <div role="tabpanel" class="tab-pane active" id="tabConf" aria-expanded="true" aria-labelledby="base-conf">
                                <div class="row">
                                  <div class="col-sm-4">
                                    <label>Maquina de Impresión</label>
                                    <select class="form-control" id="cbMaquinaImpresion"></select>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-sm-4">
                                    <label>Formula de Costo</label>
                                    <select class="form-control" id="cbFormulaCosto">
                                      <option value="0">Sumar Totales Conceptos</option>
                                      <option value="1">(M + L) x 2</option>
                                    </select>
                                  </div>
                                  <div class="col-sm-4">
                                    <label>Criterio de Corte</label>
                                    <select class="form-control" id="cbCriterioCorte">
                                      <option value="0">Horizontales o Verticales</option>
                                      <option value="1">Horizontales o Verticales</option>
                                      <option value="2">Combinado</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-sm-4">
                                    <label>Costo Total de Material</label>
                                    <input type="number" class="form-control" id="txtCostoTotalMaterial" value="0">
                                  </div>
                                  <div class="col-sm-4">
                                    <label>Criterio de Sobreposicion</label>
                                    <select class="form-control" id="cbCriterioSobreposicion">
                                      <option value="0">Horizontales o Verticales</option>
                                      <option value="1">Horizontales o Verticales</option>
                                      <option value="2">Combinado</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div role="tabpanel" class="tab-pane" id="tabOpc" aria-expanded="true" aria-labelledby="base-opc">
                                <div class="row">
                                  <div class="col-sm-4">
                                    <label>Incluir pirnzas de impresión: <input type="checkbox" id="ckPinzaImpresion" checked></label>
                                  </div>
                                  <div class="col-sm-4">
                                    <label>Utilizar reglas de impresión: <input type="checkbox" id="ckReglasImpresion" checked></label>
                                  </div>
                                  <div class="col-sm-4">
                                    <label>Frente y Vuelta con la misma lamina: <input type="checkbox" id="ckMismaLamina" checked></label>
                                  </div>
                                </div>
                                <div class="row" style="margin-top: 15px;">
                                  <div class="col-sm-4">
                                    <label>Optimizar pliegos con al siguiente formación:</label>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-sm-2">
                                    <label>Base:</label>
                                    <input type="number" id="txtBasePliegos" class="form-control" value="0" min="0">
                                  </div>
                                  <div class="col-sm-2">
                                    <label>Alto:</label>
                                    <input type="number" id="txtAltoPliegos" class="form-control" value="0" min="0">
                                  </div>
                                  <div class="col-sm-4">

                                  </div>
                                  <div class="col-sm-4">
                                    <label>Páginas por cuadernillo:</label>
                                    <select id="cbPaginasCuadernillo" class="form-control">
                                      <option value="2">2 Páginas</option>
                                      <option value="4">4 Páginas</option>
                                      <option value="6">6 Páginas</option>
                                      <option value="8">8 Páginas</option>
                                      <option value="12">12 Páginas</option>
                                      <option value="16">16 Páginas</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div role="tabpanel" class="tab-pane" id="tabCons" aria-expanded="true" aria-labelledby="base-cons">
                                <div class="row" style="margin-top: 15px;">
                                  <div class="col-sm-4">
                                    <label>Configurar excendente:</label>
                                  </div>
                                  <div class="col-sm-4">

                                  </div>
                                  <div class="col-sm-4">
                                    <label>Poses deseadas:</label>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-sm-4">
                                    <label>Utilizar excendente manual: <input type="checkbox" id="ckExcedenteManual"></label><br>
                                    <label>Excedente:</label>
                                    <input id="txtExcedente" type="number" class="form-control" min="0" value="0">
                                  </div>
                                  <div class="col-sm-4">

                                  </div>
                                  <div class="col-sm-2">
                                    <label>Poses desde:</label>
                                    <input id="txtPosesDesde" type="number" class="form-control" min="0" value="0">
                                  </div>
                                  <div class="col-sm-2">
                                    <label>Poses hasta:</label>
                                    <input id="txtPosesHasta" type="number" class="form-control" min="0" value="0">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-12">
                            <div class="card">
                              <div class="card-content">
                                <div class="card-body card-dashboard">
                                  <label>Acabados/Insumos</label>
                                  <table class="table table-striped table-bordered compact" id="tablaConceptosAcabados">
                                    <thead>
                                      <tr>
                                        <th style="width: 5%;">Incluir</th>
                                        <th style="width: 15%;">Concepto</th>
                                        <th style="width: 10%;">Cantidad</th>
                                        <th style="width: 10%;">Unidad</th>
                                        <th style="width: 10%;">Precio por Unidad</th>
                                        <th style="width: 10%;">Total</th>
                                        <th style="width: 30%;">Observaciones</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                  </table>
                                  <label>Terminados</label>
                                  <table class="table table-striped table-bordered compact" id="tablaConceptosTerminados">
                                    <thead>
                                      <tr>
                                        <th style="width: 5%;">Incluir</th>
                                        <th style="width: 15%;">Concepto</th>
                                        <th style="width: 10%;">Cantidad</th>
                                        <th style="width: 10%;">Unidad</th>
                                        <th style="width: 10%;">Precio por Unidad</th>
                                        <th style="width: 10%;">Total</th>
                                        <th style="width: 30%;">Observaciones</th>
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

                      <div class="tab-pane" id="tab12" aria-labelledby="base-tab12">
                        <table class="table table-striped table-bordered" id="tablaTotalesArea">
                          <thead>
                            <tr>
                              <th style="width: 15%;">Area</th>
                              <th style="width: 10%;">Margen (%)</th>
                              <th style="width: 10%;">Costo Interno</th>
                              <th style="width: 10%;">Total Cliente</th>
                              <th style="width: 50%;">Observaciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Papel</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td></td>
                            </tr>
                            <tr>
                              <td>Mano de obra</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td></td>
                            </tr>
                            <tr>
                              <td>Materiales</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td></td>
                            </tr>
                            <tr>
                              <td>Terceros</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td></td>
                            </tr>
                            <tr>
                              <td>Mat*2</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <div class="tab-pane" id="tab13" aria-labelledby="base-tab13">
                        <table class="table table-striped table-bordered" id="tablaTotalesNetos">
                          <thead>
                            <tr>
                              <th style="width: 15%;">Nombre</th>
                              <th style="width: 10%;">Cantidad total</th>
                              <th style="width: 10%;">Costo total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Suaje</td>
                              <td>0</td>
                              <td>Piezas</td>
                            </tr>
                            <tr>
                              <td>Suaje</td>
                              <td>0</td>
                              <td>Piezas</td>
                            </tr>
                            <tr>
                              <td>Suaje</td>
                              <td>0</td>
                              <td>Piezas</td>
                            </tr>
                            <tr>
                              <td>Suaje</td>
                              <td>0</td>
                              <td>Piezas</td>
                            </tr>
                            <tr>
                              <td>Suaje</td>
                              <td>0</td>
                              <td>Piezas</td>

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
  </div>
</div>



<div class="modal fade text-left" id="modalAlternativas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document" style="min-width: 75%">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Alternativas de Impresión</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-bordered" id="tablaAlternativas">
          <thead>
            <tr>
              <th>Pliegos <br>medida corte</th>
              <th style="width: 10%;">Medida diseño</th>
              <th style="width: 10%;">Formas</th>
              <th style="width: 10%;">Pliegos <br>medida extendida</th>
              <th style="width: 10%;">Medidas <br>extendidas</th>
              <th style="width: 10%;">Resultan</th>
              <th style="width: 10%;">Precio</th>
              <th style="width: 10%;">Desperdicio Ancho</th>
              <th style="width: 10%;">Desperdicio Alto</th>
              <th style="width: 10%;">Costo Material</th>
              <th style="width: 10%;">Costo Papel</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td> <input type="radio" class="radio_button" name="opciones" value="700"> 700</td>
              <td> 57.7 X 88.2</td>
              <td> 2 </td>
              <td> 600 </td>
              <td> 61 X 90 </td>
              <td> 2 </td>
              <td> 1.23 </td>
              <td> 0 </td>
              <td> 0 </td>
              <td> 738 </td>
              <td> 12522 </td>
            </tr>
            <tr>
              <td> <input type="radio" class="radio_button" name="opciones" value="700"> 700</td>
              <td> 57.7 X 88.2</td>
              <td> 2 </td>
              <td> 600 </td>
              <td> 61 X 90 </td>
              <td> 2 </td>
              <td> 1.23 </td>
              <td> 0 </td>
              <td> 0 </td>
              <td> 738 </td>
              <td> 12522 </td>
            </tr>
            <tr>
              <td> <input type="radio" class="radio_button" name="opciones" value="600"> 600</td>
              <td> 57.7 X 88.2</td>
              <td> 2 </td>
              <td> 600 </td>
              <td> 70 X 95 </td>
              <td> 2 </td>
              <td> 1.5 </td>
              <td> 0 </td>
              <td> 0 </td>
              <td> 900 </td>
              <td> 12684 </td>
            </tr>
            <tr>
              <td> <input type="radio" class="radio_button" name="opciones" value="750_1"> 750</td>
              <td> 44.4 X 57.1 </td>
              <td> 1 </td>
              <td> 375 </td>
              <td> 61 X 90 </td>
              <td> 2 </td>
              <td> 1.23 </td>
              <td> 0 </td>
              <td> 0 </td>
              <td> 461.25 </td>
              <td> 12522 </td>
            </tr>
            <tr>
              <td> <input type="radio" class="radio_button" name="opciones" value="750_2"> 750</td>
              <td> 44.6 X 58 </td>
              <td> 1 </td>
              <td> 375 </td>
              <td> 70 X 95 </td>
              <td> 2 </td>
              <td> 1.5 </td>
              <td> 0 </td>
              <td> 0 </td>
              <td> 562.5 </td>
              <td> 14766 </td>
            </tr>
          </tbody>
        </table>

        <div class="row" style="maring-top: 30px; margin-left: 15px;">
          <div class="col-sm-4">
            <label><b>Desperdicio de papel</b></label><br>
            <label id="lblDesperdicio">0.0%</label>
            <br><br>
            <label><b>Medidas de corte</b></label><br>
            <label><b>Alto: </b> <span id="lblMedidaCorteAlto">0.0</span></label><br>
            <label><b>Ancho: </b> <span id="lblMedidaCorteAncho">0.0</span></label><br>
            <br><br>
            <label><b>Páginas por material: </b> <span id="lblPaginasMaterial">0</span></label><br>
            <label><b>Páginas por cuadernillo: </b> <span id="lblPaginasCuadernillo">0</span></label><br>
            <label><b>cuadernillos requeridos: </b> <span id="lblCuadernillosRequeridos">0</span></label><br>
          </div>
          <div class="col-sm-4">
            <label><b>Pliegos de impresión</b></label><br>
            <canvas id="CanvasPliegos" width="500" height="300" style="border:1px solid #000000;"></canvas>
          </div>
          <div class="col-sm-4">
            <label><b>Esquema de corte</b></label><br>
            <canvas id="CanvasCorte" width="500" height="300" style="border:1px solid #000000;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade text-left" id="modalCostoAcabados" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document" style="min-width: 75%">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Costeo Insumos</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
    </div>
  </div>
</div>


<?php include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/footer.php"; ?>
<script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/util.js"></script>
<script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/cotizaciones/costear.js"></script>
