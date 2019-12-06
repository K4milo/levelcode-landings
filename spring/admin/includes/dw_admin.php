<?php
if($_GET['valid'] == "_DgETX36Dsaf_36857929ANSK")
{
function conectar_base()
{
	//$link = mysqli_connect("localhost","root","root","prada");
	$link = mysqli_connect("localhost","noestareafacil_db","tarea2018","noestareafacil_db"); 
	mysqli_query($link, "SET NAMES 'utf8'");
	return $link;
}
$enlace=conectar_base();

$table = $_GET['tabla'] ;
$file = 'export';
$csv_output = '';

$result = mysqli_query($enlace, "SHOW COLUMNS FROM ".$table."");
$i = 0;
if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_assoc($result)) {
$csv_output .= $row['Field']."; ";
$i++;
}
}
$csv_output .= "\n";

$values = mysqli_query($enlace,"SELECT * FROM ".$table."");
while ($rowr = mysqli_fetch_row($values)) {
for ($j=0;$j<$i;$j++) {
$csv_output .= $rowr[$j]."; ";
}
$csv_output .= "\n";
}

$filename = $file."_".date("Y-m-d_H-i",time());
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;
}
?>