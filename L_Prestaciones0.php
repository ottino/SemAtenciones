<?
session_cache_limiter('public');
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


<TITLE>L_Prestaciones0.php</TITLE>
</HEAD>
<BODY>

<?
echo titulo_encabezado ('Listado de Prestaciones' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL
$result=mysql_query("SELECT * FROM planes order by 2");
$planes= '<select name="cla_plan" style="background-color:'.$se_color.'"><option value="0">Planes</option>';

while ($row=mysql_fetch_array($result))
{
$planes.='<option value="'.$row['idplan'].'">'.$row['descplan'].' - '.$row['idplan'].'</option>';
}
mysql_free_result($result);
$planes.= '</select>';


?>

 <!--////////////TABLA DE GUARDIAS  ////////////////////-->

<body style="background-color:<?echo $body_color?>">
<FORM METHOD="POST" NAME="formulario3"
ACTION="L_Prestaciones.php">

<table width = "10%" align="left">
<TR>
<TD><? echo $planes ?></td></tr>
 <TR><TD><? echo '<input type="text" name="cla_fecha" id="cla_fecha" size="10" />
       <input type="button" id="lanzador" value="Fecha Desde" onclick="calendario();"/>';?></td></tr>
 <TR><TD><? echo '<input type="text" name="cla_fecha1" id="cla_fecha1" size="10" />
       <input type="button" id="lanzador1" value="Fecha Hasta" onclick="calendario1();"/>';?></td></tr>

 <TR><TD><? echo '<input type="text" size = 50 name="cla_nombre"/>
         <input type="button" value="Nombre"/>'; ?></td></tr>


</TD>
<TD>&nbsp;
</TD></TD>
</TR></TR></table>

<INPUT TYPE="SUBMIT" value="Buscar">

    </span></th>
  </tr>

</table>
<br>

</select>


</FORM>
</div>
</BODY>
</HTML>
