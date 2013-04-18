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
//ob_start("ob_gzhandler");
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=atenciones.xls");
header("Pragma: no-cache");
header("Expires: 0");


$vengo = $_POST["vengo"];

$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["cla_nombre"];
$idguardia = $_POST["cla_idguardia"];
$imagen_volver = "imagenes/Volver.ico";

   $mes  = $_POST["meses"];
   $anio = $_POST["anios"];
   $nom = $_POST["legajo"];
   if ($nom > '0')
     $nombre = $nom;
   if ($mes > '0')
      if ($anio > '0')
      { $fechad = $anio.'/0'.$mes.'/01';
        $fechah = $anio.'/0'.$mes.'/31';
      }

if (substr($fechad,2,1) == "/")
    $fechad = cambiarFormatoFecha2($fechad);

if (substr($fechah,2,1) == "/")
    $fechah = cambiarFormatoFecha2($fechah);

if ($fechah == '')
    $fechah = '2999/12/31';
if ($fechad == '')
    $fechad = '2000/01/01';


$fechad1=  cambiarFormatoFecha1($fechad);
$fechah1=  cambiarFormatoFecha1($fechah);

if ($nombre == '')
    $sqlnombre = '';
   else
    $sqlnombre = " and b.apeynomb like '%".$nombre."%' ";

if ($idguardia > '0')
    $sqlnombre = $sqlnombre." and a.idguardia = '".$idguardia."' ";

$sqlorder = "order by P4, P2";

