<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('INSERT INTO MATERIALES  (MAT_ACTV, MAT_ANCH, MAT_ALT, MAT_CSTMLLR, MAT_CSTUNTR, MAT_CRCN, MAT_IDTP, MAT_CTRLSTCK, MAT_TPMTRL) VALUES ( :activo, :ancho, :alto, :millar, :unidad, :creacion, :material, :ctrl_stock, :tipo_material)');
	$db->bind(':activo', $_POST["ACTIVO"]);
	$db->bind(':ancho', $_POST["ANCHO"]);
	$db->bind(':alto', $_POST["ALTO"]);
	$db->bind(':millar', $_POST["C_MILLAR"]);
	$db->bind(':unidad', $_POST["C_UNIDAD"]);
	$db->bind(':creacion', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->bind(':material', $_POST["MATERIAL"]);
	$db->bind(':ctrl_stock', $_POST["CTRL_STOCK"]);
	$db->bind(':tipo_material', $_POST["TIPO"]);
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
