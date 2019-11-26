<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();

	$id_factura = $_POST["id_fac"];

	try{
	$db->query('SELECT * FROM fac_facturas 
INNER JOIN COTIZACIONES ON fac_facturas.id_cotizacion = COTIZACIONES.COT_IDINTRN
INNER JOIN CONTACTOS ON CONTACTOS.`CNT_IDINTRN` = COTIZACIONES.`CONTACTOS_CNT_IDINTRN` 
INNER JOIN CLIENTES ON CONTACTOS.`CLIENTES_CLI_IDINTRN` = CLIENTES.`CLI_IDINTRN`
INNER JOIN fac_empresa ON fac_empresa.`id_empresa` = 1
WHERE fac_facturas.`id_factura` ='.$id_factura );
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