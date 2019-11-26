<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('UPDATE MAQUINAS_IMPRESION
								SET MAQ_NMBR=:nombre,
										MAQ_CSTLMN=:costo_lamina,
										MAQ_CSTMLLR=:costo_millar,
										MAQ_BRNZR=:barnizar,
										MAQ_TNTS=:tintas,
										MAQ_VLCDD=:velocidad,
										MAQ_MNANCH=:minimo_ancho,
										MAQ_MNALT=:minimo_alto,
										MAQ_MXANCH=:maximo_ancho,
										MAQ_MXALT=:maximo_alto,
										MAQ_ACTV=:activo,
										MAQ_PNZ=:pinzas,
										MAQ_ESPCLTRL=:espacio_laterales,
										MAQ_ESPCDSCST=:espacio_desbaste,
										MAQ_ESPCCL=:espacio_cola,
										MAQ_MDFCN=:modificacion
								WHERE MAQ_IDINTRN=:id');
	$db->bind(':nombre', strtoupper($_POST["NOMBRE"]));
	$db->bind(':costo_lamina', $_POST["COSTO_LAMINA"]);
	$db->bind(':costo_millar', $_POST["COSTO_MILLAR"]);
	$db->bind(':barnizar', $_POST["BARNIZAR"]);
	$db->bind(':tintas', $_POST["TINTAS"]);
	$db->bind(':velocidad', $_POST["VELOCIDAD"]);
	$db->bind(':minimo_ancho', $_POST["ANCHO_MINIMO"]);
	$db->bind(':minimo_alto', $_POST["ALTO_MINIMO"]);
	$db->bind(':maximo_ancho', $_POST["ANCHO_MAXIMO"]);
	$db->bind(':maximo_alto', $_POST["ALTO_MAXIMO"]);
	$db->bind(':activo', $_POST["ACTIVO"]);
	$db->bind(':pinzas', $_POST["TAMANO_PINZA"]);
	$db->bind(':espacio_laterales', $_POST["ESPACIO_LATERALES"]);
	$db->bind(':espacio_desbaste', $_POST["ESPACIO_DESBASTE"]);
	$db->bind(':espacio_cola', $_POST["ESPACIO_COLA"]);
	$db->bind(':modificacion', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->bind(':id', $_POST["ID"]);
	$db->exec();
	if($db->numrows() > 0){
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $row;
	} else {
		$values["RESULT"] = false;
		$values["MESSAGE"] = "No se registro cambio. ";
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
