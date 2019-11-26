<?php
	header("Content-Type: application/json");
	include "../config.php";
	include "../utilerias/funciones.php";
	$data = array();
	try{
	$db->query('SELECT FL_INCRMNT+1 AS FL_INCRMNT,FL_SR FROM FOLIOS WHERE FL_CLV = 1 ' );
	$row = $db->single();
	if(count($row) > 0){ 

		$SERIE = $row["FL_SR"];; 
		$FOLIO = $row["FL_INCRMNT"];
		$folio_completo = $SERIE.str_pad($FOLIO, 10, "0", STR_PAD_LEFT);  // produce "-=-=-Alien"
		echo $folio_completo;

	} else {
		echo 0;
	}

} catch(Exception $ex){
	echo 0;
} 

?>