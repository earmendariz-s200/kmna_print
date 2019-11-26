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
                <h3 class="card-title">Tamaños de Papel</h3>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="pull-right col-sm-2">
                <a class="btn btn-success" href="javascript:;" onclick="agregar();"><i class="fa fa-plus"></i> Registrar Tamaño</a>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <table class="table table-striped table-bordered" id="tablaTamanos">
                  <thead>
                    <tr>
                      <th style="width: 40%;">Tamaño de Papel</th>
                      <th style="width: 15%;">Medidas</th>
                      <th style="width: 10%;">Formación Columnas</th>
                      <th style="width: 10%;">Formación Filas</th>
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

<div class="modal fade text-left" id="modalTamanos" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Regristro de Tamaños de Papel</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hdId" value="0">
        <div class="row">
          <div class="col-sm-6">
            <label>Tamaño de Papel:</label>
            <input type="text" id="txtNombre" class="form-control">
          </div>
        </div>
        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-4">
            <label>Ancho:</label>
            <input type="number" id="txtAncho" class="form-control">
          </div>
          <div class="col-sm-4">
            <label>Alto:</label>
            <input type="number" id="txtAlto" class="form-control">
          </div>
        </div>
        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-4">
            <label>Formación Base:</label>
            <input type="number" id="txtFormacionBase" class="form-control">
          </div>
          <div class="col-sm-4">
            <label>Formación Alto:</label>
            <input type="number" id="txtFormacionAlto" class="form-control">
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
  <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/catalogos/tamanos_papel.js"></script>