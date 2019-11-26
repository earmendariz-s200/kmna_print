get_clientes();
get_vendedores();

setTimeout(function () { nuevo_folio(); }, 1500);

var tablaDetalles = $("#tablaDetalleCotizacion").DataTable(settingsTable);
var tablaDetalleMaterial2 = $("#tablaDetalleMateriales2").DataTable(settingsTable);
var tablaDetalleMaterial1 = $("#tablaDetalleMateriales1").DataTable(settingsTable);
var tablaDetallesAcabados = $("#tablaDetalleAcabados").DataTable(settingsTable);
var tablaDetallesTerminados = $("#tablaDetalleTerminados").DataTable(settingsTable);

var DetalleMateriales = [];
var DetalleMateriales2 = [];
var tipo_diseno = 0;
var DetalleAcabadosMateriales = [];
var DetalleTerminadoMateriales = [];
var paginas = 0;


function nuevo_folio () {
	if ($("#hdId").val() == "0") {
		var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/get_nuevo_folio.php", {});
		if (response[0].RESULT) {
			var d = new Date();
			var str = response[0].DATA.CONT + 1;
			var pad = "000";
			var ans = pad.substring(0, pad.length - str.length) + str;
			var pad2 = "00";
			var ans2 = pad2.substring(0, pad2.length - (d.getMonth() + 1).length) + (d.getMonth() + 1);
			var nuevofolio = d.getFullYear() + ans2 + ans;
			$("#txtFolioCotizacion").val(nuevofolio);
		} else
			toastError(response[0].MESSAGE, "Info", 3);
	} else {
		var data = { COT_IDINTRN: $("#hdId").val() };
		var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/consulta_cotizacion.php", data);
		if (response[0].RESULT) {
			var item = response[0].DATA[0];
			$("#txtFolioCotizacion").val(item.COT_FL);
			// $("#cbClientes").select2("val", item.CLI_IDINTRN);
			$("#cbClientes").val(item.CLI_IDINTRN).change();
			// setTimeout(function () { $("#cbContacto").select2("val", item.CNT_IDINTRN); }, 800);
			setTimeout(function () { $("#cbContacto").val(item.CNT_IDINTRN) }, 800);
			// $("#cbVendedor").select2("val", item.USR_IDINTRN);
			$("#cbVendedor").val(item.USR_IDINTRN);
			$("#txtFechaCotizacion").val(item.COT_FCHINC);
			$("#txtValidaHasta").val(item.COT_FCHFN);
			// $("#cbCondicionPago").select2("val", item.CONDICIONES_CPA_IDINTRN);
			$("#cbCondicionPago").val(item.CONDICIONES_CPA_IDINTRN);
			cargar_conceptos();
		} else
			toastError(response[0].MESSAGE, "Info", 3);
	}
}

function get_clientes () {
	var data = { prospecto: "0, 1" };
	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/clientes/get_clientes.php", data);
	if (response[0].RESULT) {
		$("#cbClientes").html("<option value=\"0\">[Seleccione Cliente]</option>");
		$.each(response[0].DATA, function (index, value){
			$("#cbClientes").append("<option value=\"" + value.CLI_IDINTRN + "\">" + value.CLI_NMCR + "</option>");
		});
	} else
		toastError(response[0].MESSAGE, "Info", 3);
}

function get_contactos () {
	if ($("#cbClientes").val() == "0")
		$("#agregarContacto").addClass("hidden");
	else
		$("#agregarContacto").removeClass("hidden").attr("href", window.location.origin + DIR_LOCAL_JS + "/vws/pimprenta/clientes/registro/cliente.php?v=" + btoa($("#cbClientes").val()));
	$("#cbContacto").html("");
	var data = { id: $("#cbClientes").val() };
	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/clientes/getContactosXClientes.php", data);
	if (response[0].RESULT) {
		$("#cbContacto").html("<option value=\"0\">[Seleccione Contacto]</option>");
		$.each(response[0].DATA, function (index, value) {
			$("#cbContacto").append("<option value=\"" + value.CNT_IDINTRN + "\">" + value.CNT_NMBR + " " + value.CNT_APLLDPTRN + " " + value.CNT_APLLDMTRN + "</option>");
		});
	} else
		toastError(response[0].MESSAGE, "Info", 3);
}

function get_vendedores () {
	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/sistema/get_vendedores.php", {});
	if (response[0].RESULT) {
		$("#cbVendedor").html("<option value=\"0\">[Seleccione Asesor]</option>");
		$.each(response[0].DATA, function (index, value) {
			$("#cbVendedor").append("<option value=\"" + value.USR_IDINTRN + "\">" + value.USR_NMBR + " " + value.USR_APLLDPTRN + " " + value.USR_APLLDMTRN + "</option>");
		});
	} else
		toastError(response[0].MESSAGE, "Info", 3);
}

function get_condiciones () {
	var data = { ID_CLIENTE: $("#cbClientes").val() };
	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/catalogos/getcondicionesxcliente.php", data);
	if (response[0].RESULT) {
		$("#cbCondicionPago").html("<option value=\"0\">[Seleccione Condición de Pago]</option>");
		$.each(response[0].DATA, function (index, value) {
			$("#cbCondicionPago").append("<option value=\"" + value.CPA_IDINTRN + "\">" + value.CPA_NMBR + "</option>");
		})
	} else
		toastError(response[0].MESSAGE, "Info", 3);
}

function get_tipoproducto () {
	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/catalogos/gettipoproductos.php", {});
	if (response[0].RESULT) {
		$("#cbTipoProductoDetalle").html("<option value=\"0\">[Seleccione Tipo de Producto]</option>");
		$.each(response[0].DATA, function (index, value) {
			$("#cbTipoProductoDetalle").append("<option value=\"" + value.TPR_IDINTRN + "\" data-tipo=\"" + value.TPR_TPDSN + "\">" + value.TPR_NMBR + "</option>");
		});
	} else {
		toastError(response[0].MESSAGE, "Info", 3);
	}
}

function get_tipodiseno () {
	$("#div-datos-detalle").show("fast");
	tablaDetalleMaterial1.clear().draw();
	tablaDetalleMaterial2.clear().draw();
	if ($("#cbTipoProductoDetalle").find(":selected").data("tipo") == "1") {
		$("#cbOrientacionDetalle").parent().addClass("hidden");
		$("#tablaDetalleM1").show();
		$("#tablaDetalleM2").hide();
		tipo_diseno = 1;
		$("#div_diseño2").hide("fast");
		$("#div-diseno2").hide();
		$("#div_diseno1").show();
		$("#base-tab1_4").css("display", "none");
		$("#tablaDetalleTerminados > tbody > tr input[type=checkbox]").prop("disabled", true);
	} else {
		$("#cbOrientacionDetalle").parent().removeClass("hidden")
		$("#tablaDetalleM1").hide();
		$("#tablaDetalleM2").show();
		tipo_diseno = 2;
		$("#div_diseño2").show("fast");
		$("#div_diseno1").hide();
		$("#div-diseno2").show();
		$("#base-tab1_4").css("display", "block");
		$("#tablaDetalleTerminados > tbody > tr input[type=checkbox]").prop("disabled", false);
	}
	cargar_acabados();
}

function get_tamanos () {
	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/catalogos/gettamanospapel.php", {});
	if (response[0].RESULT) {
		$("#cbTamanoPapel1Detalle, #cbTamanoPapel2Detalle").html("<option value=\"0\" data-medida=\"0cm X 0cm\" data-ancho=\"0\" data-alto=\"0\" >[Seleccione Tamaño]</option>");
		$.each(response[0].DATA, function (index, value) {
			$("#cbTamanoPapel1Detalle, #cbTamanoPapel2Detalle").append("<option value=\"" + value.MEP_IDINTRN + "\" data-medida=\"" + value.MEP_ANCH_ALT + "\" data-ancho=\"" + value.ANCHO + "\" data-alto=\"" + value.ALTO + "\">" + value.MEP_NMBR + "</option>");
		});
	} else
		toastError(response[0].MESSAGE, "Info", 3);
}

