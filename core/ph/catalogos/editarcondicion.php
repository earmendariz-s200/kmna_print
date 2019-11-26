<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('UPDATE CONDICIONES SET CPA_NMBR=:nombre, CPA_DSCRPCN=:descripcion, CPA_ACTV=:activo, CPA_MDFCN=:modificacion WHERE CPA_IDINTRN=:id');
	$db->bind(':nombre', strtoupper($_POST["NOMBRE"]));
	$db->bind(':descripcion', strtoupper($_POST["DESCRIPCION"]));
	$db->bind(':activo', $_POST["ACTIVO"]);
	$db->bind(':modificacion', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->bind(':id', strtoupper($_POST["ID"]));
	$db->exec();
	if($db->numrows() > 0){
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



