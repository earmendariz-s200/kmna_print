<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('SELECT * FROM CONCEPTO_COSTEO
            		INNER JOIN COSTEO_AREA ON COSTEO_AREA.`COA_IDINTRN` = CONCEPTO_COSTEO.`COA_IDINTRN`
                INNER JOIN UNIDADES ON UNIDADES.`UNI_IDINTRN` = CONCEPTO_COSTEO.`UNI_IDINTRN`
            		INNER JOIN CONFIG_COTI_CONCEPTO ON CONFIG_COTI_CONCEPTO.`CCO_IDINTRN` = CONCEPTO_COSTEO.`CCO_IDINTRN`
            	WHERE CONFIG_COTI_CONCEPTO.`SYS_TIPO_TRABAJO` = :tipo_trabajo
            	ORDER BY CONCEPTO_COSTEO.`CCO_IDINTRN` ASC');
	$db->bind(':tipo_trabajo', $_POST["TIPO_TRABAJO"]);
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
