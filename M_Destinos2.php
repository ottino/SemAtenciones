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

$destino = $_POST['dest'];

$tipo = $_POST['tipo'];

$v_tipo = is_numeric($tipo);
if ($v_tipo <> true)
   $ch_tipo = 0;

if ($ch_tipo == 1)
  mensaje_error('ABM_Destinos.php','El Tipo de Destino no es numérico');
else
 {
$sSQL="update destino set destino ='".strtoupper ($_POST['cla_destino'])."',
                          domicilio ='".strtoupper ($_POST['cla_domicilio'])."',
                          localidad ='".strtoupper ($_POST['cla_localidad'])."',
                          telefono  ='".strtoupper ($_POST['cla_telefono'])."',
                          tipo      ='".strtoupper ($_POST['cla_tipo'])."'
              where iddestino = $destino";
  mysql_query($sSQL);

insertolog($legajo, "M_Destinos2", "destino", "update", "1999-12-01", $sSQL);

 echo mensaje_ok('ABM_Destinos.php','OK');
  }

?>


