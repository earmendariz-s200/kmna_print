<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('INSERT INTO MODULOS (MDL_CLV, MDL_NMBR, MDL_URL, MDL_ICN, SISTEMAS_SIS_IDINTRN, MDL_ACTV, MDL_CRCN) VALUES (:clave, :nombre, :url, :icono, :sistema, :activo, :creacion)');
	$db->bind(':clave', strtoupper($_POST["CLAVE"]));
	$db->bind(':nombre', strtoupper($_POST["NOMBRE"]));
	$db->bind(':url', $_POST["URL_MODULO"]);
	$db->bind('icono', $_POST["ICON"]);
	$db->bind(':sistema', $_POST["ID_SISTEMA"]);
	$db->bind(':activo', $_POST["ACTIVO"]);
	$db->bind(':creacion', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->exec();
	if($db->lastId()){
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $row;
	} else {
		$values["RESULT"] = false;
		$values["MESSAGE"] = "No hay datos disponible.";
		$values["DATA"] = null;
	}
} catch(Exception $ex){
	$values["RESULT"] = false;
	$values["MESSAGE"] = "Error. ".$ex;
	$values["DATA"] = null;
}
array_push($data, $values);
echo json_encode($data);

?>



