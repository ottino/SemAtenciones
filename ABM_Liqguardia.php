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
?>


<HTML>
<HEAD>
<TITLE>ABM_Liqguardia.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>


<?
echo titulo_encabezado ('Liquidación de Honorarios' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
//Ejecutamos la sentencia SQL

$vengo = $_POST["vengo"];

if ($vengo == "")
   {
     $vengo1 = $_GET["vengo"];
   }

$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["cla_nombre"];
$idguardia = $_POST["cla_idguardia"];
$imagen_volver = "imagenes/Volver.ico";

if ($fechad == '')
    $fechad = $_POST["cla_fecha2"];

if ($vengo == "LIQMES")
   {
   $mes  = $_POST["meses"];
   $anio = $_POST["anios"];
   $nom = $_POST["legajo"];
   $sqlorder = "order by P4, P2";
   if ($nom > '0')
     $nombre = $nom;
   if ($mes > '0')
      if ($anio > '0')
      { $fechad = $anio.'/0'.$mes.'/01';
        $fechah = $anio.'/0'.$mes.'/31';
      }
   }

if ($vengo1 == "ACTUALIZA")
   {
     $vengo     = $_GET["vengo"];
     $fechad    = $_GET["cla_fecha"];
     $fechah    = $_GET["cla_fecha1"];
     $nombre    = $_GET["cla_nombre"];
     $idguardia = $_GET["cla_idguardia"];
   }

if ($vengo1 == "DESCUENTO")
   {
     $vengo     = "LIQMES";
     $fechad    = $_GET["cla_fecha"];
     $fechah    = $_GET["cla_fecha1"];
     $nombre    = $_GET["cla_nombre"];
     $idguardia = $_GET["cla_idguardia"];
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

$pepe = "select c.fecalta as P2, a.idguardia as P1, c.horaalta as P3, b.apeynomb as P4, a.tipoguardia as P5, sum(importe) as P6, c.retiene as P7,
                    count(*) as P8 from guardiasliq a, legajos b, movildisponible c where a.idguardia = c.idmovildisp and
                    a.legmed = b.legajo and c.fecalta >= '".$fechad."' and c.fecalta <= '".$fechah."'  ".$sqlnombre." group by c.fecalta, a.idguardia ".$sqlorder." ";
//echo $pepe;

echo '
<table width="100%" border="1">
 <tr style="background-color:'.$td_color.'">
        <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td>
        <td width="1000"></td>';
if ($vengo == "LIQMES")
     echo '<FORM METHOD="POST" NAME="formulario3" ACTION="ABM_LiqguardiaMes.php">';
   else
     echo '<FORM METHOD="POST" NAME="formulario3" ACTION="ABM_Liqguardia0.php">';

echo '
    <td width="17" align="right" >
                        <label onclick="this.form.submit();" style="CURSOR: pointer" >
                         <img align="middle" alt=\'Volver\' src="imagenes/Volver.ico" width="30" height="30"/>
                        </label></td></FORM>
  </tr>
</table>';


echo '
 <table width="100%" border="1">
 <tr style="background-color:'.$td_color.'">
    <td>
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">
            <th>ID</th>
            <th>FECHA</th>
            <th>HORA</th>
            <th>MEDICO</th>
            <th>TIPO</th>
            <th>ATENCIONES</th>
            <th>IMPORTE</th>
            <th>RETIENE</th>
            <th>A COBRAR</th>
            <th>Consultar</th>
        </td>';


//Mostramos los registros

$c = '0';

while ($row=mysql_fetch_array($result))
{

list($anio, $mes, $dia) = explode("-", $row['P2']);
$mesactual = $anio.$mes;
//echo $mesactual;

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
          echo '<tr style="background-color:'.$td_color.'"><td >'.$rowi["id"].'&nbsp;</td>';
          echo '<td align="center">'.$fec.'&nbsp;</td>';
          echo '<td align="center">&nbsp;</td>';
          echo '<td align="left">'.$rowi["motivo"].'&nbsp;</td>';
          echo '<td style="background-color:'.$body_color.'" align="center">DESC&nbsp;</td>';
          echo '<td align="center">AUT: '.$rowi["autoriza"].'&nbsp;</td>';
          echo '<td align="right">'.number_format($rowi["importe"]*-1,2).'&nbsp;</td>';
          echo '<td align="right">'.number_format(0,2).'&nbsp;</td>';
          echo '<td align="right">'.number_format($rowi["importe"]*-1,2).'&nbsp;</td>';
          echo '<td align="center">&nbsp;</td>';
          $total = $rowi["importe"];
          $TP6 = $TP6 - $rowi["importe"];
          $Ttotal = $Ttotal - $total;

       }
       echo '<tr style="background-color:'.$td_color.'"><td>&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">GUARDIAS&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">'.$c1.'&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">'.$viejo.'&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">TOTAL&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">'.number_format($TP6,2).'&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">'.number_format($TP7,2).'&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">'.number_format($Ttotal,2).'&nbsp;</td>';

       echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Descguardias.php">';
       echo '<input type="hidden" name= "cla_legajo" value="'.$legajomed.'" >';
       echo '<input type="hidden" name= "pasdatos" value="'.$datos.'" >';
       echo '<input type="hidden" name= "cla_fecha" value="'.$fechad.'" >';
       echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
       echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
       echo '<input type="hidden" name= "vengo" value="'.$vengo.'" >';
       echo '<input type="hidden" name= "cla_idguardia" value="'.$idguardia.'" >';
       echo '<input type="hidden" name= "cla_mes" value="'.$mes.'" >';
       echo '<input type="hidden" name= "cla_anios" value="'.$anio.'" >';
       echo '<input type="hidden" name= "cla_nom" value="'.$nom.'" >';

       echo '<td valign="center" style="background-color:'.$body_color.'" align="center"><INPUT TYPE="SUBMIT" value="Agreg Dto"></FORM></td>';

       $STP6 = $STP6 + $TP6;
       $STP7 = $STP7 + $TP7;
       $STtotal = $STtotal + $Ttotal;
       $TP6 = 0;
       $TP7 = 0;
       $Ttotal = 0;
       $c1 = 0;


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
  echo '<tr style="background-color:'.$td_color.'"><td>'.$row["P1"].'</td>';
  echo '<td align="center">'.$fecalta.'&nbsp;</td>';
  echo '<td align="center">'.$horaalta.'&nbsp;</td>';
  echo '<td align="left">'.$row["P4"].'&nbsp;</td>';
  echo '<td align="center">'.$row["P5"].'&nbsp;</td>';
  echo '<td align="center">'.$row["P8"].'&nbsp;</td>';
  echo '<td align="right">'.number_format($row["P6"],2).'&nbsp;</td>';
  echo '<td align="right">'.number_format($row["P7"],2).'&nbsp;</td>';
  echo '<td align="right">'.number_format($total,2).'&nbsp;</td>';

  $datos = $row["P1"];

  echo '<FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Liqguardia1.php">';
  echo '<input type="hidden" name= "pasdatos" value="'.$datos.'" >';
  echo '<input type="hidden" name= "cla_fecha" value="'.$fechad.'" >';
  echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
  echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
  echo '<input type="hidden" name= "vengo" value="'.$vengo.'" >';
  echo '<input type="hidden" name= "cla_idguardia" value="'.$idguardia.'" >';

  echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >';

  if ($row["revisado"] == "S")
      echo '<img align="middle" alt=\'Consultar Cerrado\' src="imagenes/Egreso.ico" width="30" height="30"/>';
    else
      echo '<img align="middle" alt=\'Consultar Abierto\' src="imagenes/Ingreso.ico" width="30" height="30"/>';


  echo '</label></td></FORM>';

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
          echo '<tr style="background-color:'.$td_color.'"><td >'.$rowi["id"].'&nbsp;</td>';
          echo '<td align="center">'.$fec.'&nbsp;</td>';
          echo '<td align="center">&nbsp;</td>';
          echo '<td align="left">'.$rowi["motivo"].'&nbsp;</td>';
          echo '<td style="background-color:'.$body_color.'" align="center">DESC&nbsp;</td>';
          echo '<td align="center">AUT: '.$rowi["autoriza"].'&nbsp;</td>';
          echo '<td align="right">'.number_format($rowi["importe"]*-1,2).'&nbsp;</td>';
          echo '<td align="right">'.number_format(0,2).'&nbsp;</td>';
          echo '<td align="right">'.number_format($rowi["importe"]*-1,2).'&nbsp;</td>';
          echo '<td align="center">&nbsp;</td>';
          $total = $rowi["importe"];
          $TP6 = $TP6 - $rowi["importe"];
          $Ttotal = $Ttotal - $total;

       }
       echo '<tr style="background-color:'.$td_color.'"><td>&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">GUARDIAS&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">'.$c1.'&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">'.$viejo.'&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">TOTAL&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">'.number_format($TP6,2).'&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">'.number_format($TP7,2).'&nbsp;</td>';
       echo '<td style="background-color:'.$body_color.'" align="center">'.number_format($Ttotal,2).'&nbsp;</td>';

       echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Descguardias.php">';
       echo '<input type="hidden" name= "cla_legajo" value="'.$legajomed.'" >';
       echo '<input type="hidden" name= "pasdatos" value="'.$datos.'" >';
       echo '<input type="hidden" name= "cla_fecha" value="'.$fechad.'" >';
       echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
       echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
       echo '<input type="hidden" name= "vengo" value="'.$vengo.'" >';
       echo '<input type="hidden" name= "cla_idguardia" value="'.$idguardia.'" >';
       echo '<input type="hidden" name= "cla_mes" value="'.$mes.'" >';
       echo '<input type="hidden" name= "cla_anios" value="'.$anio.'" >';
       echo '<input type="hidden" name= "cla_nom" value="'.$nom.'" >';

       echo '<td valign="center" style="background-color:'.$body_color.'" align="center"><INPUT TYPE="SUBMIT" value="Agreg Dto"></FORM></td>';


       $STP6 = $STP6 + $TP6;
       $STP7 = $STP7 + $TP7;
       $STtotal = $STtotal + $Ttotal;
       $TP6 = 0;
       $TP7 = 0;
       $Ttotal = 0;
       $c1 = 0;


      }

       echo '<tr style="background-color:'.$td_color.'"><td>&nbsp;</td>';
       echo '<td align="center">TOTAL GENERAL&nbsp;</td>';
       echo '<td align="center">&nbsp;</td>';
       echo '<td align="center">&nbsp;</td>';
       echo '<td align="center">&nbsp;</td>';
       echo '<td align="center">TOTAL&nbsp;</td>';
       echo '<td align="center">'.number_format($STP6,2).'&nbsp;</td>';
       echo '<td align="center">'.number_format($STP7,2).'&nbsp;</td>';
       echo '<td align="center">'.number_format($STtotal,2).'&nbsp;</td>';
       echo '<td align="center">&nbsp;</td>';

mysql_free_result($result);



?>

</table>


</BODY>
</HTML>