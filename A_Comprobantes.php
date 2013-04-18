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


<TITLE>A_Comprobantes.php</TITLE>
</HEAD>
<script>
</script>
<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Proceso de generación de cuotas' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
?>


<br>
<FORM METHOD="POST" name="formulario"
ACTION="A_Comprobantes2.php">

<?

//Ejecutamos la sentencia SQL

//Ejecutamos la sentencia SQL
$result=mysql_query("SELECT * FROM ctrlcupones where estado = '' order by 4");
$clientes.='<option selected="selected" value="">Seleccione Periodo</option>';
while ($row=mysql_fetch_array($result))
{
$periodo.='<option value="'.$row['periodo'].'">'.$row['periodo'].' - '.$row['estado'].'</option>';
}
mysql_free_result($result);



 echo'<Table>';

 echo '<TR><TD>Periodo</TD><TD><select name="cla_periodo">'.$periodo.'</select></TD></TR>';
 echo '<TR><TD>Fecha de Vto</TD><TD>
      <input type="text" name="cla_fechavto" id="cla_fecha" size="10" />
      <input type="button" id="lanzador" value="Fecha de Vto" onclick="calendario();"/></TD></TR>';
 echo '<TR><TD>Leyenda</TD><TD><input size= 80 type = "text" name = "cla_leyenda" /></TD></TR>';
 echo '<TR><TD>Leyenda 1</TD><TD><input size= 80 type = "text" name = "cla_leyenda1" /></TD></TR>';

echo '</table>' ;
?>
<td><INPUT TYPE="SUBMIT" value="Insertar"></td>


    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
   </BODY>
</HTML>


