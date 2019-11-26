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
         <div class="col-sm-6 col-lg-6">
          <div class="card">
            <div class="card-header">
              <div class="col-sm-8">
                <h3 class="card-title">Tipo de Papel</h3>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="pull-right col-sm-4">
                <a class="btn btn-success pull-right" href="javascript:;" onclick="agregarPapel();"><i class="fa fa-plus"></i> Registrar Nuevo Papel</a>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <table class="table table-striped table-bordered" id="tablaPapeles">
                  <thead>
                    <tr>
                      <th style="width: 50%;">Tipo de Papel</th>
                      <th style="width: 20%;">¿Activo?</th>
                      <th style="width: 30%;">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
         </div>
         <div class="col-sm-6 col-lg-6">
          <div class="card">
            <div class="card-header">
              <div class="col-sm-8">
                <h3 class="card-title">Gramajes</h3>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="pull-right col-sm-4">
                <a class="btn btn-success pull-right" href="javascript:;" onclick="agregarGramaje();"><i class="fa fa-plus"></i> Registrar Nuevo Gramaje</a>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <table class="table table-striped table-bordered" id="tablaGramaje">
                  <thead> 
                    <tr>
                      <th style="width: 50%;">Papel</th>
                      <th style="width: 20%;">Gramaje</th>
                      <th style="width: 30%;">Acciones</th>
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

<div class="modal fade text-left" id="modalPapel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Registro de Tipo de Papel</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hdPapelId" value="0">
        <div class="row">
          <div class="col-sm-8">
            <label>Tipo de Papel:</label>
            <input type="text" id="txtNombrePapel" class="form-control">
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
        <button type="button" class="btn btn-outline-primary" id="btnGuadarPapel">Guardar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade text-left" id="modalGramajes" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Regristro de Gramaje</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hdGramajeId" value="0">
        <div class="row">
          <div class="col-sm-8">
            <label>Tipo de Papel:</label>
            <select class="form-control" id="cbTipoPapelGramaje">
            </select>
          </div>
          <div class="col-sm-4">
            <label>Gramaje:</label>
            <input type="number" id="txtGramajePapel" class="form-control" step="5">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-outline-primary" id="btnGuadarGramaje">Guardar</button>
      </div>
    </div>
  </div>
</div>


<?php include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/footer.php"; ?>
<script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/util.js"></script>
<script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/catalogos/materiales.js"></script>