<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');
require_once("cookie.php");
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@



//Ejecucion de la sentencia SQL

$pasaid = $_POST['pasaid'];

$color = $_POST['cla_color'];
$colorm = $_POST['cla_colorm'];
$diagnostico = $_POST['cla_diagnostico'];
$impcoseguro = $_POST['cla_impcoseguro'];
$observa = $_POST['cla_observa'];
$guardia = $_POST['cla_movil'];
$clave = $_POST['cla_clave'];


$sSQL= "select * from legajos where legajo = ".$G_legajo;
$result=mysql_query($sSQL);

$resultado = mysql_fetch_array($result);

$contrasena = md5($clave);

  if ($resultado[clave] <> $contrasena)
    echo mensaje_error('M_Atenciones.php?pasaid='.$pasaid,'Clave errónea');
   else
   {
     mysql_free_result($result);
     if ($impcoseguro > '0')
       $coseguro = 'si';
      else
       $coseguro = 'no';

     $result=mysql_query("select * from movildisponible WHERE idmovildisp = ".$guardia);
     $row=mysql_fetch_array($result);

     $legmedico = $row['legmedico'];
     $legchofer = $row['legchofer'];
     $legenfermero = $row['legenfermero'];
     $movil   = $row['idmovil'];

     mysql_free_result($result);


     $sSQL="update atenciones set color    ='".$color."',
                          colormedico ='".$colorm."',
                          diagnostico ='".$diagnostico."',
                          impcoseguro ='".$impcoseguro."',
                          coseguro    ='".$coseguro."',
                          movil_2     ='".$guardia."',
                          movil       ='".$movil."',
                          medico      ='".$legmedico."',
                          chofer      ='".$legchofer."',
                          enfermero   ='".$legenfermero."',
                          observa2    = concat(observa2,'".$observa."')
              where id = $pasaid";
     mysql_query($sSQL);
     //echo $sSQL;

     insertolog($legajo, "M_Atenciones2", "atenciones", "update", "1999-12-01", $sSQL);

     echo mensaje_ok('C1_Atenciones.php?pasaid='.$pasaid.'&vengo=M','OK');
    };
?>


