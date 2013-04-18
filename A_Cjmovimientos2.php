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

$fecha    = $_POST["cla_fecha"];
$tipomov  = $_POST["cla_tipomov"];
$motivos  = $_POST["cla_motivos"];
$importe  = $_POST["cla_importe"];
$nroopera = $_POST["cla_nroopera"];
$observac = $_POST["cla_observaciones"];

$motivos1 = $_POST["cla_motivos1"];
$importe1 = $_POST["cla_importe1"];
$nroopera1= $_POST["cla_nroopera1"];
$observac1= $_POST["cla_observaciones1"];

$motivos2 = $_POST["cla_motivos2"];
$importe2 = $_POST["cla_importe2"];
$nroopera2= $_POST["cla_nroopera2"];
$observac2= $_POST["cla_observaciones2"];

$motivos3 = $_POST["cla_motivos3"];
$importe3 = $_POST["cla_importe3"];
$nroopera3= $_POST["cla_nroopera3"];
$observac3= $_POST["cla_observaciones3"];

$motivos4 = $_POST["cla_motivos4"];
$importe4 = $_POST["cla_importe4"];
$nroopera4= $_POST["cla_nroopera4"];
$observac4= $_POST["cla_observaciones4"];


if ($motivos < '1')
    mensaje_error("A_Ctrlcaja.php?pasaid=".$fecha."&vengo=B", "No seleccionó motivo");
   else
  if ($importe < '0.01')
    mensaje_error("A_Ctrlcaja.php?pasaid=".$fecha."&vengo=B", "No cargó el importe");
   else
 {
    $sSQL="insert into cjmovimientos (cjmovfecha, cjmovmotivo, cjmovtipo, cjmovimporte, cjmovnro, cjmovobs)
      values ('".$fecha."','".$motivos."','".$tipomov."','".$importe."','".$nroopera."','".$observac."')";
    mysql_query($sSQL);
    insertolog($legajo, "A_Cjmovimientos2.php", "cjmovimientos", "insert", "1999-12-01", $sSQL);

    if ($motivos < 200)
     $importe = $importe * -1;

    if ($tipomov == 'B')
      $sSQL="update cjsdosfinales set sdobanco = sdobanco + '".$importe."' where fechasaldo >= '".$fecha."'";

    if ($tipomov == 'E')
      $sSQL="update cjsdosfinales set sdoefectivo = sdoefectivo + '".$importe."' where fechasaldo >= '".$fecha."'";

    if ($tipomov == 'C')
      $sSQL="update cjsdosfinales set sdocheques = sdocheques + '".$importe."' where fechasaldo >= '".$fecha."'";

    mysql_query($sSQL);
  }

if ($motivos1 > '0' && $importe1 > '0.01')
 {
    $sSQL="insert into cjmovimientos (cjmovfecha, cjmovmotivo, cjmovtipo, cjmovimporte, cjmovnro, cjmovobs)
      values ('".$fecha."','".$motivos1."','".$tipomov."','".$importe1."','".$nroopera1."','".$observac1."')";
    mysql_query($sSQL);
    insertolog($legajo, "A_Cjmovimientos2.php", "cjmovimientos", "insert", "1999-12-01", $sSQL);

    if ($motivos1 < 200)
     $importe1 = $importe1 * -1;

    if ($tipomov == 'B')
      $sSQL="update cjsdosfinales set sdobanco = sdobanco + '".$importe1."' where fechasaldo >= '".$fecha."'";

    if ($tipomov == 'E')
      $sSQL="update cjsdosfinales set sdoefectivo = sdoefectivo + '".$importe1."' where fechasaldo >= '".$fecha."'";

    if ($tipomov == 'C')
      $sSQL="update cjsdosfinales set sdocheques = sdocheques + '".$importe1."' where fechasaldo >= '".$fecha."'";

    mysql_query($sSQL);
  }

if ($motivos2 > '0' && $importe2 > '0.01')
 {
    $sSQL="insert into cjmovimientos (cjmovfecha, cjmovmotivo, cjmovtipo, cjmovimporte, cjmovnro, cjmovobs)
      values ('".$fecha."','".$motivos2."','".$tipomov."','".$importe2."','".$nroopera2."','".$observac2."')";
    mysql_query($sSQL);
    insertolog($legajo, "A_Cjmovimientos2.php", "cjmovimientos", "insert", "1999-12-01", $sSQL);

    if ($motivos2 < 200)
     $importe2 = $importe2 * -1;

    if ($tipomov == 'B')
      $sSQL="update cjsdosfinales set sdobanco = sdobanco + '".$importe2."' where fechasaldo >= '".$fecha."'";

    if ($tipomov == 'E')
      $sSQL="update cjsdosfinales set sdoefectivo = sdoefectivo + '".$importe2."' where fechasaldo >= '".$fecha."'";

    if ($tipomov == 'C')
      $sSQL="update cjsdosfinales set sdocheques = sdocheques + '".$importe2."' where fechasaldo >= '".$fecha."'";

    mysql_query($sSQL);
  }

if ($motivos3 > '0' && $importe3 > '0.01')
 {
    $sSQL="insert into cjmovimientos (cjmovfecha, cjmovmotivo, cjmovtipo, cjmovimporte, cjmovnro, cjmovobs)
      values ('".$fecha."','".$motivos3."','".$tipomov."','".$importe3."','".$nroopera3."','".$observac3."')";
    mysql_query($sSQL);
    insertolog($legajo, "A_Cjmovimientos2.php", "cjmovimientos", "insert", "1999-12-01", $sSQL);

    if ($motivos3 < 200)
     $importe3 = $importe3 * -1;

    if ($tipomov == 'B')
      $sSQL="update cjsdosfinales set sdobanco = sdobanco + '".$importe3."' where fechasaldo >= '".$fecha."'";

    if ($tipomov == 'E')
      $sSQL="update cjsdosfinales set sdoefectivo = sdoefectivo + '".$importe3."' where fechasaldo >= '".$fecha."'";

    if ($tipomov == 'C')
      $sSQL="update cjsdosfinales set sdocheques = sdocheques + '".$importe3."' where fechasaldo >= '".$fecha."'";

    mysql_query($sSQL);
  }

if ($motivos4 > '0' && $importe4 > '0.01')
 {
    $sSQL="insert into cjmovimientos (cjmovfecha, cjmovmotivo, cjmovtipo, cjmovimporte, cjmovnro, cjmovobs)
      values ('".$fecha."','".$motivos4."','".$tipomov."','".$importe4."','".$nroopera4."','".$observac4."')";
    mysql_query($sSQL);
    insertolog($legajo, "A_Cjmovimientos2.php", "cjmovimientos", "insert", "1999-12-01", $sSQL);

    if ($motivos4 < 200)
     $importe4 = $importe4 * -1;

    if ($tipomov == 'B')
      $sSQL="update cjsdosfinales set sdobanco = sdobanco + '".$importe4."' where fechasaldo >= '".$fecha."'";

    if ($tipomov == 'E')
      $sSQL="update cjsdosfinales set sdoefectivo = sdoefectivo + '".$importe4."' where fechasaldo >= '".$fecha."'";

    if ($tipomov == 'C')
      $sSQL="update cjsdosfinales set sdocheques = sdocheques + '".$importe4."' where fechasaldo >= '".$fecha."'";

    mysql_query($sSQL);
  }

    echo mensaje_ok("A_Ctrlcaja.php?pasaid=".$fecha."&vengo=B",'OK');

?>
