<?php 
session_start();
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/head.php"; 
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/header.php";
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
      <div class="row match-height">
        <div class="col-xl-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Accesos</h4>
              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            </div>
            <div class="card-content">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-4">
                    <label>Rol</label>
                    <select class="form-control" id="cbRol" onchange="cargarPermisos();">
                      <option value="0">[Seleccione Rol]</option>
                      <?php
                      $db->query('SELECT * FROM ROLES WHERE RLS_ACTV=1');
                      $rows = $db->fetch();
                      foreach($rows as $row => $value){
                        echo '<option value="'.$value["RLS_IDINTRN"].'">'.$value["RLS_NMBR"].'</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <label>Permisos de Acceso por Rol</label>
                    <div id="tree"></div>
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
  <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/sistema/accesos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>