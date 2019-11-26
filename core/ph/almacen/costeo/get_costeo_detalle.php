<?php
	header("Content-Type: application/json");
	include "../../config.php";
	include "../../utilerias/funciones.php";
	$data = array();


$id_material = $_POST["id_material"];
$id_registro = $_POST["id_registro"];

	try{
	$db->query("SELECT
  CST_IDINTRN,
  CST_CST_PRMD,
  CST_CST,
  CST_FCH,
  MATERIALES_MAT_IDINTRN,
  ALMACENES_ALM_IDINTRN,
  PROVEEDORES_PRV_IDINTRN,
  PROVEEDORES.PRV_RZNSCL
FROM
  COSTEO
  INNER JOIN PROVEEDORES ON PROVEEDORES.PRV_IDINTRN = PROVEEDORES_PRV_IDINTRN
WHERE  CST_IDINTRN != $id_registro AND MATERIALES_MAT_IDINTRN=$id_material ORDER BY CST_FCH DESC");
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