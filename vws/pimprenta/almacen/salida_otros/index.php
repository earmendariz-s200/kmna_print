<?php 
session_start();
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/head.php"; 
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/header.php";
?>


 <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/vendors/css/forms/selects/select2.min.css">
<style type="text/css">
   .inpError {
     border: 1px solid #ff0a0a !important;
   }

</style>

<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
      <div class="row match-height">

          <div class="col-md-12">
              <div class="card" style="height: 100%;">
                <div class="card-header">
                 

                     <h4 class="card-title" id="basic-layout-form"> Salida de Material por otros conceptos 
                    <a  href="historial.php" class="btn btn-success">
                          <i class="fa fa-plus-circle" ></i> Historial de salidas por otros conceptos 
                        </a> </h4>  



                  
                </div>
                <div class="card-content collapse show">
                  <div class="card-body">
                 
                    <form class="form" id="frm_salida">
                      <div class="form-body">
                        <h4 class="form-section"><i class="ft-user"></i> Salida de mercancia por otros conceptos </h4>
                      
                         

 
                      <div class="row">
                          
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="cb_materiales"> Material </label>
                              <select id="cb_materiales" name="cb_materiales" class="form-control requerido">
                               
                              </select>
                            </div>
                          </div>


                          
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="cli_numext">Cantidad</label>
                              <input type="text" id="txt_cantidad" class="form-control requerido solo_numero" placeholder=""  >
                            </div>
                          </div>
 
                      </div>


                        <div class="row"> 
                        
                          <div class="form-group col-8 mb-6">
                            <label >Motivo</label>
                            <textarea id="motivo" rows="5" class="form-control" name="comment" placeholder="Motivo de salida"></textarea>
                          </div>

                        </div> 


 



                      <div class="form-actions">
                        <button type="button" class="btn btn-warning mr-1">
                          <i class="ft-x"></i> Cancelar salida
                        </button>
                        <button type="button" class="btn btn-primary"  id="btn_guardar" >
                          <i class="fa fa-check-square-o"></i> Guardar salida
                        </button>
                      </div>
                    </form>
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
 <script src="<?php echo $URL_PRINCIPAL; ?>assets/vendors/js/forms/select/select2.full.min.js"></script> 
 

 <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/almacen/salida.js"></script>