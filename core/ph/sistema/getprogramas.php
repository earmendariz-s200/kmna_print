<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('SELECT * FROM PROGRAMAS
					INNER JOIN MODULOS ON MODULOS.MDL_IDINTRN = PROGRAMAS.MODULOS_MDL_IDINTRN  
	                INNER JOIN SISTEMAS ON SISTEMAS.SIS_IDINTRN = MODULOS.SISTEMAS_SIS_IDINTRN');
	$row = $db->fetch();
	if(count($row) > 0){
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