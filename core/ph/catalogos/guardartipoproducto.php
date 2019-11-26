<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('INSERT INTO TIPO_PRODUCTO (TPR_NMBR, TPR_TPTRBJ, TPR_ACTV, TPR_CRCN, TPR_TPDSN) VALUES (:nombre, :tipo_trabajo, :activo, :creacion, :tipo_diseno)');
	$db->bind(':nombre', strtoupper($_POST["NOMBRE"]));
	$db->bind(':tipo_trabajo', $_POST["TIPO_TRABAJO"]);
	$db->bind(':activo', $_POST["ACTIVO"]);
	$db->bind(':creacion', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->bind(':tipo_diseno', $_POST["TIPO_DISENO"]);
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
