<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{

	 


	$db->query("UPDATE 
  SUCURSALES
SET 
  SUC_NMBR = :SUC_NMBR,
  SUC_FL = :SUC_FL,
  SUC_DSCRPCN = :SUC_DSCRPCN,
  SUC_CLL = :SUC_CLL,
  SUC_NMREXTR = :SUC_NMREXTR,
  SUC_NUMRINTR = :SUC_NUMRINTR,
  SUC_CDGPSTL = :SUC_CDGPSTL,
  CLIENTES_CLI_IDINTRN = :CLIENTES_CLI_IDINTRN,
  MERCADOS_MER_IDMRCD = :MERCADOS_MER_IDMRCD,
  SUC_ACTV = :SUC_ACTV, 
  SUC_MDFCN = :SUC_MDFCN 
WHERE `SUC_IDINTRN` = :SUC_IDINTRN" );
	$db->bind(':SUC_NMBR', strtoupper($_POST["suc_nombre"]));  
	$db->bind(':SUC_FL', strtoupper($_POST["suc_folio"])); 
	$db->bind(':SUC_DSCRPCN', strtoupper($_POST["suc_descripcion"])); 
	$db->bind(':SUC_CLL', strtoupper($_POST["suc_calle"]));
	$db->bind(':SUC_CDGPSTL', strtoupper($_POST["suc_codigopostal"]));  
	$db->bind(':SUC_NMREXTR', strtoupper($_POST["suc_numext"])); 
	$db->bind(':SUC_NUMRINTR', strtoupper($_POST["suc_numint"])); 
	$db->bind(':CLIENTES_CLI_IDINTRN', strtoupper($_POST["hd_id_cliente"])); 
	$db->bind(':MERCADOS_MER_IDMRCD', strtoupper($_POST["suc_mercado"])); 
	$db->bind(':SUC_MDFCN', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->bind(':SUC_ACTV', $_POST["suc_activo"]);
	
	$db->bind(':SUC_IDINTRN', strtoupper($_POST["hdSucursalID"]));  

		 

	
	$db->exec();
	if($db->numrows() > 0){

		if ($_POST["suc_folio"] != "" || $_POST["suc_folio"] != "") {
			$db->query('
			UPDATE 
			  FOLIOS
			SET
			  FL_INCRMNT = FL_INCRMNT + 1
			WHERE FL_CLV = 1'); 
			$db->exec();
		} 

		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $_POST["hdSucursalID"];
	} else {
		$values["RESULT"] = false;
		$values["MESSAGE"] = "No se registro cambio. ";
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



 