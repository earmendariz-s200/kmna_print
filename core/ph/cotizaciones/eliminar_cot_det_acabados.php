<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("DELETE FROM	`COT_DET_ACABADOS`
				WHERE		`CDM_IDINTRN` = :id_det_material
							AND `ACB_IDINTRN` = :id_acabado");

	$db->bind(':id_det_material', $_POST["ID_DETMAT"]);

	$db->bind(':id_acabado', $_POST["ID_ACB"]);

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
