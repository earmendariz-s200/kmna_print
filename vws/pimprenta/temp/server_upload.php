<?php


$storeFolder = "/uploads/";

if (!empty($_FILES)) {

	$tempFile = $_FILES['file']['tmp_name'];
	$targetPath = dirname( __FILE__ ).$storeFolder;
	$targetFile = $targetPath."angel.jpg";
	move_uploaded_file($tempFile,$targetFile);
}
?>   