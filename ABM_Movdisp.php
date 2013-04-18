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

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
?>


<HTML>
<HEAD>
<TITLE>ABM_Movdisp.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>

<?
echo titulo_encabezado ('Guardias Activas Actuales' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }


//Ejecutamos la sentencia SQL
$result=mysql_query("select * from movildisponible a, bases b, moviles c WHERE
a.idbase = b.idbases and a.idmovil = c.idmovil and a.vigente <> '1' order by 10");
?>

</p>
<?
echo '<table ><tr><td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Movdisp.php">';
echo '<table width="100%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
echo ' <td><td width="25" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Nueva Guardia\' src="imagenes/AMBUL01G.ICO" width="50" height="40"/>
                    </label>
                  </td></td>';
echo '<td width="1060"><div align="left"><th> <a href="Principal.php?"/a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></th></div></td>';
echo'</table></table>';

echo '</FORM>';


echo '<table width="100%" border="1" align="left">
  <tr style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'"border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$body_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
         <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">
            <th>MOVIL</th>
            <th>GUARDIA</th>
            <th>CHOFER</th>
            <th>MEDICO</th>
            <th>ENFERMERO</th>
            <th>ALTA</th>
            <th>KM ALTA</th>
            <th>MOD</th>
            <th>CONS</th>
            <th>CIERRE</th>
            <th></th>
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

switch($row['tipoguardia'])
 {
    case 1:
      $tipog = 'UTI';
     break;

    case 2:
      $tipog = 'PART';
     break;

    case 3:
      $tipog = 'TRASL';
     break;

    case 4:
      $tipog = 'EVENTO';
     break;

    default:
      $tipog = 'OTRO';
     break;
 }



echo '<tr style="background-color:'.$td_color.'"><td align="left">'.$row["idmovil"].' - '.substr($row["descmovil"],0,12).'</td>';
echo '<td align="left">'.$tipog.'</td>';
echo '<td align="left">'.substr($chofer,0,15).'&nbsp;</td>';
echo '<td align="left">'.substr($medico,0,15).'&nbsp;</td>';
echo '<td align="left">'.substr($enfermero,0,15).'&nbsp;</td>';
echo '<td align="center">'.$fecalta.' - '.$horaalta.'</td>';
echo '<td align="center">'.$row["kmalta"].'</td>';

echo '<FORM METHOD="POST" NAME="formulario3" ACTION="M_Movdisp.php">';

$idmovildisp = $row["idmovildisp"];
echo '<input type="hidden" name= "pasmovildisp" value="'.$idmovildisp.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Modificar\' src="imagenes/editar.png" width="20" height="20"/>
                    </label>
                  </td>';

echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario3" ACTION="M_Cierredisp.php">';
$idmovildisp = $row["idmovildisp"];
$vengo = "C";  //consulta
echo '<input type="hidden" name= "pasmovildisp" value="'.$idmovildisp.'" >';
echo '<input type="hidden" name= "vengo" value="'.$vengo.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Consultar\' src="imagenes/Insertar.ico" width="20" height="20"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario3" ACTION="M_Cierredisp.php">';
$idmovildisp = $row["idmovildisp"];
$vengo = "M";  //Modificacion y cierre
echo '<input type="hidden" name= "pasmovildisp" value="'.$idmovildisp.'" >';
echo '<input type="hidden" name= "vengo" value="'.$vengo.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Cerrar\' src="imagenes/cerrar1.ico" width="20" height="20"/>
                    </label>
                  </td>';


//echo '<td><a href="M_Cierredisp.php?pasmovildisp='.$idmovildisp.'">Cierre</a></td></tr>';
echo '</FORM>';
}

mysql_free_result($result)


?>

</table>

</BODY>
</HTML>