//Funcion Alerta Global
function alerto(texto, recargar){
	//alertas opcionales son las que no requieren recargar el sitio, solo informan actividad en el ajax
	var alertas_opcionales = true;
	if(recargar==true)
	{
		swal({
			title: "Buen trabajo",   
			text: texto,   
			type: "success",   
			showCancelButton: false,   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "Cerrar",  
			closeOnConfirm: true,   
			closeOnCancel: true}, 
		function(isConfirm)
		{   
			if (isConfirm) 
			{    
				window.location.reload(); 
			} else {     
				//swal("Cancelled", "Your imaginary file is safe :)", "error");   
			} 
		});
	}else if(recargar==false){
		if(alertas_opcionales == true)
		{
			swal("Atencion!", texto, "warning");
			//alert(texto);
		}
	}
}
//Arreglar titulos de tablas
function espacios(key){
	key=key.replace("_"," ");
	return key.charAt(0).toUpperCase() + key.slice(1);
}

//Registro Ajax	
function form_valid_submit(formulario, end){
	$(formulario).on('submit', function(event) {
		event.preventDefault();
		if ($(formulario).validationEngine('validate') ) {
			$('#loadingo').modal('show');
			var formData = new FormData($(formulario)[0]);
			$.ajax({            
				type: "POST",
				url: 'includes/ajax.php',
				data: formData,
				cache: false,
				xhr: function() {  // custom xhr
	                myXhr = $.ajaxSettings.xhr();
	                if(myXhr.upload){ // check if upload property exists
	                	$('#loader').show();
	                    myXhr.upload.addEventListener('progress',updateProgress, false); // for handling the progress of the upload
	                }
	                return myXhr;
	            },
	            contentType: false,
	            processData: false,
	            async: true,
				success: function(response){
					end(JSON.parse(response), formulario);
				}
				
			});	
		}else{

		}
		return false;
	});
}
function updateProgress(evt) {
    if (evt.lengthComputable) {
            var percentComplete = Math.round((evt.loaded / evt.total)*100);
            console.log(percentComplete);
            document.getElementById("bar_color").style.width = percentComplete + "%";
        	document.getElementById("status").innerHTML = percentComplete + "%";
            if(percentComplete == 100){
            	$('#loader').hide();
            }
    } else {
            // Unable to compute progress information since the total size is unknown
            console.log('unable to complete');
    }
}
function servicio(numero_servicio, end)
{
	var respuesta = "";
	$.ajax({            
		type: "POST",
		url: 'includes/ajax.php',
		dataType: "json",
		data: {s:numero_servicio},
		success: function(response){
			end(response);
		}
	});
}
function servicio_json(json, end)
{
	var respuesta = "";
	$.ajax({            
		type: "POST",
		url: 'includes/ajax.php',
		dataType: "json",
		data: json,
		success: function(response){
			end(response);
		}
	});
}
function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min)) + min;
}

