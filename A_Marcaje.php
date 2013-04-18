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


$leg = $_POST["cla_legajo"];
$tipomarca = $_POST["cla_tipomarca"];
$idmarcaje = $_POST["cla_idmarcaje"];

$hoy = date("Y-m-d");
$hora = date("H:i:s");

//Ejecucion de la sentencia SQL

if ($tipomarca == 'I')
 {
  $sSQL="insert into marcaje (legajo,fecha,hora,tipomarcaje) values
         ('".$leg."','".$hoy."','".$hora."','".$tipomarca."')";
   mysql_query($sSQL);

   insertolog($legajo, "A_Marcaje", "marcaje", "insert", "1999-12-01", $sSQL);
  }
 else
  {
  $sSQL="update marcaje set fechas='".$hoy."', horas='".$hora."', tipomarcaje='".$tipomarca."'
         where idmarcaje = '".$idmarcaje."'";
   mysql_query($sSQL);

   insertolog($legajo, "A_Marcaje", "marcaje", "update", "1999-12-01", $sSQL);
  }

   mensaje_error ('Marcaje.php', 'Marcaje correcto');

?>