function get_papeles () {
	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/catalogos/getpapeles.php", {});
	if (response[0].RESULT) {
		$("#cbTipoPapelDiseno").html("<option value=\"0\">[Seleccione Papel]</option>");
		$.each(response[0].DATA, function (index, value) {
			$("#cbTipoPapelDiseno").append("<option value=\"" + value.TPA_IDINTRN + "\">" + value.TPA_NMBR + "</option>");
		});
	} else
		toastError(response[0].MESSAGE, "Info", 3);
}

function get_gramajes () {
	$("#cbGramajeDiseno").html("");
	var data = { ID_PAPEL: $("#cbTipoPapelDiseno").val() };
	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/catalogos/getgramajesxpapel.php", data);
	if (response[0].RESULT) {
		$("#cbGramajeDiseno").html("<option value=\"0\">[Seleccione Gramaje]</option>");
		$.each(response[0].DATA, function (index, value) {
			$("#cbGramajeDiseno").append("<option value=\"" + value.GXP_IDINTRN + "\">" + value.GPA_GRAMAJE + "</option>");
		});
	} else
		toastError(response[0].MESSAGE, "Info", 3);
}

function get_tintas () {
	$("#cbTintasFrenteDiseno, #cbTintasVueltaDiseno").html("");
	var data = { ID_PAPEL: $("#cbTipoPapelDiseno").val() };
	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/catalogos/get_colores.php", data);
	if (response[0].RESULT) {
		$("#cbTintasFrenteDiseno, #cbTintasVueltaDiseno").html("<option value=\"0\">[Seleccione Color]</option>");
		$.each(response[0].DATA, function (index, value) {
			$("#cbTintasFrenteDiseno, #cbTintasVueltaDiseno").append("<option value=\"" + value.COL_IDINTR + "\">" + value.COL_NMBR + "</option>");
		});
	} else
		toastError(response[0].MESSAGE, "Info", 3);
}

function cargar_tabla_materiales () {
	if (tipo_diseno == 1) {
		tablaDetalleMaterial1.clear().draw();
		$.each(DetalleMateriales, function (index, value) {
			tablaDetalleMaterial1.row.add([
				value.DISENO,
				value.TIPO_PAPEL_TEXT,
				value.GRAMAJE_TEXT,
				value.TINTAS_FRENTE_TEXT,
				value.TINTAS_VUELTA_TEXT,
				"<button type=\"button\" class=\"btn btn-outline-secondary mr-1 btn-opciones\" onclick=\"editar_material(" + value.ID + ")\"><i class=\"fa fa-edit\"></i></button>" +
				"<button type=\"button\" class=\"btn btn-xs btn-danger btn-opciones\" data-id=\"" + value.ID + "\" onclick=\"quitar_material_1(" + value.ID + ");\"><i class=\"fa fa-trash\"></i></button>"
			]).draw();
		});
	} else {
		tablaDetalleMaterial2.clear().draw();
		$.each(DetalleMateriales2, function (index, value) {
			tablaDetalleMaterial2.row.add([
				value.UTILIZAR_PARA_TEXT,
				value.PAGINAS,
				value.TIPO_PAPEL_TEXT,
				value.GRAMAJE_TEXT,
				value.TINTAS_FRENTE_TEXT,
				value.TINTAS_VUELTA_TEXT,
				"<button type=\"button\" class=\"btn btn-outline-secondary mr-1 btn-opciones\" onclick=\"editar_material(" + value.ID + ")\"><i class=\"fa fa-edit\"></i></button>" +
				"<button type=\"button\" class=\"btn btn-xs btn-danger btn-opciones\" data-id=\"" + value.ID + "\" onclick=\"quitar_material_2(" + value.ID + ");\"><i class=\"fa fa-trash\"></i></button>"
			]).draw();
		});
	}
	generaDescripcion();
	cargar_combo_materiales();
}

function editar_material (ID) {
	$(".btn-opciones").prop("disabled", true);
	response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/get_cot_det_material.php", { ID_DETALLE : $("#hdIdDetalle").val(), ID_MATERIAL: ID });
	if (response[0].RESULT) {
		$($($($("#btnAgregarMaterial").text("Guardar Cambios").parents("div")[0]).append("<button class=\"btn grey btn-outline-secondary\" id=\"btnCancelarCambiosMaterial\" onclick=\"cancelar_cambio_material()\" type=\"button\">Cancelar</button>").removeClass("col-sm-2").addClass("col-sm-3").parent("div")[0]).append("<input type=\"hidden\" id=\"hdIdMaterial\" value=\"" + ID + "\" />").find("div")[0]).removeClass("col-sm-4").addClass("col-sm-3");
		var material = response[0].DATA[0];
		$("#cbDiseno2Utiliza").val(material.CDM_US_PRTD);
		$("#txtDiseno2Paginas").val(material.CDM_PGNS);
		$("#cbDiseno2MedidaComo").val(material.CDM_MDD);
		$("#ckDiseno2SonIguales").prop("checked", parseInt(material.CDM_IGLS));
		$("#txtNumeroDisenos").val(material.CDM_DSNS);
		$("#cbTipoPapelDiseno").val(material.TPA_IDINTRN).change();
		$("#cbGramajeDiseno").val(material.GXP_IDINTRN).change();
		$("#cbTintasFrenteDiseno").val(material.CDM_TTS_FRNT).change();
		$("#cbTintasVueltaDiseno").val(material.CDM_TTS_VLT).change();
		if (material.CDE_MED_ANCH > 0 || material.CDE_MED_ALTO > 0) {
			$("#chkMedidaDiferente").prop("checked", true).change();
			$("#txtMedidaAncho").val(material.CDE_MED_ANCH);
			$("#txtMedidaAlto").val(material.CDE_MED_ALTO);
		}
		if (material.CDE_MED_IDNT.length > 0) {
			$("#chkIdenficarMeterial").prop("checked", true).change();
			$("#txtIdentificarMaterial").val(material.CDE_MED_IDNT);
		}
	} else {
		toastError(response[0].MESSAGE, "Info", 3);
		$(".btn-opciones").prop("disabled", false);
	}
}

function cancelar_cambio_material () {
	$($("#btnAgregarMaterial").text("Agregar").parents("div")[0]).find("#btnCancelarCambiosMaterial").remove();
	$($($("#btnAgregarMaterial").parents("div")[0]).parent("div")[0]).find("#hdIdMaterial").remove();
	$($($($("#btnAgregarMaterial").parents("div")[0]).removeClass("col-sm-3").addClass("col-sm-2").parent("div")[0]).find("div")[0]).removeClass("col-sm-3").addClass("col-sm-4");
	$(".btn-opciones").prop("disabled", false);
	limpiar_materiales();
}

function quitar_material_1 (ID) {
	if (!confirm("Está a punto de eliminar este registro ¿Seguro que desea continuar?"))
		return false;
	response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/eliminar_cot_det_materiales.php", { ID_DETMAT: ID });
	if (response[0].RESULT) {
		var nuevo_array = [];
		for (var i = 0; i < DetalleMateriales.length; i++)
			if (DetalleMateriales[i].ID != ID)
				nuevo_array.push(DetalleMateriales[i]);
		DetalleMateriales = nuevo_array;
		cargar_tabla_materiales();
	} else
		toastError(response[0].MESSAGE, "Info", 3);
}

