<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("SELECT	`ACB_IDINTRN`,
						`ACB_ALT_IDINTRN`
				FROM	`COT_DET_ACABADOS`
				WHERE	`CDM_IDINTRN` = :id_det_material");

	$db->bind("id_det_material", $_POST["ID_DETMAT"]);

	$row = $db->fetch();

	if (count($row) > 0) {

		$values["RESULT"] = true;

		$values["MESSAGE"] = "Consulta exitosa.";

		$values["DATA"] = $row;

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
