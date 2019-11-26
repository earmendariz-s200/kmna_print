var tabla = $('#tablaMateriales').DataTable(settingsTable);
var tablaPapel = $('#tablaPapeles').DataTable(settingsTable);
var tablaGramaje = $('#tablaGramaje').DataTable(settingsTable);

cargarMateriales();
cargarPapeles();


function cargarMateriales(){
	tabla.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getmateriales.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].MAT_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					var tipo = "";
					switch (items[i].MAT_TPMTRL){
						case "1":
							tipo = "PAPEL";
						 	break;
						 case "2":
						 	tipo = "ACABADO";
						 	break
						 case "3":
						 	tipo = "TERMINADO";
						 	break;
					}
					tabla.row.add([ tipo,
				  					items[i].TPA_NMBR, 
				  					items[i].MAT_ANCH+" / "+items[i].MAT_ALT,
				  					"$ "+items[i].MAT_CSTMLLR,
				  					"$ "+items[i].MAT_CSTUNTR,
				  					activo, 
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editarMaterial("+items[i].MAT_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
				  				]).draw();
				}
			} else {
				toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
}

function changeTipo(){
	$("#cbMaterial").html("");
	switch($("#cbTipoMaterial").val()){
		case "1":
			var options = '';
			$.ajax({
				url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getgramajes.php",
				dataType: "json",
				success: function(response){
					if(response[0].RESULT){
						var items = response[0].DATA;
						for (var i = 0 ; i < items.length ; i++) {
							options += '<option value="'+items[i].GXP_IDINTRN+'">'+items[i].TPA_NMBR+' '+items[i].GPA_GRAMAJE+'</option>';
						}
						$("#cbMaterial").html(options);
					} else {
						//toastError(response[0].MESSAGE, 'Info', 3);
					}
				}, 
				error: function(error){
					toastError(error.responseText, 'Error', 3);
				}
			});
			break;
		case "2":
			var options = '';
			$.ajax({
				url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getacabados.php",
				dataType: "json",
				success: function(response){
					if(response[0].RESULT){
						var items = response[0].DATA;
						for (var i = 0 ; i < items.length ; i++) {
							options += '<option value="'+items[i].ACB_IDINTRN+'">'+items[i].ACB_NMBR+'</option>';
						}
						$("#cbMaterial").html(options);
					} 
				}, 
				error: function(error){
					toastError(error.responseText, 'Error', 3);
				}
			});
			break;
		case "3":
			var options = '';
			$.ajax({
				url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getterminados.php",
				dataType: "json",
				success: function(response){
					if(response[0].RESULT){
						var items = response[0].DATA;
						for (var i = 0 ; i < items.length ; i++) {
							options += '<option value="'+items[i].TER_IDNTRN+'">'+items[i].TER_NMBR+'</option>';
						}
						$("#cbMaterial").html(options);
					} 
				}, 
				error: function(error){
					toastError(error.responseText, 'Error', 3);
				}
			});
			break;
	}
}


function agregarMaterial(){
	$("#ckActivoMaterial").attr('checked', true);
	$("#ckControlStock").attr('checked', true);
	$("#cbTipoMaterial").val("");
	$("#cbMaterial").val("");
	$("#txtAncho").val("");
	$("#txtAlto").val("");
	$("#txtCostoMillar").val("");
	$("#txtCostoUnidad").val("");
	$("#modalMaterial").modal("show");

}

