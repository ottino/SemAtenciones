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
?>


<HTML>
<HEAD>
<TITLE>ABM_Cajascerr2.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $font?>">
<BODY>


<?
echo titulo_encabezado ('Modulo de Cajas Cerradas' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
$legajo = $G_legajo;

$marcaupd = '0';
$idcajas = $_POST["pasacajas"];

$font = '12px';
$fontm = '15px';

//Ejecutamos la sentencia SQL
$sSQL="select * from cajas a, legajos b WHERE a.legajo = b.legajo and a.idcaja = ".$idcajas;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

 if (!$row)
   echo '
    <table width="20%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:'.$th_color.'; border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
        <tr>
          <td><a href="A_Cajas.php">NUEVA CAJA</a></td>
        </tr>
    </table><br><br><br>';
 else
{
 echo '
<table><tr><td>
  <table width="100%" border="1" align="left">
  <tr>
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontm.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontm.'">
            <th>ID</th>
            <th>USUARIO</th>
            <th>F.APERTURA</th>
            <th>SALD.APERT.</th>
            <th>ESTADO</th>
            <th></th>
        </td></tr>';

//Mostramos los registros
$usuario = buscopersonal($row['legajo']);
$fecalta = cambiarFormatoFecha($row['fapertura']);
$estado  = "CERRADA";
$idcaja  = $row["idcaja"];
$saldoaper = $row["saldoaper"];

echo '<tr><td align="left">'.$row["idcaja"].'</td>';
echo '<td align="left">'.$usuario.'</td>';
echo '<td align="center">'.$fecalta.'</td>';
echo '<td align="center">'.$saldoaper.'</td>';
echo '<td align="center">'.$estado.'</td>';
echo '<input type="hidden" name= "pasacajas" value="'.$idcaja.'" >';

echo '</FORM>';
echo '</TR></table></table></td></tr>' ;

mysql_free_result($result);

////////////////////////////////////////////////////////////

$sSQL="select * from movcaja a, cajas b, motmovcajas c where
       a.idcaja = b.idcaja and a.debcre = c.debcre and a.idmotdc = c.id
       and a.idcaja = ".$idcaja." order by 4,5";

//echo $sSQL;

$result=mysql_query($sSQL);


$c = 0;
$coseguros = 0;
echo '
  <table width="100%" border="1" align="left">
  <tr>
    <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td></tr><tr>
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$font.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$font.'">
            <th>ID CAJA</th>
            <th>D/C</th>
            <th>MOTIVO</th>
            <th>F.MOVIM</th>
            <th>OBSERV.</th>
            <th>IMPORTE</th>
            <th>SALDO</th>
        </td>';


//Mostramos los registros

$saldo = $saldoaper;

while ($row=mysql_fetch_array($result))
{

$fecmov = cambiarFormatoFecha($row['fecmov']);
$horamov = cambiarFormatoHora($row['horamov']);

$importe = $row["importe"];

if ($row["debcre"] == '1')
{   $debcre = "D";
    $saldo = $saldo - $importe;
}  else
{   $debcre = "C";
    $saldo = $saldo + $importe;
}
echo '<tr><td align="center">'.$idcaja.'</td>';
echo '<td align="center">'.$debcre.'</td>';
echo '<td align="left">'.$row["descmotdc"].'</td>';
echo '<td align="center">'.$fecmov.' - '.$horamov.'</td>';
echo '<td align="left">'.$row["observac"].'</td>';
echo '<td align="center">'.$row["importe"].'</td>';
echo '<td align="center">'.$saldo.'</td>';

}

echo '</TR></table></table></td></tr></table>' ;
mysql_free_result($result);

}

?>

</table>


</BODY>
</HTML>