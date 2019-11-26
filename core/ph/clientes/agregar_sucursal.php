<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query("INSERT INTO SUCURSALES (
  `SUC_NMBR`,
   SUC_FL,
  `SUC_DSCRPCN`,
  `SUC_CLL`,
  `SUC_NMREXTR`,
  `SUC_NUMRINTR`,
  `SUC_CDGPSTL`,
  `CLIENTES_CLI_IDINTRN`,
  `MERCADOS_MER_IDMRCD`,
  `SUC_ACTV`,
  `SUC_CRCN`
) 
VALUES
  ( 
    :SUC_NMBR,
    :SUC_FL,
    :SUC_DSCRPCN,
    :SUC_CLL,
    :SUC_NMREXTR,
    :SUC_NUMRINTR,
    :SUC_CDGPSTL,
    :CLIENTES_CLI_IDINTRN,
    :MERCADOS_MER_IDMRCD,
    :SUC_ACTV,
    :SUC_CRCN
  ) ");
	$db->bind(':SUC_NMBR', strtoupper($_POST["suc_nombre"])); 
	$db->bind(':SUC_FL', strtoupper($_POST["suc_folio"])); 
	$db->bind(':SUC_DSCRPCN', strtoupper($_POST["suc_descripcion"])); 
	$db->bind(':SUC_CLL', strtoupper($_POST["suc_calle"])); 
	$db->bind(':SUC_NMREXTR', strtoupper($_POST["suc_numext"])); 
	$db->bind(':SUC_NUMRINTR', strtoupper($_POST["suc_numint"])); 
	$db->bind(':SUC_CDGPSTL', strtoupper($_POST["suc_codigopostal"])); 
	$db->bind(':CLIENTES_CLI_IDINTRN', strtoupper($_POST["hd_id_cliente"]));
	$db->bind(':MERCADOS_MER_IDMRCD', strtoupper($_POST["suc_mercado"])); 
	$db->bind(':SUC_ACTV', strtoupper($_POST["suc_activo"])); 
	$db->bind(':SUC_CRCN', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
  
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



