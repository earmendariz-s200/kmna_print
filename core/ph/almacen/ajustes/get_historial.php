<?php
	header("Content-Type: application/json");
	include "../../config.php";
	include "../../utilerias/funciones.php";
	$data = array();
	try{

  
	$fecha_inicio = $_POST["fecha_inicio"];
	$fecha_fin = $_POST["fecha_fin"];  

	$where = "";
 

	if ($fecha_inicio != "") {

		$fecha_ini = date("Y-m-d", strtotime($fecha_inicio));
		$fecha_final = date("Y-m-d", strtotime($fecha_fin));

	  $where .= " AND MOVIMIENTOS_ALMACEN.MAL_FCHMVMNT BETWEEN '".$fecha_ini."' AND '".$fecha_final."' " ;
	}

	$db->query("SELECT MOVIMIENTOS_ALMACEN.*,MVTD_CNTD,MVTD_MTV,`MAT_ANCH`,`MAT_ALT`,`MAT_CSTUNTR`,`MAT_STCK`,
CASE MAT_TPMTRL 
   WHEN 1 THEN (SELECT CONCAT(TPA_NMBR,' ',GPA_GRAMAJE) AS NOMBRE FROM GRAMAJE_PAPEL  
INNER JOIN TIPO_PAPEL ON TIPO_PAPEL.TPA_IDINTRN = GRAMAJE_PAPEL.TIPO_PAPEL_TPA_IDINTRN
WHERE GRAMAJE_PAPEL.GXP_IDINTRN = MAT_IDTP)
   WHEN 2 THEN (SELECT ACB_NMBR AS NOMBRE FROM ACABADOS WHERE ACB_IDINTRN = MAT_IDTP)
   WHEN 3 THEN (SELECT TER_NMBR AS NOMBRE FROM TERMINADOS WHERE TER_IDNTRN = MAT_IDTP)
END AS TPA_NMBR 
 FROM MOVIMIENTOS_ALMACEN 
INNER JOIN MOVIMIENTOS_DETALLE ON MOVIMIENTOS_ALMACEN.`MAL_IDINTRN` = MOVIMIENTOS_DETALLE.`MOVIMIENTOS_ALMACEN_MAL_IDINTRN`
INNER JOIN MATERIALES ON MATERIALES.MAT_IDINTRN = MOVIMIENTOS_DETALLE.`MATERIALES_MAT_IDINTRN`
WHERE MOVIMIENTOS_TIPOS_MVTT_IDINTRN = 3 ".$where);
					$row = $db->fetch();
	if(count($row) > 0){
 
		$json_data=[]; 

		foreach ($row as $key => $value) {
			$fila=[];

			$dato = "";  

			$fecha_entrada = date("d-m-Y", strtotime($value["MAL_FCHMVMNT"]));

			if ($value["MVTD_MTV"] == "Ajuste Positivo") {
				$tipo_ajuste = '<span class="badge badge-default badge-success m-0">'.$value["MVTD_MTV"].'</span>';
			}else{
				$tipo_ajuste = '<span class="badge badge-default badge-danger m-0">'.$value["MVTD_MTV"].'</span>';
			}
			

				array_push($fila, 
					$value["MAL_FL"],
					$fecha_entrada, 
					$value["TPA_NMBR"]." ".$value["MAT_ALT"]." x ".$value["MAT_ANCH"],
					$value["MVTD_CNTD"],
					$tipo_ajuste,
						$value["MAL_MTV"]
					 );
  
			array_push($json_data,$fila);			 
		}
 
 
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $json_data;
	} else {
		$values["RESULT"] = false;
		$values["MESSAGE"] = "No hay ajustes";
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