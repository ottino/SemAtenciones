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
<TITLE>ABM_Marcaje.php</TITLE>
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


$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["legajo"];
$imagen_volver = "imagenes/Volver.ico";

if ($GET["vengo"] == 'MARCA')
  {
   $fechad = $_GET["cla_fecha"];
   $fechah = $_GET["cla_fecha1"];
   $nombre = $_GET["legajo"];
   }

if ($fechah == '')
    $fechah = '2999/12/31';
if ($fechad == '')
    $fechad = '2000/01/01';


$fechad1=  cambiarFormatoFecha1($fechad);
$fechah1=  cambiarFormatoFecha1($fechah);

if ($nombre < '1')
    $sqlnombre = '';
   else
    $sqlnombre = " and b.legajo = '".$nombre."' ";

$result=mysql_query("select * from marcaje a, legajos b where a.legajo = b.legajo and
                a.fecha >= '".$fechad."' and a.fecha <= '".$fechah."'  ".$sqlnombre." order by a.idmarcaje desc ");

echo '<table ><tr><td>';
echo '<FORM>';
echo '<table width="100%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
echo ' <td><td></td></td>';
echo '</FORM><td width="1325"></td>';

echo '<FORM METHOD="POST" NAME="formulario3" ACTION="ABM_Marcaje0.php">';
echo ' <td width="17" align="right" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                    <label onclick="this.form.submit();">
                     <img align="middle" alt=\'Volver\' src="imagenes/Volver.ico" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo'</table></table>';
?>

<tr><td><table width="100%" border="1" align="left" style="font-size:<?echo $fontreg?>">
  <tr>
    <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td></tr><tr>
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:<?echo $fontreg?>" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:<?echo $fontt?>">
            <th>ID</th>
            <th>NOMBRE</th>
            <th>INGRESO</th>
            <th>EGRESO</th>
            <th>HS</th>
            <th>Modificar</th>
        </td>

<?
//Mostramos los registros

$c = '0';

while ($row=mysql_fetch_array($result))
{
$feci = cambiarFormatoFecha($row['fecha']);
$horai = cambiarFormatoHora($row['hora']);
$fece = cambiarFormatoFecha($row['fechas']);
$horae = cambiarFormatoHora($row['horas']);

$difhorag = calcular_horas($fece,$horae,$feci,$horai);

$difhorag = round(($difhorag / 60),2);

if ($fece == '00/00/0000')
     $difhorag = round((0 / 60),2);

echo '<tr><td align="center">'.$row["idmarcaje"].'</td>';
echo '<td>'.$row["apeynomb"].'</td>';
echo '<td align="center">'.$feci.'-'.$horai.'&nbsp;</td>';
echo '<td align="center">'.$fece.'-'.$horae.'&nbsp;</td>';
echo '<td align="center">'.$difhorag.'&nbsp;</td>';

if ($fece == '00/00/0000')
  {
    echo '<FORM METHOD="POST" NAME="formulario2" ACTION="M_marcaje.php">';
    echo '<input type="hidden" name= "idmarcaje" value="'.$row["idmarcaje"].'" >';
    echo '<input type="hidden" name="cla_fecha" value="'.$fechad.'"  >';
    echo '<input type="hidden" name="cla_fecha1" value="'.$fechah.'"  >';
    echo '<input type="hidden" name="legajo" value="'.$nombre.'"  >';

    echo ' <td width="17" align="center" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                    <label onclick="this.form.submit();">
                     <img align="middle" alt=\'Modificar\' src="imagenes/INSERTAR.ICO" width="30" height="30"/>
                    </label>
                  </td>';
    echo '</FORM>';
  }
}
mysql_free_result($result);

?>

</table>


</BODY>
</HTML>