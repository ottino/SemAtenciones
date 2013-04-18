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

<TITLE>A_Menusegu.php</TITLE>
</HEAD>
<script>
</script>
<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Alta de Menues de Seguridad' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

echo '
<br>
<FORM METHOD="POST" name="formulario"
ACTION="A_Menusegu2.php">';


 echo'<Table>';
 echo '<TR><TD>Programa</TD><TD><input size= 20 type="text" name= "pagina" ></TD></TR>';

 echo '<TD>P1</TD><TD><label><input type="radio" name="cla_p1" value="S" />SI</label>
                      <label><input type="radio" name="cla_p1" value="N" checked="checked"/>NO</label></TD></TR>';
 echo '<TD>P2</TD><TD><label><input type="radio" name="cla_p2" value="S" />SI</label>
                      <label><input type="radio" name="cla_p2" value="N" checked="checked"/>NO</label></TD></TR>';
 echo '<TD>P3</TD><TD><label><input type="radio" name="cla_p3" value="S" />SI</label>
                      <label><input type="radio" name="cla_p3" value="N" checked="checked"/>NO</label></TD></TR>';
 echo '<TD>P4</TD><TD><label><input type="radio" name="cla_p4" value="S" />SI</label>
                      <label><input type="radio" name="cla_p4" value="N" checked="checked"/>NO</label></TD></TR>';
 echo '<TD>P5</TD><TD><label><input type="radio" name="cla_p5" value="S" />SI</label>
                      <label><input type="radio" name="cla_p5" value="N" checked="checked"/>NO</label></TD></TR>';
 echo '<TD>P6</TD><TD><label><input type="radio" name="cla_p6" value="S" />SI</label>
                      <label><input type="radio" name="cla_p6" value="N" checked="checked"/>NO</label></TD></TR>';
 echo '<TD>P7</TD><TD><label><input type="radio" name="cla_p7" value="S" />SI</label>
                      <label><input type="radio" name="cla_p7" value="N" checked="checked"/>NO</label></TD></TR>';
 echo '<TD>P8</TD><TD><label><input type="radio" name="cla_p8" value="S" />SI</label>
                      <label><input type="radio" name="cla_p8" value="N" checked="checked"/>NO</label></TD></TR>';
 echo '<TD>P9</TD><TD><label><input type="radio" name="cla_p9" value="S" />SI</label>
                      <label><input type="radio" name="cla_p9" value="N" checked="checked"/>NO</label></TD></TR>';
 echo '<TD>P10</TD><TD><label><input type="radio" name="cla_p10" value="S" />SI</label>
                       <label><input type="radio" name="cla_p10" value="N" checked="checked"/>NO</label></TD></TR>';
 echo '<TD>P11</TD><TD><label><input type="radio" name="cla_p11" value="S" />SI</label>
                       <label><input type="radio" name="cla_p11" value="N" checked="checked"/>NO</label></TD></TR>';
 echo '<TD>P12</TD><TD><label><input type="radio" name="cla_p12" value="S" />SI</label>
                       <label><input type="radio" name="cla_p12" value="N" checked="checked"/>NO</label></TD></TR>';
 echo '<TD>P13</TD><TD><label><input type="radio" name="cla_p13" value="S" />SI</label>
                       <label><input type="radio" name="cla_p13" value="N" checked="checked"/>NO</label></TD></TR>';
 echo '<TD>P14</TD><TD><label><input type="radio" name="cla_p14" value="S" />SI</label>
                       <label><input type="radio" name="cla_p14" value="N" checked="checked"/>NO</label></TD></TR>';
 echo '<TD>P15</TD><TD><label><input type="radio" name="cla_p15" value="S" />SI</label>
                       <label><input type="radio" name="cla_p15" value="N" checked="checked"/>NO</label></TD></TR>';
echo '</table>' ;




?>
<td><INPUT TYPE="SUBMIT" value="Agregar"></td>


    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
   </BODY>
</HTML>


