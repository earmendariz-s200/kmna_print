<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query("INSERT INTO fac_pagos (
  fecha,
  importe,
  UUID,
  urlXML,
  urlPDF,
  UUID_factura
)
VALUES
  (
    :fecha,
    :importe,
    :UUID,
    :urlXML,
    :urlPDF,
    :UUID_factura
  )");

	$db->bind(':fecha',  date("Y-m-d H:i:s", strtotime($_POST["FECHA"])));
	$db->bind(':importe', $_POST["IMPORTE"]); 
	$db->bind(':UUID', $_POST["UUID"]); 
	$db->bind(':urlPDF', $_POST["URLPDF"]); 
	$db->bind(':urlXML', $_POST["URLXML"]); 
	$db->bind(':UUID_factura',$_POST["UUID_FACTURA"]); 

	$uuid = $_POST["UUID_FACTURA"];
  
	$db->exec();
	if($db->lastId()){

		$id_reg =  $db->lastId();

		$query_sel = "UPDATE fac_facturas SET
		total_pagos = (SELECT SUM(importe) AS suma FROM fac_pagos WHERE UUID_factura = '$uuid') 
		WHERE UUID = '$uuid' ";
		$db->query($query_sel);  
		$db->exec();

 
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $id_reg;
 

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



