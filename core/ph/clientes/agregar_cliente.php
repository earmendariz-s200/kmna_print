<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query("INSERT INTO CLIENTES (
  `CLI_NMCR`,
  `CLI_RFC`,
  `CLI_RZNSCL`,
  `CLI_CLL`,
  `CLI_NMREXTRR`,
  `CLI_NMRINTRN`,
  `CLI_CDGPSTL`,
  `CLI_ACTV`,
  `TIPOS_CLIENTES_TIC_IDINTRN`,
  `CREDITO_CLIENTE_CRC_IDINTRN`, 
  `FORMAS_CONTACTO_FRC_IDINTRN` 
) 
VALUES
  ( 
    :CLI_NMCR,
    :CLI_RFC,
    :CLI_RZNSCL,
    :CLI_CLL,
    :CLI_NMREXTRR,
    :CLI_NMRINTRN,
    :CLI_CDGPSTL,
    :CLI_ACTV,
    :TIPOS_CLIENTES_TIC_IDINTRN,
    :CREDITO_CLIENTE_CRC_IDINTRN,  
    :FORMAS_CONTACTO_FRC_IDINTRN 
  )");
	$db->bind(':CLI_NMCR', strtoupper($_POST["cli_nombre"])); 
	$db->bind(':CLI_RFC', strtoupper($_POST["cli_rfc"])); 
	$db->bind(':CLI_RZNSCL', strtoupper($_POST["cli_razon_social"])); 
	$db->bind(':CLI_CLL', strtoupper($_POST["cli_calle"])); 
	$db->bind(':CLI_NMRINTRN', strtoupper($_POST["cli_numint"])); 
	$db->bind(':CLI_NMREXTRR', strtoupper($_POST["cli_numext"]));
	$db->bind(':CLI_CDGPSTL', strtoupper($_POST["cli_cp"])); 
	$db->bind(':CLI_ACTV', strtoupper($_POST["cli_activo"]));  
	$db->bind(':TIPOS_CLIENTES_TIC_IDINTRN', strtoupper($_POST["cli_tipo"])); 
	$db->bind(':CREDITO_CLIENTE_CRC_IDINTRN', 1); 
	$db->bind(':FORMAS_CONTACTO_FRC_IDINTRN', strtoupper($_POST["cli_contacto"]));  


  
	$db->exec();
	if($db->lastId()){

		$id_cliente =  $db->lastId();
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $id_cliente;

		$db->query("INSERT INTO SUCURSALES (
		  `SUC_NMBR`,
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

		$db->bind(':SUC_NMBR', strtoupper("MATRIZ")); 
		$db->bind(':SUC_DSCRPCN', "SUCURSAL MATRIZ"); 
		$db->bind(':SUC_CLL', strtoupper($_POST["cli_calle"])); 
		$db->bind(':SUC_NMREXTR', strtoupper($_POST["cli_numext"])); 
		$db->bind(':SUC_NUMRINTR', strtoupper($_POST["cli_numint"])); 
		$db->bind(':SUC_CDGPSTL', strtoupper($_POST["cli_cp"])); 
		$db->bind(':CLIENTES_CLI_IDINTRN', $id_cliente);
		$db->bind(':MERCADOS_MER_IDMRCD', 1); 
		$db->bind(':SUC_ACTV', strtoupper($_POST["cli_activo"])); 
		$db->bind(':SUC_CRCN', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));  
	  
		$db->exec();

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



