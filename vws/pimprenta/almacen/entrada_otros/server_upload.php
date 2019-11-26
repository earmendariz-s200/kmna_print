<?php
session_start(); 
include "../../../../core/ph/config.php";

$storeFolder = "/../../temp/uploads/";

if (!empty($_FILES)) {

	$nombre = guid(); 

	$tempFile = $_FILES['file']['tmp_name'];

	$file_name = $_FILES['file']['name'];

	$tmp = explode('.', $file_name);
	$extencion = end($tmp);

 
	$archivo_nombre = $nombre.".".$extencion;

	$targetPath = dirname( __FILE__ ).$storeFolder;
	$targetFile = $targetPath.$archivo_nombre;
	move_uploaded_file($tempFile,$targetFile);

	echo $archivo_nombre;
}





?>   