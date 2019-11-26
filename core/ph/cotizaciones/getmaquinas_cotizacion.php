<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('SELECT DISTINCT(MAQ_IDINTRN), MAQUINAS_IMPRESION.* FROM MAQUINAS_IMPRESION
								INNER JOIN COLORES ON COLORES.COL_VLR = MAQUINAS_IMPRESION.MAQ_TNTS
                INNER JOIN MAQUINAS_PAPEL ON MAQUINAS_PAPEL.MAQUINAS_IMPRESION_MAQ_IDINTRN = MAQUINAS_IMPRESION.MAQ_IDINTRN
              WHERE MAQUINAS_IMPRESION.MAQ_TNTS <= :tintas');
  $db->bind(":tintas", $_POST["TINTAS"]);
  //$db->bind(":papel", $_POST["PAPEL"]);
	$row = $db->fetch();
	if(count($row) > 0){
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
