<?php
	header("Content-Type: application/json");
	include "../../config.php";
	include "../../utilerias/funciones.php";
	$data = array();
	try{

  
	$fecha_inicio = $_POST["fecha_inicio"];
	$fecha_fin = $_POST["fecha_fin"]; 
	$Proveedor = $_POST["Proveedor"];

	$where = "";
 

	if ($fecha_inicio != "") {

		$fecha_ini = date("Y-m-d", strtotime($fecha_inicio));
		$fecha_final = date("Y-m-d", strtotime($fecha_fin));

	  $where .= " AND MOVIMIENTOS_ALMACEN.MAL_FCHMVMNT BETWEEN '".$fecha_ini."' AND '".$fecha_final."' " ;
	}
	 
	if ($Proveedor > 0) {
	  $where .= " AND PROVEEDORES_PRV_IDINTRN = ".$Proveedor ;
	}


	$db->query('SELECT 
				MAL_IDINTRN, 
				MAL_FL,
				MAL_FCHMVMNT,
				MAL_FL1,
				MAL_FL2,
				MAL_NMBR_FL1,
				MAL_NMBR_FL2,
				PRV_RZNSCL 
				FROM MOVIMIENTOS_ALMACEN INNER JOIN PROVEEDORES ON
				MOVIMIENTOS_ALMACEN.PROVEEDORES_PRV_IDINTRN = PROVEEDORES.PRV_IDINTRN
				WHERE MOVIMIENTOS_ALMACEN.MOVIMIENTOS_TIPOS_MVTT_IDINTRN = 1 '.$where);
					$row = $db->fetch();
	if(count($row) > 0){
 
		$json_data=[]; 

		foreach ($row as $key => $value) {
			$fila=[];

			$dato = ""; 

			$file_factura = "";
			$file_nota = "";


			if ($value["MAL_FL1"] != "" && $value["MAL_FL1"] !== null) { 
				$url_nota = "../../../../vws/pimprenta/files/almacen/".$value["MAL_FL1"];
				if (file_exists($url_nota)) {
					$file_nota = "<a href='".$url_nota."' target='_blank' ><i class='fa fa-file-text'></i> <span>". $value["MAL_NMBR_FL1"]. "</span></a>"; 
				}else{
					$file_nota = $value["MAL_NMBR_FL1"];
				} 
			}else{
				$file_nota = $value["MAL_NMBR_FL1"];
			}

			if ($value["MAL_FL2"] != "" && $value["MAL_FL2"] !== null) { 
				$url_factura = "../../../../vws/pimprenta/files/almacen/".$value["MAL_FL2"];
				if (file_exists($url_factura)) {
					$file_factura = "<a href='".$url_factura."' target='_blank' ><i class='fa fa-file-text'></i> <span>". $value["MAL_NMBR_FL2"]. "</span> </a>"; 
				}else{
					$file_factura = $value["MAL_NMBR_FL2"];
				}
			}else{
				$file_factura = $value["MAL_NMBR_FL2"];
			}


			$fecha_entrada = date("d-m-Y", strtotime($value["MAL_FCHMVMNT"]));


			
				array_push($fila, 
					$value["MAL_FL"],
					$fecha_entrada,
					$file_nota,
					$file_factura,
					$value["PRV_RZNSCL"] 
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