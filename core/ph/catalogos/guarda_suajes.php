<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('INSERT INTO SUAJES (
                SUA_NMRSJ,
                CLI_IDINTRN,
              	SUA_ESTD,
                SUA_DSCRPCN,
                SUA_CST,
                SUA_FRMS,
                SUA_PLCS,
                SUA_CRCN
              )
              VALUES
                (
                  :numero,
              		:cliente,
                  :estado,
                  :descripcion,
                  :costo,
                  :formas,
                  :placas,
                  :creacion
                )');
	$db->bind(':numero', $_POST["NUMERO"]);
	$db->bind(':cliente', $_POST["CLIENTE"]);
	$db->bind(':estado', $_POST["ESTADO"]);
  $db->bind(':descripcion', strtoupper($_POST["DESCRIPCION"]));
  $db->bind(':costo', $_POST["COSTO"]);
  $db->bind(':formas', $_POST["FORMAS"]);
  $db->bind(':placas', $_POST["PLACAS"]);
	$db->bind(':creacion', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->exec();
	if($db->lastId()){
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
