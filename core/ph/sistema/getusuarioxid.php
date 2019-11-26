<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('SELECT * FROM USUARIOS 
	               		INNER JOIN ROLES ON ROLES.RLS_IDINTRN = USUARIOS.ROLES_RLS_IDINTRN 
	               WHERE USUARIOS.USR_IDINTRN='.$_POST["ID_USUARIO"]);
	$row = $db->single();
	if(count($row) > 0){
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $row;
		$values["PSSWRD"] = encrypt_decrypt(2, $row["USR_PSSWRD"]);
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