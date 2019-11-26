<?php 
session_start();
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/head.php"; 
include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/header.php";


?>


 <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/vendors/css/forms/selects/select2.min.css">

<link rel="stylesheet" href="<?php echo $URL_PRINCIPAL; ?>/assets/css/dropzone.css">



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
                  <h4 class="card-title" id="basic-layout-form"> Entrada de Material de compras   
                    <a  href="historial.php" class="btn btn-success">
                          <i class="fa fa-plus-circle" ></i> Historial de entradas 
                        </a> </h4> 
                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                  
                </div>
                <div class="card-content collapse show">
                  <div class="card-body">
                 
                    <div class="form" id="frm_entrada">
                      <div class="form-body">
                        <h4 class="form-section"><i class="ft-user"></i> Entrada de mercancia </h4>
                        <div class="row">
 

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="cb_proveedores"> Proveedor </label>
                              <select id="cb_proveedores" name="cb_proveedores" class="form-control requerido">
                                
                              </select>
                            </div>
                          </div> 


                         <div class="col-md-2" style="margin-top: 1%;">
                            
                                <button type="button" class="btn btn-primary" onclick="fnc_modl_proveedor()">
                                  <i class="fa fa-plus-circle"></i> 
                                </button>
                         
                          </div>

                         
                        </div>
                        

                        <div class="row">
                           
                          <div class="form-group col-6 mb-6">
                                <div class="form-group">
                                  <label >Fecha de entrada</label> 
                                    <input type="date" id="txt_fecha" class="form-control requerido" name="txt_fecha">
                                </div> 
                          </div>

                        </div>

                        <div class="row">

                          

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="txt_nota">Nota de remisión</label>
                              <input type="text" id="txt_nota" onblur="visible_cargador_nota(this.value)"  class="form-control" placeholder=""  >
                            </div>
                          </div>



                            <div class="col-md-6">
                              
                              <div class="form-group"  style="margin-top: 2%;display: none;" id="div_carga_nota"  >
                                <label> Sube archivo comprobante</label> 
                                <form action="server_upload.php" id="file_nota_lb" class="dropzone">
                                  <input type="hidden" id="hd_txt_nota" name="hd_txt_nota" value="" >
                                </form>
                              </div>  

                           </div>


                         </div>


                        <div class="row">

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="txt_factura">Factura</label>
                              <input type="text" id="txt_factura" onblur="visible_cargador_factura(this.value)" class="form-control" placeholder=""  >
                            </div>
                          </div>


                            <div class="col-md-6"  style="margin-top: 2%;">
 
                              <div class="form-group"  style="margin-top: 2%;display: none;" id="div_carga_factura"  >
                                <label> Sube archivo comprobante</label> 
                                <form action="server_upload.php" id="file_factura_lb" class="dropzone">
                                  <input type="hidden" id="hd_txt_factura" name="hd_txt_factura"  value="" >
                                </form>
                              </div>  
                           
                           </div>
                         </div>

                      

                      
                      </div>


                      <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                              <label for="cb_materiales"> Material </label>
                              <select id="cb_materiales" name="cb_materiales" class="form-control requerido">
                               
                              </select>
                            </div>
                          </div>


                          
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="cli_numext">Cantidad</label>
                              <input type="text" id="txt_cantidad" class="form-control requerido solo_numero" onkeyup="fnc_nuevo_total(this)" placeholder=""  >
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="txt_total">Total $</label>
                              <input type="text" id="txt_total" class="form-control requerido" onkeyup="fnc_nuevo_total_md(this)" placeholder=""  >
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="txt_precio_unitario">Precio unitario $</label>
                              <input type="text" id="txt_precio_unitario" class="form-control requerido solo_numero" placeholder="" disabled >
                            </div>
                          </div>





                          <div class="col-md-2" style="margin-top: 2%;">
                            
                                <button type="button" class="btn btn-primary" id="btn_add">
                                  <i class="fa fa-check-square-o"></i> Agregar
                                </button>
                         
                          </div>
                        
                      </div>


                       <div class="row">

                         <table class="table table-striped table-bordered" id="tablaMateriales">
                          <thead>
                            <tr>
                              <th style="width: 5%;"> </th>
                              <th style="width: 30%;">Material</th>
                               <th style="width: 20%;">Cantidad</th>
                              <th style="width: 20%;">Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>



                       </div>



                      <div class="form-actions">
                        <button type="button" class="btn btn-warning mr-1">
                          <i class="ft-x"></i> Cancelar entrada
                        </button>
                        <button type="button" class="btn btn-primary" id="btn_guardar" >
                          <i class="fa fa-check-square-o"></i> Guardar entrada
                        </button>
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


<div class="modal fade" id="modl_proveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alta de proveedores</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
         <form class="form" id="form_proveedor">

           <div class="row">

              <div class="col-md-6">
                <div class="form-group">
                  <label for="pro_razon_social">Razón social</label>
                  <input type="text" id="pro_razon_social" class="form-control requerido" placeholder=""  >
                </div>
              </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pro_rfc">RFC</label>
                    <input type="text" id="pro_rfc" onkeyup="mayus(this);" onblur="check_rfc(this.value,this);" class="form-control requerido" placeholder=""  >
                  </div>
               </div>
 
           </div>


            <div class="row">
            
              <div class="col-md-6">
                <div class="form-group">
                  <label for="pro_calle">Calle</label>
                  <input type="text" id="pro_calle" class="form-control requerido" placeholder=""  >
                </div>
              </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="pro_numext">Num Ext.</label>
                    <input type="text" id="pro_numext" class="form-control requerido " placeholder=""  >
                  </div>
               </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="pro_numint">Num Int.</label>
                    <input type="text" id="pro_numint"  class="form-control " placeholder=""  >
                  </div>
               </div>

            </div>


            <div class="row">
            
              <div class="col-md-6">
                <div class="form-group">
                  <label for="pro_cp">Código postal</label>
                  <input type="text" id="pro_cp" maxlength="5" class="form-control requerido solo_numero" placeholder=""  >
                </div>
              </div> 

            </div>

          </form>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn_guardar_proveedor" class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>



<?php include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/footer.php"; ?>
  <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/util.js"></script>
 <script src="<?php echo $URL_PRINCIPAL; ?>assets/vendors/js/forms/select/select2.full.min.js"></script>
 <script src="<?php echo $URL_PRINCIPAL; ?>/assets/js/scripts/dropzone.js"></script>


 <script type="text/javascript" src="<?php echo $URL_PRINCIPAL; ?>core/js/almacen/entrada.js"></script>

 