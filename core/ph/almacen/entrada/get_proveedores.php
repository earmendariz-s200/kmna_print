<?php
	header("Content-Type: application/json");
	include "../../config.php";
	include "../../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('SELECT 
  PRV_IDINTRN,
  PRV_RFC,
  PRV_RZNSCL,
  PRV_CLL,
  PRV_NMREXTRN,
  PRV_NMRINTRN,
  PRV_CDGPSTL 
FROM
  PROVEEDORES');
	$row = $db->fetch();
	if(count($row) > 0){
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $row;
	} else {
		$values["RESULT"] = false;
		$values["MESSAGE"] = "No hay proveedores.";
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