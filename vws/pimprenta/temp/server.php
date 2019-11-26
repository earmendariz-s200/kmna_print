<?php 

session_start(); 
include "../../../core/ph/config.php";
?>

<!DOCTYPE html>

<meta charset="utf-8">

<title>Dropzone simple example</title>

 

<script src="<?php echo $URL_PRINCIPAL; ?>/assets/js/scripts/dropzone.js"></script>
<link rel="stylesheet" href="<?php echo $URL_PRINCIPAL; ?>/assets/css/dropzone.css">


<p>
  This is the most minimal example of Dropzone. The upload in this example
  doesn't work, because there is no actual server to handle the file upload.
</p>

<!-- Change /upload-target to your upload address -->
<form action="server_upload.php" class="dropzone">
	


</form>




