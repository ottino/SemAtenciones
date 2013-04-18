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


<TITLE>ABM_Facturas.php</TITLE>
</HEAD>
<BODY>

<?
echo titulo_encabezado ('Consulta de Facturación' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL
$result=mysql_query("SELECT * FROM clientes order by 8");
$cliente= '<select name="cla_cliente" style="background-color:'.$se_color.'"><option value="0">Clientes</option>';

while ($row=mysql_fetch_array($result))
{
$cliente.='<option value="'.$row['idcliente'].'">'.$row['nombre'].'</option>';
}
mysql_free_result($result);
$cliente.= '</select>';

//Ejecutamos la sentencia SQL
$result=mysql_query("SELECT * FROM ctrlcupones where estado = 'OK' order by periodo desc");
$periodo= '<select name="cla_periodo" style="background-color:'.$se_color.'"><option value="0">Períodos</option>';

while ($row=mysql_fetch_array($result))
{
$periodo.='<option value="'.$row['periodo'].'">'.$row['periodo'].'</option>';
}
mysql_free_result($result);
$periodo.= '</select>';


?>

 <!--////////////TABLA DE GUARDIAS  ////////////////////-->

<body style="background-color:<?echo $body_color?>">
<FORM METHOD="POST" NAME="formulario3"
ACTION="ABM_Facturas2.php">

<table width = "10%" align="left">
<TR>
<TD><? echo $cliente ?><? echo $periodo ?>
 <? echo '<input type="text" name="cla_fecha" id="cla_fecha" size="10" />
       <input type="button" id="lanzador" value="Fecha Desde" onclick="calendario();"/>';?>
 <? echo '<input type="text" name="cla_fecha1" id="cla_fecha1" size="10" />
       <input type="button" id="lanzador1" value="Fecha Hasta" onclick="calendario1();"/>';?>
 <?echo '
     <label><input type="radio" name="cla_tipocomprob" value="C" />Cupón</label>
     <label><input type="radio" name="cla_tipocomprob" value="F" />Factura</label>
     <label><input type="radio" name="cla_tipocomprob" value="T" />Tarjetas</label>';?>


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
