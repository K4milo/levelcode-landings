<?php
include("conn_admin.php");

//Servicios Administrador
function adminService($service){
	global $ses, $admin_var;
	if($ses == true && $admin_var == true)
	{
		$service();
	}else{
		echo return_fn('acceso restringido',0);
	}
}

//Servicios Usuarios
function userService($service){
	global $ses;
	if($ses == true)
	{
		$service();
	}else{
		echo return_fn('acceso restringido',0);
	}
}

//retorno en formato Json
function return_fn($salida_texto, $salida_arreglo)
{
	$salida = array(
		"salida_texto" => $salida_texto,
		"salida_arreglo" => $salida_arreglo
	);
	return json_encode($salida);
}

if(isset($_POST["s"]))
{
	$setVar = $_POST["s"];
	switch ($setVar) {
		case 0:
			recuperarTabla();
			break;
		case 1:
			adminService('flipFila');
			break;
		case 2:
			adminService('recuperarTabla');
			break;
		case 3:
			adminService('recuperarColumnas');
			break;
		case 4:
			adminService('recuperarFila');
			break;
		case 5:
			adminService('guardarFila');
			break;
		case 6:
			adminService('agregarFila');
			break;
		case 7:
			adminService('borrarFila');
			break;
		case 8:
			userService('agregarFila');
			break;
		case 9:
			break;
		case 10:
			
			break;
		case 11:
			
			break;
		case 12:
			
			break;
		case 13:
			
			break;
		case 14:
			
			break;
		case 15:
			
			break;
		default:
			echo return_fn('No servicio', 'null');
	}
}

function recuperarTabla()
{
	global $enlace;
	$tabla = $_POST['tabla'];
	//definimos Globales
	$_SESSION["tabla_actual"] = $tabla;

	if($_POST["s"] == 2){
		$consulta = sprintf("SELECT * FROM ".$tabla."");
	}else{
		$consulta = sprintf("SELECT * FROM ".$tabla." WHERE activo=1");
	}
	$result = mysqli_query($enlace, $consulta) or die ("Invalid query ".mysqli_error($enlace));
	while($rows[] = mysqli_fetch_assoc($result)) {
	};
	array_pop($rows);
	mysqli_close($enlace);
	echo return_fn('Tabla '.$tabla.' recuperada', $rows);
}

function flipFila()
{
	global $enlace;
	$id_tabla = $_POST['id_tabla'];
	$id_flip = $_POST['id_flip'];
	$consulta_flip = sprintf("SELECT activo FROM ".$id_flip." WHERE id='$id_tabla'");
	$result_flip = mysqli_query($enlace, $consulta_flip) or die ("Invalid query ".mysqli_error($enlace));
	$result_flip_fetch = mysqli_fetch_assoc($result_flip);
	$valor_flip = $result_flip_fetch['activo'];
	
	//Valid Cambio
	$flip = 0;
	if($valor_flip == 0){
		$flip = 1;
	}else if($valor_flip == 1){
		$flip = 0;
	}
	
	if($valor_flip == 0 || $valor_flip == 1){
		
		$consulta_flip2 = sprintf("UPDATE ".$id_flip." SET activo='$flip' WHERE id='$id_tabla'");
		$result_flip2 = mysqli_query($enlace, $consulta_flip2) or die ("Invalid query ".mysqli_error($enlace));
		if($result_flip2)
		{
			$salida = array(
				'val' => $flip,
				'id_tabla' => $id_tabla
			);
			$arr = array(
				'salida' => $salida,
				"salida_n" => 1,
			);
			echo json_encode($arr);
		}
	}else{
		$arr = array(
			'salida' => 'Fallo el flip',
			"salida_n" => 0,
		);
		echo json_encode($arr);
	}
	mysqli_close($enlace);
}
function borrarFila()
{
	global $enlace;
	$id_tabla = $_POST['id_tabla'];
	$id_borrar = $_POST['id_borrar'];
	$consulta_borrar = sprintf("DELETE FROM ".$id_tabla." WHERE id='$id_borrar'");
	$result_borrar = mysqli_query($enlace, $consulta_borrar) or die ("Invalid query ".mysqli_error($enlace));
	if($result_borrar)
	{
		echo return_fn(ucfirst(strtolower($id_tabla))." ".$id_borrar.' borrado', 1);
	}else{
		echo return_fn(ucfirst(strtolower($id_tabla))." ".$id_borrar.' NO fue borrado', 0);
	}
	mysqli_close($enlace);
}

function recuperarFila(){
	global $enlace;
	
	$tabla_temp = $_POST['tabla'];
	$id_temp = $_POST['id'];
	
	$consulta_fila = sprintf("SELECT * FROM ".$tabla_temp." WHERE id=%s", GetSQLValueString($id_temp, "text"));
	$result_fila = mysqli_query ($enlace, $consulta_fila) or die (return_fn("Consulta Invalida ".mysqli_error($enlace),0));
	$result_log_fetch_fila = mysqli_fetch_assoc($result_fila);
	
	
	if(mysqli_num_rows($result_fila)!=0)
	{
		echo return_fn('Fila '.$id_temp.' Cargada', $result_log_fetch_fila);
	}else{
		echo return_fn('Fila '.$id_temp.' NO Cargada', 0);
	}
}

