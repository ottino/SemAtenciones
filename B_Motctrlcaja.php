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
<TITLE>B_Motctrlcaja.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Baja de Motivos de Mov Caja' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$motivos = $_POST["pasmotivo"];

//echo $motivos;

echo '<FORM METHOD="POST"
ACTION="B_Motctrlcaja2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="Select * From cjmotivos where cjmotid = ".$motivos;

$result=mysql_query($sSQL);

while ($row=mysql_fetch_array($result))
{echo'<Table>';
 echo '<input type="hidden" name= "desc" value="'.$row["cjmotid"].'" >';
 echo '<TR><TD>CODIGO</TD><TD><input disabled="disabled" size= 50 type = "text" name = "clave" value = "'.$row[cjmotcodigo].'-'.$row[cjmotdesc].'"/></TD></TR>';
 echo '</table>' ;
}

mysql_free_result($result)


?>
    </span></th>
  </tr>
</table>
<br>
</select>
<INPUT TYPE="SUBMIT" value="Borrar">
</FORM>

<FORM METHOD="POST" ACTION="ABM_Motctrlcaja.php">

<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>

</div>
</BODY>
</HTML>