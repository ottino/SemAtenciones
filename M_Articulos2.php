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



//Ejecucion de la sentencia SQL

$articulos = $_POST['art'];
$rubros    = $_POST['rub'];

$sSQL= "update articulos set articulo = '".strtoupper($_POST['cla_desarticulo'])."',
                              rubro  = '".strtoupper($_POST['rubros'])."',
                              existencia = '".$_POST['cla_existencia']."',
                              cncritica  = '".$_POST['cla_cncritica']."'
              where idarticulo = '$articulos' and rubro = '$rubros'";
//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "M_Articulos2", "articulos", "update", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Articulos.php','OK');


?>


