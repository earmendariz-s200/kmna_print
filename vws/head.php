<?php
include realpath($_SERVER["DOCUMENT_ROOT"])."/carmona/core/ph/config.php";
if($_SESSION["USR_CLV"] == ""){ header("locaction: ".$URL_PRINCIPAL); }
$menu = '<li><img src="'.$URL_PRINCIPAL.'/assets/images/logo/logotipo.png" style="max-height: 70px;"></li>';
$qry = "SELECT
          MODULOS.*, MODULOS.MDL_IDINTRN AS IDMODULO,
          SISTEMAS.*
          FROM MODULOS
          INNER JOIN SISTEMAS ON SISTEMAS.SIS_IDINTRN = MODULOS.SISTEMAS_SIS_IDINTRN
          INNER JOIN PROGRAMAS ON PROGRAMAS.MODULOS_MDL_IDINTRN = MODULOS.MDL_IDINTRN
          INNER JOIN PROGRAMAS_ROLES ON PROGRAMAS_ROLES.PROGRAMAS_PRG_IDINTRN = PROGRAMAS.PRG_IDINTRN
                AND PROGRAMAS_ROLES.ROLES_RLS_IDINTRN = ".$_SESSION["RLS_IDINTRN"]." AND MODULOS.MDL_ACTV = 1
          GROUP BY IDMODULO ORDER BY MODULOS.MDL_ORDN ASC";
$db->query($qry);
$modulos = $db->fetch();
foreach ($modulos as $modulo => $value_modulo) {
  $link = "";
  if($value_modulo["MDL_URLMDL"] == "javascript:;"){
    $link = $value_modulo["MDL_URLMDL"];
  } else {
    $link = $URL_PRINCIPAL.$value_modulo["SIS_URL"].$value_modulo["MDL_URLMDL"];
  }
  $menu .= '
      <li class="dropdown nav-item" data-menu="dropdown">
          <a class="dropdown-toggle nav-link" href="'.$link.'" data-toggle="dropdown"><i class="'.$value_modulo["MDL_ICN"].'"></i>
            <span>'.$value_modulo["MDL_NMBR"].'</span>
          </a>
          <ul class="dropdown-menu">
  ';
  $qry = 'SELECT PROGRAMAS.*,
                MODULOS.*
              FROM PROGRAMAS
              INNER JOIN MODULOS ON PROGRAMAS.MODULOS_MDL_IDINTRN = MODULOS.MDL_IDINTRN
              INNER JOIN PROGRAMAS_ROLES ON PROGRAMAS_ROLES.PROGRAMAS_PRG_IDINTRN = PROGRAMAS.PRG_IDINTRN
                  AND PROGRAMAS_ROLES.ROLES_RLS_IDINTRN = '.$_SESSION["RLS_IDINTRN"].'
              WHERE PROGRAMAS.MODULOS_MDL_IDINTRN='.$value_modulo["MDL_IDINTRN"].' AND PROGRAMAS.PRG_ACTV=1';
  $db->query($qry);
  $programas = $db->fetch();
  foreach ($programas as $programa => $value_programa) {
    $link = "";
    if($value_programa["PRG_URLPRGRM"] == "javascript:;"){
      $link = $value_programa["PRG_URL"];
    } else {
      $link = $URL_PRINCIPAL.$value_modulo["SIS_URL"].$value_programa["PRG_URL"];
    }
    $menu .=  '
        <li data-menu=""><a class="dropdown-item" href="'.$link.'" data-toggle="dropdown">'.$value_programa["PRG_NMBR"].'
              <submenu class="name"></submenu></a>
        </li>
     ';
  }
  $menu .= ' </ul>
  </li>
  ';
}
?>
<!--
Version:  2.0.1
Author:   STATUS 200 SOLUCIÓN INTEGRAL SA DE CV  
Website:  https://www.status200.mx/
Contact:  info@status200.mx
Project:  CARMONA IMPRESORES
-->
<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="STATUS 200 SOLUCIÓN INTEGRAL SA DE CV   |   Ángel Ávila - Eduardo Armendáriz ">
  <title>CARMONA IMPRESORES | PIMPRENTA 2.0</title>
  <link rel="apple-touch-icon" href="<?php echo $URL_PRINCIPAL; ?>assets/images/logo/logotipo.png">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo $URL_PRINCIPAL; ?>assets/images/logo/logotipo.png">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
  rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/css/vendors.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/vendors/css/extensions/unslider.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/vendors/css/weather-icons/climacons.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/fonts/meteocons/style.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/vendors/css/charts/morris.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/css/app.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/css/core/menu/menu-types/horizontal-menu.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/css/core/colors/palette-gradient.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/fonts/simple-line-icons/style.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/css/core/colors/palette-gradient.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/css/pages/timeline.css">

  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/vendors/css/extensions/toastr.css">


  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/vendors/css/forms/selects/select2.min.css">

  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/vendors/css/tables/datatable/datatables.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/vendors/css/tables/extensions/responsive.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/vendors/css/tables/extensions/colReorder.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/vendors/css/tables/extensions/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/vendors/css/tables/extensions/fixedHeader.dataTables.min.css">

  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/css/plugins/extensions/toastr.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $URL_PRINCIPAL; ?>assets/tpl_assets/css/style.css">
</head>
