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
                <h3 class="card-title">Materiales</h3>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="pull-right col-sm-2">
                <a class="btn btn-success" href="javascript:;" onclick="agregarMaterial();"><i class="fa fa-plus"></i> Registrar Nuevo Materiales</a>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <table class="table table-striped table-bordered" id="tablaMateriales">
                  <thead>
                    <tr>
                      <th style="width: 15%;">Tipo</th>
                      <th style="width: 10%;">Descripción</th>
                      <th style="width: 25%;">Tamaño (CMS)</th>
                      <th style="width: 10%;">Costo por Millar</th>
                      <th style="width: 10%;">Costo por Unidad</th>
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



<div class="modal fade text-left" id="modalMaterial" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Regristro de Material</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hdMaterialId" value="0">
        <div class="row">
          <div class="col-sm-4">
            <label>Tipo:</label>
            <select class="form-control" id="cbTipoMaterial" onchange="changeTipo();">
              <option value="0">Seleccione Tipo de Material</option>
              <option value="1">Papel</option>
              <option value="2">Acabados</option>
              <option value="3">Terminados</option>
            </select>
          </div>
          <div class="col-sm-8">
            <label>Material:</label>
            <select class="form-control" id="cbMaterial">
            </select>
          </div>
        </div>
        <div class="row" style="margin-top: 15px;">
          <div class="col-sm-3">
            <label>Ancho:</label>
            <input type="number" id="txtAncho" class="form-control" value="0" step="0.0001">
          </div>
          <div class="col-sm-3">
            <label>Alto:</label>
            <input type="number" id="txtAlto" class="form-control" value="0" step="0.0001">
          </div>
          <div class="col-sm-3">
            <label>Costo Millar:</label>
            <input type="number" id="txtCostoMillar" class="form-control" value="1" step="0.0001">
          </div>
          <div class="col-sm-3">
            <label>Costo Unidad:</label>
            <input type="number" id="txtCostoUnidad" class="form-control" value="1" step="0.0001">
          </div>
        </div>
        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-6">
            <label><input type="checkbox" id="ckActivoMaterial" checked="checked"> Activo</label>
          </div>
          <div class="col-sm-6">
            <label><input type="checkbox" id="ckControlStock" checked="checked" checked="checked"> Control de Stock</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-outline-primary" id="btnGuardarMaterial">Guardar</button>
      </div>
    </div>
  </div>
</div>



<?php include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/footer.php"; ?>
<script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/util.js"></script>
<script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/catalogos/materiales.js"></script>