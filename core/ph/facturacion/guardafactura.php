<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query("INSERT INTO fac_facturas (
  `id_cotizacion`,
   folio,
  `fecha`,
   iva,
   sub_total,
  `total_factura`,
  `UUID`,
  `urlXML`,
  `urlPDF`,
  `estatus`,
  `conPagos`,
  `total_pagos`
)
VALUES
  ( 
    :id_cotizacion,
    :folio,
    :fecha,
    :iva,
    :sub_total,
    :total_factura,
    :UUID,
    :urlXML,
    :urlPDF,
    :estatus,
    :conPagos,
    :total_pagos
  )");
	$db->bind(':id_cotizacion', $_POST["IDCOTIZACION"]); 
	$db->bind(':fecha',  date("Y-m-d H:i:s", strtotime("NOW")));
	$db->bind(':total_factura', $_POST["total"]); 
	$db->bind(':sub_total', $_POST["subtotal"]); 
	$db->bind(':iva', $_POST["iva"]); 
	$db->bind(':UUID', $_POST["UUID"]); 
	$db->bind(':urlPDF', $_POST["URLPDF"]); 
	$db->bind(':urlXML', $_POST["URLXML"]); 
	$db->bind(':estatus', 1);
	$db->bind(':conPagos', $_POST["conPagos"]); 
	$db->bind(':total_pagos',0); 

	$db->bind(':folio',$_POST["folio"]); 


  
	$db->exec();
	if($db->lastId()){

		$id_reg =  $db->lastId();
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



