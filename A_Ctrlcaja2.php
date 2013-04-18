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
require_once("cookie.php");
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

//Ejecucion de la sentencia SQL


$hoy = date("Y-m-d");
$importe = '0';

   $resultin=mysql_query("select idsdosfinales from cjsdosfinales where fechasaldo = '".$hoy."'");
   $rowin=mysql_fetch_array($resultin);
   $idsaldos = $rowin["idsdosfinales"] +0;
   mysql_free_result($resultin);

if ($idsaldos < '1')
    {

     $resultmax=mysql_query("select max(idsdosfinales) as idmax from cjsdosfinales");
     $rowmax=mysql_fetch_array($resultmax);
     $pasaidmax = $rowmax["idmax"] +0;
     mysql_free_result($resultmax);

      $resulta=mysql_query("select * from cjsdosfinales WHERE idsdosfinales = ".$pasaidmax." order by 1");
      $rowa=mysql_fetch_array($resulta);
      $asbanco    = $rowa['sdobanco'];
      $asefectivo = $rowa['sdoefectivo'];
      $ascheque   = $rowa['sdocheques'];
      mysql_free_result($resulta);

      $sSQL="insert into cjsdosfinales (fechasaldo, sdobanco, sdocheques, sdoefectivo)
           values ('".$hoy."','".$asbanco."','".$ascheque."','".$asefectivo."')";
      mysql_query($sSQL);
      insertolog($legajo, "A_Cjsdosfinales2.php", "cjsdosfinales", "insert", "1999-12-01", $sSQL);
    }

  echo mensaje_ok("A_Ctrlcaja.php?pasaid=".$hoy."&vengo=B",'OK');

?>
