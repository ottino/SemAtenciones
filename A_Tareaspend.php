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


<TITLE>A_Tareaspend.php</TITLE>
</HEAD>
<BODY>

<?
echo titulo_encabezado ('Alta de Tareas de Mantenimiento' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$moviles = $_POST["pasmovil"];

//Ejecutamos la sentencia SQL
//Ejecutamos la sentencia SQL SELECCIONA MOVILES
$result=mysql_query("select * from moviles where idmovil = ".$moviles." order by 1");

$movil= '<select style="width:300px" name="moviles" style="background-color:'.$se_color.'"><option value="0">Movil</option>';

while ($row=mysql_fetch_array($result))
{
if ($row['idmovil']== $moviles)
   $movil.='<option selected = "selected" value="'.$row['idmovil'].'">'.$row['idmovil'].'-'.$row['descmovil'].'</option>';
else
   $movil.='<option value="'.$row['idmovil'].'">'.$row['idmovil'].'-'.$row['descmovil'].'</option>';
}
mysql_free_result($result);
$movil.= '</select>';



//Ejecutamos la sentencia SQL para los tareas
$result=mysql_query("select * from tareas order by 2");
$tarea= '<select name="tarea" style="background-color:'.$se_color.'"><option value="0">Tareas</option>';
while ($row=mysql_fetch_array($result))
{
 $tarea.='<option value="'.$row['idtarea'].'">'.$row['desctarea'].'</option>';
}
mysql_free_result($result);
$tarea.= '</select>';

//Ejecutamos la sentencia SQL para los proveedores
$result=mysql_query("SELECT * FROM proveedores order by 2");

$provee= '<select name="provee" style="background-color:'.$se_color.'"><option value="0">Proveedor</option>';

while ($row=mysql_fetch_array($result))
{
$provee.='<option value="'.$row['idproveedores'].'">'.$row['proveedores'].'</option>';
}
mysql_free_result($result);

$provee.= '</select>';

?>


<body style="background-color:<?echo $body_color?>">
<FORM METHOD="POST" NAME="formulario3"
ACTION="A_Tareaspend2.php">


<table width = "50%" align="left">
 <tr>
            <th>MOVILES</th>
            <th>TAREAS</th>
            <th>PROVEEDOR</th>
            <th>FECHA</th>
            <th></th>
            <th>KM</th>
 </tr>
<TR>
<TD><? echo $movil?></TD>
<TD><? echo $tarea ?></TD>
<TD><? echo $provee ?></TD>
<TD><input type="text" name="cla_fecha" id="cla_fecha" size="10" /></TD>
<TD><input type="button" id="lanzador" value="Fecha" onclick="calendario();"/></TD>
<TD><input size= 12 type = "text" name = "cla_km" /></TD>
<td><INPUT TYPE="SUBMIT" value="Insertar"></td>

<TD>&nbsp;
</TD>
</TR></table>
</select>


</FORM>
</div>
</BODY>
</HTML>


