<?php include_once("includes/conn_admin.php"); ?>
<?php include_once("includes/head_admin.php"); ?>
<?php include_once("includes/menu_admin.php"); ?>
<script>
$(document).ready(function() {
	getTabla();
})

var tablaG = "registros";

function getTabla(cant){
	
	var json = {s:2, tabla:tablaG}
	servicio_json(json, endTabla)
}
function endTabla(data){
	var salida = data.salida_arreglo;
	
	var salida_n = data.salida_texto;
	//alert(salida_n + salida);
	if(salida_n != 0)
	{
		var retorno = "";
		retorno += "<table id='tablaganadores_admin' class='table'>"; 
		retorno += "<tr>"; 
		retorno += "<th>Num</th>";
		retorno += "<th>ID</th>";
		retorno += "<th>Editar</th>";
		retorno += "<th>Nombre</th>";
    retorno += "<th>Cédula</th>";
		retorno += "<th>Correo</th>";
		retorno += "<th>Teléfono</th>";
		retorno += "<th>Mensaje</th>";
		retorno += "<th>Fecha Registro</th>";
		retorno += "<th>Activa</th>";
		retorno += "<th>Borrar</th>";
		retorno += "</tr>";
		for(var n = 0; n <= salida.length-1 ; n++) {
			var fecha = arreglarFecha(salida[n].fecha_registro,1);
			var activo = "";
			var boton_e = "";
            var foto = "";
			if(salida[n].activo == 1)
			{
				activo = "Si";
				boton_e = "btn-success"
				
			}else{
				activo = "No";
				boton_e = "btn-danger"
			}
			retorno += '<tr id='+String('fila_'+salida[n].id)+'>';
			retorno += '<td style="text-align: center;">'+(n+1)+'</td>';
			retorno += '<td style="text-align: center;">'+salida[n].id+'</td>';
			retorno += '<td><button type="button" class="btn btn-success btn-sm" onclick=openeditor(this) tabla="'+tablaG+'" id_tabla="'+salida[n].id+'" class="edit_open"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></td>';
			retorno += '<td>'+salida[n].nombre+'</td>';
      		retorno += '<td>'+salida[n].cedula+'</td>';
			retorno += '<td>'+salida[n].email+'</td>';
			  retorno += '<td>'+salida[n].telefono+'</td>';
			  retorno += '<td>'+salida[n].mensaje+'</td>';
			retorno += '<td>'+salida[n].fecha_registro+'</td>';
			retorno += '<td id="boton_'+salida[n].id+'"><button type="button" class="btn '+boton_e+' btn-sm" onclick="flip(this)" id_tabla="'+salida[n].id+'" id_flip="'+tablaG+'">'+activo +'</button></td>';
			retorno += '<td id="boton_borrar'+salida[n].id+'"><button type="button" class="btn btn-danger btn-sm" onclick="borrar(this)" id_borrar="'+salida[n].id+'" id_tabla="'+tablaG+'">Borrar</button></td>';
			retorno += '</tr>';
		}
		retorno += '</table>';
		$(".boton_add_class").remove();
		var boton_add = '<button id="boton_add" type="button" onclick=openadd(this) class="btn btn-success btn-md boton_add_class" tabla="'+tablaG+'" nombre_tabla="'+tablaG+'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Agregar Fila</button>'
		$("#principal_sel1").append(boton_add);
		$('#tablaContent').html(retorno);
		
	}else if(salida_n == 1)
	{
		alerto(salida);
	}
}
function flip(elem){
	var id_tabla = String($(elem).attr("id_tabla"));
	var id_flip = String($(elem).attr("id_flip"));
	var json = {s:1, id_tabla:id_tabla, id_flip:id_flip}
	console.log(json);
	servicio_json(json, endFlip)
}
function endFlip(data){
	var salida = data.salida;
	var salida_n = data.salida_n;
	if(salida_n == 1)
	{
		
		if(salida.val == 1)
		{
			activo = "Si";
			boton_e = "btn-success"
			
		}else{
			activo = "No";
			boton_e = "btn-danger"
		}
		
		var retorno_v = '<button type="button" class="btn '+boton_e+' btn-sm" onclick="flip(this)" id_tabla="'+salida.id_tabla+'" id_flip="'+tablaG+'">'+activo +'</button>'
		$('#boton_'+salida.id_tabla).html(retorno_v);
	}else if(salida_n == 0)
	{
		alerto(salida);
	}
	//alerto(salida);
}

</script>

<!-- container ya esta abierto -->
	<div class="row" style="margin-top:20px; margin-bottom:20px;">
    	<div class="col-md-12 img-thumbnail">
       		<h1 id="titulo">Usuarios</h1>
       	</div>
    </div>
	<div class="row" style="margin-top:20px; margin-bottom:20px;">
        <div class="col-md-12">
            <!-- Split button -->
            <div id="principal_sel1" class="btn-group">
            	<button type="button" class="btn btn-success btn-md" onClick="getFacturas(0)">
                  <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Mostrar todos los usuarios
                </button>
                <a class="btn btn-success btn-md" href="includes/dw_admin.php?valid=_DgETX36Dsaf_36857929ANSK&tabla=usuarios"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Descargar Base de Datos (Exel)</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
    		<div class="panel panel-default">
      			<!-- Default panel contents -->
      			<div class="panel-heading" id="nombre_tabla">Lista de Productos</div>
                <!-- Table -->
                <div id="tablaContent">
                <table class="table" id="tabla1">
                      <tr>
                        <th>#</th>
                        <th>Selecionar</th>
                        <th>Editar</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>email</th>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td><input type="checkbox"></td>
                        <td><button type="button" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></td>
                        <td>Prueba Nombre 1</td>
                        <td>Prueba Apellido 1</td>
                        <td>email1@gmail.com</td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td><input type="checkbox"></td>
                        <td><button type="button" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></td>
                        <td>Prueba Nombre 2</td>
                        <td>Prueba Apellido 2</td>
                        <td>email2@gmail.com</td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td><input type="checkbox"></td>
                        <td><button type="button" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></td>
                        <td>Prueba Nombre 3</td>
                        <td>Prueba Apellido 3</td>
                        <td>email3@gmail.com</td>
                      </tr>
                    
                </table>
                </div>
    		</div>
    	</div>
    </div>
    <!-- Modales -->
    
    <!-- Modal Crear -->
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Crear Lista</h4>
          </div>
          <form id="form1">
          <div class="modal-body">
          	<span>Seleccione su archivo CVS para crear una nueva Lista</span>
            <div class="input-group spacer-class">
            	<span class="input-group-addon">Nombre Lista</span>
            	<input type="text" class="form-control validate[required,minSize[3]]" name="nombre" placeholder="Lista 1..."/>
          	</div>
          	<div class="input-group spacer-class">
            	<span class="input-group-addon">Archivo CVS</span>
            	<input type="file" class="form-control validate[required]" name="file" placeholder="Archivo CVS"/>
          	</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <input type="hidden" name="s" value="0">
            <input type="submit" class="btn btn-primary" value="Crear">
          </div>
          </form>
        </div>
      </div>
    </div>  
<?php include_once("includes/footer_admin.php"); ?>