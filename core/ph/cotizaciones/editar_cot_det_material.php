<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("UPDATE	`COT_DETALLE_MATERIALES`
				SET		`CDM_US_PRTD` = :uso,
						`CDM_PGNS` = :paginas,
						`CDM_MDD` = :medidas,
						`CDM_IGLS` = :iguales,
						`CDM_DSNS` = :disenos,
						`TPA_IDINTRN` = :tipo_papel,
						`GXP_IDINTRN` = :gramaje_papel,
						`CDM_TTS_FRNT` = :tintas_frente,
						`CDM_TTS_VLT` = :tintas_vuelta,
						`CDE_MED_ANCH` = :medida_ancho,
						`CDE_MED_ALTO` = :medida_alto,
						`CDE_MED_IDNT` = :medida_identificar
				WHERE	`CDM_IDINTRN` = :id_material
						AND `CDE_IDINTRN` = :id_detalle");

	$db->bind(":id_material", $_POST["ID_MATERIAL"]);
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
