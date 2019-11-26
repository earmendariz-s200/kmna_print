<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('UPDATE ROLES  
					SET RLS_CLV=:clave, RLS_NMBR=:nombre, RLS_ACTV=:activo, RLS_MDFCN=:modificacion 
					WHERE RLS_IDINTRN=:id');
	$db->bind(':clave', strtoupper($_POST["CLAVE"]));
	$db->bind(':nombre', strtoupper($_POST["NOMBRE"]));
	$db->bind(':activo', $_POST["ACTIVO"]);
	$db->bind(':modificacion', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->bind(':id', $_POST["ID_ROL"]);
	$db->exec();
	if($db->numrows() > 0){
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $row;
	} else {
		$values["RESULT"] = false;
		$values["MESSAGE"] = "No se registro cambio.";
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



