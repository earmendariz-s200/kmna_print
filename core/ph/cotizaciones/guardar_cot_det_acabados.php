<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("INSERT INTO	`COT_DET_ACABADOS` (
							`CDM_IDINTRN`,
							`ACB_IDINTRN`,
							`ACB_ALT_IDINTRN`
							) VALUES (
							:id_det_material,
							:id_acabado,
							:id_acabado_alterno
							)");

	$db->bind(":id_det_material", $_POST["ID_DETMAT"]);
	$db->bind(":id_acabado", $_POST["ID_ACB"]);
	$db->bind(":id_acabado_alterno", $_POST["ID_ACB_ALT"]);

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
