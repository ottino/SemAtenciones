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


<TITLE>A_Cobranzas0.php</TITLE>
</HEAD>
<script>
</script>
<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Captura de Cobranzas por lotes' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
?>


<br>
<FORM METHOD="POST" name="formulario"
ACTION="A_Cobranzas1.php">

<?
$result=mysql_query("SELECT * FROM cobrador order by 1");
$cobrador.='<option selected="selected" value="">Seleccione Cobrador</option>';
while ($row=mysql_fetch_array($result))
{
$cobrador.='<option value="'.$row['idcob'].'">'.$row['desccob'].'</option>';
}
mysql_free_result($result);



 echo'<Table>';
?>
 <TR><TD><? echo '<input type="text" name="cla_fecha" id="cla_fecha" size="10" />
       <input type="button" id="lanzador" value="Fecha Desde" onclick="calendario();"/>';?></td></tr>

<?
// echo '<TR><TD>Ingrese Fecha Rendición</TD><TD><input size= 15 type = "text" name = "cla_fecrendi" /></TD></TR>';
 echo '<TR><TD><select name="cla_cobrador">'.$cobrador.'</select></TD><TD>Seleccione Cobrador</TD></TR>';
 echo '<TR><TD><input size= 10 type = "text" name = "cla_nrolote" /></TD><TD>Ingrese lote</TD></TR>';

echo '</table>' ;
?>
<td><INPUT TYPE="SUBMIT" value="Crear Lote"></td>
</span></th>
</tr>
</table>
</select>
</FORM>
</div>
<FORM METHOD="POST" ACTION="ABM_Cobranzas.php">
<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>
</BODY>
</HTML>


