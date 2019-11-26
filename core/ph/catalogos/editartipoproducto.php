<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('UPDATE TIPO_PRODUCTO
					SET  TPR_NMBR=:nombre, TPR_TPTRBJ=:tipo_trabajo, TPR_ACTV=:activo, TPR_MDFCN=:modificacion, TPR_TPDSN=:tipo_diseno
					WHERE TPR_IDINTRN=:id');
	$db->bind(':nombre', strtoupper($_POST["NOMBRE"]));
	$db->bind(':tipo_trabajo', $_POST["TIPO_TRABAJO"]);
	$db->bind(':activo', $_POST["ACTIVO"]);
	$db->bind(':modificacion', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->bind(':id', $_POST["ID_TIPO"]);
	$db->bind(':tipo_diseno', $_POST["TIPO_DISENO"]);
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
