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


<TITLE>ABM_Novarticulos.php</TITLE>
</HEAD>
<BODY>

<?
echo titulo_encabezado ('Consultas de Compras' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia
$result=mysql_query("SELECT * FROM proveedores order by 2");

$provee= '<select name="provee" style="background-color:'.$se_color.'"><option value="0">Proveedor</option>';

while ($row=mysql_fetch_array($result))
{
$provee.='<option value="'.$row['idproveedores'].'">'.$row['proveedores'].'</option>';
}
mysql_free_result($result);

$provee.= '</select>';

//Ejecutamos la sentencia SQL para los articulos
$result=mysql_query("select * from articulos a, rubros b where a.rubro = b.idrubro order by 2");
$arti= '<select name="artic" style="background-color:'.$se_color.'"><option value="0">Artículo</option>';
while ($row=mysql_fetch_array($result))
{
 $arti.='<option value="'.$row['idarticulo'].'-'.$row['rubro'].'">'.$row['articulo'].'-'.$row['descrubro'].'</option>';
}
mysql_free_result($result);
$arti.= '</select>';



//Ejecutamos la sentencia SQL  BgColor="#d0d0d0"


?>

<body style="background-color:<?echo $body_color?>">
<FORM METHOD="POST" NAME="formulario3"
ACTION="ABM_Novarticulos2.php">

<table width = "10%" align="left">
<TR>
<TD><? echo $provee ?><? echo $arti ?>
 <? echo '<input type="text" name="cla_fecha" id="cla_fecha" size="10" />
       <input type="button" id="lanzador" value="Fecha Desde" onclick="calendario();"/>';?>
 <? echo '<input type="text" name="cla_fecha1" id="cla_fecha1" size="10" />
       <input type="button" id="lanzador1" value="Fecha Hasta" onclick="calendario1();"/>';?>


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


