<?php
header("Content-Type: text/html;charset=utf-8");
date_default_timezone_set('America/Bogota');
//Sesion
if(!isset($_SESSION["sesion"]))
{
session_start();
}
//variable de sesion global
$ses = false;
$admin_var = false;
//evaluo nombre script
$file = basename($_SERVER["SCRIPT_FILENAME"], '.php');

//Evaluo Sesion
if(isset($_SESSION["sesion"]))
{
	$ses = $_SESSION["sesion"];
	if(isset($_SESSION["admin"])){
		$admin_var = $_SESSION["admin"];
	}
	if($file == "admin" && $ses == true && $admin_var == true)
	{
		header("Location: main.php");
	}
	if(isset($_POST["close"]))
	{
		session_destroy();
		$ses = false;
		header("Location: admin.php");
	}
}
//valido seguridad
if($file == "main" || $file == "sel1" || $file == "sel2")
{
	if($ses == false || $admin_var = false)
	{
		header("Location: admin.php");
		
	}
}
//DB connection
function conectar_base()
{
	//$link = mysqli_connect("localhost","root","root","prada");
	$link = mysqli_connect("localhost","spring_db","SP2019*!","spring_db");
	mysqli_query($link, "SET NAMES 'utf8'");
	return $link;
}

$enlace=conectar_base();

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
	$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  $enlace = conectar_base();
  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($enlace,$theValue) : mysqli_escape_string($theValue);

  switch ($theType) {
	case "text":
	  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
	  break;    
	case "long":
	case "int":
	  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
	  break;
	case "double":
	  $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
	  break;
	case "date":
	  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
	  break;
	case "defined":
	  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
	  break;
  }
  return $theValue;
}
?>
