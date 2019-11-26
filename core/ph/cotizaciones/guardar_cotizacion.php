<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('UPDATE COTIZACIONES
					SET  COT_OBSRVCNS=:observaciones,
							COT_ESTTS=1
					WHERE COT_FL=:folio');
	$db->bind(':folio', $_POST["FOLIO"]);
  $db->bind(':observaciones', strtoupper($_POST["OBSERVACIONES"]));
  $db->exec();
	if($db->numrows() > 0){
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
