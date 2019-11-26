<?php 
 
 session_start(); 
if(!isset($_SESSION["DIR_LOCAL"])) 
{   
   $host = $_SERVER["HTTP_HOST"]; 
  header("Location: //".$host);
} 
 

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
                <h4 class="card-title">Titulo</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="card-content">
                <div class="card-body">
                  
                </div>
              </div>
            </div>
          </div>
        </div>
     
      </div>
    </div>
  </div>

<?php include realpath($_SERVER["DOCUMENT_ROOT"]).$_SESSION["DIR_LOCAL"]."/vws/footer.php"; ?>