function arreglarFecha(fecha, tipo){
	
	var formattedDate = new Date(fecha);
	var d = formattedDate.getDate();
	var m =  formattedDate.getMonth();
	m += 1;  // JavaScript months are 0-11
	var y = formattedDate.getFullYear();
	
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	if(tipo ==1){
		return String(d + "/" + m);
	}else if(tipo ==2)
	{
		return String(String(meses[m-1]) + " " + d +" "+y );
	}
}
/* Funcion para ajustar el formulario resultante al dar click en editar, permite no mostrar campos, o cambiar el tipo de input que tiene cada campo segun el nombre en de la variable en la tabla.*/
function validEditForm(fila_cont, form, tipo){
	if(tipo == 'add'){
		for (var key in fila_cont) {
			var valid = fila_cont[key].Field.toLowerCase()
			switch(valid) {
			    case "id":
			        form += '';
			        break;
			    case "activo":
			        form += '';
			        break;
			    case "descripcion":
			        form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(fila_cont[key].Field) + '</span> <textarea class="form-control validate[required]" rows="5" name="' + fila_cont[key].Field + '" placeholder="' + espacios(fila_cont[key].Field) + '" value=""></textarea></div>';
			        break;
			    case "posicion_der":
			        var nombres1 = Array("No", "Si");
			        var valores1 = Array("0", "1");
			     	var marcas_select = "";
			     	for(var i = 0; i<=valores1.length-1; i++)
			     	{
						marcas_select += '<option value="'+valores1[i]+'">'+nombres1[i]+'</option>';
			     	};
			        form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(fila_cont[key].Field) + '</span><select name="' + fila_cont[key].Field + '" class="form-control"><option value="0">Seleccione</option>'+marcas_select+'</select></div>';
			        break;
			    case "posicion_izq":
			        var nombres2 = Array("No", "Si");
			        var valores2 = Array("0", "1");
			     	var marcas_select = "";
			     	for(var i = 0; i<=valores2.length-1; i++)
			     	{
						marcas_select += '<option value="'+valores2[i]+'">'+nombres2[i]+'</option>';
			     	};
			        form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(fila_cont[key].Field) + '</span><select name="' + fila_cont[key].Field + '" class="form-control"><option value="0">Seleccione</option>'+marcas_select+'</select></div>';
			        break;
			    case "foto":
			        form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(fila_cont[key].Field) + '</span><input type="file" class="form-control validate[required]" name="' + fila_cont[key].Field + '" placeholder="' + espacios(fila_cont[key].Field) + '" value=""/></div>';
			        break;
			    case "logo":
			        form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(fila_cont[key].Field) + '</span><input type="file" class="form-control validate[required]" name="' + fila_cont[key].Field + '" placeholder="' + espacios(fila_cont[key].Field) + '" value=""/></div>';
			        break;
			    case "email":
			        form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(fila_cont[key].Field) + '</span><input type="text" class="form-control validate[required,custom[email]]" name="' + fila_cont[key].Field + '" placeholder="' + espacios(fila_cont[key].Field) + '" value=""/></div>';
			        break;
			    case "fecha_registro":
			        form += '';
			        break;
			    default:
			        form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(fila_cont[key].Field) + '</span><input type="text" class="form-control validate[required]" name="' + fila_cont[key].Field + '" placeholder="' + espacios(fila_cont[key].Field) + '" value=""/></div>';
			}
		}
	}else if (tipo == 'edit') {
		for (var key in fila_cont) {
			var valid = key.toLowerCase();
			switch(valid) {
			    case "id":
			        form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(key) + '</span><input type="text" class="form-control" name="' + key + '" placeholder="' + espacios(key) + '" value="'+fila_cont[key]+'" readonly/></div>';
			        break;
			    case "descripcion":
			        form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(key) + '</span><textarea class="form-control" rows="5" class="form-control" name="' + key + '" placeholder="' + espacios(key) + '" value="">'+fila_cont[key]+'</textarea></div>';
			        break;
			    case "activo":
			        form += '';
			        break;
			    case "posicion_izq":
			     	var valor1 = fila_cont[key];
			     	var nombres1 = Array("No", "Si");
			     	var valores1 = Array("0", "1");
			     	var marcas_select = "";
			     	for(var i = 0; i<=valores1.length-1; i++)
			     	{
			     		if(valores1[i] === valor1)
				     	{
				     		marcas_select += '<option value="'+valores1[i]+'" selected>'+nombres1[i]+'</option>';
				     	}else{
							marcas_select += '<option value="'+valores1[i]+'">'+nombres1[i]+'</option>';
				     	};
			     	};
			        form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(key) + '</span><select name="' + key + '" class="form-control"><option value="0">Seleccione</option>'+marcas_select+'</select></div>';
			        break;
			    case "posicion_der":
			     	var valor2 = fila_cont[key];
			     	var nombres2 = Array("No", "Si");
			     	var valores2 = Array("0", "1");
			     	var marcas_select = "";
			     	for(var i = 0; i<=valores2.length-1; i++)
			     	{
			     		if(valores2[i] === valor2)
				     	{
				     		marcas_select += '<option value="'+valores2[i]+'" selected>'+nombres2[i]+'</option>';
				     	}else{
							marcas_select += '<option value="'+valores2[i]+'">'+nombres2[i]+'</option>';
				     	};
			     	};
			        form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(key) + '</span><select name="' + key + '" class="form-control"><option value="0">Seleccione</option>'+marcas_select+'</select></div>';
			        break;
			    case "foto":
			        form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(key) + '</span><input type="file" class="form-control" name="' + key + '" placeholder="' + espacios(key) + '" value=""/></div>';
			        break;
			    case "logo":
			        form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(key) + '</span><input type="file" class="form-control" name="' + key + '" placeholder="' + espacios(key) + '" value=""/></div>';
			        break;
			    case "email":
			    	form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(key) + '</span><input type="text" class="form-control validate[required,custom[email]]" name="' + key + '" placeholder="' + espacios(key) + '" value="'+fila_cont[key]+'"/></div>';
			        break;
			    case "fecha_registro":
			        form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(key) + '</span><input type="text" class="form-control" name="' + key + '" placeholder="' + espacios(key) + '" value="'+fila_cont[key]+'" readonly/></div>';
			        break;
			    default:
					form += '<div class="input-group spacer-class"><span class="input-group-addon">' + espacios(key) + '</span><input type="text" class="form-control validate[required]" name="' + key + '" placeholder="' + espacios(key) + '" value="'+fila_cont[key]+'"/></div>';
			}
		}

	};
	return form;
}

