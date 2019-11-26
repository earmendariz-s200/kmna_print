<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$password = encrypt_decrypt(1, $_POST["PASSWORD"]);
	$db->query('SELECT * FROM USUARIOS WHERE USR_CLV= :usuario');
	$db->bind(':usuario', $_POST['USUARIO']);
	$row = $db->single();
	if(count($row) == 0){
		$values["RESULT"] = false;
		$values["MESSAGE"] = "Datos de Acceso Incorrectos. Verifique por favor. ";
		$values["DATA"] = null;
	} else if($row["USR_PSSWRD"] == $password){
		$_SESSION["USR_CLV"] = $row["USR_CLV"];
		$_SESSION["USR_IDINTRN"] = $row["USR_IDINTRN"];
		$_SESSION["USR_NMBR"] = $row["USR_NMBR"];
		$_SESSION["USR_APLLDPTRN"] = $row["USR_APLLDPTRN"];
		$_SESSION["USR_APLLDMTRN"] = $row["USR_APLLDMTRN"];
		$_SESSION["RLS_IDINTRN"] = $row["ROLES_RLS_IDINTRN"];

		// TODO : Controlar acceso a SISTEMAS
		$_SESSION["SISTEMA"] = "PIMPRENTA 2.0"; 
		
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Acceso exitoso.";
		$values["DATA"] = $row;
	} else {
		$values["RESULT"] = false;
		$values["MESSAGE"] = "Datos de Acceso Incorrectos. Verifique por favor.";
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