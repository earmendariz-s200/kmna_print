<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('UPDATE MATERIALES  
					SET MAT_ACTV=:activo, 
						MAT_ANCH=:ancho, 
						MAT_ALT=:alto, 
						MAT_CSTMLLR=:millar, 
						MAT_CSTUNTR=:unidad, 
						MAT_MDFCN=:modificacion, 
						MAT_IDTP=:material, 
						MAT_TPMTRL=:tipo_material,
						MAT_CTRLSTCK=:ctrl_stock
					WHERE MAT_IDINTRN=:id');
	$db->bind(':activo', $_POST["ACTIVO"]);
	$db->bind(':ancho', $_POST["ANCHO"]);
	$db->bind(':alto', $_POST["ALTO"]);
	$db->bind(':millar', $_POST["C_MILLAR"]);
	$db->bind(':unidad', $_POST["C_UNIDAD"]);
	$db->bind(':modificacion', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->bind(':material', $_POST["MATERIAL"]);
	$db->bind(':tipo_material', $_POST["TIPO"]);
	$db->bind(':ctrl_stock', $_POST["CTRL_STOCK"]);
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



