<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('INSERT INTO COTIZACIONES ( COT_FL,
                                        COT_FCHCRCN,
                                        CONTACTOS_CNT_IDINTRN,
                                        USUARIOS_USR_VNDEDR,
                                        USUARIOS_USR_CTZDR,
                                        CONDICIONES_CPA_IDINTRN,
                                        COT_FCHINC,
                                        COT_FCHFN )
                                    VALUES (  :folio,
                                              :fecha_creacion,
                                              :contacto,
                                              :vendedor,
                                              :cotizador,
                                              :condicion,
                                              :fecha_inicio,
                                              :fecha_fin )');
	$db->bind(':folio', $_POST["FOLIO"]);
	$db->bind(':fecha_creacion', date("Y-m-d H:i:s"));
	$db->bind(':contacto', $_POST["ID_CONTACTO"]);
  $db->bind(':vendedor', $_POST["ID_VENDEDOR"]);
  $db->bind(':cotizador', $_SESSION["USR_IDINTRN"]);
  $db->bind(':condicion', $_POST["ID_CONDICION"]);
  $db->bind(':fecha_inicio', $_POST["FECHA_INICIO"]);
  $db->bind(':fecha_fin', $_POST["FECHA_FIN"]);
	$db->exec();
	if($db->lastId()){
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $db->lastId();
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
