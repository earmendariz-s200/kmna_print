<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("SELECT	*
				FROM	`COTIZACIONES_DETALLE`
				WHERE	`CDE_IDINTRN` = :id_cot_det");

	$db->bind(":id_cot_det", $_POST["ID_COT_DET"]);

	$general = $db->fetch();

	$db->query("SELECT		`CDM`.`CDM_IDINTRN`,
							`CDM`.`CDM_US_PRTD`,
							`CDM`.`CDM_PGNS`,
							`CDM`.`CDM_MDD`,
							`CDM`.`CDM_IGLS`,
							`CDM`.`CDM_DSNS`,
							`CDM`.`TPA_IDINTRN`,
							`TPA`.`TPA_NMBR`,
							`CDM`.`GXP_IDINTRN`,
							`GPA`.`GPA_GRAMAJE`,
							`CDM`.`CDM_TTS_FRNT`,
							(SELECT `COL_NMBR` FROM `COLORES` WHERE `COL_IDINTR` = `CDM`.`CDM_TTS_FRNT`) AS `COL_NMBR_FRNT`,
							`CDM`.`CDM_TTS_VLT`,
							(SELECT `COL_NMBR` FROM `COLORES` WHERE `COL_IDINTR` = `CDM`.`CDM_TTS_VLT`) AS `COL_NMBR_VLT`
				FROM		`COT_DETALLE_MATERIALES`	AS `CDM`
				LEFT JOIN	`TIPO_PAPEL`				AS `TPA`	ON `CDM`.`TPA_IDINTRN` = `TPA`.`TPA_IDINTRN`
				LEFT JOIN	`GRAMAJE_PAPEL`				AS `GPA`	ON `CDM`.`GXP_IDINTRN` = `GPA`.`GXP_IDINTRN`
				WHERE		`CDE_IDINTRN` = :id_cot_det");

	$db->bind(":id_cot_det", $_POST["ID_COT_DET"]);
	
	$materiales = $db->fetch();

	if (count($materiales) > 0) {

		$ids = [];

		for ($i = 0; $i < count($materiales); $i++)
			array_push($ids, $materiales[$i]["CDM_IDINTRN"]);

		$in = join(", ", $ids);

		$db->query("SELECT		`CDA`.`CDA_IDINTRN`,
								`CDA`.`CDM_IDINTRN`,
								`CDA`.`ACB_IDINTRN`,
								`CCO`.`CCO_NMBR`,
								`CDA`.`ACB_ALT_IDINTRN`,
								IFNULL(`CCA`.`CCA_NMBR`, '') AS `CCA_NMBR`
					FROM		`COT_DET_ACABADOS`			AS `CDA`
					JOIN		`CONCEPTO_COSTEO`			AS `CCO`	ON `CDA`.`ACB_IDINTRN` = `CCO`.`CCO_IDINTRN`
					LEFT JOIN	`CONCEPTO_COS_ALTERNATIVAS`	AS `CCA`	ON `CDA`.`ACB_ALT_IDINTRN` = `CCA`.`CCA_IDINTRN`
					WHERE		`CDA`.`CDM_IDINTRN` IN ($in)
					ORDER BY	`CDA`.`CDM_IDINTRN`,
								`CDA`.`ACB_IDINTRN`");

		$acabados = $db->fetch();

	} else
		$acabados = [];

	/*
	$db->query("SELECT	`CDT`.`CDT_IDINTRN`,
						`CDT`.`TER_IDNTRN`,
						`TER`.`TER_NMBR`,
						`CDT`.`CDE_IDINTRN`
				FROM	`COT_DET_TERMINADOS`	AS `CDT`
				JOIN	`TERMINADOS`			AS `TER`	ON `CDT`.`TER_IDNTRN` = `TER`.`TER_IDNTRN`
				WHERE	`CDT`.`CDE_IDINTRN` = :id_cot_det");
	*/

	$db->query("SELECT	`CDT`.`CDT_IDINTRN`,
						`CDT`.`TER_IDNTRN`,
						`TER`.`CCO_NMBR`
				FROM	`COT_DET_TERMINADOS`	AS `CDT`
				JOIN	`CONCEPTO_COSTEO`		AS `TER`	ON `CDT`.`TER_IDNTRN` = `TER`.`CCO_IDINTRN` AND `TER`.`CCO_NMBR` IN ('Cosido', 'Engargolado', 'Grapas', 'Hotmelt')
				WHERE	`CDT`.`CDE_IDINTRN` = :id_cot_det");

	$db->bind(":id_cot_det", $_POST["ID_COT_DET"]);

	$terminados = $db->fetch();

	if (count($general) > 0) {

		$values["RESULT"] = true;

		$values["MESSAGE"] = "Consulta exitosa.";

		$values["GENERAL"] = $general;

		$values["MATERIALES"] = $materiales;

		$values["ACABADOS"] = $acabados;

		$values["TERMINADOS"] = $terminados;

		// $values["OBSERVACIONES"] = $;

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
