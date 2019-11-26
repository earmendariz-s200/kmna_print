<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("UPDATE	`COTIZACIONES_DETALLE`
				SET		`TPR_IDINTRN` = :id_tip_pro,
						`CDE_TG` = :tag,
						`CDE_CNTD` = :cantidad,
						`CDE_TRBJ` = :tipo_trabajo,
						`CDE_URGNT` = :urgente,
						`CDE_TP_MDD_1` = :tipo_medida_1,
						`CDE_MDD_ANCH_1` = :ancho_1,
						`CDE_MDD_ALT_1` = :alto_1,
						`CDE_TP_MDD_2` = :tipo_medida_2,
						`CDE_MDD_ANCH_2` = :ancho_2,
						`CDE_MDD_ALT_2` = :alto_2,
						`CDE_HRNTZN` = :orientacion,
						`CDE_DSCRPCN` = :descripcion
				WHERE	`CDE_IDINTRN` = :id_cot_det");

	$db->bind(":id_cot_det", $_POST["ID_COT_DET"]);
	$db->bind(":id_tip_pro", $_POST["ID_TIPO_PRODUCTO"]);
	$db->bind(":tag", $_POST["TAG"]);
	$db->bind(":cantidad", $_POST["CANTIDAD"]);
	$db->bind(":tipo_trabajo", $_POST["TIPO_TRABAJO"]);
	$db->bind(":urgente", $_POST["URGENTE"]);
	$db->bind(":tipo_medida_1", $_POST["TIPO_MEDIDA_1"]);
	$db->bind(":ancho_1", $_POST["ANCHO_1"]);
	$db->bind(":alto_1", $_POST["ALTO_1"]);
	$db->bind(":tipo_medida_2", $_POST["TIPO_MEDIDA_2"]);
	$db->bind(":ancho_2", $_POST["ANCHO_2"]);
	$db->bind(":alto_2", $_POST["ALTO_2"]);
	$db->bind(":orientacion", $_POST["ORIENTACION"]);
	$db->bind(":descripcion", $_POST["DESCRIPCION"]);

	$db->exec();

	if ($db->rowCount() > 0) {

		$values["RESULT"] = true;

		$values["MESSAGE"] = "Consulta exitosa.";

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
