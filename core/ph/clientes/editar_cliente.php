<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{

	 


	$db->query('UPDATE 
  `CLIENTES` 
SET 
  `CLI_NMCR` = :nombre,
  `CLI_RFC` = :rfc,
  `CLI_RZNSCL` = :razon,
  `CLI_CLL` = :calle,
  `CLI_NMREXTRR` = :numext,
  `CLI_NMRINTRN` = :numint,
  `CLI_CDGPSTL` = :cp, 
  `CLI_ACTV` = :activo,
  `TIPOS_CLIENTES_TIC_IDINTRN` = :tipocliente, 
  `FORMAS_CONTACTO_FRC_IDINTRN` = :formacontacto 
WHERE `CLI_IDINTRN` =:id_cliente ;
');
	$db->bind(':nombre', strtoupper($_POST["cli_nombre"])); 
	$db->bind(':rfc', strtoupper($_POST["cli_rfc"])); 
	$db->bind(':razon', strtoupper($_POST["cli_razon_social"])); 
	$db->bind(':calle', strtoupper($_POST["cli_calle"]));  
	$db->bind(':numext', strtoupper($_POST["cli_numext"])); 
	$db->bind(':numint', strtoupper($_POST["cli_numint"])); 
	$db->bind(':cp', strtoupper($_POST["cli_cp"]));  
	$db->bind(':tipocliente', strtoupper($_POST["cli_tipo"])); 
	$db->bind(':formacontacto', strtoupper($_POST["cli_contacto"])); 
	$db->bind(':activo', $_POST["cli_activo"]);
	
	$db->bind(':id_cliente', strtoupper($_POST["hd_id_cliente"]));  
	
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



 