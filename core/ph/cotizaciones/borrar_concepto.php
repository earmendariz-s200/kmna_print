<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('DELETE FROM COTIZACIONES_DETALLE
					WHERE CDE_IDINTRN=:id');
	$db->bind(':id', $_POST["CDE_IDINTRN"]);
	$db->exec();
	$values["RESULT"] = true;
	$values["MESSAGE"] = "Consulta exitosa.";
	$values["DATA"] = $row;

} catch(Exception $ex){
	$values["RESULT"] = false;
	$values["MESSAGE"] = "Error. ".$ex;
	$values["DATA"] = null;
}
array_push($data, $values);
echo json_encode($data);

?>
