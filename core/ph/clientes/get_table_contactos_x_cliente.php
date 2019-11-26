<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('SELECT 
  `CNT_IDINTRN`,
  `CNT_NMBR`,
  `CNT_APLLDPTRN`,
  `CNT_APLLDMTRN`,
  `CNT_EML`,
  `CNT_TLFN`,
  `CNT_CLLR`,
  `CNT_TPCNTCT`,
  `CNT_ACTV`,
  `CNT_CRCN`,
  `CTN_MDFCN`,
  `SUCURSALES_SUC_IDINTRN`,
  `CLIENTES_CLI_IDINTRN` 
FROM
  CONTACTOS
 WHERE CLIENTES_CLI_IDINTRN = '.$_POST["id"]);
	$row = $db->fetch();
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