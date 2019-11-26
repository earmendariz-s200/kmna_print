<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();

	$id_fac = $_POST["id_fac"];
   

	try{   

	$db->query("
SELECT
  id_pagos,
  fecha,
  importe,
  UUID,
  urlXML,
  urlPDF,
  UUID_factura,
  cancelado
FROM
  fac_pagos
  WHERE UUID_factura = (SELECT UUID FROM fac_facturas WHERE id_factura = $id_fac )
  AND cancelado = 0");
	$row = $db->fetch();
	if(count($row) > 0){
 
		$table=""; 

		foreach ($row as $key => $value) {
			$fila=[];

			$dato = ""; 
			$table.="<tr>"; 

			$urlXML =  $value["urlXML"];
			$urlPDF =  $value["urlPDF"];
			$fecha_entrada = date("d-m-Y", strtotime($value["fecha"])); 
			$id_pagos =  $value["id_pagos"];
			$UUID =  $value["UUID"]; 
			$importe =  $value["importe"];  

		 
			$file_xml = "<a href='".$urlXML."' target='_blank' > <img src='../../../../assets/images/xml.png' > <span>  </span></a>"; 
			$file_PDF = "<a href='".$urlPDF."' target='_blank' > <img src='../../../../assets/images/pdf.png'> <span> </span> </a>"; 

			$delete = "<a onclick='fnc_calcel_pago($id_pagos)' class='fa fa-times-circle' target='_blank' > </a>"; 
			$correo = "<a onclick='modal_correo(99,$id_pagos)' class='fa fa-envelope-square' target='_blank' > </a>"; 
			   
			$table.="<td>".$fecha_entrada."</td>"; 
 			$table.="<td>".$importe."</td>"; 
			$table.="<td>".$file_PDF."</td>"; 		 
 		 	$table.="<td>".$file_xml."</td>"; 
 		 	$table.="<td>".$correo."</td>"; 
 		 	$table.="<td>".$delete."</td>"; 


 		 	$table.="<tr>"; 

		}


  


		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $table;
	} else {
		$values["RESULT"] = false;
		$values["MESSAGE"] = "No hay entradas";
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