<?

session_start();

######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//incluï¿½mos la clase ajax
require ('xajax/xajax.inc.php');
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

?>


<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<TITLE><?php echo TITULO_SISTEMA; ?></TITLE>
<link href="css/sem.css" type="text/css" rel="stylesheet">
</HEAD>



<BODY>


<?
echo titulo_encabezado ('Menú principal del Sistema' , $path_imagen_logo);


?>


</BODY>
</HTML>