function quitar_material_2 (ID) {
	if (!confirm("Está a punto de eliminar este registro ¿Seguro que desea continuar?"))
		return false;
	response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/eliminar_cot_det_materiales.php", { ID_DETMAT: ID });
	if (response[0].RESULT) {
		var nuevo_array = [];
		for (var i = 0; i < DetalleMateriales2.length; i++)
			if (DetalleMateriales2[i].ID != ID)
				nuevo_array.push(DetalleMateriales2[i]);
		DetalleMateriales2 = nuevo_array;
		cargar_tabla_materiales();
	} else
		toastError(response[0].MESSAGE, "Info", 3);
}

function cargar_combo_materiales () {
	$("#cbMaterialesAcabados").html("");
	if (tipo_diseno == 1)
		$.each(DetalleMateriales, function (index, value) {
			$("#cbMaterialesAcabados").append("<option value=\"" + value.ID + "\">" + value.TIPO_PAPEL_TEXT + " - " + value.GRAMAJE_TEXT + " Páginas</option>");
		});
	else
		$.each(DetalleMateriales2, function (index, value) {
			$("#cbMaterialesAcabados").append("<option value=\"" + value.ID + "\">" + value.UTILIZAR_PARA_TEXT + " - " + value.TIPO_PAPEL_TEXT + " - " + value.PAGINAS + " Páginas</option>");
		});
}

/**
 *
 * Obeservacion: los acabados de
 * revistas y posters no son los
 * mismos.
 *
 * Y algunas de las opciones de
 * para posters tienen opciones
 * de en frente y en vuelta.
 */
function cargar_acabados () {
	tablaDetallesAcabados.clear().draw();
	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/catalogos/getacabados.php", { TIPO_DISENO: tipo_diseno });
	if (response[0].RESULT) {
		$.each(response[0].DATA, function (index, value) {
			var selectAlts = value.CCO_NMBR,
				options = "";
			for (var i = 0; i < response[0].ALTERNOS.length; i++)
				if (value.CCO_IDINTRN == response[0].ALTERNOS[i].CCO_IDINTRN)
					options += "<option value=\"" + response[0].ALTERNOS[i].CCA_IDINTRN + "\">" + value.CCO_NMBR + " " + response[0].ALTERNOS[i].CCA_NMBR + "</option>";
			if (options.length > 0)
				selectAlts = "<select class=\"form-control\" onchange=\"cb_acabado(this)\" disabled><option value=\"0\">" + value.CCO_NMBR + "</option>" + options + "</select>";
			tablaDetallesAcabados.row.add([
				"<input type=\"checkbox\" onclick=\"ck_acabado(this)\" data-nombre=\"" + value.CCO_NMBR + "\" value=\"" + value.CCO_IDINTRN + "\" />",
				selectAlts
			]).draw();
		});
	} else
		toastError(response[0].MESSAGE, "Info", 3);
}

function cargar_terminados () {
	tablaDetallesTerminados.clear().draw();
	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/catalogos/getterminados.php", {});
	if (response[0].RESULT)
		$.each(response[0].DATA, function (index, value) {
			tablaDetallesTerminados.row.add([
				"<input type=\"checkbox\" onclick=\"ck_terminado(this);\" data-nombre=\"" + value.CCO_NMBR + "\" value=\"" + value.CCO_IDINTRN + "\" />",
				value.CCO_NMBR
			]).draw();
		});
	else
		toastError(response[0].MESSAGE, "Info", 3);
}

function limpiar_materiales () {
	$("#cbDiseno2Utiliza, #cbDiseno2MedidaComo, #cbGramajeDiseno").val("0");
	$("#txtMedidaAncho, #txtMedidaAlto").val("0.00");
	$("#chkMedidaDiferente, #chkIdenficarMeterial").prop("checked", false).change();
	$("#txtDiseno2Paginas").val("4");
	$("#txtNumeroDisenos").val("1");
	$("#ckDiseno2SonIguales").prop("checked", false);
	$("#cbTipoPapelDiseno").select2("val", "0");
	$("#cbTintasFrenteDiseno").select2("val", "0");
	$("#cbTintasVueltaDiseno").select2("val", "0");
	$("#txtIdentificarMaterial").val("");
}

function agregarAcabdosArray (ID_DETMAT) {
	var existe = false,
		index = 0,
		arrayAcabados = [];
	for (var i = 0; i < ($el = $("#tablaDetalleAcabados > tbody > tr input[type=checkbox]:checked")).length; i++) {
		var alterno = "";
		if ($($el[i]).parents("tr").find("select").length > 0)
			if ($($el[i]).parents("tr").find("select").val() != 0)
				alterno = $($el[i]).parents("tr").find("select option:selected").text();
		arrayAcabados.push({
			"id_acabado": $($el[i]).val(),
			"acabado": $($el[i]).data("nombre"),
			"id_alterno": $($el[i]).parents("tr").find("select").length > 0 ? $($el[i]).parents("tr").find("select").val() : 0,
			"alterno": alterno
		});
	}
	if (DetalleAcabadosMateriales.length > 0) {
		for (var i = 0; i < DetalleAcabadosMateriales.length; i++)
			if (DetalleAcabadosMateriales[i].material == ID_DETMAT) {
				existe = true;
				index = i;
				break;
			}
		if (!existe)
			DetalleAcabadosMateriales.push({ "material" : ID_DETMAT, "acabados" : arrayAcabados });
		else
			DetalleAcabadosMateriales[index].acabados = arrayAcabados;
	}
	else
		DetalleAcabadosMateriales.push({ "material" : ID_DETMAT, "acabados" : arrayAcabados });
}

function agregarTerminadosArray () {
	DetalleTerminadoMateriales = [];
	for (var i = 0; i < ($el = $("#tablaDetalleTerminados > tbody > tr input[type=checkbox]:checked")).length; i++)
		DetalleTerminadoMateriales.push($($el[i]).data("nombre"));
}

function ck_acabado (el) {
	if ($("#cbMaterialesAcabados").val() == null || $("#cbMaterialesAcabados").val() == "0") {
		toastError("Seleccione un material.", "Info", 3);
		el.checked = !el.checked;
		return false;
	}
	var dataAjax = {
		ID_DETMAT: $("#cbMaterialesAcabados").val(),
		ID_ACB: el.value,
		ID_ACB_ALT: 0
	};
	if (el.checked)
		$.ajax({
			url: window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/guardar_cot_det_acabados.php",
			type: "POST",
			dataType: "json",
			data: dataAjax,
			success: function (response) {
				if (!response[0].RESULT) {
					toastError(response[0].MESSAGE, "Info", 3);
					el.checked = false;
				} else {
					if ((select = $(el).parents("tr").find("select")).length > 0)
						select[0].disabled = false;
					agregarAcabdosArray($("#cbMaterialesAcabados").val());
					generaDescripcion();
				}
			},
			error: function (error) {
				toastError(error.textStatus, "Info", 3);
			}
		});
	else
		$.ajax({
			url: window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/eliminar_cot_det_acabados.php",
			type: "POST",
			dataType: "json",
			data: dataAjax,
			success: function (response) {
				if (!response[0].RESULT) {
					toastError(response[0].MESSAGE, "Info", 3);
					el.checked = true;
				} else {
					if ((select = $(el).parents("tr").find("select")).length > 0)
						select[0].disabled = true;
					agregarAcabdosArray($("#cbMaterialesAcabados").val());
					generaDescripcion();
				}
			},
			error: function (error) {
				toastError(error.textStatus, "Info", 3);
			}
		});
	// agregarAcabdosArray($("#cbMaterialesAcabados").val());
	// generaDescripcion();
	// console.log(DetalleAcabadosMateriales);
}

