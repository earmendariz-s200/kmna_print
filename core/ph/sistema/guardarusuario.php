<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('INSERT INTO USUARIOS (USR_CLV, USR_PSSWRD, USR_NMBR, USR_APLLDPTRN, USR_APLLDMTRN, USR_ACTV, ROLES_RLS_IDINTRN, USR_CRCN,USR_PRVLGS) VALUES (:clave, :password, :nombre, :paterno, :materno, :activo, :rol, :creacion,:USR_PRVLGS)');
	$db->bind(':clave', $_POST["CLAVE"]);
	$db->bind(':password', encrypt_decrypt(1, $_POST["PASSWORD"]));
	$db->bind(':nombre', strtoupper($_POST["NOMBRE"]));
	$db->bind(':paterno', strtoupper($_POST["PATERNO"]));
	$db->bind(':materno', strtoupper($_POST["MATERNO"]));
	$db->bind(':activo', $_POST["ACTIVO"]);
	$db->bind(':USR_PRVLGS', $_POST["PRIVILEGIOS"]);
	
	$db->bind(':rol', $_POST["ID_ROL"]);
	$db->bind(':creacion', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
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



