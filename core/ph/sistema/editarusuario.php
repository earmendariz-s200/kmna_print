<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('UPDATE USUARIOS SET USR_CLV=:clave, USR_PSSWRD=:password, USR_NMBR=:nombre, USR_APLLDPTRN=:paterno, USR_APLLDMTRN=:materno, USR_ACTV=:activo, ROLES_RLS_IDINTRN=:rol, USR_MDFCN=:modificacion, USR_PRVLGS=:USR_PRVLGS WHERE USR_IDINTRN=:id');
	$db->bind(':clave', $_POST["CLAVE"]);
	$db->bind(':password', encrypt_decrypt(1, $_POST["PASSWORD"]));
	$db->bind(':nombre', strtoupper($_POST["NOMBRE"]));
	$db->bind(':paterno', strtoupper($_POST["PATERNO"]));
	$db->bind(':materno', strtoupper($_POST["MATERNO"]));
	$db->bind(':activo', $_POST["ACTIVO"]);
	$db->bind(':rol', $_POST["ID_ROL"]);
	$db->bind(':USR_PRVLGS', $_POST["PRIVILEGIOS"]);

	$db->bind(':modificacion', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->bind(':id', $_POST["ID_USUARIO"]);
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



