<?php
	header("Content-Type: application/json");
	include "../../config.php";
	include "../../utilerias/funciones.php";
	$data = array();


	 
	$id_proveedor = $_POST["id_proveedor"];
	 
	$id_materiales = $_POST["id_materiales"];
	$precio_unitario = $_POST["precio_unitario"];
	 
	$fecha = $_POST["fecha"];
	$fecha_entrada = date("Y-m-d", strtotime($fecha));
 	
 	 
		
	try{


		$db->query('SELECT AVG(NULLIF(CST_CST,0)) AS PROMEDIO, COUNT(*) AS CANTIDAD FROM COSTEO WHERE MATERIALES_MAT_IDINTRN ='.$id_materiales.' GROUP BY MATERIALES_MAT_IDINTRN  ' );
		$row = $db->single(); 
		
		$PROMEDIO = $row["PROMEDIO"]; 
		$CANTIDAD = $row["CANTIDAD"];

		if($PROMEDIO === NULL || $PROMEDIO  == "") {
 			$PROMEDIO = $precio_unitario;
		}else{
			$sum_promedio = $PROMEDIO*$CANTIDAD;
			$nuevo_promedio = ( ($sum_promedio + $precio_unitario) / ($CANTIDAD + 1) );

			$PROMEDIO = $nuevo_promedio;
		}



 



     
		$db->query('INSERT INTO  COSTEO ( 
					  CST_CST_PRMD,
					  CST_CST,
					  CST_FCH,
					  MATERIALES_MAT_IDINTRN,
					  ALMACENES_ALM_IDINTRN,
					  PROVEEDORES_PRV_IDINTRN
					) 
					VALUES
					  ( 
					    :CST_CST_PRMD,
					    :CST_CST,
					    :CST_FCH,
					    :MATERIALES_MAT_IDINTRN,
					    :ALMACENES_ALM_IDINTRN,
					    :PROVEEDORES_PRV_IDINTRN
					  )'); 


		$db->bind(':CST_CST_PRMD', $PROMEDIO);
		$db->bind(':CST_CST', $precio_unitario); 
		$db->bind(':CST_FCH',  $fecha_entrada);
		$db->bind(':MATERIALES_MAT_IDINTRN', $id_materiales);  
		$db->bind(':ALMACENES_ALM_IDINTRN', 1);  
		$db->bind(':PROVEEDORES_PRV_IDINTRN', $id_proveedor);   


		$db->exec();


		if ($db->lastId()) {


			$precio_millar = $precio_unitario * 1000;
			$db->query('UPDATE 
						  MATERIALES
						SET
						  MAT_CSTUNTR = :MAT_CSTUNTR , MAT_CSTMLLR = :MAT_CSTMLLR
						WHERE MAT_IDINTRN = :MAT_IDINTRN'); 

			$db->bind(':MAT_CSTUNTR',$precio_unitario); 
			$db->bind(':MAT_CSTMLLR',$precio_millar); 
			$db->bind(':MAT_IDINTRN',$id_materiales);  
			$db->exec(); 

		}  
 

		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $dato;
	 
} catch(Exception $ex){
	$values["RESULT"] = false;
	$values["MESSAGE"] = "Error. ".$ex;
	$values["DATA"] = null;
}
array_push($data, $values);
echo json_encode($data);



 

  

?>



