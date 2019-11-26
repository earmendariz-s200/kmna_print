<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('UPDATE SUAJES SET
                SUA_NMRSJ=:numero,
                CLI_IDINTRN=:cliente,
              	SUA_ESTD=:estado,
                SUA_DSCRPCN=:descripcion,
                SUA_CST=:costo,
                SUA_FRMS=:formas,
                SUA_PLCS=:placas,
                SUA_MDFCN=:modificacion
              WHERE SUA_IDINTRN=:id');
  $db->bind(':id', $_POST["ID"]);
	$db->bind(':numero', $_POST["NUMERO"]);
	$db->bind(':cliente', $_POST["CLIENTE"]);
	$db->bind(':estado', $_POST["ESTADO"]);
  $db->bind(':descripcion', strtoupper($_POST["DESCRIPCION"]));
  $db->bind(':costo', $_POST["COSTO"]);
  $db->bind(':formas', $_POST["FORMAS"]);
  $db->bind(':placas', $_POST["PLACAS"]);
	$db->bind(':modificacion', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->exec();
	if($db->numrows() > 0){
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Datos guardados correctamente.";
		$values["DATA"] = $row;
	} else {
		$values["RESULT"] = false;
		$values["MESSAGE"] = "No se registro cambio.";
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