function editarMaterial(ID){
	$("#hdMaterialId").val(ID);
	var options = '';
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getgramajes.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					options += '<option value="'+items[i].GXP_IDINTRN+'">'+items[i].TPA_NMBR+' '+items[i].GPA_GRAMAJE+'</option>';
				}
				$("#cbMaterial").html(options);
				$.ajax({
					type: "POST",
					url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getmaterialxid.php",
					dataType: "json",
					data: { ID: ID },
					success: function(response){
						if(response[0].RESULT){
							var item = response[0].DATA;
							((item.MAT_ACTV == 1) ? $("#ckActivoMaterial").attr('checked', true) : $("#ckActivoMaterial").attr('checked', false) );
							((item.MAT_CTRLSTCK == 1) ? $("#ckControlStock").attr('checked', true) : $("#ckControlStock").attr('checked', false) );
							$("#cbTipoMaterial").val(item.MAT_TPMTRL);
							changeTipo();
							setTimeout(function(){ $("#cbMaterial").val(item.MAT_IDTP); }, 800)
							$("#txtAncho").val(item.MAT_ANCH);
							$("#txtAlto").val(item.MAT_ALT);
							$("#txtCostoMillar").val(item.MAT_CSTMLLR);
							$("#txtCostoUnidad").val(item.MAT_CSTUNTR);
							$("#modalMaterial").modal("show");
						} else {
							toastError(response[0].MESSAGE, 'Info', 3);
						}
					}, 
					error: function(error){
						toastError(error.responseText, 'Error', 3);
					} 
				});
			} else {
				//toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
}

$("#btnGuardarMaterial").click(function(){
	var ACTIVO = ($("#ckActivoMaterial").is(':checked') ? 1: 0);
	var CTRL_STOCK = ($("#ckControlStock").is(':checked') ? 1: 0);
	var URL = (($("#hdMaterialId").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/guardarmaterial.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/editarmaterial.php"));
	$.ajax({
		type: "POST",
		url: URL,
		dataType: "json",
		data: {  
				TIPO: $("#cbTipoMaterial").val(),
				MATERIAL: $("#cbMaterial").val(), 
				ANCHO: $("#txtAncho").val(),
				ALTO: $("#txtAlto").val(),
				C_MILLAR: $("#txtCostoMillar").val(),
				C_UNIDAD: $("#txtCostoUnidad").val(),
				ID: $("#hdMaterialId").val(),
				CTRL_STOCK: CTRL_STOCK,
				ACTIVO: ACTIVO 
			},
		success: function(response){
			if(response[0].RESULT){
				toastExito("Datos guardados correctamente.", 'Éxito', 3);
				$("#modalMaterial").modal("hide");
				cargarMateriales();
			} else {
				toastError(response[0].MESSAGE, 'Error', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
});



//  --->. Papeles. <---

function cargarPapeles(){
	tablaPapel.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getpapeles.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				cargarGramajes();
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					var activo = ((items[i].TPA_ACTV == 1) ? ('<span class="badge badge-default badge-success m-0">Si</span>') : ('<span class="badge badge-default badge-danger m-0">No</span>'));
					tablaPapel.row.add([ 
				  					items[i].TPA_NMBR, 
				  					activo, 
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editarPapel("+items[i].TPA_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
				  				]).draw();

				}
			} else {
				//toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
}


function agregarPapel(){
	$("#txtNombrePapel").val("");
	$("#hdPapelId").val(0);
	$("#modalPapel").modal("show");
}

function editarPapel(ID){
	$("#hdPapelId").val(ID);
	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/gettpapelxid.php",
		dataType: "json",
		data: { ID: ID },
		success: function(response){
			if(response[0].RESULT){
				var item = response[0].DATA;
				((item.TPA_ACTV == 1) ? $("#ckActivo").attr('checked', true) : $("#ckActivo").attr('checked', false) );
				$("#txtNombrePapel").val(item.TPA_NMBR);
				$("#modalPapel").modal("show");
			} else {
				toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		} 
	});
}


$("#btnGuadarPapel").click(function(){
	if($("#txtNombrePapel").val() == ""){
		toastError('Es necesario capturar los datos del Papel', 'Problema', 3);
	} else {
		var ACTIVO = ($("#ckActivo").is(':checked') ? 1: 0);
		var URL = (($("#hdPapelId").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/guardarpapel.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/editarpapel.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: {  
					NOMBRE: $("#txtNombrePapel").val(), 
					ID: $("#hdPapelId").val(),
					ACTIVO: ACTIVO 
				},
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalPapel").modal("hide");
					cargarPapeles();
				} else {
					toastError(response[0].MESSAGE, 'Error', 3);
				}
			}, 
			error: function(error){
				toastError(error.responseText, 'Error', 3);
			}
		});
	}
});




//  --->. Gramajes. <---
function cargarGramajes(){
	tablaGramaje.clear().draw();
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getgramajes.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					tablaGramaje.row.add([ 
									items[i].TPA_NMBR,
				  					items[i].GPA_GRAMAJE, 
				  					"<a href='javascript:;' class='btn btn-outline-secondary mr-1' onclick='editarGramaje("+items[i].GXP_IDINTRN+")'><i class='fa fa-edit'></i></a>" 
				  				]).draw();
				}
			} else {
				//toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});	
}

function agregarGramaje(){
	$("#cbTipoPapelGramaje").html("<option value='0'>[Seleccione Tipo Papel]</option>");
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getpapeles.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					if(items[i].TPA_ACTV == 1){
						$("#cbTipoPapelGramaje").append('<option value="'+items[i].TPA_IDINTRN+'">'+items[i].TPA_NMBR+'</option>');
					}
				}
				$("#txtGramajePapel").val("");
				$("#cbTipoPapelGramaje").val(0);
				$("#hdGramajeId").val(0);
				$("#modalGramajes").modal("show");
			} else {
				//toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
}

$("#btnGuadarGramaje").click(function(){
	if($("#cbTipoPapelGramaje").val() == "0" || $("#txtGramajePapel").val() == ""){
		toastError('Es necesario capturar los datos del Gramaje', 'Problema', 3);
	} else {
		var URL = (($("#hdGramajeId").val() == 0) ? (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/guardargramaje.php") : (window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/editargramaje.php"));
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "json",
			data: {  
					GRAMAJE: $("#txtGramajePapel").val(), 
					PAPEL: $("#cbTipoPapelGramaje").val(),
					ID: $("#hdGramajeId").val()
				},
			success: function(response){
				if(response[0].RESULT){
					toastExito("Datos guardados correctamente.", 'Éxito', 3);
					$("#modalGramajes").modal("hide");
					cargarGramajes();
				} else {
					toastError(response[0].MESSAGE, 'Error', 3);
				}
			}, 
			error: function(error){
				toastError(error.responseText, 'Error', 3);
			}
		});
	}
});


