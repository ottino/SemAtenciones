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



<TITLE>A_Descguardias.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Alta de Descuentos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$vengo = $_POST["vengo"];
$datos = $_POST["pasdatos"];
$legajo = $_POST["cla_legajo"];
$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["cla_nombre"];
$idguardia1 = $_POST["cla_idguardia"];
$mes  = $_POST["cla_mes"];
$anio = $_POST["cla_anios"];
$nom = $_POST["cla_nom"];




//Ejecutamos la sentencia SQL
$sSQL="SELECT * FROM legajos where legajo = ".$legajo;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);


echo '<table>' ;
echo '<TR><td>PERSONAL:  </td><td disabled="disabled" width="1325" align="left">'.$row["apeynomb"].'</td><td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="ABM_Liqguardia.php">';

echo '<input type="hidden" name= "cla_legajo" value="'.$legajo.'" >';
echo '<input type="hidden" name= "cla_fecha2" value="'.$fechad.'" >';
echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
echo '<input type="hidden" name= "vengo" value="'.$vengo.'" >';
echo '<input type="hidden" name= "cla_idguardia" value="'.$idguardia1.'" >';

echo ' <td width="17" align="center" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                    <label onclick="this.form.submit();">
                     <img align="middle" alt=\'Volver\' src="imagenes/Volver.ico" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';
echo '</table>' ;
?>


<br>
<FORM METHOD="POST"
ACTION="A_Descguardias2.php">
<?
 echo '<table>' ;
 echo '<TR><TD>Personal</TD><TD>'.$row["apeynomb"].'</TD></TR>';
 echo '<TR><TD>Motivo</TD><TD><input size= 30 type = "text" name = "motivo" /></TD></TR>';
 echo '<TR><TD>Importe</TD><TD><input size= 10 type = "text" name = "importe" /></TD></TR>';
 echo '</table>' ;
?>

 <Table> <TR><TD><? echo '<input type="text" name="cla_fecha" id="cla_fecha" size="10"/>
       <input type="button" id="lanzador" value="Fecha Desde" onclick="calendario();"/>';?></td></tr>
</table>
<?
 echo '<input type="hidden" name= "cla_fecha2" value="'.$fechad.'" >';
 echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
 echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
 echo '<input type="hidden" name= "vengo" value="'.$vengo.'" >';
 echo '<input type="hidden" name= "cla_idguardia" value="'.$idguardia.'" >';
 echo '<input type="hidden" name= "cla_legajo" value="'.$legajo.'" >';


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


