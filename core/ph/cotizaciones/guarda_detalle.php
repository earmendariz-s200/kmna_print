<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("INSERT INTO	`COTIZACIONES_DETALLE` (
							`COT_IDINTRN`,
							`TPR_IDINTRN`,
							`CDE_TG`,
							`CDE_CNTD`,
							`CDE_TRBJ`,
							`CDE_URGNT`,
							`CDE_TP_MDD_1`,
							`CDE_MDD_ANCH_1`,
							`CDE_MDD_ALT_1`,
							`CDE_TP_MDD_2`,
							`CDE_MDD_ANCH_2`,
							`CDE_MDD_ALT_2`,
							`CDE_HRNTZN`
							) VALUES (
							:id_cotizacion,
							:tipo_producto,
							:tag,
							:cantidad,
							:trabajo,
							:urgente,
							:tipo_medida_1,
							:ancho_1,
							:alto_1,
							:tipo_medida_2,
							:ancho_2,
							:alto_2,
							:orientacion
							)");

	$db->bind(":id_cotizacion", $_POST["ID_COTIZACION"]);
	$db->bind(":tipo_producto", $_POST["ID_TIPO_PRODUCTO"]);
	$db->bind(":tag", $_POST["TAG"]);
	$db->bind(":cantidad", $_POST["CANTIDAD"]);
	$db->bind(":trabajo", $_POST["TIPO_TRABAJO"]);
	$db->bind(":urgente", $_POST["URGENTE"]);
	$db->bind(":tipo_medida_1", $_POST["TIPO_MEDIDA_1"] );
	$db->bind(":ancho_1", $_POST["ANCHO_1"]);
	$db->bind(":alto_1", $_POST["ALTO_1"]);
	$db->bind(":tipo_medida_2", $_POST["TIPO_MEDIDA_2"]);
	$db->bind(":ancho_2", $_POST["ANCHO_2"]);
	$db->bind(":alto_2", $_POST["ALTO_2"]);
	$db->bind(":orientacion", $_POST["ORIENTACION"]);

	$db->exec();

	if ($db->lastId()) {

		$values["RESULT"] = true;

		$values["MESSAGE"] = "Consulta exitosa.";

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
