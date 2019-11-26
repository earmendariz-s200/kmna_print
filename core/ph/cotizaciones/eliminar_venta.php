<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	/**
	 *
	 * Primero: consultar si su
	 * estatus esta en pendiente.
	 */
	$db->query("SELECT IFNULL(`COT_ESTTS`, 'x') AS `ESTATUS` FROM `COTIZACIONES` WHERE `COT_IDINTRN` = :id");

	$db->bind(":id", $_POST["ID"]);

	$estatus = $db->single()["ESTATUS"];

	/**
	 *
	 * Segundo: comprobar si el
	 * estatus es diferente x.
	 */
	$db->beginTrans();

	if ($estatus != "x") {

		$db->query("UPDATE `COTIZACIONES` SET `COT_ESTTS` = 6 WHERE `COT_IDINTRN` = :id");

		$db->bind(":id", $_POST["ID"]);

		if ($db->exec()) {

			$db->endTrans();

			$values["RESULT"] = true;

			$values["MESSAGE"] = "Consulta exitosa.";

			$values["DATA"] = null;

		} else {

			$db->cancel();

			$values["RESULT"] = false;

			$values["MESSAGE"] = "No hay datos disponible.";

			$values["DATA"] = null;

		}

	} /*else {

		$db->endTrans();

		$db->cancel();

	}*/

} catch (Exception $ex) {

	if ($db->transActive())
		$db->cancel();

	$values["RESULT"] = false;

	$values["MESSAGE"] = "Error. " . $ex;

	$values["DATA"] = null;

}

array_push($data, $values);

echo json_encode($data);
