<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("SELECT		`COT`.`COT_FL`,
							`CLI`.`CLI_IDINTRN`,
							`CON`.`CNT_IDINTRN`,
							`USU`.`USR_IDINTRN`,
							`COT`.`COT_FCHINC`,
							`COT`.`COT_FCHFN`,
							`CLI`.`CONDICIONES_CPA_IDINTRN`
				FROM		`COTIZACIONES`	AS `COT`
				INNER JOIN	`CONTACTOS`		AS `CON`	ON `COT`.`CONTACTOS_CNT_IDINTRN` = `CON`.`CNT_IDINTRN`
				INNER JOIN	`CLIENTES`		AS `CLI`	ON `CON`.`CLIENTES_CLI_IDINTRN` = `CLI`.`CLI_IDINTRN`
				INNER JOIN	`USUARIOS`		AS `USU`	ON `COT`.`USUARIOS_USR_VNDEDR` = `USU`.`USR_IDINTRN`
				WHERE		`COT_IDINTRN` = :id");

	$db->bind(":id", $_POST["COT_IDINTRN"]);

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
