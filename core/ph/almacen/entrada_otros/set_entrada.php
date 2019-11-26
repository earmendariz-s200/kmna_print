<?php
	header("Content-Type: application/json");
	include "../../config.php";
	include "../../utilerias/funciones.php";
	$data = array();


	 
	$motivo = $_POST["motivo"]; 
	$nota = $_POST["nota"];
	$factura = $_POST["factura"];
	$file_nota = $_POST["file_nota"];
	$file_factura = $_POST["file_factura"];

	$materiales = $_POST["materiales"];
	$cantidades = $_POST["cantidades"];

	$fecha = $_POST["fecha"];

 
	$fecha_entrada = date("Y-m-d", strtotime($fecha));

	
	try{
	
	$db->query('SELECT  MVTT_CNSCTV+1 AS INCREMENTO,MVTT_CLV FROM MOVIMIENTOS_TIPOS WHERE MVTT_IDINTRN = 4');
	$row = $db->single(); 
	$folio = $row["INCREMENTO"]; 
	$clave = $row["MVTT_CLV"];
 


$db->query('INSERT INTO MOVIMIENTOS_ALMACEN ( 
  MAL_FCHRGSTR,
  MAL_FCHMVMNT,
  MOVIMIENTOS_TIPOS_MVTT_IDINTRN,
  MAL_CRCN,
  ALMACENES_ALM_IDINTRN,
  MAL_FL1,
  MAL_FL2, 
  MAL_NMBR_FL1,
  MAL_NMBR_FL2,
  PROVEEDORES_PRV_IDINTRN,
  MAL_MTV,
  MAL_FL
) 
VALUES
  ( 
:MAL_FCHRGSTR,
:MAL_FCHMVMNT,
:MOVIMIENTOS_TIPOS_MVTT_IDINTRN,
:MAL_CRCN,
:ALMACENES_ALM_IDINTRN,
:MAL_FL1,
:MAL_FL2, 
:MAL_NMBR_FL1,
:MAL_NMBR_FL2,
:PROVEEDORES_PRV_IDINTRN,
:MAL_MTV,
:MAL_FL
  )');

	$db->bind(':MAL_FCHRGSTR', date("Y-m-d H:i:s"));
	$db->bind(':MAL_FCHMVMNT', $fecha_entrada);
	$db->bind(':MOVIMIENTOS_TIPOS_MVTT_IDINTRN',4);
	$db->bind(':MAL_CRCN', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->bind(':ALMACENES_ALM_IDINTRN', 1);
	$db->bind(':PROVEEDORES_PRV_IDINTRN', 0);

	$db->bind(':MAL_MTV',$motivo);  

	$db->bind(':MAL_FL', $clave."-".$folio);

	 
	$db->bind(':MAL_NMBR_FL1', $_POST["nota"]);
	$db->bind(':MAL_NMBR_FL2', $_POST["factura"]);


	$dato = ""; 
	$origen = "../../../../vws/pimprenta/temp/uploads/".$file_nota;

	if (file_exists($origen)) {

		$destino = "../../../../vws/pimprenta/files/almacen/".$file_nota;

		copy($origen,$destino); 
  		unlink($origen); 

  		$db->bind(':MAL_FL1',$file_nota);


	}else{
		$db->bind(':MAL_FL1', "");
	}


	$origen_fac = "../../../../vws/pimprenta/temp/uploads/".$file_factura;
	if (file_exists($origen_fac)) {

		$destino_fac = "../../../../vws/pimprenta/files/almacen/".$file_factura;

		copy($origen_fac,$destino_fac); 
  		unlink($origen_fac); 

  		$db->bind(':MAL_FL2',$file_factura); 

	}else{
		$db->bind(':MAL_FL2', "");
	}

 
 
	 
	$db->exec();

	$id_movimiento = $db->lastId();

	if($db->lastId()){

	

		$num = count($materiales);

		for ($i=0; $i < $num; $i++) {  

			$db->query('INSERT INTO MOVIMIENTOS_DETALLE ( 
						   MOVIMIENTOS_ALMACEN_MAL_IDINTRN ,
						   MATERIALES_MAT_IDINTRN ,
						   MVTD_CNTD ,
						   MVTD_MTV 
						) 
						VALUES
						  ( 
							:MOVIMIENTOS_ALMACEN_MAL_IDINTRN ,
							:MATERIALES_MAT_IDINTRN ,
							:MVTD_CNTD ,
							:MVTD_MTV  
						  )'); 


			$db->bind(':MOVIMIENTOS_ALMACEN_MAL_IDINTRN', $id_movimiento);
			$db->bind(':MATERIALES_MAT_IDINTRN', $materiales[$i]); 
			$db->bind(':MVTD_CNTD',  $cantidades[$i]);
			$db->bind(':MVTD_MTV', "Entrada por otros conceptos");  

			$db->exec();




			if ($db->lastId()) {

				$db->query('UPDATE 
							  MATERIALES
							SET
							  MAT_STCK = MAT_STCK + :MAT_STCK
							WHERE MAT_IDINTRN = :MAT_IDINTRN'); 
	 
				$db->bind(':MAT_STCK',$cantidades[$i]); 
				$db->bind(':MAT_IDINTRN',$materiales[$i]);  
				$db->exec(); 

			}
 



		}


		// 4 tipo de movimiento  // incremento 
		$db->query('UPDATE MOVIMIENTOS_TIPOS 
							SET MVTT_CNSCTV = :MVTT_CNSCTV 
							WHERE MVTT_IDINTRN = :MVTT_IDINTRN '); 
	 
				$db->bind(':MVTT_CNSCTV',$folio); 
				$db->bind(':MVTT_IDINTRN',4);  
				$db->exec(); 
 

 

		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $dato;
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



