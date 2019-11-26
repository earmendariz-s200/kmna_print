<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('INSERT INTO ROLES (RLS_CLV, RLS_NMBR, RLS_ACTV, RLS_CRCN) VALUES (:clave, :nombre, :activo, :creacion)');
	$db->bind(':clave', strtoupper($_POST["CLAVE"]));
	$db->bind(':nombre', strtoupper($_POST["NOMBRE"]));
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



