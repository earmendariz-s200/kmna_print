<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	$db->query("SELECT	`COND`.`CPA_IDINTRN`,
						`COND`.`CPA_NMBR`
				FROM	`CONDICIONES`	AS `COND`
				JOIN	`CLIENTES`		AS `CLIE`	ON `COND`.`CPA_IDINTRN` = `CLIE`.`CONDICIONES_CPA_IDINTRN`
				WHERE	`CLIE`.`CLI_IDINTRN` = :id_cliente");

	$db->bind(":id_cliente", $_POST["ID_CLIENTE"]);

	$row = $db->fetch();

	$values["RESULT"] = true;

	$values["MESSAGE"] = "Consulta exitosa.";

	$values["DATA"] = $row;

} catch (Exception $ex) {

	$values["RESULT"] = false;

	$values["MESSAGE"] = "Error. " . $ex;

	$values["DATA"] = null;

}

array_push($data, $values);

echo json_encode($data);
