<?php
	header("Content-Type: application/json");
	include "../../config.php";
	include "../../utilerias/funciones.php";
	$data = array();
	try{
	$db->query("INSERT INTO PROVEEDORES  (
   PRV_RFC ,
   PRV_RZNSCL ,
   PRV_CLL ,
   PRV_NMREXTRN ,
   PRV_NMRINTRN ,
   PRV_CDGPSTL 
) 
VALUES
  ( 
    :PRV_RFC,
    :PRV_RZNSCL,
    :PRV_CLL,
    :PRV_NMREXTRN,
    :PRV_NMRINTRN,
    :PRV_CDGPSTL
  )");

   
	$db->bind(':PRV_RFC', strtoupper($_POST["PRV_RFC"])); 
	$db->bind(':PRV_RZNSCL', strtoupper($_POST["PRV_RZNSCL"])); 
	$db->bind(':PRV_CLL', strtoupper($_POST["PRV_CLL"])); 
	$db->bind(':PRV_NMREXTRN', strtoupper($_POST["PRV_NMREXTRN"])); 
	$db->bind(':PRV_NMRINTRN', strtoupper($_POST["PRV_NMRINTRN"]));
	$db->bind(':PRV_CDGPSTL', strtoupper($_POST["PRV_CDGPSTL"])); 
	 
  
	$db->exec();
	if($db->lastId()){

		$id_proveedor =  $db->lastId();
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $id_proveedor;
 

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



