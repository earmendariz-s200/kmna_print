<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
 
 

	$id_factura = $_POST["id_fac"];
	$estatus = $_POST["estatus"];

	$data = array();
	try{
	$db->query('UPDATE fac_facturas SET estatus = :estatus WHERE id_factura = :id_factura');
	$db->bind(':estatus', $estatus); 
	$db->bind(':id_factura', $id_factura);
	$db->exec();
	
	if($db->numrows() > 0){
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $db->lastId();
	} else {
		$values["RESULT"] = false;
		$values["MESSAGE"] = "NO SE ACTUALIZO";
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



