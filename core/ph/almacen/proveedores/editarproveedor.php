<?php
	header("Content-Type: application/json");
	include "../../config.php";
	include "../../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('UPDATE
  PROVEEDORES
SET 
  `PRV_RFC` = :PRV_RFC,
  `PRV_RZNSCL` = :PRV_RZNSCL,
  `PRV_CLL` = :PRV_CLL,
  `PRV_NMREXTRN` = :PRV_NMREXTRN,
  `PRV_NMRINTRN` = :PRV_NMRINTRN,
  `PRV_CDGPSTL` = :PRV_CDGPSTL,
  `PRV_ACTV` = :PRV_ACTV
WHERE `PRV_IDINTRN` = :PRV_IDINTRN
');
	$db->bind(':PRV_RFC', strtoupper($_POST["PRV_RFC"]));
	$db->bind(':PRV_RZNSCL', strtoupper($_POST["PRV_RZNSCL"]));
	$db->bind(':PRV_CLL', strtoupper($_POST["PRV_CLL"]));
	$db->bind(':PRV_NMREXTRN', strtoupper($_POST["PRV_NMREXTRN"]));
	$db->bind(':PRV_NMRINTRN', strtoupper($_POST["PRV_NMRINTRN"]));
	$db->bind(':PRV_CDGPSTL', strtoupper($_POST["PRV_CDGPSTL"]));
	$db->bind(':PRV_ACTV', $_POST["ACTIVO"]); 
	$db->bind(':PRV_IDINTRN', $_POST["ID_PROVEEDOR"]);
	$db->exec();
	if($db->numrows() > 0){
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $row;
	} else {
		$values["RESULT"] = false;
		$values["MESSAGE"] = "No se registro cambio. ";
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



