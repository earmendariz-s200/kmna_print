<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('SELECT * FROM SUAJES WHERE SUA_IDINTRN=:id');
  $db->bind(":id", $_POST["ID_SUAJE"]);
  $row = $db->single();
  if(count($row) > 0){
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Datos guardados.";
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
