<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('INSERT INTO PLACAS (PLC_CLAVE, PLC_CLI_IDINTRN, PLC_ESTADO, PLC_DSCRPCN, PLC_COSTO, PLC_TNTS, PLC_ACTV, PLC_CRCN) VALUES (:clave, :idcliente, :estado, :descripcion, :costo, :tintas, :activo, :creacion)');
	$db->bind(':clave', mb_strtoupper($_POST["CLAVE"]));
	$db->bind(':idcliente', $_POST["IDCLIENTE"]);
	$db->bind(':estado', $_POST["ESTADO"]);
	$db->bind(':descripcion', mb_strtoupper($_POST["DESCRIPCION"]));
	$db->bind(':costo', $_POST["COSTO"]);
	$db->bind(':tintas', $_POST["TINTAS"]);
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