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
        <div class="col-xl-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <div class="col-sm-10">
                <h3 class="card-title">Maquinas de impresión</h3>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="pull-right col-sm-2">
                <a class="btn btn-success" href="javascript:;" onclick="agregar();"><i class="fa fa-plus"></i> Registrar Maquinas</a>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <table class="table table-striped table-bordered" id="tablaMaquina">
                  <thead>
                    <tr>
                      <th style="width: 30%;">Maquina</th>
                      <th style="width: 10%;">Precio Lamina</th>
                      <th style="width: 10%;">Tintas</th>
                      <th style="width: 10%;">¿Puede Barnizar?</th>
                      <th style="width: 10%;">¿Activo?</th>
                      <th style="width: 10%;">Acciones</th>
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

<div class="modal fade text-left" id="modalMaquina" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Regristro de Maquinas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hdMaquinasId" value="0">
        <div class="row">
          <div class="col-sm-8">
            <label>Nombre:</label>
            <input type="text" id="txtNombre" class="form-control">
          </div>
        </div>
        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-3">
            <label>Costo por lamina</label>
            <input type="number" id="txtCostoLamina" class="form-control" step="0.0001" value="0">
          </div>
          <div class="col-sm-3">
            <label>Costo por millar</label>
            <input type="number" id="txtCostoMillar" class="form-control" step="0.0001" value="0">
          </div>
          <div class="col-sm-3" style="margin-top: 30px;">
            <label><input type="checkbox" id="ckBarnizar" > ¿Puede Barnizar?</label>
          </div>
          <div class="col-sm-3" style="margin-top: 30px;">
            <label><input type="checkbox" id="ckActivo" checked="checked"> Activo</label>
          </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-sm-12">
              <ul class="nav nav-tabs nav-top-border no-hover-bg">
                <li class="nav-item">
                  <a class="nav-link active" id="base-tab11" data-toggle="tab" aria-controls="tab11"
                  href="#tab11" aria-expanded="true">Información Tecnica</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="base-tab12" data-toggle="tab" aria-controls="tab12" href="#tab12"
                  aria-expanded="false">Reglas de impresión</a>
                </li>
              </ul>
              <div class="tab-content px-1 pt-1">
                <div role="tabpanel" class="tab-pane active" id="tab11" aria-expanded="true" aria-labelledby="base-tab11">
                  <div class="row" style="margin-bottom: 35px;">
                    <div class="col-sm-3">
                      <label>Numero de Tintas:</label>
                      <input class="form-control" type="number" id="txtTintas" step="1" value="0" min="0">
                    </div>
                    <div class="col-sm-3">
                      <label>Velocidad de tirada:</label>
                      <input class="form-control" type="number" id="txtVelocidad" step="1" value="0" min="0">
                    </div>
                  </div>
                  <div class="row" style="margin-top: 10px;">
                    <div class="col-sm-4">
                      <label>Ancho Mínimo de pliego:</label>
                      <input type="number" id="txtAnchoMin" class="form-control" step="0.0001" value="0">
                    </div>

                    <div class="col-sm-4">
                      <label>Alto Mínimo de pliego:</label>
                      <input type="number" id="txtAltoMin" class="form-control" step="0.0001" value="0">
                    </div>
                  </div>
                  <div class="row" style="margin-top: 10px;">
                    <div class="col-sm-4">
                      <label>Ancho Máximo de pliego:</label>
                      <input type="number" id="txtAnchoMax" class="form-control" step="0.0001" value="0">
                    </div>

                    <div class="col-sm-4">
                      <label>Alto Máximo de pliego:</label>
                      <input type="number" id="txtAltoMax" class="form-control" step="0.0001" value="0">
                    </div>
                  </div>

                </div>
                <div class="tab-pane" id="tab12" aria-labelledby="base-tab12">
                  <div class="row" style="margin-bottom: 35px;">
                    <div class="col-sm-3">
                      <label>Tamaño de pinza:</label>
                      <input class="form-control" type="number" id="txtTamanoPinza" step="0.01" value="0" min="0">
                    </div>
                    <div class="col-sm-3">
                      <label>Espacio de desbaste:</label>
                      <input class="form-control" type="number" id="txtEspacioDesbaste" step="0.01" value="0" min="0">
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 10px;">
                    <div class="col-sm-3">
                      <label>Espacios para laterales:</label>
                      <input class="form-control" type="number" id="txtEspacioLaterales" step="0.01" value="0" min="0">
                    </div>
                    <div class="col-sm-3">
                      <label>Espacio para cola:</label>
                      <input class="form-control" type="number" id="txtEspacioCola" step="0.01" value="0" min="0">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-outline-primary" id="btnGuadar">Guardar</button>
      </div>
    </div>
  </div>
</div>


<?php include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/footer.php"; ?>
<script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/util.js"></script>
<script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/catalogos/maquinas.js"></script>
