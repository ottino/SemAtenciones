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

$pasaid = $_POST["cla_pasaid"];
$cjmov = $_POST["cla_cjmov"];

$result=mysql_query("select * from cjsdosfinales WHERE idsdosfinales = ".$pasaid." order by 1");
$row=mysql_fetch_array($result);

//Creamos la sentencia SQL y la ejecutamos
$result=mysql_query("SELECT * FROM cjmovimientos, cjmotivos WHERE cjmovmotivo = cjmotcodigo and idcjmov = ".$cjmov." order by 1");
$row=mysql_fetch_array($result);

$fecha = date("Y-m-d");
$motivos = '208';
$tipomov = 'B';
$importe = $row["cjmovimporte"];
$nroopera = $row["cjmovnro"];
$observac = $row["cjmovobs"];

$sSQL="insert into cjmovimientos (cjmovfecha, cjmovmotivo, cjmovtipo, cjmovimporte, cjmovnro, cjmovobs)
      values ('".$fecha."','".$motivos."','".$tipomov."','".$importe."','".$nroopera."','".$observac."')";
mysql_query($sSQL);
insertolog($legajo, "A_Valcobro.php", "cjmovimientos", "insert", "1999-12-01", $sSQL);

$sSQL="update cjsdosfinales set sdobanco = sdobanco + '".$importe."' where fechasaldo >= '".$fecha."'";
mysql_query($sSQL);


$motivos = '108';
$tipomov = 'C';
$sSQL="insert into cjmovimientos (cjmovfecha, cjmovmotivo, cjmovtipo, cjmovimporte, cjmovnro, cjmovobs)
      values ('".$fecha."','".$motivos."','".$tipomov."','".$importe."','".$nroopera."','".$observac."')";
mysql_query($sSQL);
insertolog($legajo, "A_Valcobro.php", "cjmovimientos", "insert", "1999-12-01", $sSQL);

$sSQL="update cjsdosfinales set sdocheques = sdocheques - '".$importe."' where fechasaldo >= '".$fecha."'";
mysql_query($sSQL);

$sSQL="update cjmovimientos set cjmovmotivo = '208' where idcjmov = '".$cjmov."'";
mysql_query($sSQL);


    echo mensaje_ok("A_Ctrlcaja.php?pasaid=".$pasaid."&vengo=B",'OK');
?>
