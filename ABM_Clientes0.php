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


<TITLE>ABM_Clientes0.php</TITLE>
</HEAD>
<BODY>

<?
echo titulo_encabezado ('Listado de Clientes' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL

?>

<body style="background-color:<?echo $body_color?>">
<FORM METHOD="POST" NAME="formulario3"
ACTION="ABM_Clientes.php">

<table width = "10%" align="left">

<?

echo '<TR><TD>
      <label>
        <input type="radio" name="cla_bus" value="C">
        CUIT</label><label>
        <input type="radio" name="cla_bus" value="D">
        DOC</label><label>
        <input type="radio" name="cla_bus" value="S">
        SOCIO</label><label>
        <input type="radio" name="cla_bus" value="N">
        NOMBRE</label></td><TD>Búsqueda</TD></tr>';

echo '<TR><TD><input type="text" size = 50 name="cla_nombre"/></td></tr>';

echo '<TR></TR><TR><TD>
      <label>
        <input type="radio" name="cla_ord" value="C">
        CUIT</label><label>
        <input type="radio" name="cla_ord" value="D">
        DOC</label><label>
        <input type="radio" name="cla_ord" value="S">
        SOCIO</label><label>
        <input type="radio" name="cla_ord" value="N">
        NOMBRE</label></td><TD>Ordenado</TD></tr>';


?>
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
