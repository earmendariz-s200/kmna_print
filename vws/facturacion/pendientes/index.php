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
                <h3 class="card-title">Nuevas facturas</h3>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>

 
            </div>
            <div class="card-content">



              <div class="card-body">


                


                <table class="table table-striped table-bordered" id="tablaListado">
                  <thead>
                    <tr>  
                      <th style="width: 15%;">Folio</th>
                      <th style="width: 15%;">Cotización</th>
                      <th style="width: 15%;">Fecha</th>  
                      <th style="width: 15%;">Cliente</th>  
                      <th style="width: 15%;">PDF</th>  
                      <th style="width: 15%;">XML</th> 
                       <th style="width: 15%;">Opciones</th> 
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

  
<?php include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/footer.php"; ?>
  <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/util.js"></script> 
   <script src="<?php echo $URL_PRINCIPAL; ?>/assets/js/scripts/dropzone.js"></script>
 <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/facturacion/listado_pendientes.js"></script>

 