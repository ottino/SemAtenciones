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
<TITLE>C_Movdisp2.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>

</p>
<?
echo titulo_encabezado ('Consulta Control de Móviles' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

if ($_GET["vengo"] == "MOVIL")
   {
     $vengo   = $_GET["vengo"];
     $idmovil = $_GET["cla_movil"];
     $fechad  = $_GET["cla_fecha"];
     $fechah  = $_GET["cla_fecha1"];
   }
  else
   {
     $idmovil = $_POST["cla_movil"];
     $fechad  = $_POST["cla_fecha"];
     $fechah  = $_POST["cla_fecha1"];
   }


if ($idmovil > "0")
   $query1 = "and c.idmovil = '".$idmovil."' ";

if (substr($fechad,2,1) == "/")
    $fechad = cambiarFormatoFecha2($fechad);

if (substr($fechah,2,1) == "/")
    $fechah = cambiarFormatoFecha2($fechah);

if ($fechah == '')
    $fechah = '2999/12/31';
if ($fechad == '')
    $fechad = '2000/01/01';

     $result=mysql_query("select * from movildisponible a, moviles c WHERE
     a.idmovil = c.idmovil ".$query1." and a.fecalta >= '".$fechad."' and a.fecalta <= '".$fechah."' order by a.idmovil, a.idmovildisp desc");

$ver = "select * from movildisponible a, moviles c WHERE
     a.idmovil = c.idmovil ".$query1." and a.fecalta > '".$fechad."' and a.fecalta < '".$fechah."' order by a.idmovil, a.idmovildisp desc";

//echo $ver;

echo '
</p><table width="100%" border="1" align="left">
  <table width="100%" border="1" align="left">
  <tr>
    <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"><div align="center">'.$literal.'</div>
      <div align="right"><th> <a href="C_Movdisp1.php?"/a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></th></div></td>
      </tr><tr><TD colspan = "2">
  <table width="100%" border="1" align="left">
    <tr style="background-color:'.$td_color.'"><td width="100%" colspan = "11" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'"border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
         <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">
            <th>GDIA</th>
            <th>MOVIL</th>
            <th>CHOFER</th>
            <th>MEDICO</th>
            <th>ALTA</th>
            <th>KM A/B</th>
            <th>DIF</th>
            <th>ATEN</th>
            <th>CONS</th>
        </td></tr>';


//Mostramos los registros
while ($row=mysql_fetch_array($result))
{

$medico = buscopersonal($row['legmedico']);
$enfermero = buscopersonal($row['legenfermero']);
$chofer = buscopersonal($row['legchofer']);

$fecalta = cambiarFormatoFecha($row['fecalta']);
$fecbaja = cambiarFormatoFecha($row['fecbaja']);
$horaalta = cambiarFormatoHora($row['horaalta']);
$horabaja = cambiarFormatoHora($row['horabaja']);

$kmalta = $row["kmalta"];
$kmbaja = $row["kmbaja"];

$difer = $kmbaja - $kmalta;


$resultmax=mysql_query("select count(*) as cont from atenciones where movil_2 =".$row['idmovildisp']);
$rowmax=mysql_fetch_array($resultmax);
$cont = $rowmax["cont"] +0;
mysql_free_result($resultmax);


echo '<tr style="background-color:'.$td_color.'"><td align="left">'.$row["idmovildisp"].'</td>';
echo '<td align="left">'.$row["idmovil"].'-'.substr($row["descmovil"],0,15).'</td>';
echo '<td align="left">'.substr($chofer,0,15).'&nbsp;</td>';
echo '<td align="left">'.substr($medico,0,15).'&nbsp;</td>';
echo '<td align="center">'.$fecalta.' - '.$horaalta.'</td>';
echo '<td align="center">'.$row["kmalta"].'-'.$row["kmbaja"].'</td>';
echo '<td align="center">'.$difer.'</td>';
echo '<td align="center">'.$cont.'</td>';

$idmovildisp = $row["idmovildisp"];
$vengo = "MOVIL";

echo '<FORM METHOD="POST" NAME="formulario3" ACTION="M_Cierredisp2.php">';
$idmovildisp = $row["idmovildisp"];
echo '<input type="hidden" name= "pasmovildisp" value="'.$idmovildisp.'" >';
echo '<input type="hidden" name= "pasaid" value  = "'.$idbase.'" >';
echo '<input type="hidden" name= "cla_movil" value  = "'.$idmovil.'" >';
echo '<input type="hidden" name= "cla_fecha" value  = "'.$fechad.'" >';
echo '<input type="hidden" name= "cla_fecha1" value  = "'.$fechah.'" >';
echo '<input type="hidden" name= "cla_vengo" value  = "'.$vengo.'" >';

echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="20" height="20"/>
                    </label>
                  </td>';
echo '</FORM>';

}

mysql_free_result($result)


?>

</table>


</BODY>
</HTML>