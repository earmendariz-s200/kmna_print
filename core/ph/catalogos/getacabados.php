<?php

header("Content-Type: application/json");

include "../config.php";

include "../utilerias/funciones.php";

$data = array();

try {

	// $db->query('SELECT * FROM ACABADOS');

	// $db->query("SELECT		`CC`.`CCO_IDINTRN`,
	// 						`CC`.`CCO_NMBR`
	// 			FROM		`CONCEPTO_COSTEO`		AS `CC`
	// 			INNER JOIN	`COSTEO_AREA`			AS `CA`		ON `CC`.`COA_IDINTRN` = `CA`.`COA_IDINTRN`
	// 			INNER JOIN	`UNIDADES`				AS `U`		ON `CC`.`UNI_IDINTRN` = `U`.`UNI_IDINTRN`
	// 			INNER JOIN	`CONFIG_COTI_CONCEPTO`	AS `CCC`	ON `CC`.`CCO_IDINTRN` = `CCC`.`CCO_IDINTRN`
	// 			WHERE		`CCC`.`SYS_TIPO_TRABAJO` = 0
	// 						AND `CC`.`SYS_AREA_PRODUCCION` = 2
	// 			ORDER BY	`CC`.`CCO_NMBR`");

	if ($_POST["TIPO_DISENO"] == 2)
		$acabdos = "'Suaje', 'Folio', 'Ojillo', 'Pegamento', 'Barniz', 'Plastificado', 'Perforacion', 'Troquelar', 'Pleca de Doblez', 'Ponchado Manual', 'Color Piroflex', 'Arillo Metalico', 'Grapado Manual', 'Hot Stamping'";
	else
		$acabdos = "'Suaje', 'Folio', 'Ojillo', 'Pegamento', 'Barniz', 'Plastificado', 'Perforacion', 'Engargolado', 'Realzar al Fuego', 'Troquelar', 'Pleca de Doblez', 'Ponchado Manual', 'Intercalar Carbón', 'Color Piroflex', 'Broche Baco', 'Block', 'Dobladora', 'Grapado Manual', 'Pleca de Precorte', 'Puntas Redondas', 'Hot Stamping'";

	$db->query("SELECT		`CCO_IDINTRN`,
							`CCO_NMBR`
				FROM		`CONCEPTO_COSTEO`
				WHERE		`CCO_NMBR` IN ($acabdos)
				ORDER BY	`CCO_NMBR`");

	$row1 = $db->fetch();

	$db->query("SELECT		`CCA`.`CCA_IDINTRN`,
							`CCA`.`CCO_IDINTRN`,
							`CCA`.`CCA_NMBR`
				FROM		`CONCEPTO_COS_ALTERNATIVAS`	AS `CCA`
				JOIN		`CONCEPTO_COSTEO`			AS `CCO`	ON `CCA`.`CCO_IDINTRN` = `CCO`.`CCO_IDINTRN`
				WHERE		`CCO`.`CCO_NMBR` IN ($acabdos)
				ORDER BY	`CCA`.`CCO_IDINTRN`,
							`CCA`.`CCA_NMBR`");

	$row2 = $db->fetch();

	if (count($row1) > 0) {

		$values["RESULT"] = true;

		$values["MESSAGE"] = "Consulta exitosa.";

		$values["DATA"] = $row1;

		$values["ALTERNOS"] = $row2;

	} else {

		$values["RESULT"] = false;

		$values["MESSAGE"] = "No hay datos disponible.";

		$values["DATA"] = null;

	}

} catch (Exception $ex) {

	$values["RESULT"] = false;

	$values["MESSAGE"] = "Error. ".$ex;

	$values["DATA"] = null;

}

array_push($data, $values);

echo json_encode($data);
