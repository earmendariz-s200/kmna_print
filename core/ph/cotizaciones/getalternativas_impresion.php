<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{

  // Consultamos posibles formas de impresion segun las medidas de diseño y las medidas del papel seleccionado
	$db->query('SELECT DISTINCT PAPEL_PRECIO.ID_PAPEL_PRECIO,
					DIVISIONES,
					SOBRA_ANCHO,
					SOBRA_ALTO,
					ANCHO,
					ALTO,
					CABE_EXT_ANCHO,
					CABE_EXT_ALTO,
					PRECIO
			FROM PAPEL_MEDIDA_EXTENDIDA
					  INNER JOIN PAPEL_MEDIDA ON PAPEL_MEDIDA.ID_MEDIDA_EXTENDIDA = PAPEL_MEDIDA_EXTENDIDA.ID_MEDIDA_EXTENDIDA
					  INNER JOIN TIPO_PAPEL ON TIPO_PAPEL.TPA_IDINTRN = PAPEL_MEDIDA.TPA_IDINTRN
					  RIGHT JOIN PAPEL_EXTENDIDO_CORTE ON PAPEL_EXTENDIDO_CORTE.ID_MEDIDA_EXTENDIDA = PAPEL_MEDIDA_EXTENDIDA.ID_MEDIDA_EXTENDIDA
					  INNER JOIN PAPEL_PRECIO ON PAPEL_PRECIO.TPA_IDINTRN = TIPO_PAPEL.TPA_IDINTRN AND PAPEL_PRECIO.ID_PAPEL_MEDIDA = PAPEL_MEDIDA.ID_PAPEL_MEDIDA
					  WHERE TIPO_PAPEL.TPA_IDINTRN = :tipo_papel ');
	$db->bind(':tipo_papel', $_POST["TIPO_PAPEL"]);
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
