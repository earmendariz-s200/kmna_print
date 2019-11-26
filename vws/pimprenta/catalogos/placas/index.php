<?php
session_start();
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/head.php";
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/header.php";
?>
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row"></div>
    <div class="content-body">

      <div class="row match-height">
        <div class="col-xl-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <div class="col-sm-10">
                <h3 class="card-title">Placas</h3>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="pull-right col-sm-2">
                <a class="btn btn-success" href="javascript:;" onclick="agregar();"><i class="fa fa-plus"></i> Registrar Placas</a>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <table class="table table-striped table-bordered" id="tablaPlaca">
                  <thead>
                    <tr>
                      <th style="width: 10%;">Clave Placas</th>
                      <th style="width: 25%;">Cliente</th>
                      <th style="width: 10%;">Estado</th>
                      <th style="width: 30%;">Descripción</th>
                      <th style="width: 10%;">Costo</th>
                      <th style="width: 10%;">Tintas</th>
                      <th style="width: 5%;">¿Activo?</th>
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

<div class="modal fade text-left" id="modalPlaca" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Registro de Placas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hdPlacasId" value="0">
        <div class="row">
          <div class="col-sm-4">
            <label>Clave Placas:</label>
            <input type="text" id="txtClave" class="form-control">
          </div>
          <div class="col-sm-8">
            <label>Cliente:</label>
            <select class="form-control" id="cbCliente"></select>
          </div>
        </div>
        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-4">
            <label>Estado:</label>
            <select class="form-control" id="cbEstado">
              <option value="-1" selected>[Seleccione un estado]</option>
              <option value="0">Dañada</option>
              <option value="1">Excelente</option>
            </select>
          </div>
          <div class="col-sm-4">
            <label>Costo:</label>
            <input type="number" id="txtCosto" class="form-control" value="0" step="0.0001">
          </div>
          <div class="col-sm-4">
            <label>Tintas:</label>
            <input type="number" id="txtTintas" class="form-control" value="0">
          </div>
        </div>
        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-12">
            <label>Descripción:</label>
            <textarea class="form-control" cols="6" rows="4" id="txtDescripcion"></textarea>
          </div>
        </div>
        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-6">
            <label><input type="checkbox" id="ckActivo" checked="checked"> Activo</label>
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
  <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/catalogos/placas.js"></script>