function cb_acabado (el) {
	if ($("#cbMaterialesAcabados").val() == null || $("#cbMaterialesAcabados").val() == "0") {
		toastError("Seleccione un material.", "Info", 3);
		return false;
	}
	var $select = $(el);
	var dataAjax = {
		ID_DETMAT: $("#cbMaterialesAcabados").val(),
		ID_ACB: $select.parents("tr").find("input[type=checkbox]").val(),
		ID_ACB_ALT: $select.val()
	};
	$.ajax({
		url: window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/guardar_cot_det_acabados_alt.php",
		type: "POST",
		dataType: "json",
		data: dataAjax,
		success: function (response) {
			if (response[0].RESULT) {
				agregarAcabdosArray($("#cbMaterialesAcabados").val());
				generaDescripcion();
			}
			else
				toastError(response[0].MESSAGE, "Info", 3);
		},
		error: function (error) {
			toastError(error.textStatus, "Info", 3);
		}
	});
}

function ck_terminado (el) {
	var dataAjax = {
		ID_COTDET: $("#hdIdDetalle").val(),
		ID_TER: el.value
	};
	if (el.checked)
		$.ajax({
			url: window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/guardar_cot_det_terminados.php",
			type: "POST",
			dataType: "json",
			data: dataAjax,
			success: function (response) {
				if (!response[0].RESULT) {
					toastError(response[0].MESSAGE, "Info", 3);
					el.checked = false;
				} else {
					agregarTerminadosArray();
					generaDescripcion();
				}
			},
			error: function (error) {
				toastError(error.responseText, "Info", 3);
			}
		});
	else
		$.ajax({
			url: window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/eliminar_cot_det_terminados.php",
			type: "POST",
			dataType: "json",
			data: dataAjax,
			success: function (response) {
				if (!response[0].RESULT) {
					toastError(response[0].MESSAGE, "Info", 3);
					el.checked = true;
				} else {
					agregarTerminadosArray();
					generaDescripcion();
				}
			},
			error: function (error) {
				toastError(error.responseText, "Info", 3);
			}
		});
}

function nuevo_concepto () {
	cancelar_cambio_material();
	limpiar_materiales();
	get_tipoproducto();
	get_tamanos();
	get_papeles();
	get_tintas();
	cargar_acabados();
	cargar_terminados();
	$("#txtTagDetalle, #txtCantidadDetalle, #txtDetalleCotizacion").val("");
	$("#div-datos-detalle").hide();
	DetalleMateriales = [];
	DetalleMateriales2 = [];
	DetalleAcabadosMateriales = [];
	DetalleTerminadoMateriales = [];
	$("#modalDetalle").modal("show");
	$("#btnGuardarConcepto").text("Agregar Concepto");
	$("#btnAgregarDetalleGeneral").show("fast");
}

function cargar_conceptos () {
	tablaDetalles.clear().draw();
	var data = {
		ID: $("#hdId").val()
	};
	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/get_conceptos_cotizacion.php", data);
	if (response[0].RESULT) {
		$.each(response[0].DATA, function (index, value) {
			tablaDetalles.row.add([
				"<a title='Duplicar partida' href=\"javascript:;\" class=\"btn btn-outline-secondary mr-1\" onclick=\"duplicar_partida(" + value.CDE_IDINTRN + ","+ value.COT_IDINTRN+")\"><i class=\"fa fa-refresh\"></i> <strong >"+value.CDE_IDINTRN+"</strong></a>" ,
				value.TPR_NMBR,
				value.CDE_URGNT,
				value.CDE_DSCRPCN,
				0,
				0,
				"<a href=\"javascript:;\" class=\"btn btn-outline-secondary mr-1\" onclick=\"editar_concepto(" + value.CDE_IDINTRN + ")\"><i class=\"fa fa-edit\"></i></a>" +
				"<a href=\"javascript:;\" class=\"btn btn-xs btn-danger\" onclick=\"borrar_concepto(" + value.CDE_IDINTRN + ")\"><i class=\"fa fa-trash\"></i></a>"
			]).draw();
		});
		$("#btnGuardarCotizacion").show();
	} else {
		toastError(response[0].MESSAGE, "Info", 3);
		$("#btnGuardarCotizacion").hide();
	}
}

function borrar_concepto (idconcepto) {
	if (!confirm("Está a punto de eliminar este registro ¿Seguro que desea continuar?"))
		return false;
	var data = {
		CDE_IDINTRN: idconcepto
	};
	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/borrar_concepto.php", data);
	if (response[0].RESULT) {
		toastExito("Información actualizada correctamente", "Cotizaciones", 3);
		cargar_conceptos();
	} else {
		toastError(response[0].MESSAGE, "Info", 3);
	}
}

function duplicar_partida(idpartida,idcot){

	if (!confirm("¿Seguro que desea duplicar la partida?"))
		return false;
	var data = {
		ID_DETALLE: idpartida,
		ID_COT:idcot
	};
	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/duplicar_partida.php", data);
	if (response[0].RESULT) {
		toastExito("Información actualizada correctamente", "Cotizaciones", 3);
		cargar_conceptos();
	} else {
		toastError(response[0].MESSAGE, "Info", 3);
	}
}