$result=mysql_query("select revisado, c.fecalta as P2, a.idguardia as P1, c.horaalta as P3, b.apeynomb as P4, a.tipoguardia as P5, sum(importe) as P6, c.retiene as P7,
                    count(*) as P8 from guardiasliq a, legajos b, movildisponible c where a.idguardia = c.idmovildisp and
                    a.legmed = b.legajo and c.fecalta >= '".$fechad."' and c.fecalta <= '".$fechah."'  ".$sqlnombre." group by c.fecalta, a.idguardia ".$sqlorder." ");


$exporta = '<table border=1>
            <tr> <td width="100%" rowspan="1" valign="top">
              <table border = 1>
               <TR colspan = "5" align="center">LIQUIDACION MENSUAL DE: '.$fechad1.' A '.$fechah1.'</tr>
                  <tr style="background-color:'.$body_color.'">
                  <th></th>
                  <th>ID</th>
                  <th>FECHA</th>
                  <th>HORA</th>
                  <th>MEDICO</th>
                  <th>TIPO</th>
                  <th>ATENCIONES</th>
                  <th>IMPORTE</th>
                  <th>RETIENE</th>
                  <th>A COBRAR</th></td></tr>';

echo $exporta;
$exporta = '';


//Mostramos los registros

$c = '0';

while ($row=mysql_fetch_array($result))
{

list($anio, $mes, $dia) = explode("-", $row['P2']);
$mesactual = $anio.$mes;

  if (($row["P4"] != $viejo) || ($mesactual != $mesviejo))
    if ($c > 0)
     if ($vengo == "LIQMES")
      {
       $resultu=mysql_query("SELECT * FROM legajos where apeynomb like '%".$viejo."%' order by 1");
       $rowu=mysql_fetch_array($resultu);
       mysql_free_result($resultu);

       $legajomed = $rowu["legajo"];

       list($aniox, $mesx, $diax) = explode("-", $fechavieja);
       $fechadx = $aniox.'/'.$mesx.'/01';
       $fechahx = $aniox.'/'.$mesx.'/31';

       $resulti=mysql_query("SELECT * FROM descuentosliq where legajo = '".$legajomed."' and fechadesc >= '".$fechadx."' and fechadesc <= '".$fechahx."'order by 4");
       while ($rowi=mysql_fetch_array($resulti))
       {
          $fec = cambiarFormatoFecha($rowi['fechadesc']);
          $exporta = $exporta.'<tr><td >&nbsp;</td>';
          $exporta = $exporta.'<td align="center">&nbsp;</td>';
          $exporta = $exporta.'<td align="center">'.$fec.'</td>';
          $exporta = $exporta.'<td >&nbsp;</td>';
          $exporta = $exporta.'<td align="left">'.$rowi["motivo"].'</td>';
          $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">DESC&nbsp;</td>';
          $exporta = $exporta.'<td align="center">AUT: '.$rowi["autoriza"].'</td>';
          $exporta = $exporta.'<td align="right">'.number_format($rowi["importe"]*-1, 2, ',', '0').'</td>';
          $exporta = $exporta.'<td align="right">'.number_format(0, 2, ',', '0').'</td>';
          $exporta = $exporta.'<td align="right">'.number_format($rowi["importe"]*-1, 2, ',', '0').'</td>';
          $total = $rowi["importe"];
          $TP6 = $TP6 - $rowi["importe"];
          $Ttotal = $Ttotal - $total;
          echo $exporta;
          $exporta = '';
       }
       $exporta = $exporta.'<tr><td >&nbsp;</td><td style="background-color:'.$body_color.'"></td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">GUARDIAS</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">'.$c1.'</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">'.$viejo.'</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">&nbsp;</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">TOTAL</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">'.number_format($TP6, 2, ',', '').'</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">'.number_format($TP7, 2, ',', '').'</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">'.number_format($Ttotal, 2, ',', '').'</td>';
        $STP6 = $STP6 + $TP6;
        $STP7 = $STP7 + $TP7;
        $STtotal = $STtotal + $Ttotal;
       $TP6 = 0;
       $TP7 = 0;
       $Ttotal = 0;
       $c1 = 0;
       echo $exporta;
       $exporta = '';

      }

  $c = $c+1;
  $c1 = $c1+1;
  $total = $row["P6"]-$row["P7"];
  $TP6 = $TP6 + $row["P6"];
  $TP7 = $TP7 + $row["P7"];
  $Ttotal = $Ttotal + $total;
  $viejo = $row["P4"];
  $fechavieja = $row["P2"];
  $mesviejo = $mesactual;

  $fecalta = cambiarFormatoFecha($row['P2']);
  $horaalta = cambiarFormatoHora($row['P3']);
  $exporta = $exporta.'<tr><td >&nbsp;</td><td>'.$row["P1"].'</td>';
  $exporta = $exporta.'<td align="center">'.$fecalta.'</td>';
  $exporta = $exporta.'<td align="center">'.$horaalta.'</td>';
  $exporta = $exporta.'<td align="left">'.$row["P4"].'</td>';
  $exporta = $exporta.'<td align="center">'.$row["P5"].'</td>';
  $exporta = $exporta.'<td align="center">'.$row["P8"].'</td>';
  $exporta = $exporta.'<td align="right">'.number_format($row["P6"], 2, ',', '').'</td>';
  $exporta = $exporta.'<td align="right">'.number_format($row["P7"], 2, ',', '').'</td>';
  $exporta = $exporta.'<td align="right">'.number_format($total, 2, ',', '').'</td>';

  $datos = $row["P1"];
  echo $exporta;
  $exporta = '';

}

     if ($vengo == "LIQMES")
      {
       $resultu=mysql_query("SELECT * FROM legajos where apeynomb like '%".$viejo."%' order by 1");
       echo $row["P4"];
       $rowu=mysql_fetch_array($resultu);
       mysql_free_result($resultu);

       $legajomed = $rowu["legajo"];

       list($aniox, $mesx, $diax) = explode("-", $fechavieja);
       $fechadx = $aniox.'/'.$mesx.'/01';
       $fechahx = $aniox.'/'.$mesx.'/31';

       $resulti=mysql_query("SELECT * FROM descuentosliq where legajo = '".$legajomed."' and fechadesc >= '".$fechadx."' and fechadesc <= '".$fechahx."'order by 4");

       while ($rowi=mysql_fetch_array($resulti))
       {
          $fec = cambiarFormatoFecha($rowi['fechadesc']);
          $exporta = $exporta.'<tr><td >&nbsp;</td><td >&nbsp;</td>';
          $exporta = $exporta.'<td align="center">'.$fec.'</td>';
          $exporta = $exporta.'<td align="center">&nbsp;</td>';
          $exporta = $exporta.'<td align="left">'.$rowi["motivo"].'</td>';
          $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">DESC&nbsp;</td>';
          $exporta = $exporta.'<td align="center">AUT: '.$rowi["autoriza"].'</td>';
          $exporta = $exporta.'<td align="right">'.number_format($rowi["importe"]*-1, 2, ',', '').'</td>';
          $exporta = $exporta.'<td align="right">'.number_format(0, 2, ',', '').'</td>';
          $exporta = $exporta.'<td align="right">'.number_format($rowi["importe"]*-1, 2, ',', '').'</td>';
          $exporta = $exporta.'<td align="center">&nbsp;</td>';
          $total = $rowi["importe"];
          $TP6 = $TP6 - $rowi["importe"];
          $Ttotal = $Ttotal - $total;
          echo $exporta;
          $exporta = '';

       }
       $exporta = $exporta.'<tr><td >&nbsp;</td><td style="background-color:'.$body_color.'">&nbsp;</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">GUARDIAS&nbsp;</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">'.$c1.'</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">'.$viejo.'</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">&nbsp;</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">TOTAL&nbsp;</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">'.number_format($TP6, 2, ',', '').'</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">'.number_format($TP7, 2, ',', '').'</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">'.number_format($Ttotal, 2, ',', '').'</td>';
        $STP6 = $STP6 + $TP6;
        $STP7 = $STP7 + $TP7;
        $STtotal = $STtotal + $Ttotal;

       $TP6 = 0;
       $TP7 = 0;
       $Ttotal = 0;
       $c1 = 0;
       echo $exporta;
       $exporta = '';

      }

       $exporta = $exporta.'<tr><td >&nbsp;</td><td style="background-color:'.$body_color.'">&nbsp;</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">TOTAL GENERAL&nbsp;</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">&nbsp;</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">&nbsp;</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">&nbsp;</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">TOTAL&nbsp;</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">'.number_format($STP6, 2, ',', '').'</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">'.number_format($STP7, 2, ',', '').'</td>';
       $exporta = $exporta.'<td style="background-color:'.$body_color.'" align="center">'.number_format($STtotal, 2, ',', '').'</td>';
       echo $exporta;
       $exporta = '';
mysql_free_result($result);



?>
