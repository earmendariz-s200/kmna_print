<?php
header("Content-Type: application/json");
include "../config.php";
include "../utilerias/funciones.php";
$data = array();
try{
$db->query('SELECT * FROM COTIZACIONES_DETALLE
              INNER JOIN TIPO_PRODUCTO ON TIPO_PRODUCTO.TPR_IDINTRN = COTIZACIONES_DETALLE.TPR_IDINTRN
              INNER JOIN COTIZACIONES ON COTIZACIONES.COT_IDINTRN = COTIZACIONES_DETALLE.COT_IDINTRN
            WHERE COTIZACIONES_DETALLE.COT_IDINTRN =:id');
$db->bind(':id', $_POST["ID"]);
$row = $db->fetch();
$html = "<table class='table table-inline'>";
if(count($row) > 0){
  for($i = 0; $i < count($row); $i++){
    $html .= '<tr>'.
    '<td>'.$row[$i]["CDE_DSCRPCN"].'</td>'.
    '<td><a href="../costear/index.php?id='.$row[$i]["CDE_IDINTRN"].'" class="btn btn-outline-secondary mr-1"><i class="fa fa-dollar"></i></a></td>'.
    '</tr>';
  }
  $html  .= '</table>';
  $values["RESULT"] = true;
  $values["MESSAGE"] = "Consulta exitosa.";
  $values["DATA"] = $html;
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
