<?php
	header("Content-Type: application/json");
	include "../../config.php";
	include "../../utilerias/funciones.php";
	$data = array();
	try{
	$db->query("SELECT   
  f.CST_IDINTRN,
  f.CST_CST_PRMD,
  f.CST_CST,
  f.CST_FCH,
  f.MATERIALES_MAT_IDINTRN,
  f.ALMACENES_ALM_IDINTRN,
  f.PROVEEDORES_PRV_IDINTRN,
  PROVEEDORES.`PRV_RZNSCL`,
  TABLA_MATERIALES.TPA_NMBR
FROM (
    SELECT 
 max(CST_IDINTRN) as CST_IDINTRN, 
 MAX(CST_FCH) AS maxdate,
 MATERIALES_MAT_IDINTRN
FROM COSTEO GROUP BY MATERIALES_MAT_IDINTRN
) AS tc INNER JOIN COSTEO AS f ON f.CST_IDINTRN = tc.CST_IDINTRN AND f.CST_FCH = tc.maxdate
INNER JOIN PROVEEDORES ON f.PROVEEDORES_PRV_IDINTRN = PROVEEDORES.`PRV_IDINTRN`
INNER JOIN (
SELECT MATERIALES.*,
CASE MAT_TPMTRL 
   WHEN 1 THEN (SELECT CONCAT(TPA_NMBR,' ',GPA_GRAMAJE) AS NOMBRE FROM GRAMAJE_PAPEL  
INNER JOIN TIPO_PAPEL ON TIPO_PAPEL.TPA_IDINTRN = GRAMAJE_PAPEL.TIPO_PAPEL_TPA_IDINTRN
WHERE GRAMAJE_PAPEL.GXP_IDINTRN = MAT_IDTP)
   WHEN 2 THEN (SELECT ACB_NMBR AS NOMBRE FROM ACABADOS WHERE ACB_IDINTRN = MAT_IDTP)
   WHEN 3 THEN (SELECT TER_NMBR AS NOMBRE FROM TERMINADOS WHERE TER_IDNTRN = MAT_IDTP)
END AS TPA_NMBR 
FROM MATERIALES
) AS TABLA_MATERIALES ON TABLA_MATERIALES.MAT_IDINTRN = f.MATERIALES_MAT_IDINTRN
	");
	$row = $db->fetch();
	if(count($row) > 0){


		//$json_data=array("data"=>$row); 


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