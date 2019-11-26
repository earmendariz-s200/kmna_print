<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{

	 


	$db->query('UPDATE 
  CLIENTES
SET
  CLI_LMT_CRDT = :CLI_LMT_CRDT,
  CLI_CRDT_CTV = :CLI_CRDT_CTV,
  CONDICIONES_CPA_IDINTRN = :CONDICIONES_CPA_IDINTRN,
  CLI_ESTTS_CRDT = :CLI_ESTTS_CRDT 
WHERE CLI_IDINTRN = :CLI_IDINTRN ');

	$db->bind(':CLI_LMT_CRDT', strtoupper($_POST["cli_limite_credito"])); 
	$db->bind(':CLI_CRDT_CTV', strtoupper($_POST["ACTIVO"])); 
	$db->bind(':CLI_ESTTS_CRDT', strtoupper($_POST["rank"])); 
	$db->bind(':CLI_IDINTRN', strtoupper($_POST["hd_id_cliente"]));  
	$db->bind(':CONDICIONES_CPA_IDINTRN', strtoupper($_POST["cli_forma_pago"]));  


	  
	
	$db->exec();
	if($db->numrows() > 0){
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $_POST["hd_id_cliente"];
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



 