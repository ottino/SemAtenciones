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

<TITLE>M_Tareaspend.php</TITLE>
</HEAD>
<BODY>

<?
echo titulo_encabezado ('Mantenimiento tareas pendientes' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$idtareapend = $_POST["pasatareapend"];

//Creamos la sentencia SQL y la ejecutamos
$sSQL="select * from tareaspend a, moviles b, tareas c, proveedores d where
         a.idmovil = b.idmovil and a.idtarea = c.idtarea and a.idproveedor = d.idproveedores and
         a.id = ".$idtareapend;

$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$id      = $row['id'];
$moviles = $row['idmovil'];
$idtarea  = $row['idtarea'];
$idprove = $row['idproveedor'];
$fecha   = $row['fecha'];
$km      = $row['km'];


//Ejecutamos la sentencia SQL
$result=mysql_query("select * from moviles order by 1");
$movil= '<select name="movil" style="background-color:'.$se_color.'"><option value="0">Moviles</option>';
while ($row=mysql_fetch_array($result))
{
if ($row['idmovil']== $moviles)
   $movil.='<option selected = "selected" value="'.$row['idmovil'].'">'.$row['idmovil'].'-'.$row['descmovil'].'</option>';
else
   $movil.='<option value="'.$row['idmovil'].'">'.$row['idmovil'].'-'.$row['descmovil'].'</option>';
}
mysql_free_result($result);
$movil.= '</select>';


//Ejecutamos la sentencia SQL para los articulos
$result=mysql_query("select * from tareas order by 2");
$tarea= '<select name="tarea" style="background-color:'.$se_color.'"><option value="0">Tareas</option>';
while ($row=mysql_fetch_array($result))
{
if ($row['idtarea']== $idtarea)
 $tarea.='<option selected = "selected" value="'.$row['idtarea'].'">'.$row['desctarea'].'</option>';
else
 $tarea.='<option value="'.$row['idtarea'].'">'.$row['desctarea'].'</option>';
}
mysql_free_result($result);
$tarea.= '</select>';

//Ejecutamos la sentencia SQL para los proveedores
$result=mysql_query("SELECT * FROM proveedores order by 2");

$provee= '<select name="provee" style="background-color:'.$se_color.'"><option value="0">Proveedor</option>';

while ($row=mysql_fetch_array($result))
{
if ($row['idproveedores']== $idprove)
   $provee.='<option selected = "selected" value="'.$row['idproveedores'].'">'.$row['proveedores'].'</option>';
else
   $provee.='<option value="'.$row['idproveedores'].'">'.$row['proveedores'].'</option>';
}
mysql_free_result($result);

$provee.= '</select>';


?>


<body style="background-color:<?echo $body_color?>">
<FORM METHOD="POST" NAME="formulario3"
ACTION="M_Tareaspend2.php">

<?
 echo'<Table>';
 echo '<TR><TD>Moviles</TD><TD>'.$movil.'</TD></TR>';
 echo '<TR><TD>Tareas</TD><TD>'.$tarea.'</TD></TR>';
 echo '<TR><TD>Proveedores</TD><TD>'.$provee.'</TD></TR>';
 echo '<TR><TD>Fecha</TD><TD>
      <input type="text" name="cla_fecha" id="cla_fecha" size="10" value = "'.$fecha.'" />
      <input type="button" id="lanzador" value="Seleccionar fecha" onclick="calendario();"/></TD></TR>';
 echo '<TR><TD>KM</TD><TD><input size= 12 type = "text" name = "cla_km" value = "'.$km.'"/></TD></TR>';
 echo '<input type="hidden" name= "tarpen" value="'.$id.'" >';
 echo '</table>' ;
?>
<td><INPUT TYPE="SUBMIT" value="Actualizar"></td>

<TD>&nbsp;
</TD>
</TR></table>
</select>


</FORM>
</div>
<FORM METHOD="POST" ACTION="ABM_Tareaspend2.php">
<? echo '<input type="hidden" name= "movil" value="'.$row[idmovil].'" >'; ?>
<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>

</BODY>
</HTML>


