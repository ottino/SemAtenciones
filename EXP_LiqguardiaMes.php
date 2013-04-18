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


<TITLE>EXP_LiqguardiasMes.php</TITLE>
</HEAD>
<BODY>

<?
echo titulo_encabezado ('Liquidación Mensual de Guardias' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL
$result=mysql_query("SELECT * FROM legajos order by 2");

$legajos= '<select name="legajo" style="background-color:'.$se_color.'"><option value="0">Personal</option>';

while ($row=mysql_fetch_array($result))
{
$legajos.='<option value="'.$row['apeynomb'].'">'.$row['apeynomb'].'</option>';
$funciones = $row['funcion'];
}
mysql_free_result($result);

$legajos.= '</select>';

$vector_meses= '<select name ="meses" style="background-color:'.$se_color.'"><option value="0">Meses</option>';
$vector_anios= '<select name ="anios" style="background-color:'.$se_color.'"><option value="0">Años</option>';

for($c=1;$c<=12;$c++)
$vector_meses.= '<option value="'.$c.'">'.$c.'</option>';

for($c=2009;$c<=2025;$c++)
$vector_anios.= '<option value="'.$c.'">'.$c.'</option>';

$vector_meses.= '</select>';
$vector_anios.= '</select>';


//Ejecutamos la sentencia SQL


?>

 <!--////////////TABLA DE GUARDIAS  ////////////////////-->

<body style="background-color:<?echo $body_color?>">
<FORM METHOD="POST" NAME="formulario3"
ACTION="EXP_Liqguardia.php">

<table width = "10%" align="left">
<TR>
<TD><? echo $legajos ?><? echo $vector_meses ?><? echo $vector_anios ?><input type="hidden" name= "vengo" value="LIQMES" >
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


