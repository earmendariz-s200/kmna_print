<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("SELECT	`MEP_IDINTRN`,
						`MEP_NMBR`,
						CONCAT(`MEP_ANCH`, 'cm X ', `MEP_ALT`, 'cm') AS `MEP_ANCH_ALT`,
						MEP_ANCH AS ANCHO,
						MEP_ALT AS ALTO,
						MEP_FORMACION_BASE AS COLUMNAS,
						MEP_FORMACION_ALTO AS FILAS
				FROM	`MEDIDAS_PAPEL`");

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
