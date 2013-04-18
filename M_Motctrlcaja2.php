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

//echo $_POST['desc'];
$motivos = $_POST['desc'];
$codigo  = $_POST['clave'];
$descrip = $_POST['descripcion'];

$ch_idmotivo = 0;

$v_idmotivo = is_numeric($motivos);
if ($v_idmotivo <> true)
   $ch_idmotivo = 1;

if ($ch_idmotivo == 1)
  mensaje_error('ABM_Motctrlcaja.php','El CODIGO no es numérico');
 else
 {
    $sSQL="Update cjmotivos set cjmotcodigo = '".$codigo."', cjmotdesc ='".strtoupper ($_POST['descripcion'])."' where cjmotid = ".$motivos;
    mysql_query($sSQL);

    insertolog($legajo, "M_Motctrlcaja2", "cjmotivos", "update", "1999-12-01", $sSQL);

   echo mensaje_ok('ABM_Motctrlcaja.php','OK');
  }

?>


