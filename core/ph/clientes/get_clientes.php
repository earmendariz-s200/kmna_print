<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("SELECT		`C`.`CLI_IDINTRN`,
							`C`.`CLI_NMCR`,
							`C`.`CLI_ACTV`,
							`C`.`CLI_CDGPSTL`,
							`C`.`CLI_FCHPRMR`,
							`C`.`CLI_RFC`,
							`C`.`CLI_RZNSCL`,
							`TC`.`TIC_NMBR` AS `TIPO_CLIENTE`
				FROM		`CLIENTES`			AS `C`
				INNER JOIN	`TIPOS_CLIENTES`	AS `TC`	ON `C`.`TIPOS_CLIENTES_TIC_IDINTRN` = `TC`.`TIC_IDINTRN`
				WHERE		1 = 1
							AND `C`.`CLI_PRSPCT` IN ($_POST[prospecto])");

	$row = $db->fetch();

	if (count($row) > 0) {

		$values["RESULT"] = true;

		$values["MESSAGE"] = "Consulta exitosa.";

		$values["DATA"] = $row;

	} else {

		$values["RESULT"] = false;

		$values["MESSAGE"] = "No hay clientes disponibles.";

		$values["DATA"] = null;

	}

} catch (Exception $ex) {

	$values["RESULT"] = false;

	$values["MESSAGE"] = "Error. " . $ex;

	$values["DATA"] = null;

}

array_push($data, $values);

echo json_encode($data);
