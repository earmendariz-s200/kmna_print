<?php
header("Content-Type: application/json");
include "../config.php";
include "../utilerias/funciones.php";
$data = array();
try {
	$db->query("INSERT INTO COTIZACIONES_DETALLE (`COT_IDINTRN`,`TPR_IDINTRN`,`CDE_TG`,`CDE_CNTD`,`CDE_TRBJ`,`CDE_URGNT`,`CDE_TP_MDD_1`,`CDE_MDD_ANCH_1`,`CDE_MDD_ALT_1`,`CDE_TP_MDD_2`,`CDE_MDD_ANCH_2`,`CDE_MDD_ALT_2`,`CDE_HRNTZN`,`CDE_DSCRPCN`)
                    SELECT COT_IDINTRN,TPR_IDINTRN,CONCAT(CDE_TG,' - ',(SELECT COUNT(*) from COTIZACIONES_DETALLE where COT_IDINTRN = ".$_POST["ID_COT"].")),CDE_CNTD,CDE_TRBJ,CDE_URGNT,CDE_TP_MDD_1,CDE_MDD_ANCH_1,CDE_MDD_ALT_1,CDE_TP_MDD_2,CDE_MDD_ANCH_2,CDE_MDD_ALT_2,CDE_HRNTZN,CDE_DSCRPCN
                    FROM COTIZACIONES_DETALLE where CDE_IDINTRN = ".$_POST["ID_DETALLE"]." ");

	$db->exec();
	if ($db->lastId()) {
		$values["RESULT"] = true;
		$values["MESSAGE"] = "Consulta exitosa.";
		$values["DATA"] = $db->lastId();
	} else {
		$values["RESULT"] = false;
		$values["MESSAGE"] = "No hay datos disponible.";
		$values["DATA"] = null;
	}
} catch (Exception $ex) {
	$values["RESULT"] = false;
	$values["MESSAGE"] = "Error. " . $ex;
	$values["DATA"] = null;
}
array_push($data, $values);
echo json_encode($data);
