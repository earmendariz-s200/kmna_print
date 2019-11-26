<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('UPDATE MEDIDAS_PAPEL
					SET  MEP_NMBR=:nombre, MEP_ANCH=:ancho, MEP_ALT=:alto, MEP_FORMACION_BASE=:formacion_base, MEP_FORMACION_ALTO=:formacion_alto, MEP_MDFCN=:modificacion, MEP_ACTV=:activo
					WHERE MEP_IDINTRN=:id');
	$db->bind(':nombre', strtoupper($_POST["NOMBRE"]));
	$db->bind(':ancho', strtoupper($_POST["ANCHO"]));
	$db->bind(':alto', strtoupper($_POST["ALTO"]));
	$db->bind(':formacion_base', $_POST["FORMACION_BASE"]);
	$db->bind(':formacion_alto', $_POST["FORMACION_ALTO"]);
	$db->bind(':modificacion', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->bind(':activo', $_POST["ACTIVO"]);
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
