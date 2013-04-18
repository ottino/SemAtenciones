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

<TITLE>A_Novarticulos.php</TITLE>
</HEAD>
<body style="background-color:<?echo $body_color?>">

<?
echo titulo_encabezado ('Novedades de Artículos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL para los articulos
$result=mysql_query("select * from articulos a, rubros b where a.rubro = b.idrubro order by 2");
$arti= '<select name="artic" style="background-color:'.$se_color.'"><option value="0">Artículo</option>';
while ($row=mysql_fetch_array($result))
{
 $arti.='<option value="'.$row['idarticulo'].'-'.$row['rubro'].'">'.$row['articulo'].'-'.$row['descrubro'].'</option>';
}
mysql_free_result($result);
$arti.= '</select>';

//Ejecutamos la sentencia SQL para los proveedores
$result=mysql_query("select * from proveedores order by 2");
$provee= '<select name="provee" style="background-color:'.$se_color.'"><option value="0">Proveedor</option>';
while ($row=mysql_fetch_array($result))
{
 $provee.='<option value="'.$row['idproveedores'].'">'.$row['proveedores'].'</option>';
}
mysql_free_result($result);
$provee.= '</select>';

?>

<br>
<FORM METHOD="POST"
ACTION="A_Novarticulos2.php">

<?
 echo'<Table>';
 echo '<TR><TD>Artículo</TD><TD>'.$arti.'</TD></TR>';
 echo '<TR><TD>Proveedor</TD><TD>'.$provee.'</TD></TR>';
 echo '<TR><TD>Fecha Compra</TD><TD>
       <input type="text" name="cla_fecha" id="cla_fecha" size="10" />
       <input type="button" id="lanzador" value="Seleccionar fecha" onclick="calendario();"/></TD></TR>';
 echo '<TR><TD>Cantidad</TD><TD><input size= 10 type = "text" name = "cla_cantidad" /></TD></TR>';
 echo '<TR><TD>Importe</TD><TD><input size= 10 type = "text" name = "cla_importe" /></TD></TR>';

 echo '</table>' ;
?>

<INPUT TYPE="SUBMIT" value="Insertar">

    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
   </BODY>
</HTML>


