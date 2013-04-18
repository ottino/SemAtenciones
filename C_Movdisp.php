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
<TITLE>C_Movdisp.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>

</p>
<?
echo titulo_encabezado ('Consulta Guardias Cerradas' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$pasaid = $_GET["pasdatos"];

if ($pasaid + 0 < 1)
   {
     $pasaid = $_POST["pasaid"];
     $marca  = $_POST["marca"];
   }
  else
     $marca  = '1';

$idbase = $pasaid;

if ($pasaid < 1)
   {
     $pasaid = 0;
     $idbase = 0;
   };

$resultmax=mysql_query("select max(idmovildisp) as id from movildisponible where vigente > '0'");
$rowmax=mysql_fetch_array($resultmax);
$ultmovdisp = $rowmax["id"] +0;
mysql_free_result($resultmax);
$ultpag = round(($ultmovdisp),0);



if ($pasaid > $ultpag || $pasaid < 1)
   {
     $pasaid = $ultpag;
     $idbase = $ultpag;
   };


if ($marca == '1')
  {  $idbase = $pasaid;
     $result=mysql_query("select * from movildisponible a, bases b, moviles c WHERE
     a.idbase = b.idbases and a.idmovil = c.idmovil and a.vigente = '1' and idmovildisp <= ".$idbase." order by 1 desc limit 0,20");
//     $idbase = (($ultpag - $idbase) + 20);
   }
 else
  {  $idbase = $pasaid;
     $result=mysql_query("select * from movildisponible a, bases b, moviles c WHERE
     a.idbase = b.idbases and a.idmovil = c.idmovil and a.vigente = '1' and idmovildisp <= ".$idbase." order by 1 desc limit 0,20");
//   $result=mysql_query("select * from movildisponible a, bases b, moviles c WHERE
//   a.idbase = b.idbases and a.idmovil = c.idmovil and a.vigente = '1' order by 1 desc limit ".$idbase.",20");
  }

     $antpag = $idbase +20;
     $propag = $idbase -20;

echo '</p>
      <table width="100%" border="1" align="left">
      <table width="100%" border="1" align="left">';

echo '
  <table width="100%" border="1" align="left" >
    <tr style="background-color:'.$td_color.'">
    <td style="width:2000px"><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td>';
     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="C_Movdisp.php">';
     echo '<input type="hidden" name= "pasaid" value  = "20" >';
     echo '<input type="hidden" name= "marca" value  ="0" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Inicio\' src="imagenes/117.ico" width="30" height="30"/>
                     </label></td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="C_Movdisp.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$propag.'" >';
     echo '<input type="hidden" name= "marca" value  ="0" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Pag Anterior\' src="imagenes/118.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="C_Movdisp.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$antpag.'" >';
     echo '<input type="hidden" name= "marca" value  ="0" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Pag Posterior\' src="imagenes/119.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="C_Movdisp.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$ultmovdisp.'" >';
     echo '<input type="hidden" name= "marca" value  ="0" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Final\' src="imagenes/120.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="C_Movdisp.php">';
     echo '<input type="text" name= "pasaid" valign="center">';
     echo '<input type="hidden" name= "marca" value  ="1" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Ir a\' src="imagenes/120.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM>';
     echo '</tr><tr style="background-color:'.$td_color.'">';

echo '
    <td width="100%" colspan = "11" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'"border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$body_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">
            <th>GDIA</th>
            <th>MOVIL</th>
            <th>CHOFER</th>
            <th>MEDICO</th>
            <th>ENFERMERO</th>
            <th>ALTA</th>
            <th>KM ALTA</th>
            <th>CONS</th>';
  if ($G_perfil == '1' || $G_perfil == '3')
     echo '<th>MOD</th><th></th></td></tr>';



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

echo '<tr style="background-color:'.$td_color.'"><td align="left">'.$row["idmovildisp"].'</td>';
echo '<td align="left">'.$row["idmovil"].'-'.substr($row["descmovil"],0,15).'</td>';
echo '<td align="left">'.substr($chofer,0,15).'&nbsp;</td>';
echo '<td align="left">'.substr($medico,0,15).'&nbsp;</td>';
echo '<td align="left">'.substr($enfermero,0,10).'&nbsp;</td>';
echo '<td align="center">'.$fecalta.' - '.$horaalta.'</td>';
echo '<td align="center">'.$row["kmalta"].'</td>';

$idmovildisp = $row["idmovildisp"];

echo '<FORM METHOD="POST" NAME="formulario3" ACTION="M_Cierredisp2.php">';
$idmovildisp = $row["idmovildisp"];
echo '<input type="hidden" name= "pasmovildisp" value="'.$idmovildisp.'" >';
echo '<input type="hidden" name= "pasaid" value  = "'.$idbase.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="20" height="20"/>
                    </label>
                  </td>';
echo '</FORM>';

if ($G_perfil == '1' || $G_perfil == '3')
 {
   echo '<FORM METHOD="POST" NAME="formulario3" ACTION="M_Guardiacerr.php">';
   $idmovildisp = $row["idmovildisp"];
   echo '<input type="hidden" name= "pasmovildisp" value="'.$idmovildisp.'" >';
   echo '<input type="hidden" name= "pasaid" value  = "'.$idbase.'" >';
   echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Modificar\' src="imagenes/editar.png" width="20" height="20"/>
                    </label>
                  </td>';
   echo '</FORM>';
 }

}

mysql_free_result($result)


?>

</table>


</BODY>
</HTML>