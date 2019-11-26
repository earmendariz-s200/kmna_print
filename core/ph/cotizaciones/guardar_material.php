<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("INSERT INTO	`COT_DETALLE_MATERIALES` (
							`CDM_US_PRTD`,
							`CDM_PGNS`,
							`CDM_MDD`,
							`CDM_IGLS`,
							`CDM_DSNS`,
							`TPA_IDINTRN`,
							`GXP_IDINTRN`,
							`CDM_TTS_FRNT`,
							`CDM_TTS_VLT`,
							`CDE_IDINTRN`,
							`CDE_MED_ANCH`,
							`CDE_MED_ALTO`,
							`CDE_MED_IDNT`
							) VALUES (
							:uso,
							:paginas,
							:medidas,
							:iguales,
							:disenos,
							:tipo_papel,
							:gramaje_papel,
							:tintas_frente,
							:tintas_vuelta,
							:id_detalle,
							:medida_ancho,
							:medida_alto,
							:medida_identificar
							)");

	$db->bind(":uso", $_POST["USO"]);
	$db->bind(":paginas", $_POST["PAGINAS"]);
	$db->bind(":medidas", $_POST["MEDIDAS"]);
	$db->bind(":iguales", $_POST["IGUALES"]);
	$db->bind(":disenos", $_POST["DISENO"]);
	$db->bind(":tipo_papel", $_POST["TIPO_PAPEL"]);
	$db->bind(":gramaje_papel", $_POST["GRAMAJE"]);
	$db->bind(":tintas_frente", $_POST["TINTAS_FRENTE"]);
	$db->bind(":tintas_vuelta", $_POST["TINTAS_VUELTA"]);
	$db->bind(":id_detalle", $_POST["ID_DETALLE"]);
	$db->bind(":medida_ancho", $_POST["MEDIDA_ANCHO"]);
	$db->bind(":medida_alto", $_POST["MEDIDA_ALTO"]);
	$db->bind(":medida_identificar", $_POST["IDENTIFICAR"]);

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
