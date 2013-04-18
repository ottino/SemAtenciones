<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
?>


<HTML>
<HEAD>
<TITLE>principal.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?

$path=".";

$directorio=dir($path);

echo "Directorio ".$path.":<br><br>";
echo "Ruta: " . $directorio->path ."<br><br>";
while ($archivo = $directorio->read())
{
     echo "<a href=$archivo target='_blank'>$archivo$path</a><br>";

}

$directorio->close();

?>


</BODY>
</HTML>