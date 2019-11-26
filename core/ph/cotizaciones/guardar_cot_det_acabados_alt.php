<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("UPDATE	`COT_DET_ACABADOS`
				SET		`ACB_ALT_IDINTRN` = :id_acabado_alterno
				WHERE	`CDM_IDINTRN` = :id_det_material
						AND `ACB_IDINTRN` = :id_acabado");

	$db->bind(":id_det_material", $_POST["ID_DETMAT"]);
	$db->bind(":id_acabado", $_POST["ID_ACB"]);
	$db->bind(":id_acabado_alterno", $_POST["ID_ACB_ALT"]);

	$db->exec();

	if ($db->rowCount()) {
		
		$values["RESULT"] = true;
		
		$values["MESSAGE"] = "Guardado exitoso.";
		
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
