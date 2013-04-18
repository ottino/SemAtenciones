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

$hoy = date("Y-m-d");
$hora = date("H:i:s");

$errores = '0';

if ($_POST['tipo'] < '1')
   {
      $errores = '1';
      $mensaje = "No ingresó tipo de guardia - ";
    }

if ($_POST['base'] == '0')
   {
      $errores = '1';
      $mensaje = $mensaje."No ingresó la base - ";
    }

if ($_POST['legajoc'] < '1')
   {
      $errores = '1';
      $mensaje = $mensaje."No ingresó chofer";
    }

if ($_POST['tipo'] == '2' && $_POST['movil'] > '12')
    $errores = '2';

if ($_POST['tipo'] != '2' && $_POST['movil'] < '13')
    $errores = '3';

if ($errores > '0')
  mensaje_error('ABM_Movdisp.php', $mensaje);
 else
 {
  $sSQL="insert into movildisponible (idbase, tipoguardia, fecalta, horaalta, kmalta, idmovil, legmedico, legchofer, legenfermero, legotro, disponible,vigente)
      values ('".$_POST['base']."','".$_POST['tipo']."','".$hoy."','".$hora."','".$_POST['cla_kmalta']."','".$_POST['movil']."',
              '".$_POST['legajo']."','".$_POST['legajoc']."','".$_POST['legajoe']."','".$_POST['legajoo']."','0','0')";
  //echo $sSQL;
   mysql_query($sSQL);
   insertolog($legajo, "A_Movdisp2.php", "movildisponible", "insert", "1999-12-01", $sSQL);
   echo mensaje_ok('ABM_Movdisp.php','OK');
  }

?>
