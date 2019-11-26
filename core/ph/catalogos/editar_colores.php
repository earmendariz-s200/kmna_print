<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('UPDATE
  COLORES
SET
  COL_NMBR = :COL_NMBR,
	COL_VLR = :COL_VLR,
  COL_ACTV = :COL_ACTV,
  COL_MDFCN = :COL_MDFCN
WHERE COL_IDINTR = :COL_IDINTR');


	$db->bind(':COL_NMBR', strtoupper($_POST["NOMBRE"]));
	$db->bind(':COL_ACTV', $_POST["ACTIVO"]);
	$db->bind(':COL_VLR', $_POST["VALOR"]);
	$db->bind(':COL_MDFCN', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->bind(':COL_IDINTR', $_POST["ID"]);
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
