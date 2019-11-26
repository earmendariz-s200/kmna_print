<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('UPDATE COTIZACIONES_DETALLE
					SET  CDE_DSCRPCN=:descripcion
					WHERE CDE_IDINTRN=:id');
	$db->bind(':id', $_POST["ID_DETALLE"]);
  $db->bind(':descripcion', $_POST["DESCRIPCION"]);
	$db->exec();
	//if($db->numrows() > 0){
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $row;
	// } else {
	// 	$values["RESULT"] = false;
	// 	$values["MESSAGE"] = "No se registro cambio. ";
	// 	$values["DATA"] = null;
	// }
} catch(Exception $ex){
	$values["RESULT"] = false;
	$values["MESSAGE"] = "Error. ".$ex;
	$values["DATA"] = null;
}
array_push($data, $values);
echo json_encode($data);

?>
