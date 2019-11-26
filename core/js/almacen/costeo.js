
/* Formatting function for row details - modify as you need */
      function format ( d ) {

        var tabla_nueva = "";

        tabla_nueva = "<table class=''>";
        tabla_nueva += "<thead>  <tr> <th>Proveedor</th>  <th>Costo</th> <th>Fecha</th>  </tr> </thead> <tbody>";
                   
        var data = { id_material:d.MATERIALES_MAT_IDINTRN ,id_registro:d.CST_IDINTRN         };
        var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/almacen/costeo/get_costeo_detalle.php", data);
        if(response[0].RESULT){

          var items = response[0].DATA;
            for (var i = 0 ; i < items.length ; i++) {
               
              var CST_FCH = items[i].CST_FCH;
              var TPA_NMBR = items[i].TPA_NMBR;
              var PRV_RZNSCL = items[i].PRV_RZNSCL; 
              var CST_CST = items[i].CST_CST;  


              tabla_nueva += "<tr>";
              tabla_nueva += " <td>"+PRV_RZNSCL+"</td>";
              tabla_nueva += " <td>"+CST_CST+"</td>";
              tabla_nueva += " <td>"+CST_FCH+"</td>"; 
              tabla_nueva +=" </tr>";

              
            }

             tabla_nueva += " </tbody>  </table> ";

        } else {
          toastError(response[0].MESSAGE, 'Info', 3);
        }

 
        //cellpadding="5" cellspacing="0" 
          return tabla_nueva;
      }

          // -- Child rows (show extra / detailed information) --
      var data = { fecha_inicio:"" ,fecha_fin:""          };
      var response = sendRequest(window.location.origin+DIR_LOCAL_JS+"/core/ph/almacen/costeo/get_costeo.php", data);
      if(response[0].RESULT){
        var items = response[0].DATA;
        console.log(items);

            //var myObj = JSON.parse(items);

          var tableChildRows = $('.show-child-rows').DataTable( {
              "data": items,
              "columns": [
                  {
                      "className":      'details-control',
                      "orderable":      false,
                      "data":           null,
                      "defaultContent": ''
                  },
                  { "data": "TPA_NMBR" },
                  { "data": "CST_CST" },
                  { "data": "CST_CST_PRMD" },
                  { "data": "CST_FCH" },
                  { "data": "PRV_RZNSCL" }
              ],
              "order": [[1, 'asc']]
          } );

          // Add event listener for opening and closing details
          $('.show-child-rows tbody').on('click', 'td.details-control', function () {
              var tr = $(this).closest('tr');
              var row = tableChildRows.row( tr );

              if ( row.child.isShown() ) {
                  // This row is already open - close it
                  row.child.hide();
                  tr.removeClass('shown');
              }
              else {
                  // Open this row
                  row.child( format(row.data()) ).show();
                  tr.addClass('shown');
              }
          } );

        /*$('#tablaListado').DataTable({
                data: items,
                destroy: true,
                columns: [
                    { title: "Folio" },
                    { title: "Fecha" }, 
                    { title: "Material" },
                    { title: "Cantidad" },
                    { title: "Tipo Ajuste" },
                    { title: "Motivo" } 
                ]
            });*/

      } else {
        toastError(response[0].MESSAGE, 'Info', 3);
      }
  


        