function editar_concepto (idconcepto) {
	DetalleMateriales = [];
	DetalleMateriales2 = [];
	DetalleAcabadosMateriales = [];
	DetalleTerminadoMateriales = [];
	get_tipoproducto();
	get_tamanos();
	get_papeles();
	get_tintas();
	cargar_terminados();
	$("#txtTagDetalle, #txtCantidadDetalle, #txtDetalleCotizacion").val("");
	$("#hdIdDetalle").val(idconcepto);
	$("#div-datos-detalle, #btnAgregarDetalleGeneral").hide("fast");

	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/get_cot_det.php", { ID_COT_DET: idconcepto });

	if (response[0].RESULT) {
		$("#modalDetalle").modal("show");
		$("#btnGuardarConcepto").text("Guardar Cambios");

		var general = response[0].GENERAL[0],
			materiales = response[0].MATERIALES,
			acabados = response[0].ACABADOS,
			terminados = response[0].TERMINADOS;

		/**
		 *
		 * Carga primera pestaña
		 */
		$("#cbTipoProductoDetalle").val(general.TPR_IDINTRN).change();
		$("#txtTagDetalle").val(general.CDE_TG);
		$("#txtCantidadDetalle").val(general.CDE_CNTD);
		$("#cbTipoTrabajoDetalle").val(general.CDE_TRBJ).change();
		$("[name=ckUrgenteDetalle]").prop("checked", parseInt(general.CDE_URGNT));
		if (general.CDE_TP_MDD_1 != "0" || general.CDE_TP_MDD_2 != "0") {
			$("#cbMedida1, #cbMedida2").val("0").change();
			$("#cbTamanoPapel1Detalle").val(general.CDE_TP_MDD_1).change();
			$("#cbTamanoPapel2Detalle").val(general.CDE_TP_MDD_2).change();
		} else {
			$("#cbMedida1, #cbMedida2").val("1").change();
			$("#txtAncho").val(general.CDE_MDD_ANCH_1);
			$("#txtAlto").val(general.CDE_MDD_ALT_1);
			$("#txtAncho2").val(general.CDE_MDD_ANCH_2);
			$("#txtAlto2").val(general.CDE_MDD_ALT_2);
		}
		$("#cbOrientacionDetalle").val(general.CDE_HRNTZN);

		/**
		 *
		 * Carga segunda pestaña
		 */
		if ($("#cbTipoProductoDetalle").find(":selected").data("tipo") == 1)
			$.each(materiales, function (index, value) {
				var arrayMaterial = {
					"ID": value.CDM_IDINTRN,
					"DISENO": value.CDM_DSNS,
					"TIPO_PAPEL": value.TPA_IDINTRN,
					"TIPO_PAPEL_TEXT": value.TPA_NMBR,
					"GRAMAJE": value.GXP_IDINTRN,
					"GRAMAJE_TEXT": value.GPA_GRAMAJE,
					"TINTAS_FRENTE": value.CDM_TTS_FRNT,
					"TINTAS_FRENTE_TEXT": value.COL_NMBR_FRNT,
					"TINTAS_VUELTA": value.CDM_TTS_VLT,
					"TINTAS_VUELTA_TEXT": value.COL_NMBR_VLT
				};
				DetalleMateriales.push(arrayMaterial);
			});
		else
			$.each(materiales, function (index, value) {
				var arrayMaterial = {
					"ID": value.CDM_IDINTRN,
					"UTILIZAR_PARA": value.CDM_US_PRTD,
					"UTILIZAR_PARA_TEXT": (value.CDM_US_PRTD == 0 ? "Portada" : "Interior"),
					"PAGINAS": value.CDM_PGNS,
					"IGUALES": value.CDM_IGLS,
					"TIPO_PAPEL": value.TPA_IDINTRN,
					"TIPO_PAPEL_TEXT": value.TPA_NMBR,
					"GRAMAJE": value.GXP_IDINTRN,
					"GRAMAJE_TEXT": value.GPA_GRAMAJE,
					"TINTAS_FRENTE": value.CDM_TTS_FRNT,
					"TINTAS_FRENTE_TEXT": value.COL_NMBR_FRNT,
					"TINTAS_VUELTA": value.CDM_TTS_VLT,
					"TINTAS_VUELTA_TEXT": value.COL_NMBR_VLT
				};
				// paginas = paginas + parseInt($("#txtDiseno2Paginas").val());
				DetalleMateriales2.push(arrayMaterial);
			});
		cargar_tabla_materiales();

		/**
		 *
		 * Carga tercera pestaña
		 */
		if (acabados.length > 0) {
			var arrayAcabados = [],
				piv_id = acabados[0].CDM_IDINTRN;
			$.each(acabados, function (index, value) {
				if (value.CDM_IDINTRN != piv_id) {
					DetalleAcabadosMateriales.push({ "material": piv_id, "acabados": arrayAcabados });
					arrayAcabados = [];
					piv_id = value.CDM_IDINTRN;
				}
				arrayAcabados.push({
					"id_acabado": value.ACB_IDINTRN,
					"acabado": value.CCO_NMBR,
					"id_alterno": value.ACB_ALT_IDINTRN,
					"alterno": value.ACB_ALT_IDINTRN != 0 ? value.CCO_NMBR + " " + value.CCA_NMBR : value.CCA_NMBR
				});
			});
			DetalleAcabadosMateriales.push({ "material": piv_id, "acabados": arrayAcabados });
			checkTablaAcabdos(DetalleAcabadosMateriales[0]);
		}

		/**
		 *
		 * Carga cuarta pestaña
		 */
		// $("[name=tablaDetalleTerminados_length]").val(100).change();
		$.each(terminados, function (index, value) {
			for (var i = 0; i < ($el = $("#tablaDetalleTerminados > tbody > tr")).length; i++)
				if ($($el[i]).find("input[type=checkbox]").val() == value.TER_IDNTRN) {
					$($el[i]).find("input[type=checkbox]").prop("checked", true);
					break;
				}
			DetalleTerminadoMateriales.push(value.CCO_NMBR);
		});

		/**
		 *
		 * Carga quinta pestaña
		 */

		generaDescripcion();
	} else
		toastError(response[0].MESSAGE, "Info", 3);
}

function generaDescripcion () {
	var text = $("#txtCantidadDetalle").val() + " | [/producto/] : ";
	text = text.replace("[/producto/]", $("#txtTagDetalle").val().length > 0 ? $("#txtTagDetalle").val() : $("#cbTipoProductoDetalle").find(":selected").text());
	if (tipo_diseno == 1) {
		var totalDisenos = 0;
		text += "[/disenos/] Diseños Totales | ";
		if ($("#cbMedida1").val() == 0)
			text += "Medidas " + $("#cbTamanoPapel1Detalle option:selected").data("medida");
		else
			text += "Medidas " + $("#txtAncho").val() + "cm X " + $("#txtAlto").val() + "cm";
		var data_tabla = tablaDetalleMaterial1.rows().data();
		for (var i = 0; i < data_tabla.length; i++) {
			totalDisenos += Number(data_tabla[i][0]);
			text += "\n    ->" + data_tabla[i][0] + " [/plural/] | Papel " + data_tabla[i][1] + " " + data_tabla[i][2] + " | Tintas Frente: " + data_tabla[i][3] + " - Tinta Vuelta: " + data_tabla[i][4];
			text = text.replace("[/plural/]", Number(data_tabla[i][0]) > 1 ? "Diseños" : "Diseño");
			if (DetalleAcabadosMateriales.length > 0) {
				DetalleAcabadosMateriales.forEach(function (item) {
					var arrayTemp = [];
					if ($($(tablaDetalleMaterial1.rows().data()[i][5])[1]).data("id") == item.material) {
						item.acabados.forEach(function (i) {
							if (i.id_alterno != 0)
								arrayTemp.push(i.alterno);
							else
								arrayTemp.push(i.acabado);
						});
						text += " con " + arrayTemp.join(", ");
					}
				});
			}
		}
		text = text.replace("[/disenos/]", totalDisenos);
	} else {
		var totalPaginas = 0;
		text += "[/paginas/] Páginas Totales | ";
		if ($("#cbMedida1").val() == 0)
			text += "Medidas Interior " + $("#cbTamanoPapel1Detalle option:selected").data("medida");
		else
			text += "Medidas Interior " + $("#txtAncho2").val() + "cm X " + $("#txtAlto2").val() + "cm";
		if ($("#cbMedida2").val() == 0)
			text += " - Medidas Portada " + $("#cbTamanoPapel2Detalle option:selected").data("medida");
		else
			text += " - Medidas Portada " + $("#txtAncho").val() + "cm X " + $("#txtAlto").val() + "cm";
		//text +=  paginas+" PÁGINAS ";
		var data_tabla = tablaDetalleMaterial2.rows().data();
		for (var i = 0; i < data_tabla.length; i++) {
			totalPaginas += Number(data_tabla[i][1]);
			text += "\n    ->Utilizar para: " + data_tabla[i][0] + " | " + data_tabla[i][1] + " Páginas | Papel " + data_tabla[i][2] + " de " + data_tabla[i][3] + "g | Tintas Frente: " + data_tabla[i][4] + " - Tinta Vuelta: " + data_tabla[i][5];
			if (DetalleAcabadosMateriales.length > 0) {
				DetalleAcabadosMateriales.forEach(function (item) {
					var arrayTemp = [];
					if ($($(tablaDetalleMaterial2.rows().data()[i][6])[1]).data("id") == item.material) {
						item.acabados.forEach(function (i) {
							if (i.id_alterno != 0)
								arrayTemp.push(i.alterno);
							else
								arrayTemp.push(i.acabado);
						});
						text += " con " + arrayTemp.join(", ");
					}
				});
			}
		}
		text = text.replace("[/paginas/]", totalPaginas);
		if (DetalleTerminadoMateriales.length > 0)
			text += "\n    ->Terminado " + DetalleTerminadoMateriales.join(", ");
	}
	//console.log(data_tabla);
	text = text.toUpperCase();
	$("#txtDetalleCotizacion").val(text);
}

