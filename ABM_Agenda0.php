<?
session_cache_limiter('public');
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//inclu�mos la clase ajax
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

  <!-- librer�a principal del calendario -->
 <script type="text/javascript" src="calendario/calendar.js"></script>

 <!-- librer�a para cargar el lenguaje deseado -->
  <script type="text/javascript" src="calendario/lang/calendar-es.js"></script>

  <!-- librer�a que declara la funci�n Calendar.setup, que ayuda a generar un calendario en unas pocas l�neas de c�digo -->
  <script type="text/javascript" src="calendario/calendar-setup.js"></script>

  <!-- librer�a que declara la funci�n Calendar.setup, que ayuda a generar un calendario en unas pocas l�neas de c�digo -->
  <script type="text/javascript" src="jsfunciones.js"></script>
  <!------------------------------------------------------------------------------------------------------->


<TITLE>ABM_Agenda0.php</TITLE>
</HEAD>
<BODY>

<?
echo titulo_encabezado ('Agenda Personal' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL

?>

<body style="background-color:<?echo $body_color?>">
<FORM METHOD="POST" NAME="formulario3"
ACTION="ABM_Agenda.php">

<table width = "30%" align="left">

<?


echo '<TR><TD>Ingrese nombre</TD><TD><input type="text" size = 50 name="cla_nombre"/></td></tr>';

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
