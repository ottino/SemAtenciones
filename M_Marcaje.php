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
                                    <!--       CALENDARIO    -->
 <!--Hoja de estilos del calendario -->
  <link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-green.css" title="win2k-cold-1" />

  <!-- librería principal del calendario -->
 <script type="text/javascript" src="calendario/calendar.js"></script>

 <!-- librería para cargar el lenguaje deseado -->
  <script type="text/javascript" src="calendario/lang/calendar-es.js"></script>

  <!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
  <script type="text/javascript" src="calendario/calendar-setup.js"></script>

  <!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
  <script type="text/javascript" src="jsfunciones.js"></script>
  <!------------------------------------------------------------------------------------------------------->

<TITLE>M_Marcaje.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Modificación de Parámetros Liquidación' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["legajo"];
$idmarcaje = $_POST["idmarcaje"];

echo '<table ><tr><td>';
echo '<FORM>';
echo '<table width="100%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
echo ' <td><td></td></td>';
echo '</FORM><td width="1325"></td>';

echo '<FORM METHOD="POST" NAME="formulario3" ACTION="ABM_Marcaje.php">';
echo ' <td width="17" align="right" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                    <label onclick="this.form.submit();">
                     <img align="middle" alt=\'Volver\' src="imagenes/Volver.ico" width="30" height="30"/>
                    </label>
                  </td>';
    echo '<input type="hidden" name="cla_fecha" value="'.$fechad.'"  >';
    echo '<input type="hidden" name="cla_fecha1" value="'.$fechah.'"  >';
    echo '<input type="hidden" name="legajo" value="'.$nombre.'"  >';

echo '</FORM>';

echo'</table></table>';


echo '<FORM METHOD="POST"
ACTION="M_Marcaje2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="Select * From marcaje a, legajos b where a.legajo = b.legajo and idmarcaje = ".$idmarcaje;
//echo $sSQL;
$result=mysql_query($sSQL);

//Mostramos los registros en forma de menú desplegable
$row=mysql_fetch_array($result);

$feci = cambiarFormatoFecha($row['fecha']);
$horai = cambiarFormatoHora($row['hora']);

 echo'<Table>';
 echo '<TR><TD>ID</TD><TD><input disabled="disabled" size= 8 type = "text" name = "idmarcaje" value = "'.$row[idmarcaje].'"/></TD></TR>';
 echo '<TR><TD>Ingreso</TD><TD><input size= 20 type = "text" name = "cla_tipmovil" value = "'.$feci.'-'.$horai.'" /></TD>';
?>
 <TD><? echo '<input type="button" id="lanzador1" value="Fecha Hasta" onclick="calendario1();"/><input type="text" name="fecha1" id="cla_fecha1" value = "'.$row['fecha'].'" size="10"/>';?></td>
<?

 echo '<TD>  Hora Egreso</TD><TD><input size= 6 type = "text" name = "cla_hora1" value = "'.$horai.'"/></TD></TR>';
 echo '<input type="hidden" name="cla_fecha" value="'.$fechad.'"  >';
 echo '<input type="hidden" name="cla_fecha1" value="'.$fechah.'"  >';
 echo '<input type="hidden" name="legajo" value="'.$nombre.'"  >';
 echo '<input type="hidden" name="idmarcaje" value="'.$idmarcaje.'"  >';

 echo '</table>' ;

?>
    </span></th>
  </tr>
</table>
<br>
</select>

<INPUT name="SUBMIT" TYPE="submit" value="Actualizar"></FORM>
    <th width="769" scope="col">

</FORM>
</div>
   </BODY>
</HTML>