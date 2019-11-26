<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("INSERT INTO	`COT_DET_TERMINADOS` (
							`TER_IDNTRN`,
							`CDE_IDINTRN`
							) VALUES (
							:id_terminado,
							:id_cot_det
							)");

	$db->bind(":id_cot_det", $_POST["ID_COTDET"]);

	$db->bind(":id_terminado", $_POST["ID_TER"]);

	$db->exec();

	if ($db->lastId()) {

		$values["RESULT"] = true;
		
		$values["MESSAGE"] = "Guardado exitoso.";
		
		$values["DATA"] = $db->lastId();

	} else {

		$values["RESULT"] = false;

		$values["MESSAGE"] = "No hay datos disponible.";

		$values["DATA"] = null;

	}

} catch (Exception $ex) {

	$values["RESULT"] = false;

	$values["MESSAGE"] = "Error. " . $ex;

	$values["DATA"] = null;

}

array_push($data, $values);

echo json_encode($data);
