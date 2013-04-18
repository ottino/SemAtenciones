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
<TITLE>B_Menusegu.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Baja de Menues de Seguridad' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$idsegmenu = $_POST["pasmenu"];

echo '<FORM METHOD="POST"
ACTION="B_Menusegu2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="Select * From segmenu where idsegmenu = ".$idsegmenu;
$result=mysql_query($sSQL);

$row=mysql_fetch_array($result);

 echo'<Table>';
 echo '<TR><TD>Programa</TD><TD><input disabled="disabled" size= 20 type = "text" value = "'.$row[pagina].'" /></TD></TR>';
 echo '<TR><TD>P1</TD><TD><input disabled="disabled" size= 3 type = "text" value = "'.$row[p1].'" /></TD></TR>';
 echo '<TR><TD>P2</TD><TD><input disabled="disabled" size= 3 type = "text" value = "'.$row[p2].'" /></TD></TR>';
 echo '<TR><TD>P3</TD><TD><input disabled="disabled" size= 3 type = "text" value = "'.$row[p3].'" /></TD></TR>';
 echo '<TR><TD>P4</TD><TD><input disabled="disabled" size= 3 type = "text" value = "'.$row[p4].'" /></TD></TR>';
 echo '<TR><TD>P5</TD><TD><input disabled="disabled" size= 3 type = "text" value = "'.$row[p5].'" /></TD></TR>';
 echo '<TR><TD>P6</TD><TD><input disabled="disabled" size= 3 type = "text" value = "'.$row[p6].'" /></TD></TR>';
 echo '<TR><TD>P7</TD><TD><input disabled="disabled" size= 3 type = "text" value = "'.$row[p7].'" /></TD></TR>';
 echo '<TR><TD>P8</TD><TD><input disabled="disabled" size= 3 type = "text" value = "'.$row[p8].'" /></TD></TR>';
 echo '<TR><TD>P9</TD><TD><input disabled="disabled" size= 3 type = "text" value = "'.$row[p9].'" /></TD></TR>';
 echo '<TR><TD>P10</TD><TD><input disabled="disabled" size= 3 type = "text" value = "'.$row[p10].'" /></TD></TR>';
 echo '<TR><TD>P11</TD><TD><input disabled="disabled" size= 3 type = "text" value = "'.$row[p11].'" /></TD></TR>';
 echo '<TR><TD>P12</TD><TD><input disabled="disabled" size= 3 type = "text" value = "'.$row[p12].'" /></TD></TR>';
 echo '<TR><TD>P13</TD><TD><input disabled="disabled" size= 3 type = "text" value = "'.$row[p13].'" /></TD></TR>';
 echo '<TR><TD>P14</TD><TD><input disabled="disabled" size= 3 type = "text" value = "'.$row[p14].'" /></TD></TR>';
 echo '<TR><TD>P15</TD><TD><input disabled="disabled" size= 3 type = "text" value = "'.$row[p15].'" /></TD></TR>';
 echo '<input type="hidden" name= "pasmenu" value="'.$row[idsegmenu].'" >';

 echo '</table>' ;

mysql_free_result($result);


?>
    </span></th>
  </tr>
</table>
<br>
</select>
<INPUT TYPE="SUBMIT" value="Borrar">
</FORM>
</div>
</BODY>
</HTML>