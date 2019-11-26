<?php 
session_start();
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/head.php"; 
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/header.php";
?>
<style>
.icp-auto{z-index:1151 !important;}
</style>
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
                <h3 class="card-title">Modulos</h3>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="pull-right col-sm-2">
                <a class="btn btn-success" href="javascript:;" onclick="agregarModulo();"><i class="fa fa-plus"></i> Registrar Nuevo Modulo</a>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <table class="table table-striped table-bordered" id="tablaModulos">
                  <thead>
                    <tr>
                      <th style="width: 15%;">Clave</th>
                      <th style="width: 25%;">Modulo</th>
                      <th style="width: 15%;">Url</th>
                      <th style="width: 15%;">Sistema</th>
                      <th style="width: 15%;">¿Activo?</th>
                      <th style="width: 15%;">Acciones</th>
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


<div class="modal fade text-left" id="modalModulos" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Regristro de Modulo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hdModuloId" value="0">
        <div class="row">
          <div class="col-sm-4">
            <label>Clave:</label>
            <input type="text" id="txtClaveModulo" class="form-control" maxlength="5">
          </div>
        </div>
        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-6">
            <label>Nombre de Modulo:</label>
            <input type="text" id="txtNombreModulo" class="form-control">
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <label>Icono</label>
              <input class="form-control icp icp-auto" value="fas fa-anchor" type="text" id="txtIcono"/>
            </div>
          </div>
        </div>
        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-6">
            <label>URL:</label>
            <input type="text" id="txtURLModulo" class="form-control">
          </div>
          <div class="col-sm-6">
            <label>Sistema de modulo:</label>
            <select id="cbSistemas" class="form-control">
                <option value="0">[Seleccione el Sistema]</option>
                <?php
                    $db->query('SELECT * FROM SISTEMAS WHERE SIS_ACTV=1');
	                $rows = $db->fetch();
	                foreach($rows as $row => $value){
	                    echo '<option value="'.$value["SIS_IDINTRN"].'">'.$value["SIS_NMBR"].'</option>';
	                }
                ?>
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
        <button type="button" class="btn btn-outline-primary" id="btnGuadarModulo">Guardar</button>
      </div>
    </div>
  </div>
</div>



  <?php include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/footer.php"; ?>
  <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/util.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.2.0/js/fontawesome-iconpicker.min.js"></script>
  <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/sistema/modulos.js"></script>
