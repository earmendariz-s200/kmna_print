<?php session_start()?>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . $_SESSION["DIR_LOCAL"] . "/vws/head.php"?>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . $_SESSION["DIR_LOCAL"] . "/vws/header.php"?>

<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row"></div>
		<div class="content-body">
			<div class="row match-height">
				<div class="col-xl-12 col-lg-12">
					<div class="card">
						<div class="card-header">
							<div class="col-sm-10">
								<h3 class="card-title">Pantalla de Ventas</h3>
								<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
							</div>
						</div>
						<div class="card-content">
							<div class="card-body">
								<table class="table table-striped table-bordered" id="tablaMonitor">
									<thead>
										<tr>
											<th style="width:1%"></th>
											<th style="width:9%">Fecha</th>
											<th style="width:10%">Folio</th>
											<th style="width:40%">Cliente</th>
											<th style="width:10%">Estatus</th>
											<th style="width:35%">Acciones</th>
										</tr>
									</thead>
									<tbody>
										<?php $sql = "SELECT	`COT`.`COT_IDINTRN`,
																`COT`.`COT_FCHCRCN`,
																`COT`.`COT_FL`,
																`CLI`.`CLI_RZNSCL`,
																CASE
																	WHEN `COT`.`COT_ESTTS` IN (1, 0) THEN '<span class=\"badge badge-info m-0\">A Costear</span>'
																	WHEN `COT`.`COT_ESTTS` = 2 THEN '<span class=\"badge badge-primary m-0\">A Costear</span>'
																	WHEN `COT`.`COT_ESTTS` = 3 THEN '<span class=\"badge badge-success m-0\">Enviada</span>'
																	WHEN `COT`.`COT_ESTTS` = 4 THEN '<span class=\"badge bg-blue-grey m-0\">Aprobada</span>'
																	WHEN `COT`.`COT_ESTTS` = 5 THEN '<span class=\"badge badge-warning m-0\">Rechazada</span>'
																	WHEN `COT`.`COT_ESTTS` = 6 THEN '<span class=\"badge badge-danger m-0\">Eliminada</span>'
																	WHEN `COT`.`COT_ESTTS` = 7 THEN '<span class=\"badge bg-purple bg-lighten-3 m-0\">Eliminada</span>'
																	ELSE '<span class=\"badge badge-secondary m-0\">Sin Estatus</span>'
																END AS `COT_ESTTS_LABEL`,
																CASE
																	WHEN `COT`.`COT_ESTTS` IN (1, 0) THEN '<a href=\"javascript:;\" class=\"btn btn-outline-secondary mr-1 btnDesglose\" data-id=\"[:id:]\"><i class=\"fa fa-list\"></i></a>
																		<a href=\"[:url:]/carmona/vws/pimprenta/cotizaciones/crear_cotizacion/index.php?ui=[:id:]\" class=\"btn btn-outline-info mr-1\" target=\"_blank\"><i class=\"fa fa-eye\"></i></a>
																		<a href=\"javascript:;\" class=\"btn btn-danger mr-1 btnEliminar\" data-id=\"[:id:]\"><i class=\"fa fa-trash\"></i></a>'
																	WHEN `COT`.`COT_ESTTS` = 2 THEN '<a href=\"javascript:;\" class=\"btn btn-outline-secondary mr-1 btnDesglose\" data-id=\"[:id:]\"><i class=\"fa fa-list\"></i></a>
																		<a href=\"[:url:]/carmona/vws/pimprenta/cotizaciones/crear_cotizacion/index.php?ui=[:id:]\" class=\"btn btn-outline-info mr-1\"><i class=\"fa fa-eye\"></i></a>
																		<a href=\"javascript:;\" class=\"btn btn-danger mr-1 btnEliminar\" data-id=\"[:id:]\"><i class=\"fa fa-trash\"></i></a>'
																	WHEN `COT`.`COT_ESTTS` = 3 THEN '<a href=\"javascript:;\" class=\"btn btn-outline-secondary mr-1 btnDesglose\" data-id=\"[:id:]\"><i class=\"fa fa-list\"></i></a>
																		<a href=\"[:url:]/carmona/vws/pimprenta/cotizaciones/crear_cotizacion/index.php?ui=[:id:]\" class=\"btn btn-outline-info mr-1\" target=\"_blank\"><i class=\"fa fa-eye\"></i></a>
																		<a href=\"javascript:;\" class=\"btn btn-outline-danger mr-1 btnCancelar\" data-id=\"[:id:]\"><i class=\"fa fa-trash\"></i></a>
																		<a href=\"javascript:;\" class=\"btn btn-danger mr-1 btnEliminar\" data-id=\"[:id:]\"><i class=\"fa fa-trash\"></i></a>'
																	WHEN `COT`.`COT_ESTTS` = 6 THEN '<a href=\"[:url:]/carmona/vws/pimprenta/cotizaciones/crear_cotizacion/index.php?ui=[:id:]\" class=\"btn btn-outline-info mr-1\" target=\"_blank\"><i class=\"fa fa-eye\"></i></a>'
																	ELSE '<a href=\"[:url:]/carmona/vws/pimprenta/cotizaciones/crear_cotizacion/index.php?ui=[:id:]\" class=\"btn btn-outline-info mr-1\" target=\"_blank\"><i class=\"fa fa-eye\"></i></a>
																		<a href=\"javascript:;\" class=\"btn btn-danger mr-1 btnEliminar\" data-id=\"[:id:]\"><i class=\"fa fa-trash\"></i></a>'
																END AS `COT_BTTNS`
														FROM	`COTIZACIONES`	AS `COT`
														JOIN	`CONTACTOS`		AS `CON`	ON `COT`.`CONTACTOS_CNT_IDINTRN` = `CON`.`CNT_IDINTRN`
														JOIN	`CLIENTES`		AS `CLI`	ON `CON`.`CLIENTES_CLI_IDINTRN` = `CLI`.`CLI_IDINTRN`
														WHERE	`COT`.`USUARIOS_USR_CTZDR` = $_SESSION[USR_IDINTRN]"?>
										<?php $db->query($sql)?>
										<?php $ventas = $db->fetch()?>
										<?php foreach ($ventas as $venta) {?>
										<tr>
											<td>
												<span style="visibility:hidden"><?php echo $venta["COT_IDINTRN"]?>
											</td>
											<td><?php echo $venta["COT_FCHCRCN"]?></td>
											<td><?php echo $venta["COT_FL"]?></td>
											<td><?php echo $venta["CLI_RZNSCL"]?></td>
											<td><?php echo $venta["COT_ESTTS_LABEL"]?></td>
											<td><?php echo str_replace(["[:url:]", "[:id:]"], [$_SERVER["HTTP_REFERER"], $venta["COT_IDINTRN"]], $venta["COT_BTTNS"])?></td>
										</tr>
										<?php }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . $_SESSION["DIR_LOCAL"] . "/vws/footer.php"?>
<script type="text/javascript" src="<?php echo $URL_PRINCIPAL?>core/js/util.js"></script>
<script type="text/javascript" src="<?php echo $URL_PRINCIPAL?>core/js/cotizaciones/monitor_ventas.js"></script>
