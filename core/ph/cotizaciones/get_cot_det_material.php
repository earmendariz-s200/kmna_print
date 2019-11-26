<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("SELECT	`CDM_US_PRTD`,
						`CDM_PGNS`,
						`CDM_MDD`,
						`CDM_IGLS`,
						`CDM_DSNS`,
						`TPA_IDINTRN`,
						`GXP_IDINTRN`,
						`CDM_TTS_FRNT`,
						`CDM_TTS_VLT`,
						IFNULL(`CDE_MED_ANCH`, 0.00) AS `CDE_MED_ANCH`,
						IFNULL(`CDE_MED_ALTO`, 0.00) AS `CDE_MED_ALTO`,
						IFNULL(`CDE_MED_IDNT`, '') AS `CDE_MED_IDNT`
				FROM	`COT_DETALLE_MATERIALES`
				WHERE	`CDM_IDINTRN` = :id_material
						AND `CDE_IDINTRN` = :id_detalle");

	$db->bind(":id_material", $_POST["ID_MATERIAL"]);
	$db->bind(":id_detalle", $_POST["ID_DETALLE"]);

	$r = $db->fetch();

	if (count($r) > 0) {

		$values["RESULT"] = true;

		$values["MESSAGE"] = "Consulta exitosa.";

		$values["DATA"] = $r;

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
