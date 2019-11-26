


function cargarPermisos(){
	if($("#cbRol").val() == "0"){
		toastError("Seleccione el Rol para ver los permisos", 'Error', 3);
	} else {
		$('#tree').jstree("destroy").empty();
		$.ajax({
			type: "POST",
			url: window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/getpermisos.php",
			dataType: "json",
			data: { ID_ROL: $("#cbRol").val() },
			success: function(response){
				$('#tree').jstree({
				    	'checkbox' : {
				      		'keep_selected_style' : false
						    },
						'plugins' : [ "checkbox" ], 
						'core' : {
						    'data' : response[0].DATA
						 }
					}).on('changed.jstree', function (e, data) {
				    var i, j, r = [];
				    for(i = 0, j = data.selected.length; i < j; i++) {
				      r.push(data.instance.get_node(data.selected[i]).original.id_programa);
				    }
				    cambiarPermisos($("#cbRol").val(), r);
				  });
			},
			error: function(error){
				toastError(error.responseText, 'Error', 3);
			}
		});
	}
}


function cambiarPermisos(id_rol, array_programas){

	$.ajax({
		type: "POST",
		url: window.location.origin+DIR_LOCAL_JS+"/core/ph/sistema/setpermisos.php",
		dataType: "json",
		data: { ID_ROL: id_rol, AR_PROGRAMAS: array_programas },
		success: function(response){
			console.log(response);
		},
		error: function(error){
			toastError(error.responseText, 'Error', 3);
		}
	});
}


