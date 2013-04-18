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

$cla_periodo = $_POST["cla_periodo"];
$fechavto    = $_POST["cla_fechavto"];
$legajo      = $G_legajo;


$archivov = 'Archivos/visamov.txt';
$fpv = fopen($archivov, "w");

$archivom = 'Archivos/DA168D.txt';
$fpm = fopen($archivom, "w");

$archivon = 'Archivos/neva.txt';
$fpn = fopen($archivon, "w");


$hoyn   = date("ymd");

$stringn = "610001194                   ".$hoyn."                                   \r\n";
$write = fputs($fpn, $stringn);


$sSQL="select * from ctrlcupones where ultid in (select max(ultid) from ctrlcupones)";
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$comprobante = $row[ultid];

$sSQL="select * from contratos a, comprobantes b where a.idcontrato = b.idcontrato and b.tipocomprob = 'T' and
       b.periodo = '".$cla_periodo."' order by b.cobrador, b.idcomprob";
$result=mysql_query($sSQL);
while ($row=mysql_fetch_array($result))
{
  $det = '1';

  if ($det == '0')
  {}
  else
  {
   $plan = $row[idplan];
   $idcontrato = $row[idcontrato];
   $nroafiliado = $row[nroafiliado];
   $ordenmax = $row[ordenmax];
   $tipocomprob = $row[tipocomprob];
   $cobrador = $row[codcobrador];
   $importe  = $row[importe];
   $nrotarjeta  = $row[nrotarjeta];

   $ySQL = "select * from planes where idplan = ".$plan;
   $yresult = mysql_query($ySQL);
   $yrow=mysql_fetch_array($yresult);
   $comprobante = $row[idcomprob];
   $comprobante = str_pad($comprobante, 10, "0", STR_PAD_LEFT);
 if ($importe < '1')
    if ($ordenmax < 1)
       $importe = $yrow[imp1];
      else
    if ($ordenmax == 1)
       $importe = $yrow[imp2];
      else
     if ($ordenmax == 2)
       $importe = $yrow[imp3];
        else
     if ($ordenmax == 3)
       $importe = $yrow[imp4];
        else
     if ($ordenmax == 4)
       $importe = $yrow[imp5];
        else
     if ($ordenmax == 5)
       $importe = $yrow[imp6];
        else
     if ($ordenmax == 6)
       $importe = $yrow[imp7];
        else
     if ($ordenmax == 7)
       $importe = $yrow[imp8];
        else
     if ($ordenmax == 8)
       $importe = $yrow[imp9];
        else
     if ($ordenmax == 9)
       $importe = $yrow[imp10];
        else
     if ($ordenmax == 10)
       $importe = $yrow[imp11];
        else
     if ($ordenmax == 11)
       $importe = $yrow[imp12];
        else
     if ($ordenmax == 12)
       $importe = $yrow[imp13];
        else
     if ($ordenmax == 13)
       $importe = $yrow[imp14];
        else
     if ($ordenmax == 14)
       $importe = $yrow[imp15];
        else
     if ($ordenmax == 15)
       $importe = $yrow[imp16];
        else
     if ($ordenmax == 16)
       $importe = $yrow[imp17];
        else
     if ($ordenmax == 17)
       $importe = $yrow[imp18];
        else
     if ($ordenmax == 18)
       $importe = $yrow[imp19];
        else
     if ($ordenmax == 19)
       $importe = $yrow[imp20];
        else
     if ($ordenmax > 19)
       $importe = $yrow[imp20];


   $importe2 = $importe * 100;
   $importe1 = $importe;
   $importe2 = str_pad($importe2, 10, "0", STR_PAD_LEFT);
   $codbarra = $comprobante;

   if ($cobrador == 50)    //MASTERCARD
     {

      $compm = $comprobante + 0;
      $compm = str_pad($compm, 6, "0", STR_PAD_LEFT);
      $nroafilm = str_pad($nroafiliado, 6, "0", STR_PAD_LEFT);
      $imporm = $importe * 100;
      $imporm = str_pad($imporm, 11, "0", STR_PAD_LEFT);

      $aniom = substr($cla_periodo,2,2);
      $mesm  = substr($cla_periodo,4,2);
      $hoym   = date("dmy");
      $hoym1 = str_pad($hoym, 6, "0", STR_PAD_LEFT);

      $nrotarjeta = str_pad($nrotarjeta, 16, "0", STR_PAD_LEFT);

      $stringm = $stringm."089358992".$nrotarjeta.$compm.$nroafilm."00199901".$imporm.$mesm."/".$aniom."0".$hoym1."000000000000000000000000000000000000000000000000000000000000\r\n";

      $contm = $contm + 1;
      $summ  = $summ + $importe;
     }


   if ($cobrador == 51)    //VISA
     {
      $imporv = $importe * 100;
      $imporv = str_pad($imporv, 15, "0", STR_PAD_LEFT);

      $nrotarjeta = str_pad($nrotarjeta, 16, "0", STR_PAD_LEFT);

      $contv = $contv + 1;
      $contv1 = str_pad($contv, 8, "0", STR_PAD_LEFT);
      $hoyv   = date("dmy");
      $hoyv1 = str_pad($hoyv, 6, "0", STR_PAD_LEFT);
      $compv = $comprobante + 0;
      $compv = str_pad($compv, 8, "0", STR_PAD_LEFT);
      $nroafilv = str_pad($nroafiliado, 7, "0", STR_PAD_LEFT);

      $stringv = $stringv."   ".$nrotarjeta." ".$contv1.$hoyv1."        ".$imporv."       ".$compv.$nroafilv." \r\n";

      $sumv  = $sumv + $importe;
     }


   if ($cobrador == 53)    //NEVADA
     {
      $imporn = $importe * 100;
      $imporn = str_pad($imporn, 12, "0", STR_PAD_LEFT);

      $nrotarjeta = str_pad($nrotarjeta, 16, "0", STR_PAD_LEFT);

      $compn = $comprobante + 0;
      $compn = str_pad($compn, 8, "0", STR_PAD_LEFT);
      $nroafiln = str_pad($nroafiliado, 7, "0", STR_PAD_LEFT);

      $hoyv   = date("dmy");
      $hoyv1 = str_pad($hoyv, 6, "0", STR_PAD_LEFT);

      list($anio,$mes,$dia) = explode("-",$row[fecalta]);

      $anio = substr($anio,2,2);


      $stringn = $nrotarjeta.$imporn.$anio.$mes.$dia."PERIODO-".$cla_periodo."      ".$nroafiln.$compn."\r\n";
      $write = fputs($fpn, $stringn);

      $contn = $contn + 1;
      $sumn  = $sumn + $importe;
     }


  }
}

   $hoy   = date("Y-m-d");
   $legajo = $G_legajo;

