<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();

	$uuid = $_POST["uuid"];

	try{
	$db->query('SELECT
  `id_factura`,
  `folio`,
  `id_cotizacion`,
  `fecha`,
  `iva`,
  `sub_total`,
  `total_factura`,
  `UUID`,
  `urlXML`,
  `urlPDF`,
  `estatus`,
  `conPagos`,
  `total_pagos`
FROM
  fac_facturas
  WHERE UUID = "'.$uuid.'"' );


	$row = $db->single();
	if(count($row) > 0){
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $row;
	} else {
		$values["RESULT"] = false;
		$values["MESSAGE"] = "No hay datos disponible.";
		$values["DATA"] = null;
	}

} catch(Exception $ex){
	$values["RESULT"] = false;
	$values["MESSAGE"] = "Error. ".$ex;
	$values["DATA"] = null;
}
array_push($data, $values);
echo json_encode($data);

?>