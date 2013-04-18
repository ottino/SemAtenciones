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


<TITLE>ABM_Botiquines.php</TITLE>
</HEAD>
<BODY>

<?
echo titulo_encabezado ('Consultas de Botiquines' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL  BgColor="#d0d0d0"
$result=mysql_query("select * from moviles where estado < 1 order by 1");
$movil= '<select name="movil" style="background-color:'.$se_color.'"><option value="0">Moviles</option>';
while ($row=mysql_fetch_array($result))
{
$movil.='<option value="'.$row['idmovil'].'">'.$row['idmovil'].'-'.$row['descmovil'].'</option>';
}
mysql_free_result($result);
$movil.= '</select>';


?>



<body style="background-color:<?echo $body_color?>">

<FORM METHOD="POST" NAME="formulario3"
ACTION="ABM_Botiquines2.php">

<table width = "10%" align="left">
<TR>
<TD><? echo $movil ?>

</TD>
<TD>&nbsp;
</TD>
</TR></table>

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


