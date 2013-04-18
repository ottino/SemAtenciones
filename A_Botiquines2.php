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


$articulos = $_POST["artic"];
echo $_POST["artic"];
$articu = explode("-",$articulos);

$articulos = $articu[0];
$rubro    =  $articu[1];


//Ejecucion de la sentencia SQL

 $sSQL="insert into botiquines (idmovil, idarticulo, rubro, cnminima)
      values ('".$_POST['movil']."','".$articulos."','".$rubro."','".$_POST['cla_cnminima']."')";
//echo $sSQL;
 mysql_query($sSQL);

 insertolog($legajo, "A_Botiquines2", "botiquines", "insert", "1999-12-01", $sSQL);

 echo mensaje_ok('ABM_Botiquines.php','OK');


?>
