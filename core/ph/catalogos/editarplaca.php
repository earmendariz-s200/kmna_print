<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('UPDATE PLACAS  
					SET  	PLC_CLAVE=:clave, 
							PLC_CLI_IDINTRN=:idcliente, 
							PLC_ESTADO=:estado, 
							PLC_DSCRPCN=:descripcion, 
							PLC_COSTO=:costo, 
							PLC_TNTS=:tintas,
							PLC_ACTV=:activo,
							PLC_MDFCN=:modificacion
					WHERE PLC_IDINTRN=:id');
	$db->bind(':clave', mb_strtoupper($_POST["CLAVE"]));
	$db->bind(':idcliente', $_POST["IDCLIENTE"]);
	$db->bind(':estado', $_POST["ESTADO"]);
	$db->bind(':descripcion', mb_strtoupper($_POST["DESCRIPCION"]));
	$db->bind(':costo', $_POST["COSTO"]);
	$db->bind(':tintas', $_POST["TINTAS"]);
	$db->bind(':activo', $_POST["ACTIVO"]);
	$db->bind(':modificacion', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->bind(':id', $_POST["ID"]);
	$db->exec();
	if($db->numrows() > 0){
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $row;
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

