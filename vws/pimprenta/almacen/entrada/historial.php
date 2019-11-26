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
                <h3 class="card-title">Historial de entradas</h3>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>

 
            </div>
            <div class="card-content">



              <div class="card-body">


                 <div class="row">
                
                    <div class="form-group col-3 mb-3">
                        <div class="form-group">
                          <label >Fecha de inicio</label> 
                            <input type="date" id="txt_fecha_ini" class="form-control requerido" name="txt_fecha_ini">
                        </div> 
                    </div>
                     <div class="form-group col-3 mb-3">
                        <div class="form-group">
                          <label >Fecha de fin</label> 
                            <input type="date" id="txt_fecha_fin" class="form-control requerido" name="txt_fecha_fin">
                        </div> 
                    </div>

                      <div class="col-md-3">
                            <div class="form-group">
                              <label for="cb_proveedores"> Proveedor </label>
                              <select id="cb_proveedores" name="cb_proveedores" class="form-control requerido">

                                  <option value="0"> [VER TODOS]</option>
                                   <?php
                                      $db->query('SELECT PRV_IDINTRN, PRV_RZNSCL FROM PROVEEDORES WHERE PRV_ACTV = 1');
                                      $rows = $db->fetch();
                                      foreach($rows as $row => $value){
                                        
                                        echo '<option value="'.$value["PRV_IDINTRN"].'"  >'.$value["PRV_RZNSCL"].'</option>';
                                        
                                      }
                                  ?> 
                              </select>
                            </div>
                          </div> 

                      <div class="col-md-3">
                            <button type="button" class="btn btn-primary" onclick="cargar_datos()" style="margin-top: 5%">
                                  <i class="fa fa-search"></i> 
                                </button> 
                      </div> 



                           

              </div>


                <table class="table table-striped table-bordered" id="tablaListado">
                  <thead>
                    <tr>
                      <th style="width: 5%;">Folio de entrada</th> 
                      <th style="width: 15%;">Fecha</th>
                      <th style="width: 15%;">Nota</th>
                      <th style="width: 15%;">Factura</th>
                      <th style="width: 15%;">Proveedor</th>
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

<div class="modal fade text-left" id="modalColores" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detalle de entrada</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      
       
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button> 
      </div>
    </div>
  </div>
</div>


<?php include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/footer.php"; ?>
  <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/util.js"></script> 
   <script src="<?php echo $URL_PRINCIPAL; ?>/assets/js/scripts/dropzone.js"></script>
 <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/almacen/entrada.js"></script>