function guardarFila(){
	global $enlace;
	
	$tabla_temp = $_POST['tabla'];
	$id_temp = $_POST['id'];
	$control = "";
	$nameSql1 = "";
	$nameSql2 = "";
	if(isset($_FILES["foto"]) || isset($_FILES["logo"]))
	{
		if($_FILES["foto"]['name']!=''){
			$foto_n = random_string(6);
			//$control = subirFoto($foto_n);
			$name1= '../img/productos/'.$foto_n.'.png';
			$nameSql1 = 'img/productos/'.$foto_n.'.png';
			move_uploaded_file($_FILES["foto"]['tmp_name'], $name1);
			//$foto_p = resizeImage($name1,150, 150,$name2);
		}
		if($_FILES["logo"]['name']!=''){
			$foto_n = random_string(6);
			//$control = subirFoto($foto_n);
			$name2= '../img/productos/'.$foto_n.'.png';
			$nameSql2 = 'img/productos/'.$foto_n.'.png';
			move_uploaded_file($_FILES["logo"]['tmp_name'], $name2);
			//$foto_p = resizeImage($name1,150, 150,$name2);
		}
	}
	
	$consulta_guardarFila_text = "UPDATE ".$tabla_temp." SET ";
	$numItems = count($_POST)-3;
	$i = 0;
	foreach ($_POST as $key => $value){
		if($key == "tabla" || $key == "id" || $key == "s"){
			$consulta_guardarFila_text .= "";
		}else if($key == "foto"){
			
		}else{
			if(++$i === $numItems) {
				if($_FILES["logo"]['name']!='')
				{
					$consulta_guardarFila_text .= " `logo` = '$nameSql2', ";
					$control = "Logo almacenado correctamente |";
				}
				if($_FILES["foto"]['name']!='')
				{
					$consulta_guardarFila_text .= " `foto` = '$nameSql1', ";
					$control = "Foto almacenada correctamente |";
				}
				$consulta_guardarFila_text .= " $key = '$value' ";
			}else{
				$consulta_guardarFila_text .= " `$key` = '$value', ";
			}
		}
	}
	$consulta_guardarFila_text .= "WHERE id=".$id_temp;
	
	$consulta_guardarFila = sprintf($consulta_guardarFila_text);
	$result_guardarFila = mysqli_query($enlace, $consulta_guardarFila) or die (return_fn("Consulta Invalida ".mysqli_error($enlace).'     '.$consulta_guardarFila_text,0));
	
	if($result_guardarFila)
	{
		echo return_fn('Fila '.$id_temp.' Guardada | '.$control, '');
	}else{
		echo return_fn('Fila '.$id_temp.' NO Guardada', 0);
	}
	
}

function agregarFila()
{
	global $enlace;
	
	$tabla_temp = $_POST['tabla'];
	
	$vars_temp = "";
	$vals_temp = "";

	$control = "";

	$nameSql1 = "";
	$nameSql2 = "";
	
	//validamos si la capa $_FILES contiene una foto

	$foto_n = "";
	if(isset($_FILES["foto"]) || isset($_FILES["logo"]))
	{

		if($_FILES["foto"]['name']!=''){
			$foto_n = random_string(6);
			//$control = subirFoto($foto_n);
			$name1= '../img/productos/'.$foto_n.'.png';
			$nameSql1 = 'img/productos/'.$foto_n.'.png';
			move_uploaded_file($_FILES["foto"]['tmp_name'], $name1);
			//$foto_p = resizeImage($name1,150, 150,$name2);
			$control .= "| Foto subida correctamente |";
		}
		if($_FILES["logo"]['name']!=''){
			$foto_n = random_string(6);
			//$control = subirFoto($foto_n);
			$name2= '../img/productos/'.$foto_n.'.png';
			$nameSql2 = 'img/productos/'.$foto_n.'.png';
			move_uploaded_file($_FILES["logo"]['tmp_name'], $name2);
			//$foto_p = resizeImage($name1,150, 150,$name2);
			$control .= "| Logo subido correctamente |";
		}
	}

	$numItems = count($_POST)-2;
	$i = 0;
	foreach ($_POST as $key => $value){
		if($key == "tabla" || $key == "s"){
			$vars_temp .= "";
			$vals_temp .= "";
		}else{
			if(++$i === $numItems) {
				if(isset($_FILES["foto"]))
				{
					$vars_temp .= "foto, ";
					$vals_temp .= "'$nameSql1', ";
				}
				if(isset($_FILES["logo"]))
				{
					$vars_temp .= "logo, ";
					$vals_temp .= "'$nameSql2', ";
				}
				$vars_temp .= "$key";
				$vals_temp .= "'$value'";
			}else{
				$vars_temp .= "$key, ";
				$vals_temp .= "'$value', ";
			}
		}
		
	}
	$consulta_agregarFila_text = "INSERT INTO ".$tabla_temp."(".$vars_temp.") VALUES (".$vals_temp.")";
	
	$consulta_agregarFila = sprintf($consulta_agregarFila_text);
	$result_agregarFila = mysqli_query($enlace, $consulta_agregarFila) or die (return_fn("Consulta Invalida ".mysqli_error($enlace).'     '.$consulta_agregarFila_text,0));
	$id_last = mysqli_insert_id($enlace);
	if($result_agregarFila)
	{
		echo return_fn('Fila '.$id_last.' Agregada | '.$control.'',1);
	}else{
		echo return_fn('Fila NO Agregada', 0);
	}
}

