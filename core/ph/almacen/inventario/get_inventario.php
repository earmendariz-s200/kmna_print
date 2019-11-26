<?php
	header("Content-Type: application/json");
	include "../../config.php";
	include "../../utilerias/funciones.php";
	$data = array();
	try{
	$db->query("
SELECT MATERIALES.*,
CASE MAT_TPMTRL 
   WHEN 1 THEN (SELECT CONCAT(TPA_NMBR,' ',GPA_GRAMAJE) AS NOMBRE FROM GRAMAJE_PAPEL  
INNER JOIN TIPO_PAPEL ON TIPO_PAPEL.TPA_IDINTRN = GRAMAJE_PAPEL.TIPO_PAPEL_TPA_IDINTRN
WHERE GRAMAJE_PAPEL.GXP_IDINTRN = MAT_IDTP)
   WHEN 2 THEN (SELECT ACB_NMBR AS NOMBRE FROM ACABADOS WHERE ACB_IDINTRN = MAT_IDTP)
   WHEN 3 THEN (SELECT TER_NMBR AS NOMBRE FROM TERMINADOS WHERE TER_IDNTRN = MAT_IDTP)
END AS TPA_NMBR ,
CASE MAT_TPMTRL 
   WHEN 1 THEN 'PAPEL' 
   WHEN 2 THEN 'ACABADOS'
   WHEN 3 THEN 'TERMINADOS'
END AS TIPO_MATERIAL 
FROM MATERIALES
 
	");
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