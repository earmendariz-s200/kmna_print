<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("DELETE FROM	`COT_DET_TERMINADOS`
				WHERE		`CDE_IDINTRN` = :id_cot_det
							AND `TER_IDNTRN` = :id_terminado");

	$db->bind(":id_cot_det", $_POST["ID_COTDET"]);

	$db->bind(":id_terminado", $_POST["ID_TER"]);

	$db->exec();

	if ($db->rowCount() > 0) {

		$values["RESULT"] = true;

		$values["MESSAGE"] = "Eliminado exitosamente.";

		$values["DATA"] = null;
		
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