function recuperarColumnas($ajax = true){
	global $enlace;
	
	if(!isset($_SESSION["tabla_actual"])){
		$tableName_string = $_POST["tabla"];
	}else{
		$tableName_string = $_SESSION["tabla_actual"];
	}
	
	//Nombre de las columnas
	$consulta_col_tabla = sprintf("SHOW COLUMNS FROM ".$tableName_string);
	$result_col_tabla = mysqli_query ($enlace, $consulta_col_tabla) or die (return_fn("Consulta Invalida ".$_SESSION["tabla_actual"]." ".mysqli_error($enlace),0));
	$result_log_fetch_col_tabla = array();
	while($row1 = mysqli_fetch_assoc($result_col_tabla))
	{
	   $result_log_fetch_col_tabla[] = $row1;
	}
	if($ajax == true){
		//Unificación Tabla
		$tabla = array(
			"nombre" => "tabla",
			"nombre_string" => $tableName_string,
			"col" => $result_log_fetch_col_tabla
		);
		if(mysqli_num_rows($result_col_tabla)!=0)
		{
			echo return_fn('Columnas de la tabla "'.$tableName_string.'"', $tabla);
		}else{
			echo return_fn('Columnas de la tabla "'.$tableName_string.'" NO Cargadas', 0);
		}
	}else{
		return $result_log_fetch_col_tabla;
	}
}
function subirFoto($nombre){
	//Subida de archivos
	$target_dir = "../img/productos";
	//Retorno Upload
	$upload_return = '';
	$nombre_destino_p = $target_dir . $nombre."-t .png";
	$nombre_destino_g = $target_dir . $nombre.".png";
	//Validador de subida
	$uploadOk = 1;
	//Imagen temporal sin procesar
	$imagen_nombre = $_FILES["foto"]["name"];
	$imagen = $_FILES["foto"]["tmp_name"];
	$imageFileType = pathinfo($imagen_nombre,PATHINFO_EXTENSION);

	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($imagen);
		if($check !== false) {
			$upload_return .= " - El Archivo es una imagen - " . $check["mime"] . ". ";
			$uploadOk = 1;
		} else {
			$upload_return .= " - El Archivo NO es una imagen. ";
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($nombre_destino_p) || file_exists($nombre_destino_g)) {
		$upload_return .= "- El archivo ya existe. ";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["foto"]["size"] > 10000000) {
		$upload_return .= "- El Archivo excede el limite de tamaño.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		$upload_return .= "- Disculpe, solo se pueden subir JPG, JPEG, PNG y GIF.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$upload_return .= "- Disculpe su archivo no se puede subir en estos momentos. ";
	// if everything is ok, try to upload file
	} else {

		$exploded = explode('.',$imagen_nombre);
	    $ext = $exploded[count($exploded) - 1]; 

	    if (preg_match('/jpg|jpeg/i',$ext)){
	        $imageTmp=imagecreatefromjpeg($imagen);
	    }
	    else if (preg_match('/png/i',$ext)){
	        $imageTmp=imagecreatefrompng($imagen);
	    }
	    else if (preg_match('/gif/i',$ext)){
	        $imageTmp=imagecreatefromgif($imagen);
	    }
	    else if (preg_match('/bmp/i',$ext)){
	        $imageTmp=imagecreatefrombmp($imagen);
	    }

	    if (imagejpeg($imageTmp, $nombre_destino_g, 80)) {
	    	//$foto_p = resizeImage($imagen,$imagen_nombre,150, 150,$nombre_destino_p);
	    	if($foto_p == true){
	    		imagedestroy($imageTmp);
				$upload_return .= "- Foto ". basename($imagen_nombre). " subida correctamente. ";
			}else{
				$upload_return .= "- Disculpe hubo un error subiendo su archivo pequeño. ";
			}
		} else {
			$upload_return .= "- Disculpe hubo un error subiendo su archivo. ";
		}
	}
	return $upload_return;
}

function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

function resizeImage($filename, $max_width, $max_height, $nombre_destino_p)
{
    list($orig_width, $orig_height) = getimagesize($filename);

    $width = $orig_width;
    $height = $orig_height;

    # taller
    if ($height > $max_height) {
        $width = ($max_height / $height) * $width;
        $height = $max_height;
    }

    # wider
    if ($width > $max_width) {
        $height = ($max_width / $width) * $height;
        $width = $max_width;
    }

    $image_p = imagecreatetruecolor($width, $height);

    $image = imagecreatefromjpeg($filename);

    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
    $retorno = imagejpeg($image_p, $nombre_destino_p, 80);
    imagedestroy($image_p);
    return $retorno;
}
?>