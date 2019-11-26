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
                <h3 class="card-title">Tipo de producto</h3>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="pull-right col-sm-2">
                <a class="btn btn-success" href="javascript:;" onclick="agregar();"><i class="fa fa-plus"></i> Registrar Nuevo Tipo</a>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <table class="table table-striped table-bordered" id="tablaTipoProducto">
                  <thead>
                    <tr>
                      <th style="width: 30%;">Tipo de Producto</th>
                      <th style="width: 30%;">Tipo de Trabajo</th>
                      <th style="width: 25%;">Tipo de diseño</th>
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

<div class="modal fade text-left" id="modalTipoProducto" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Regristro de Tipos de Producto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hdTipoId" value="0">
        <div class="row">
          <div class="col-sm-6">
            <label>Nombre:</label>
            <input type="text" id="txtNombreTipo" class="form-control">
          </div>
          <div class="col-sm-6">
            <label>Tipo de Diseño:</label>
            <select  id="txtTipoDiseño" class="form-control">
              <option value="1">Con Diseño</option>
              <option value="2">Paginado</option>
            </select>
          </div>
        </div>
        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-4">
            <label>Tipo de trabajo:</label>
            <select class="form-control" id="cbTipoTrabajo">
              <option value="0">COMERCIAL</option>
              <option value="1">EDITORIAL</option>
              <option value="2">FISCAL O TALONARIO</option>
            </select>
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
  <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/catalogos/tipo_producto.js"></script>
