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
<TITLE>A_Planes.php</TITLE>
</HEAD>
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


<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Alta de Planes' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
?>


<br>
<FORM METHOD="POST"
ACTION="A_Planes2.php">

<?
$result=mysql_query("SELECT * FROM tipoplan order by 1");
$tipoplan.='<option selected="selected" value="">Seleccione Tipo Plan</option>';
while ($row=mysql_fetch_array($result))
{
$tipoplan.='<option value="'.$row['idtipoplan'].'">'.$row['desctipoplan'].'</option>';
}
mysql_free_result($result);


 echo'<Table>';
echo '<TR><TD>ID Plan</TD><TD><input size= 6 type = "text" name = "idplan" /></TD></TR>';
echo '<TR><TD>Descripción</TD><TD><input size= 50 type = "text" name = "descplan" /></TD></TR>';
echo '<TR><TD>Tipo Plan</TD><TD><select name="codigoplan">'.$tipoplan.'</select></TD></TR>';
echo '<TR><TD>Contacto</TD><TD><input size= 50 type = "text" name = "contacto" /></TD></TR>';
echo '<TR><TD>Contacto</TD><TD><input size= 50 type = "text" name = "contacto1" /></TD></TR>';
echo '<TR><TD><input type="text" name="cla_fecha" id="cla_fecha" size="10" /></TD><TD><input type="button" id="lanzador" value="Fecha Alta" onclick="calendario();"/></td>';
echo '<TD>Imp Unico/Anual</TD><TD><input size= 8 type = "text" name = "imp1" /></TD>';
echo '<TD>Importe1</TD><TD><input size= 8 type = "text" name = "imp2" /></TD>';
echo '<TD>Importe2</TD><TD><input size= 8 type = "text" name = "imp3" /></TD>';
echo '<TD>Importe3</TD><TD><input size= 8 type = "text" name = "imp4" /></TD>';
echo '<TD>Importe4</TD><TD><input size= 8 type = "text" name = "imp5" /></TD></TR>';
echo '<TR><TD><input type="text" name="cla_fecha1" id="cla_fecha1" size="10" /></TD><TD><input type="button" id="lanzador1" value="Fecha Baja" onclick="calendario1();"/></td>';

echo '<TD>Importe5</TD><TD><input size= 8 type = "text" name = "imp6" /></TD>';
echo '<TD>Importe6</TD><TD><input size= 8 type = "text" name = "imp7" /></TD>';
echo '<TD>Importe7</TD><TD><input size= 8 type = "text" name = "imp8" /></TD>';
echo '<TD>Importe8</TD><TD><input size= 8 type = "text" name = "imp9" /></TD>';
echo '<TD>Importe9</TD><TD><input size= 8 type = "text" name = "imp10" /></TD></TR>';
echo '<TR><TD>Desc Abrev</TD><TD><input size= 20 type = "text" name = "descabrev" /></TD>';
echo '<TD>Importe10</TD><TD><input size= 8 type = "text" name = "imp11" /></TD>';
echo '<TD>Importe11</TD><TD><input size= 8 type = "text" name = "imp12" /></TD>';
echo '<TD>Importe12</TD><TD><input size= 8 type = "text" name = "imp13" /></TD>';
echo '<TD>Importe13</TD><TD><input size= 8 type = "text" name = "imp14" /></TD>';
echo '<TD>Importe14</TD><TD><input size= 8 type = "text" name = "imp15" /></TD></TR>';
echo '<TR><TD>Frecuencia</TD><TD><input size= 3 type = "text" name = "frecuencia" /></TD><TD>Importe15</TD>';
echo '<TD><input size= 8 type = "text" name = "imp16" /></TD>';
echo '<TD>Importe16</TD><TD><input size= 8 type = "text" name = "imp17" /></TD>';
echo '<TD>Importe17</TD><TD><input size= 8 type = "text" name = "imp18" /></TD>';
echo '<TD>Importe18</TD><TD><input size= 8 type = "text" name = "imp19" /></TD>';
echo '<TD>Importe19</TD><TD><input size= 8 type = "text" name = "imp20" /></TD></TR>';
echo '<TR><TD>Estado</TD><TD><input size= 3 type = "text" name = "estado" /></TD>';
echo '<TD>Coseguro</TD><TD><input size= 8 type = "text" name = "impcoseguro" /></TD>';
echo '<TD>Cn Excede</TD><TD><input size= 8 type = "text" name = "cla_cnexcede" /></TD>';
echo '<TD>$ Excede</TD><TD><input size= 8 type = "text" name = "cla_impexcede" /></TD></TR>';
echo '</table>' ;
echo '<table>' ;
echo '<TR><TD>Instructivo</TD><TD><textarea name="datos" rows="10" cols="80"></textarea></TD></TR>';
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


