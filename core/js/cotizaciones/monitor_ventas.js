var tabla = $("#tablaMonitor").DataTable(settingsTable_desc);

$("#tablaMonitor").on("click", ".btnDesglose", function () {
	var $tr = $(this).parents("tr")[0];

	if ($(this).parents("tr").next().hasClass("row-details")) {
		$(this).parents("tr").next().remove();
		return false;
	}

	$.ajax({
		url: window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/get_conceptos_cotizacion_html.php",
		type: "POST",
		dataType: "json",
		data: {
			ID: $(this).data("id")
		},
		success: function (response) {
			$("#tablaMonitor").find(".row-details").remove();
			$($tr).after("<tr class=\"row-details\"><td colspan=\"6\">" + response[0].DATA + "</td></tr>");
		},
		error: function (error) {
			toastError(error, "Info", 3);
		}
	});
});

$("#tablaMonitor").on("click", ".btnCancelar", function () {

	alert("Cancelar: " + $(this).data("id"));

});

$("#tablaMonitor").on("click", ".btnEliminar", function () {

	var $id = $(this).data("id");

	var response = sendRequest(window.location.origin + DIR_LOCAL_JS + "/core/ph/cotizaciones/eliminar_venta.php", { ID: $id })[0];

	if (response.RESULT) {} else
		toastError(response.MESSAGE, "Info", 3);

});
