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

$comprobante = $_POST["cla_nrocupon"];
$nrolote  = $_POST["cla_nrolote"];
$fecrendi = $_POST["cla_fecrendi"];
$fecgraba = $_POST["cla_fecgraba"];
$idcob    = $_POST["cla_idcob"];
$estado    = $_POST["cla_anula"];
$vengo    = $_POST["cla_vengo"];

$hoy   = date("Y-m-d");
$legajo = $G_legajo;


$sSQL="select * from cobrador where idcob = ".$idcob;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$comiscupon = $row[comiscupon];
$comifact   = $row[comisfact];

$sSQL="select * from comprobantes where idcomprob = ".$comprobante;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);


//echo $row[nroafiliado];

if ($vengo == 'CUPON')
{
 if ($row[usuario] < 1)
 {
  $idcontrato = $row[idcontrato];
  $importe = $row[monto];
  $upp     = $row[periodo];
  $comision = $importe * $comiscupon / 100;
  $neto = $importe - $comision;
  $ySQL="update comprobantes set
         compestado= '".$estado."',
         fecpago   = '".$hoy."',
         usuario   = '".$legajo."'
       where idcomprob = ".$comprobante;
   mysql_query($ySQL);

   insertolog($legajo, "A_Cobranzas2.php", "comprobantes", "update", "1999-12-01", $ySQL);

  $jSQL="update contratos set
         deuda  = deuda - '".$importe."',
         upp    = '".$upp."'
       where idcontrato = ".$idcontrato;
  mysql_query($jSQL);

  insertolog($legajo, "A_Cobranzas2.php", "comprobantes", "update", "1999-12-01", $jSQL);

  if ($estado == 'A')
     {
      $importe = 0;
      $comision = 0;
      $neto     = 0;
     }

  $jSQL="update lotes set
         limporte = limporte + '".$importe."',
         lcomision = lcomision + '".$comision."',
         lmontoneto = lmontoneto + '".$neto."',
         cncupones  = cncupones + 1
       where lnrolote = ".$nrolote;
  mysql_query($jSQL);

  insertolog($legajo, "A_Cobranzas2.php", "lotes", "update", "1999-12-01", $jSQL);

  $pSQL= "insert into cobranzas (cnrolote, cidcomprob, fecgrab, fecrecep, cimporte, ccomision, cmontoneto, cidcobrador, estado)
      VALUES ('".$nrolote."' ,'".$comprobante."', '".$fecgraba."', '".$fecrendi."' , '".$importe."' , '".$comision."' , '".$neto."' ,
              '".$idcob."' , '".$estado."')";
  mysql_query($pSQL);

  insertolog($legajo, "A_Cobranzas2", "cobranzas", "insert", "1999-12-01", $pSQL);

  echo mensaje_ok('A_Cobranzas1.php?cla_nrolote='.$nrolote,'OK');
 }
 else
  mensaje_error ('A_Cobranzas1.php?cla_nrolote='.$nrolote, 'Cuota ya pagada - Verifique!!!');
}
 else
{
  $estado = "C";
  $jSQL="update lotes set
         lestado = '".$estado."'
       where lnrolote = ".$nrolote;
  mysql_query($jSQL);
  echo mensaje_ok('A_Cobranzas1.php?cla_nrolote='.$nrolote,'OK');
}

?>
