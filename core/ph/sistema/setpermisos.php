<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
		$db->query('DELETE FROM PROGRAMAS_ROLES WHERE ROLES_RLS_IDINTRN='.$_POST["ID_ROL"]);
		$db->exec();
		for($i = 0; $i < count($_POST["AR_PROGRAMAS"]); $i++)
		{
			if($_POST["AR_PROGRAMAS"][$i]){
				$db->query('INSERT INTO PROGRAMAS_ROLES  (PROGRAMAS_PRG_IDINTRN, ROLES_RLS_IDINTRN) VALUES(:clave , :id)');
				$db->bind(':clave', $_POST["AR_PROGRAMAS"][$i]);
				$db->bind(':id', $_POST["ID_ROL"]);
				$db->exec();
			}	
		}

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



