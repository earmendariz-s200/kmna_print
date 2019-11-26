<?php
	header("Content-Type: application/json");
	include "../../config.php";
	include "../../utilerias/funciones.php";
	$data = array();


	 
	$motivo = $_POST["motivo"]; 
	$cantidad = $_POST["cantidad"]; 
	$materiales = $_POST["materiales"]; 
 
	
	try{

	$db->query('SELECT  MVTT_CNSCTV+1 AS INCREMENTO,MVTT_CLV FROM MOVIMIENTOS_TIPOS WHERE MVTT_IDINTRN = 2');
	$row = $db->single(); 
	$folio = $row["INCREMENTO"]; 
	$clave = $row["MVTT_CLV"];
 



	$db->query('INSERT INTO MOVIMIENTOS_ALMACEN ( 
  MAL_FCHRGSTR,
  MAL_FL,
  MAL_FCHMVMNT,
  MOVIMIENTOS_TIPOS_MVTT_IDINTRN,
  MAL_CRCN,
  ALMACENES_ALM_IDINTRN,
  PROVEEDORES_PRV_IDINTRN,
  MAL_MTV
) 
VALUES
  ( 
:MAL_FCHRGSTR,
:MAL_FL,
:MAL_FCHMVMNT,
:MOVIMIENTOS_TIPOS_MVTT_IDINTRN,
:MAL_CRCN,
:ALMACENES_ALM_IDINTRN,
:PROVEEDORES_PRV_IDINTRN,
:MAL_MTV
  )');

	$db->bind(':MAL_FCHRGSTR', date("Y-m-d H:i:s") );
	$db->bind(':MAL_FCHMVMNT', date("Y-m-d H:i:s") );
	$db->bind(':MOVIMIENTOS_TIPOS_MVTT_IDINTRN',2);
	$db->bind(':MAL_CRCN', $_SESSION["USR_CLV"]." ".date("Y-m-d H:i:s"));
	$db->bind(':ALMACENES_ALM_IDINTRN', 1);
	$db->bind(':PROVEEDORES_PRV_IDINTRN', 0);
	$db->bind(':MAL_MTV', $motivo); 

	$db->bind(':MAL_FL', $clave."-".$folio);

	  
	$db->exec();


	//positivo 1
	//negativo 2

	$id_movimiento = $db->lastId();

	if($db->lastId()){

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
			$db->bind(':MATERIALES_MAT_IDINTRN',$materiales); 
			$db->bind(':MVTD_CNTD',  $cantidad);
			$db->bind(':MVTD_MTV', "salida de mercancia");  
			$db->exec();



		if ($db->lastId()) {

			$db->query('UPDATE 
						  MATERIALES
						SET
						  MAT_STCK = MAT_STCK + :MAT_STCK
						WHERE MAT_IDINTRN = :MAT_IDINTRN'); 
 
			$db->bind(':MAT_STCK', -$cantidad); 
			
			$db->bind(':MAT_IDINTRN',$materiales);  
			$db->exec(); 

		}


			// 2 tipo de movimiento  // incremento 
		$db->query('UPDATE MOVIMIENTOS_TIPOS 
							SET MVTT_CNSCTV = :MVTT_CNSCTV 
							WHERE MVTT_IDINTRN = :MVTT_IDINTRN '); 
	 
				$db->bind(':MVTT_CNSCTV',$folio); 
				$db->bind(':MVTT_IDINTRN',2);  
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



