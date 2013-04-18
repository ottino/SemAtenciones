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

$ch_legajos = 0;
$ch_dni = 0;
$ch_matricula = 0;

$v_legajos = is_numeric($_POST['cla_legajo']);
if ($v_legajos <> true)
   $ch_legajos = 1;

$v_dni = is_numeric($_POST['cla_dni']);
if ($v_dni <> true)
   $ch_dni = 1;
if ($_POST['cla_dni'] > 59999999 or $_POST['cla_dni'] < 2999999)
   $ch_dni = 1;

$v_matricula = is_numeric($_POST['cla_matricula']);
if ($v_matricula <> true)
   $ch_matricula = 1;

$hoy = date("Y-m-d");
$hora = date("H:i:s");
$tipomarca = "E";

$contrasena = md5($_POST['cla_legajo']);
//echo $contrasena;


if ($ch_legajos == 1)
  mensaje_error('A_Legajos.php','El Legajo no es numérico');
else
   if ($ch_dni == 1)
  mensaje_error('A_Legajos.php','El DNI no es numérico');
 else
   if ($ch_matricula == 1)
  mensaje_error('A_Legajos.php','La matrícula no es numérico');
 else
 {
   $sSQL="insert into legajos (legajo, apeynomb, sexo, dni, cuit, fecnac, filiacion, funcion, matricula, perfil,clave,fecalta1,estado)
      values ('".$_POST['cla_legajo']."','".strtoupper ($_POST['cla_apeynomb'])."',
              '".strtoupper ($_POST['cla_sexo'])."','".$_POST['cla_dni']."','".$_POST['cla_cuit']."',
              '".$_POST['cla_fecnac']."','".$_POST['cla_filiacion']."','".$_POST['cla_funcion']."','".$_POST['cla_matricula']."',
              '".$_POST['cla_perfil']."','".$contrasena."','".$_POST['cla_fecalta']."','')";
   //echo $sSQL;
   mysql_query($sSQL);

//  $sSQL="insert into marcaje (legajo,fecha,hora,fechas,horas,tipomarcaje) values
//         ('".$_POST['cla_legajo']."','".$hoy."','".$hora."','".$hoy."','".$hora."','".$tipomarca."')";
//   mysql_query($sSQL);

   insertolog($legajo, "A_Legajos2", "legajos", "insert", "1999-12-01", $sSQL);

  echo mensaje_ok('ABM_Legajos.php','OK');
  }

?>
