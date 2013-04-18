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


<TITLE>L_Gastobotiquines.php</TITLE>
</HEAD>
<BODY>

<?
echo titulo_encabezado ('Consulta de Consumo Botiquines' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$hoy = date("Y/m/d");


// <TR><TD><? echo '<input type="text" name="cla_fecha" id="cla_fecha" size="10" value = "'.$hoy.'"/>

?>

<body style="background-color:<?echo $body_color?>">
<FORM METHOD="POST" NAME="formulario3"
ACTION="L_Gastobotiquines1.php">

<table width = "50%" align="left">
<TR>
 <TR><TD><? echo '<input type="text" name="cla_fecha" id="cla_fecha" size="10"/>
       <input type="button" id="lanzador" value="Fecha Desde" onclick="calendario();"/>';?></td></tr>
 <TR><TD><? echo '<input type="text" name="cla_fecha1" id="cla_fecha1" size="10"/>
       <input type="button" id="lanzador1" value="Fecha Hasta" onclick="calendario1();"/>';?></td></tr>

</TR>
<TR><TD><INPUT TYPE="SUBMIT" value="Buscar"></td></tr>

</TD></TD>
</TR></TR></table>

</span></th>
  </tr>

</table>
<br>

</select>


</FORM>
</div>
</BODY>
</HTML>
