<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('SELECT * FROM COTIZACIONES_DETALLE
                INNER JOIN TIPO_PRODUCTO ON TIPO_PRODUCTO.TPR_IDINTRN = COTIZACIONES_DETALLE.TPR_IDINTRN
                INNER JOIN COT_DETALLE_MATERIALES ON COT_DETALLE_MATERIALES.CDE_IDINTRN = COTIZACIONES_DETALLE.CDE_IDINTRN
								INNER JOIN GRAMAJE_PAPEL ON GRAMAJE_PAPEL.GXP_IDINTRN = COT_DETALLE_MATERIALES.GXP_IDINTRN
								INNER JOIN TIPO_PAPEL ON TIPO_PAPEL.TPA_IDINTRN = GRAMAJE_PAPEL.TIPO_PAPEL_TPA_IDINTRN
								LEFT JOIN MEDIDAS_PAPEL ON MEDIDAS_PAPEL.MEP_IDINTRN = COTIZACIONES_DETALLE.CDE_TP_MDD_1
							WHERE COT_DETALLE_MATERIALES.CDM_IDINTRN=:id');
	$db->bind(':id', $_POST["ID"]);
  	$row = $db->single();
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
