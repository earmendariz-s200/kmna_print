<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('INSERT INTO MAQUINAS_IMPRESION (
																		MAQ_NMBR,
																		MAQ_CSTLMN,
																		MAQ_CSTMLLR,
																		MAQ_BRNZR,
																		MAQ_TNTS,
																		MAQ_VLCDD,
																		MAQ_MNANCH,
																		MAQ_MNALT,
																		MAQ_MXANCH,
																		MAQ_MXALT,
																		MAQ_ACTV,
																		MAQ_PNZ,
																		MAQ_ESPCLTRL,
																		MAQ_ESPCDSCST,
																		MAQ_ESPCCL,
																		MAQ_CRCN
																	) VALUES (
																			:nombre,
																			:costo_lamina,
																			:costo_millar,
																			:barnizar,
																			:tintas,
																			:velocidad,
																			:minimo_ancho,
																			:minimo_alto,
																			:maximo_ancho,
																			:maximo_alto,
																			:activo,
																			:pinzas,
																			:espacio_laterales,
																			:espacio_desbaste,
																			:espacio_cola,
																			:creacion
																		)');
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
