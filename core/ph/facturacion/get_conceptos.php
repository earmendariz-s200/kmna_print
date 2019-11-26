<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{

$busca = $_GET["term"];

$sql = "SELECT * FROM fac_conceptos WHERE  UPPER(Descripcion) LIKE UPPER('%$busca%') or UPPER(c_ClaveProdServ) LIKE UPPER('%$busca%')  LIMIT 10";
	
	 $resultado = "";


	$db->query($sql);
	$row = $db->fetch();
	if(count($row) > 0){

		$tempArray = array();
	    foreach ($row as $value) {
	        array_push($tempArray, array('label' =>   $value["c_ClaveProdServ"]." - ". $value["Descripcion"]    ));
	    }
	    $resultado = json_encode($tempArray);



		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $resultado ;
	} else { 

		$resultado = json_encode(array('label' => "No se encontraron coincidencias"));
		

		$values["RESULT"] = false;
		$values["MESSAGE"] = "No hay datos disponible.";
		$values["DATA"] = $resultado ;
	}

} catch(Exception $ex){ 

	$values["RESULT"] = false;
	$values["MESSAGE"] = "Error. ".$ex;
	$values["DATA"] = null;
}
array_push($data, $values);
echo json_encode($data);
 


?>