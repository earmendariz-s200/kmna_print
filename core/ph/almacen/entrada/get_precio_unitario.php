<?php
	header("Content-Type: application/json");
	include "../../config.php";
	include "../../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('SELECT 
  `MAT_IDINTRN`,
  `MAT_ACTV`,
  `MAT_ANCH`,
  `MAT_ALT`,
  `MAT_CSTMLLR`,
  `MAT_CSTUNTR`,
  `MAT_CRCN`,
  `MAT_MDFCN`,
  `MAT_IDTP`,
  `MAT_STCK` 
FROM
  MATERIALES WHERE MAT_IDINTRN='.$_POST["material"]);
	$row = $db->single();
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