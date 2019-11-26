<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query("INSERT INTO CONTACTOS( 
  `CNT_NMBR`,
  `CNT_APLLDPTRN`,
  `CNT_APLLDMTRN`,
  `CNT_EML`,
  `CNT_TLFN`,
  `CNT_CLLR`,
  `CNT_TPCNTCT`,
  `CNT_ACTV`,
  `CNT_CRCN`, 
  `SUCURSALES_SUC_IDINTRN`,
  `CLIENTES_CLI_IDINTRN`
) 
VALUES
  ( 
    :CNT_NMBR,
    :CNT_APLLDPTRN,
    :CNT_APLLDMTRN,
    :CNT_EML,
    :CNT_TLFN,
    :CNT_CLLR,
    :CNT_TPCNTCT,
    :CNT_ACTV,
    :CNT_CRCN, 
    :SUCURSALES_SUC_IDINTRN,
    :CLIENTES_CLI_IDINTRN
  )");
	$db->bind(':CNT_NMBR', strtoupper($_POST["cont_nombre"])); 
	$db->bind(':CNT_APLLDPTRN', strtoupper($_POST["cont_apellidop"])); 
	$db->bind(':CNT_APLLDMTRN', strtoupper($_POST["cont_apellidom"])); 
	$db->bind(':CNT_EML', strtoupper($_POST["cont_correo"])); 
	$db->bind(':CNT_TLFN', strtoupper($_POST["cont_telefono"])); 
	$db->bind(':CNT_CLLR', strtoupper($_POST["cont_celular"])); 
	$db->bind(':CNT_TPCNTCT', strtoupper($_POST["cont_tipocontacto"]));
	$db->bind(':CNT_ACTV', strtoupper($_POST["cont_activo"])); 
	$db->bind(':SUCURSALES_SUC_IDINTRN', strtoupper($_POST["cont_sucursales"])); 
	$db->bind(':CLIENTES_CLI_IDINTRN', strtoupper($_POST["hd_id_cliente"])); 
	$db->bind(':CNT_CRCN', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
  
	$db->exec();
	if($db->lastId()){
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