function checkTablaAcabdos (arrayAcabados) {
	$("[name=tablaDetalleAcabados_length]").val(50).change();
	$("#tablaDetalleAcabados").find("input[type=checkbox]").prop("checked", false);
	$("#tablaDetalleAcabados").find("select").val("0").prop("disabled", true);
	$.each($("#tablaDetalleAcabados tbody tr"), function (index, value) {
		for (var i = 0; i < arrayAcabados.acabados.length; i++)
			if ($(value).find("input[type=checkbox]").val() == arrayAcabados.acabados[i].id_acabado) {
				$(value).find("input[type=checkbox]").prop("checked", true);
				$(value).find("select").prop("disabled", false).val(arrayAcabados.acabados[i].id_alterno);
			}
	});
}

// jQuery
// $("#cbClientes, #cbContacto, #cbVendedor, #cbCondicionPago").select2();

$("#cbTipoPapelDiseno, #cbTintasFrenteDiseno, #cbTintasVueltaDiseno, #cbTipoTrabajoDetalle, #cbTipoProductoDetalle, #cbMaterialesAcabados, #cbGramajeDiseno").select2({
	dropdownParent: $("#modalDetalle")
});

$("#btnAgregarDetalle").click(function () {
	if ($("#cbClientes").val() == 0 || $("#cbContacto").val() == 0 || $("#cbContacto").val() == 0 || $("#cbVendedor").val() == 0 || $("#cbCondicionPago").val() == 0)
		toastError("Capture los datos para cotización", "Info", 3);
	else {
		var data = {
			FOLIO: $("#txtFolioCotizacion").val() ,
			FECHA_INICIO: $("#txtFechaCotizacion").val(),
			FECHA_FIN: $("#txtValidaHasta").val(),
			ID_CLIENTE: $("#cbClientes").val(),
			ID_CONTACTO: $("#cbContacto").val(),
			ID_VENDEDOR: $("#cbVendedor").val(),
			ID_CONDICION: $("#cbCondicionPago").val()
		};
		if ($("#hdId").val() == "0") {
			var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/guarda_cabecera.php", data);
			if (response[0].RESULT)
				$("#hdId").val(response[0].DATA);
			else
				toastError(response[0].MESSAGE, "Info", 3);
		}
		nuevo_concepto();
	}
});

$("#btnAgregarDetalleGeneral").click(function () {
	// if ($("#cbTamanoPapel1Detalle").val() == 0 && $("#txtAncho").val() == 0 && $("#txtAlto").val())
	if (($("#cbMedida1") == 0 && $("#cbTamanoPapel1Detalle").val() == 0) || ($("#cbMedida1") == 1 && (Number($("#txtAncho").val()) < 0 || Number($("#txtAlto").val()) < 0)))
		toastError("Información incompleta", "Info", 3);
	else {
		if ($("#btnAgregarDetalleGeneral").text() == "Agregar") {
			// $("#btnAgregarDetalleGeneral").hide("fast");
			var data = {
				ID_COTIZACION: $("#hdId").val(),
				ID_TIPO_PRODUCTO: $("#cbTipoProductoDetalle").val(),
				TAG: $("#txtTagDetalle").val(),
				CANTIDAD: $("#txtCantidadDetalle").val(),
				TIPO_TRABAJO: $("#cbTipoTrabajoDetalle").val(),
				URGENTE: ($("[name=ckUrgenteDetalle]").is(":checked") ? 1 : 0),
				TIPO_MEDIDA_1:  $("#cbTamanoPapel1Detalle").val(),
				ANCHO_1: $("#txtAncho").val(),
				ALTO_1: $("#txtAlto").val(),
				TIPO_MEDIDA_2: $("#cbTamanoPapel2Detalle").val(),
				ANCHO_2: $("#txtAncho2").val(),
				ALTO_2: $("#txtAlto2").val(),
				ORIENTACION: $("#cbOrientacionDetalle").val()
			};
			var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/guarda_detalle.php", data);
			if (response[0].RESULT) {
				$("#hdIdDetalle").val(response[0].DATA);
				// console.log(response[0].MESSAGE);
				$("#btnAgregarDetalleGeneral").text("Modificar");
			} else {
				toastError(response[0].MESSAGE, "Info", 3);
				// $("#btnAgregarDetalleGeneral").show("fast");
				$("#btnAgregarDetalleGeneral").text("Agregar");
			}
		} else if ($("#btnAgregarDetalleGeneral").text() == "Modificar") {
			var data = {
				ID_COT_DET: $("#hdIdDetalle").val(),
				ID_TIPO_PRODUCTO: $("#cbTipoProductoDetalle").val(),
				TAG: $("#txtTagDetalle").val(),
				CANTIDAD: $("#txtCantidadDetalle").val(),
				TIPO_TRABAJO: $("#cbTipoTrabajoDetalle").val(),
				URGENTE: ($("[name=ckUrgenteDetalle]").is(":checked") ? 1 : 0),
				TIPO_MEDIDA_1:  $("#cbTamanoPapel1Detalle").val(),
				ANCHO_1: $("#txtAncho").val(),
				ALTO_1: $("#txtAlto").val(),
				TIPO_MEDIDA_2: $("#cbTamanoPapel2Detalle").val(),
				ANCHO_2: $("#txtAncho2").val(),
				ALTO_2: $("#txtAlto2").val(),
				ORIENTACION: $("#cbOrientacionDetalle").val()
			};
			var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/editar_detalle.php", data);
			if (response[0].RESULT)
				toastExito(response[0].MESSAGE, "Cotizaciones", 3);
			else
				toastError(response[0].MESSAGE, "Info", 3);
		}
	}
});

$("#cbTipoPapelDiseno").change(function () {
	if ($(this).val() != 0 && $(this)[0].length > 0)
		get_gramajes();
	else
		$("#cbGramajeDiseno").html("<option value=\"0\">[Seleccione Gramaje]</option>");
});

