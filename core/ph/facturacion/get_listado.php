<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();

	$id_estatus = $_POST["estatus"];
	$where = "";

	if ($id_estatus>0) {
		$where .= " AND estatus =".$id_estatus;
	}


	try{   

	$db->query('SELECT
				  id_factura,
				  folio,
				  id_cotizacion,
				  fecha,
				  total_factura,
				  UUID,
				  urlXML,
				  urlPDF,
				  estatus,
				  conPagos,
				  total_pagos
				FROM
				  fac_facturas WHERE 1=1 '.$where);
					$row = $db->fetch();
	if(count($row) > 0){
 
		$json_data=[]; 

		foreach ($row as $key => $value) {
			$fila=[];

			$dato = ""; 

			$folio =  $value["folio"];
			$urlXML =  $value["urlXML"];
			$urlPDF =  $value["urlPDF"];

			$id_factura =  $value["id_factura"];
			$id_cotizacion =  $value["id_cotizacion"];
			$total_factura =  number_format( $value["total_factura"],2);
			$UUID =  $value["UUID"]; 
			$total_pagos =  $value["total_pagos"]; 

			$estatus =  $value["estatus"];
			$conPagos =  $value["conPagos"];
			$opciones1 = "";
			$opciones2 = "";

			if ($conPagos > 0) {
				$opciones2 .= '<a class="dropdown-item" onclick="fnc_mod(5,'.$id_factura.')">Realizar complemento de pago</a>'; 
				$opciones2 .= '<a class="dropdown-item" onclick="fnc_mod(6,'.$id_factura.')">Ver complementos de pago</a>'; 
			} 

			switch ($estatus) {
				case 1: // FACTURADA
					 $opciones1 .= '<a class="dropdown-item" onclick="fnc_mod(0,'.$id_factura.')">Enviar por correo</a>'; 
					 $opciones1 .= '<a class="dropdown-item" onclick="fnc_mod(4,'.$id_factura.')">Cancelar factura</a>'; 
					 $opciones1 .= '<a class="dropdown-item" onclick="fnc_mod(2,'.$id_factura.')">Marcar como factura pagada</a>';  
					break;
				case 2: // PAGADA
					 $opciones1 .= '<a class="dropdown-item" onclick="fnc_mod(0,'.$id_factura.')">Enviar por correo</a>'; 
					 $opciones1 .= '<a class="dropdown-item" onclick="fnc_mod(4,'.$id_factura.')">Cancelar factura</a>';
					 $opciones1 .= '<a class="dropdown-item" onclick="fnc_mod(1,'.$id_factura.')">Desmarcar como pagada</a>';  

					break;
				case 3: // PENDIENTE DE CANCELACION
					 
					 $opciones1 .= '<a class="dropdown-item" onclick="fnc_mod(0,'.$id_factura.')">Enviar por correo</a>'; 
					 $opciones1 .= '<a class="dropdown-item" onclick="fnc_mod(4,'.$id_factura.')">Verificar estatus de cancelación</a>'; 

					break;
				case 4: // CANCELADA
					 
					  $opciones1 .= '<a class="dropdown-item" onclick="fnc_mod(0,'.$id_factura.')">Enviar por correo</a>'; 

					break;
				 
				
				default:
					# code...
					break;
			}

			$boton_opciones = '<div class="btn-group mr-1 mb-1">
                                        <button type="button" class="btn btn-secondary btn-min-width dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-o"></i> Opciones</button>
                                        <div class="dropdown-menu">
                                            '.$opciones1.'
                                            <div class="dropdown-divider"></div>
                                            '.$opciones2.'
                                        </div>
                                    </div>';
		 
			$file_xml = "<a href='".$urlXML."' target='_blank' > <img src='../../../assets/images/xml.png' > <span>  </span></a>"; 
			$file_PDF = "<a href='".$urlPDF."' target='_blank' > <img src='../../../assets/images/pdf.png' > <span> </span> </a>"; 
			  

			$fecha_entrada = date("d-m-Y", strtotime($value["fecha"]));


			
				array_push($fila, 
					$folio,
					"$".$total_factura, 
					$id_cotizacion,
					$fecha_entrada,
					" - ",
					$file_PDF, 
					$file_xml, 
					$boton_opciones
					 );


			array_push($json_data,$fila);			 
		}


  


		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $json_data;
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