function editarGramaje(ID){
	$("#hdGramajeId").val(ID);
	$("#cbTipoPapelGramaje").html("<option value='0'>[Seleccione Tipo Papel]</option>");
	$.ajax({
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getpapeles.php",
		dataType: "json",
		success: function(response){
			if(response[0].RESULT){
				var items = response[0].DATA;
				for (var i = 0 ; i < items.length ; i++) {
					if(items[i].TPA_ACTV == 1){
						$("#cbTipoPapelGramaje").append('<option value="'+items[i].TPA_IDINTRN+'">'+items[i].TPA_NMBR+'</option>');
					}
				}
				$.ajax({
					type: "POST",
					url: window.location.origin+DIR_LOCAL_JS+"/core/ph/catalogos/getgramajexid.php",
					dataType: "json",
					data: { ID: ID },
					success: function(response){
						if(response[0].RESULT){
							var item = response[0].DATA;
							$("#txtGramajePapel").val(item.GPA_GRAMAJE);
							$("#cbTipoPapelGramaje").val(item.TIPO_PAPEL_TPA_IDINTRN);
							$("#modalGramajes").modal("show");
						} else {
							toastError(response[0].MESSAGE, 'Info', 3);
						}
					}, 
					error: function(error){
						toastError(error.responseText, 'Error', 3);
					} 
				});
			} else {
				//toastError(response[0].MESSAGE, 'Info', 3);
			}
		}, 
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});

	
}