$("#btnAgregarMaterial").click(function () {
	// TODO: AGREGAR  LA CONFIGURACION PARA EL DISEÑO 1
	if ($("#cbTipoPapelDiseno").val() == "0" || $("#cbGramajeDiseno").val() == "0" || $("#cbTintasFrenteDiseno").val() == "0" || $("#cbTintasVueltaDiseno").val() == "0") {
		toastError("Capture los datos del Material", "Info", 3);
	} else {
		// console.log($("#cbGramajeDiseno").val());
		// generaDescripcion();
		if ($("#btnAgregarMaterial").text() == "Agregar") {
			if (DetalleMateriales2.length > 0)
				if ($("#cbDiseno2Utiliza").val() == "0")
					for (var i = 0; i < DetalleMateriales2.length; i++)
						if (DetalleMateriales2[i].UTILIZAR_PARA == "0") {
							toastError("No se permite tener 2 veces el material para PORTADA.", "Info", 3);
							return false;
						}
			var data = {
				ID_DETALLE: $("#hdIdDetalle").val(),
				USO: $("#cbDiseno2Utiliza").val(),
				PAGINAS: $("#txtDiseno2Paginas").val(),
				MEDIDAS: $("#cbDiseno2MedidaComo").val(),
				IGUALES: ($("#ckDiseno2SonIguales").is(":checked") ? 1 : 0),
				DISENO: $("#txtNumeroDisenos").val(),
				TIPO_PAPEL: $("#cbTipoPapelDiseno").val(),
				GRAMAJE: ($("#cbGramajeDiseno").val() == "" ? 0 : $("#cbGramajeDiseno").val()),
				TINTAS_FRENTE: $("#cbTintasFrenteDiseno").val(),
				TINTAS_VUELTA: $("#cbTintasVueltaDiseno").val(),
				MEDIDA_ANCHO: $("#txtMedidaAncho").val(),
				MEDIDA_ALTO: $("#txtMedidaAlto").val(),
				IDENTIFICAR: $("#txtIdentificarMaterial").val()
			};
			var id = 0;
			var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/guardar_material.php", data);
			if (response[0].RESULT) {
				id = response[0].DATA;
				// console.log(response[0].MESSAGE);
			} else {
				toastError(response[0].MESSAGE, "Info", 3);
				return;
			}
			if (tipo_diseno == 1) {
				var detalle = {
					"ID": id,
					"DISENO": $("#txtNumeroDisenos").val(),
					"TIPO_PAPEL": $("#cbTipoPapelDiseno").val(),
					"TIPO_PAPEL_TEXT": $("#cbTipoPapelDiseno option:selected").text(),
					"GRAMAJE": ($("#cbGramajeDiseno").val() == "" ? 0 : $("#cbGramajeDiseno").val()),
					"GRAMAJE_TEXT": $("#cbGramajeDiseno option:selected").text(),
					"TINTAS_FRENTE": $("#cbTintasFrenteDiseno").val(),
					"TINTAS_FRENTE_TEXT": $("#cbTintasFrenteDiseno option:selected").text(),
					"TINTAS_VUELTA": $("#cbTintasVueltaDiseno").val(),
					"TINTAS_VUELTA_TEXT": $("#cbTintasVueltaDiseno option:selected").text(),
					"MEDIDA_ANCHO": $("#txtMedidaAncho").val(),
					"MEDIDA_ALTO": $("#txtMedidaAlto").val(),
					"IDENTIFICAR": $("#txtIdentificarMaterial").val()
				};
				DetalleMateriales.push(detalle);
			} else {
				var detalle = {
					"ID": id,
					"UTILIZAR_PARA": $("#cbDiseno2Utiliza").val(),
					"UTILIZAR_PARA_TEXT": $("#cbDiseno2Utiliza option:selected").text(),
					"PAGINAS": $("#txtDiseno2Paginas").val(),
					"IGUALES": $("#ckDiseno2SonIguales").is(":checked"),
					"TIPO_PAPEL": $("#cbTipoPapelDiseno").val(),
					"TIPO_PAPEL_TEXT": $("#cbTipoPapelDiseno option:selected").text(),
					"GRAMAJE": ($("#cbGramajeDiseno").val() == "" ? 0 : $("#cbGramajeDiseno").val()),
					"GRAMAJE_TEXT": $("#cbGramajeDiseno option:selected").text(),
					"TINTAS_FRENTE": $("#cbTintasFrenteDiseno").val(),
					"TINTAS_FRENTE_TEXT": $("#cbTintasFrenteDiseno option:selected").text(),
					"TINTAS_VUELTA": $("#cbTintasVueltaDiseno").val(),
					"TINTAS_VUELTA_TEXT": $("#cbTintasVueltaDiseno option:selected").text(),
					"MEDIDA_ANCHO": $("#txtMedidaAncho").val(),
					"MEDIDA_ALTO": $("#txtMedidaAlto").val(),
					"IDENTIFICAR": $("#txtIdentificarMaterial").val()
				};
				paginas = paginas + parseInt($("#txtDiseno2Paginas").val());
				DetalleMateriales2.push(detalle);
			}
			cargar_tabla_materiales();
			limpiar_materiales();
			generaDescripcion();
		} else if ($("#btnAgregarMaterial").text() == "Guardar Cambios") {
			var data = {
				ID_MATERIAL: $("#hdIdMaterial").val(),
				ID_DETALLE: $("#hdIdDetalle").val(),
				USO: $("#cbDiseno2Utiliza").val(),
				PAGINAS: $("#txtDiseno2Paginas").val(),
				MEDIDAS: $("#cbDiseno2MedidaComo").val(),
				IGUALES: ($("#ckDiseno2SonIguales").is(":checked") ? 1 : 0),
				DISENO: $("#txtNumeroDisenos").val(),
				TIPO_PAPEL: $("#cbTipoPapelDiseno").val(),
				GRAMAJE: ($("#cbGramajeDiseno").val() == "" ? 0 : $("#cbGramajeDiseno").val()),
				TINTAS_FRENTE: $("#cbTintasFrenteDiseno").val(),
				TINTAS_VUELTA: $("#cbTintasVueltaDiseno").val(),
				MEDIDA_ANCHO: $("#txtMedidaAncho").val(),
				MEDIDA_ALTO: $("#txtMedidaAlto").val(),
				IDENTIFICAR: $("#txtIdentificarMaterial").val()
			};
			response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/editar_cot_det_material.php", data);
			if (!response[0].RESULT) {
				toastError(response[0].MESSAGE, "Info", 3);
				return;
			}
			if (tipo_diseno == 1) {
				var index = 0;
				for (index; index < DetalleMateriales.length; index++)
					if (DetalleMateriales[index].ID == $("#hdIdMaterial").val())
						break;
				var detalle = {
					"ID": $("#hdIdMaterial").val(),
					"DISENO": $("#txtNumeroDisenos").val(),
					"TIPO_PAPEL": $("#cbTipoPapelDiseno").val(),
					"TIPO_PAPEL_TEXT": $("#cbTipoPapelDiseno option:selected").text(),
					"GRAMAJE": ($("#cbGramajeDiseno").val() == "" ? 0 : $("#cbGramajeDiseno").val()),
					"GRAMAJE_TEXT": $("#cbGramajeDiseno option:selected").text(),
					"TINTAS_FRENTE": $("#cbTintasFrenteDiseno").val(),
					"TINTAS_FRENTE_TEXT": $("#cbTintasFrenteDiseno option:selected").text(),
					"TINTAS_VUELTA": $("#cbTintasVueltaDiseno").val(),
					"TINTAS_VUELTA_TEXT": $("#cbTintasVueltaDiseno option:selected").text(),
					"MEDIDA_ANCHO": $("#txtMedidaAncho").val(),
					"MEDIDA_ALTO": $("#txtMedidaAlto").val(),
					"IDENTIFICAR": $("#txtIdentificarMaterial").val()
				};
				DetalleMateriales[index] = detalle;
			} else {
				var index = 0;
				for (index; index < DetalleMateriales2.length; index++)
					if (DetalleMateriales2[index].ID == $("#hdIdMaterial").val())
						break;
				var detalle = {
					"ID": $("#hdIdMaterial").val(),
					"UTILIZAR_PARA": $("#cbDiseno2Utiliza").val(),
					"UTILIZAR_PARA_TEXT": $("#cbDiseno2Utiliza option:selected").text(),
					"PAGINAS": $("#txtDiseno2Paginas").val(),
					"IGUALES": $("#ckDiseno2SonIguales").is(":checked"),
					"TIPO_PAPEL": $("#cbTipoPapelDiseno").val(),
					"TIPO_PAPEL_TEXT": $("#cbTipoPapelDiseno option:selected").text(),
					"GRAMAJE": ($("#cbGramajeDiseno").val() == "" ? 0 : $("#cbGramajeDiseno").val()),
					"GRAMAJE_TEXT": $("#cbGramajeDiseno option:selected").text(),
					"TINTAS_FRENTE": $("#cbTintasFrenteDiseno").val(),
					"TINTAS_FRENTE_TEXT": $("#cbTintasFrenteDiseno option:selected").text(),
					"TINTAS_VUELTA": $("#cbTintasVueltaDiseno").val(),
					"TINTAS_VUELTA_TEXT": $("#cbTintasVueltaDiseno option:selected").text(),
					"MEDIDA_ANCHO": $("#txtMedidaAncho").val(),
					"MEDIDA_ALTO": $("#txtMedidaAlto").val(),
					"IDENTIFICAR": $("#txtIdentificarMaterial").val()
				};
				paginas = paginas + parseInt($("#txtDiseno2Paginas").val());
				DetalleMateriales2[index] = detalle;
			}
			$("#btnAgregarMaterial").text("Agregar");
			cargar_tabla_materiales();
			cancelar_cambio_material();
			generaDescripcion();
		}
	}
});

