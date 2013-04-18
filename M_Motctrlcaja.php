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
<TITLE>ABM_Motctrlcaja.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Modificación de Motivos de Mov Caja' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }


$motivos = $_POST["pasmotivo"];
//echo $motivos;

$sSQL="Select * From cjmotivos where cjmotid = ".$motivos;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);
$id=$row['cjmotid'];
$codigo=$row['cjmotcodigo'];
$descripcion=$row['cjmotdesc'];

echo '<FORM METHOD="POST"
ACTION="M_Motctrlcaja2.php">';
//Creamos la sentencia SQL y la ejecutamos

echo'<Table>';
 echo '<input type="hidden" name= "desc" value="'.$id.'" >';
 echo '<TR><TD>CODIGO</TD><TD><input size= 5 type = "text" name = "clave" value = "'.$row[cjmotcodigo].'"/></TD></TR>';
 echo '<TR><TD>DESCRIPCION</TD><TD><input size= 50 type = "text" name = "descripcion" value = "'.$row[cjmotdesc].'"/></TD></TR>';
 echo '</table>' ;

?>
    </span></th>
  </tr>
</table>
<br>
</select>

<INPUT name="SUBMIT" TYPE="submit" value="Actualizar"></FORM>


<FORM METHOD="POST" ACTION="ABM_Motctrlcaja.php">

<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>

</FORM>
</div>
   </BODY>
</HTML>