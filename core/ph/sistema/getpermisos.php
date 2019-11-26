<?php
header("Content-Type: application/json");
include "../config.php";
include "../utilerias/funciones.php";
try{
  $data = array();
  $datos = array();
  $json_sistemas = array();
  $qry = "SELECT SISTEMAS.*, SISTEMAS.SIS_IDINTRN AS IDSISTEMA
  FROM SISTEMAS 
  WHERE SISTEMAS.SIS_ACTV=1
  GROUP BY IDSISTEMA";
  $db->query($qry);
  $sistemas = $db->fetch();
  foreach ($sistemas as $sistema => $value_sistema) {
    $qry = "SELECT MODULOS.*, MODULOS.MDL_IDINTRN AS IDMODULO 
    FROM MODULOS
    WHERE MODULOS.MDL_ACTV=1 AND MODULOS.SISTEMAS_SIS_IDINTRN=".$value_sistema["SIS_IDINTRN"]."
    GROUP BY IDMODULO";
    $db->query($qry);
    $modulos = $db->fetch();
    $json_modulos = array();
    foreach ($modulos as $modulo => $value_modulo) {
      $qry = "SELECT PROGRAMAS.*, PROGRAMAS.PRG_IDINTRN AS IDPROGRAMA
      FROM PROGRAMAS
      WHERE PROGRAMAS.PRG_ACTV=1 AND PROGRAMAS.MODULOS_MDL_IDINTRN=".$value_modulo["MDL_IDINTRN"]."
      GROUP BY IDPROGRAMA";
      $db->query($qry);
      $programas = $db->fetch();
      $json_programas = array();
      foreach ($programas as $programa => $value_programa) {
        $db->query("SELECT * FROM PROGRAMAS_ROLES WHERE PROGRAMAS_PRG_IDINTRN = ".$value_programa["PRG_IDINTRN"]." AND ROLES_RLS_IDINTRN = ".$_POST["ID_ROL"]);
        $r = $db->single();
        if(count($r) > 0){
          $select->selected = true;
        } else {
          $select->selected = false;
        }
        array_push($json_programas, 
                          array( 
                                  'id_programa' => $value_programa["PRG_IDINTRN"],
                                  'text' => $value_programa["PRG_NMBR"],
                                  'state' => $select
                                )
                        );
      }
      array_push($json_modulos, 
                    array( 
                        'id_modulo' => $value_modulo["MDL_IDINTRN"],
                        'text' => $value_modulo["MDL_NMBR"],
                        'state' => array( 'opened' => true ),
                        'children' => $json_programas 
                      )
                  );
    }
    array_push($json_sistemas, 
                  array( 
                      'id_sistema' => $value_sistema["SIS_IDINTRN"],
                      'text' => $value_sistema["SIS_NMBR"], 
                      'state' => array( 'opened' => true ), 
                      'children' => $json_modulos 
                    )
                );
  }

  $datos[] = array('SISTEMAS' => $json_sistemas);


  if(count($datos) > 0){
    $values["RESULT"] = true;
    $values["MESSAGE"] = "Consulta exitosa. "."SELECT * FROM PROGRAMAS_ROLES WHERE PROGRAMAS_PRG_IDINTRN = ".$value_programa["PRG_IDINTRN"]." AND ROLES_RLS_IDINTRN = ".$_POST["ID_ROL"];
    $values["DATA"] = $json_sistemas;
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