$("#btnGuardarConcepto").click(function () {
	if ($("#btnGuardarConcepto").text() == "Agregar Concepto") {
		var data = {
			ID_DETALLE: $("#hdIdDetalle").val()
		};
		var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/get_material_concepto.php", data);
		if (response[0].RESULT) {
			data = {
				ID_DETALLE: $("#hdIdDetalle").val(),
				DESCRIPCION: $("#txtDetalleCotizacion").val()
			};
			var response2 = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/agregar_concepto.php", data);
			if (response2[0].RESULT) {
				$("#modalDetalle").modal("hide");
				cargar_conceptos();
			} else
				toastError(response2[0].MESSAGE, "Info", 3);
		} else
			toastError("Información incompleta, verifique por favor.", "Info", 3);
	} else {
		var data = {
			ID_COT_DET: $("#hdIdDetalle").val(),
			ID_TIPO_PRODUCTO: $("#cbTipoProductoDetalle").val(),
			TAG: $("#txtTagDetalle").val(),
			CANTIDAD: $("#txtCantidadDetalle").val(),
			TIPO_TRABAJO: $("#cbTipoTrabajoDetalle").val(),
			URGENTE: ($("[name=ckUrgenteDetalle]").is(":checked") ? 1 : 0),
			TIPO_MEDIDA_1: $("#cbTamanoPapel1Detalle").val(),
			ANCHO_1: $("#txtAncho").val(),
			ALTO_1: $("#txtAlto").val(),
			TIPO_MEDIDA_2: $("#cbTamanoPapel2Detalle").val(),
			ANCHO_2: $("#txtAncho2").val(),
			ALTO_2: $("#txtAlto2").val(),
			ORIENTACION: $("#cbOrientacionDetalle").val(),
			DESCRIPCION: $("#txtDetalleCotizacion").val()
		};
		var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/editar_detalle.php", data);
		if (response[0].RESULT) {
			toastExito(response[0].MESSAGE, "Cotizaciones", 3);
			$("#modalDetalle").modal("hide");
			$("#btnGuardarConcepto").text("Agregar Concepto");
			cargar_conceptos();
		}
		else
			toastError(response[0].MESSAGE, "Info", 3);
	}
});

$("#btnGuardarCotizacion").click(function () {
	var data = {
		FOLIO: $("#txtFolioCotizacion").val(),
		OBSERVACIONES: $("#txtObservacionesGenerales").val()
	};
	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/guardar_cotizacion.php", data);
	if (response[0].RESULT) {
		toastExito("Información capturada correctamente", "Cotizaciones", 3);
		setTimeout(function () { window.location = window.location.origin + DIR_LOCAL_JS + "/vws/pimprenta/cotizaciones/monitor/"; }, 3500);
	} else {
		toastError(response[0].MESSAGE, "Info", 3);
	}
});

$("#cbMaterialesAcabados").change(function () {
	$("[name=tablaDetalleAcabados_length]").val(50).change();
	$("#tablaDetalleAcabados").find("input[type=checkbox]").prop("checked", false);
	$("#tablaDetalleAcabados").find("select").val("0").prop("disabled", true);
	for (var i = 0; i < DetalleAcabadosMateriales.length; i++)
		if (DetalleAcabadosMateriales[i].material == $("#cbMaterialesAcabados").val()) {
			checkTablaAcabdos(DetalleAcabadosMateriales[i]);
			break;
		}
});

$("#modalDetalle").on("hide.bs.modal", function () {
	if ($("#btnGuardarConcepto").text() == "Guardar Cambios")
		cancelar_cambio_material();
});

$("#txtTagDetalle").change(function () {
	if ($(this).val().trim().length > 0)
		$(this).val($(this).val().trim());
	else
		$(this).val("");
	generaDescripcion();
});

$("#txtCantidadDetalle").change(function () {
	if (Number($(this).val()) < 1)
		$(this).val("1");
	generaDescripcion();
});

$("#chkMedidaDiferente").change(function () {
	if ($(this).is(":checked"))
		$($(this).parents()[1]).find(".medidas").removeClass("hidden");
	else
		$($(this).parents()[1]).find(".medidas").addClass("hidden");
});

$("#chkIdenficarMeterial").change(function () {
	if ($(this).is(":checked"))
		$("#txtIdentificarMaterial").attr("type", "text");
	else
		$("#txtIdentificarMaterial").attr("type", "hidden")
});

$("#txtAncho, #txtAlto, #txtAncho2, #txtAlto2").change(function () {
	if (Number($("#txtAncho").val()) < 0) $("#txtAncho").val(0);
	if (Number($("#txtAlto").val()) < 0) $("#txtAlto").val(0);
	if (Number($("#txtAncho2").val()) < 0) $("#txtAncho2").val(0);
	if (Number($("#txtAlto2").val()) < 0) $("#txtAlto2").val(0);

	var	$ancho = Number($("#txtAncho").val()),
		$alto = Number($("#txtAlto").val()),
		$ancho2 = Number($("#txtAncho2").val()),
		$alto2 = Number($("#txtAlto2").val());

	$("#txtAncho").val($ancho.toFixed(2));
	$("#txtAlto").val($alto.toFixed(2));
	$("#txtAncho2").val($ancho2.toFixed(2));
	$("#txtAlto2").val($alto2.toFixed(2));

	generaDescripcion();
});

$("#cbTamanoPapel1Detalle, #cbTamanoPapel2Detalle").change(function () {
	$("#txtAncho").val($("#cbTamanoPapel1Detalle option:selected").data("ancho"));
	$("#txtAlto").val($("#cbTamanoPapel1Detalle option:selected").data("alto"));
	$("#txtAncho2").val($("#cbTamanoPapel2Detalle option:selected").data("ancho"));
	$("#txtAlto2").val($("#cbTamanoPapel2Detalle option:selected").data("alto"));

	generaDescripcion();
});

$("#cbMedida1, #cbMedida2").change(function () {
	if ($(this).val() == "0") { // ESTANDAR
		$(".div_medida1_personalizado, .div_medida2_personalizado").hide("fast");
		$(".div_medida1_estandar, .div_medida2_estandar").show("fast");
	} else { // PERSONALIZADO
		$(".div_medida1_personalizado, .div_medida2_personalizado").show("fast");
		$(".div_medida1_estandar, .div_medida2_estandar").hide("fast");
	}
	$("#cbMedida1, #cbMedida2").val($(this).val());
	generaDescripcion();
});

$("#cbClientes").change(function () {
	get_contactos();
	get_condiciones();
});

$("#cbDiseno2Utiliza").change(function () {
	if ($("#btnAgregarMaterial").text() == "Agregar")
		if ($("#cbDiseno2Utiliza").val() == "0")
			if (DetalleMateriales2.length > 0)
				for (var i = 0; i < DetalleMateriales2.length; i++)
					if (DetalleMateriales2[i].UTILIZAR_PARA == "0") {
						toastError("No se permite tener 2 veces el material para PORTADA.", "Info", 3);
						$("#cbDiseno2Utiliza").val(1);
						break;
					}
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	 // newly activated tab
	// previous active tab

	//alert(e.target);
	//alert(e.relatedTarget);
	var id_detalle = $("#hdIdDetalle").val();
 
	if(id_detalle == 0){
		$('a[href="#tab1_1"]').click();
		toastError("Por favor primero guarde los datos generales", "Info", 3);
	}

});