function openadd(elem) {
    var tabla_name = String($(elem).attr("tabla"));
	var tabla_nombre_string = String($(elem).attr("nombre_tabla"));

	servicio(3,end6);
	function end6(e){
		if(e != "")
		{
			alerto(e.salida_texto,false);
			var fila_cont = e.salida_arreglo.col;
			var form_name = 'form_'+tabla_name;
			console.log(fila_cont);
			var form_add = '<form id="'+form_name+'" action=""><div class="modal-body"><span>Crear fila en '+tabla_nombre_string+'</span>'

			form_add = validEditForm(fila_cont,form_add, 'add')

			form_add += '</div><div class="modal-footer"><input type="hidden" name="s" value="6"><input type="hidden" name="tabla" value="'+tabla_name+'"><input type="submit" class="btn btn-primary" value="Agregar"></div></form>';
			$.fancybox({
				width: "600px",
				height: "600px",
				autoResize: true,
				content: form_add,
				
			});
			function end7(e){
				if(e != "")
				{
					alerto(e.salida_texto+" fin",true);
				}else{
					alerto("no data",false);
				}
			}
			form_valid_submit(String("#"+form_name),end7);
		}else{
			alerto("no data",false);
		}
	}
}

function openeditor(elem) {
  var tabla_name = String($(elem).attr("tabla"));
	var id_tabla = String($(elem).attr("id_tabla"));
	
	var ajax_var = {s:4, tabla:tabla_name, id:id_tabla};
	servicio_json(ajax_var,end4);
	
	function end4(e){
		if(e != "")
		{
			alerto(e.salida_texto,false);
			var fila_cont = e.salida_arreglo;
			var form_name = 'form_'+tabla_name+'_'+id_tabla;
			var form = '<form id="'+form_name+'" action=""><div class="modal-body"><span>Editar la fila '+ id_tabla+'</span>'
			//Recorremos la fila y llenamos el formulario
			form = validEditForm(fila_cont,form, 'edit');
			
			form += '</div><div class="modal-footer"><input type="hidden" name="s" value="5"><input type="hidden" name="tabla" value="'+tabla_name+'"><input type="hidden" name="id" value="'+id_tabla+'"><input type="submit" class="btn btn-primary" value="Guardar"></div></form>';
			$.fancybox({
				width: "600px",
				height: "600px",
				autoResize: true,
				content: form,
				
			});
			
			function end5(e){
				if(e != "")
				{
					alerto(e.salida_texto,true);
				}else{
					alerto("no data", false);
				}
			
			}
			form_valid_submit(String("#"+form_name),end5);
		}else{
			alerto("no data",false);
		}
	}
}
function openphoto(url){
    alerto(url,false);
    var form = '<div class="modal-body">';
    form += '<div><img height="900" src="'+url+'"/></div>';
    form += '</div><div class="modal-footer"></div>';
    $.fancybox({
        width: "600px",
        height: "600px",
        autoResize: true,
        content: form,
    });
}

function borrar(elem){
	var id_tabla = String($(elem).attr("id_tabla"));
	var id_borrar = String($(elem).attr("id_borrar"));
	var json = {s:7, id_tabla:id_tabla, id_borrar:id_borrar};
	//alerto(String(id_tabla+" "+id_borrar),false);
    servicio_json(json, endBorrar);
}
function endBorrar(e){
    if(e != "")
    {
        alerto(e.salida_texto,true);
    }else{
        alerto("No se borro la fila")
    }
}
function formatDinero(n, currency) {
    return currency + Number(n).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}




