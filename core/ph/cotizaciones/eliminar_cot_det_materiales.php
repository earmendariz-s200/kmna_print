<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("DELETE FROM	`COT_DETALLE_MATERIALES`
				WHERE		`CDM_IDINTRN` = :id_det_material");

	$db->bind(":id_det_material", $_POST["ID_DETMAT"]);

	$db->exec();
	
	$values["RESULT"] = true;

	$values["MESSAGE"] = "Eliminado exitosamente.";

	$values["DATA"] = null;

} catch (Exception $ex) {

	$values["RESULT"] = false;

	$values["MESSAGE"] = "Error. ".$ex;

	$values["DATA"] = null;

}

array_push($data, $values);

echo json_encode($data);
