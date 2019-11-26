<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{

  // Consultamos posibles formas de impresion segun las medidas de diseño y las medidas del papel seleccionado
	$db->query('SELECT * FROM MAQUINAS_EXCEDENTES
	               WHERE MAQ_IDINTRN =  :id_maquina AND :cantidad BETWEEN MAQ_DESDE AND MAQ_HASTA; ');
	$db->bind(':id_maquina', $_POST["ID_MAQUINA"]);
  $db->bind(':cantidad', $_POST["CANTIDAD"]);
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
