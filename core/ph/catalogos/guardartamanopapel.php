<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('INSERT INTO MEDIDAS_PAPEL (MEP_NMBR, MEP_ANCH, MEP_ALT, MEP_FORMACION_BASE, MEP_FORMACION_ALTO, MEP_CRCN, MEP_ACTV)
					VALUES (:nombre, :ancho, :alto, :formacion_base, :formacion_alto, :creacion, :activo)');
	$db->bind(':nombre', strtoupper($_POST["NOMBRE"]));
	$db->bind(':ancho', $_POST["ANCHO"]);
	$db->bind(':alto', $_POST["ALTO"]);
	$db->bind(':formacion_base', $_POST["FORMACION_BASE"]);
	$db->bind(':formacion_alto', $_POST["FORMACION_ALTO"]);
	$db->bind(':creacion', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->bind(':activo', $_POST["ACTIVO"]);
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
