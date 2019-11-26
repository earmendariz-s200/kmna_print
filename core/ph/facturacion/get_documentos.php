<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();

	$id_cliente = $_POST["cliente"];

	try{
	$db->query('SELECT id_factura,folio,fecha,iva,sub_total,total_factura,UUID,urlPDF,total_pagos FROM fac_facturas 
INNER JOIN COTIZACIONES ON COTIZACIONES.`COT_IDINTRN` = fac_facturas.`id_cotizacion`
INNER JOIN CONTACTOS ON CONTACTOS.CNT_IDINTRN = COTIZACIONES.CONTACTOS_CNT_IDINTRN
INNER JOIN CLIENTES ON CLIENTES.CLI_IDINTRN = CONTACTOS.CLIENTES_CLI_IDINTRN 
WHERE CLIENTES.CLI_IDINTRN = '.$id_cliente);
	$row = $db->fetch();
	if(count($row) > 0){


		$table=""; 

		foreach ($row as $key => $value) {
			$fila=[];

			$dato = ""; 
			$table.="<tr>"; 
 
			$urlPDF =  $value["urlPDF"];
			$fecha = date("d-m-Y", strtotime($value["fecha"])); 
			$folio =  $value["folio"];
			$UUID =  $value["UUID"]; 
			$importe =  $value["total_factura"];  

		 
			$file_xml = "<a href='".$urlXML."' target='_blank' > <img src='../../../../assets/images/xml.png' > <span>  </span></a>"; 
			$file_PDF = "<a href='".$urlPDF."' target='_blank' > <img src='../../../../assets/images/pdf.png'> <span> </span> </a>"; 

			$sel = "<a onclick='fnc_select(this,\"".$UUID."\")' class='fa fa-plus-square' target='_blank' > </a>"; 
			 
			$table.="<td>".$folio."</td>"; 
			$table.="<td>".$fecha."</td>"; 
 			$table.="<td>".$importe."</td>"; 
			$table.="<td>".$file_PDF."</td>"; 
 		 	$table.="<td>".$sel."</td>"; 


 		 	$table.="<tr>"; 

		}







		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $table;
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