// TARJETA NEVADA
$sumn = $sumn * 100;
$sumn = str_pad($sumn, 12, "0", STR_PAD_LEFT);
$contn = str_pad($contn, 6, "0", STR_PAD_LEFT);
$stringn = $contn."          ".$sumn.$hoyn."                                   \r\n";
$write = fputs($fpn, $stringn);
fclose($fpn);

//TARJETA VISA

$contv1 = str_pad($contv, 2, "0", STR_PAD_LEFT);
$sumv = $sumv * 100;
$sumv1 = str_pad($sumv, 15, "0", STR_PAD_LEFT);
$headerv = "0DB".$hoyv1."2652020001       00050011611159".$contv1.$sumv1." 9119                  \r\n";
$stringv = $headerv.$stringv;
$write = fputs($fpv, $stringv);
fclose($fpv);


//TARJETA MASTERCARD

$contm1 = str_pad($contm, 7, "0", STR_PAD_LEFT);
$summ = $summ * 100;
$summ1 = str_pad($summ, 14, "0", STR_PAD_LEFT);
$headerm = "089358991".$hoym1.$contm1."0".$summ1."0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000\r\n";
$stringm = $headerm.$stringm;
$write = fputs($fpm, $stringm);
fclose($fpm);

echo mensaje_ok('A_Archtarjetas.php','OK');


?>
