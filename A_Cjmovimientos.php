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
<TITLE>A_Cjmovimientos.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Alta de Movimientos de Caja' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$fecha = $_POST["cla_fecha"];
$tipomov = $_POST["cla_tipomov"];
$pasaid = $_POST["cla_pasaid"];

//echo $tipomov;

if ($tipomov == 'B')
   $dtipomov = 'BANCO';

if ($tipomov == 'C')
   $dtipomov = 'CHEQUE';

if ($tipomov == 'E')
   $dtipomov = 'EFECTIVO';


$fechad =  cambiarFormatoFecha($fecha);

$result=mysql_query("select * from cjmotivos where cjmotcodigo <> 208 and cjmotcodigo <> 108 order by 2");
$motivos= '<select name="cla_motivos" style="background-color:'.$se_color.'"><option value="0">Motivo</option>';
while ($row=mysql_fetch_array($result))
{
$motivos.='<option value="'.$row['cjmotcodigo'].'">'.$row['cjmotdesc'].' - '.$row['cjmotcodigo'].'</option>';
}
mysql_free_result($result);
$motivos.= '</select>';

$result=mysql_query("select * from cjmotivos where cjmotcodigo <> 208 and cjmotcodigo <> 108 order by 2");
$motivos1= '<select name="cla_motivos1" style="background-color:'.$se_color.'"><option value="0">Motivo</option>';
while ($row=mysql_fetch_array($result))
{
$motivos1.='<option value="'.$row['cjmotcodigo'].'">'.$row['cjmotdesc'].' - '.$row['cjmotcodigo'].'</option>';
}
mysql_free_result($result);
$motivos1.= '</select>';

$result=mysql_query("select * from cjmotivos where cjmotcodigo <> 208 and cjmotcodigo <> 108 order by 2");
$motivos2= '<select name="cla_motivos2" style="background-color:'.$se_color.'"><option value="0">Motivo</option>';
while ($row=mysql_fetch_array($result))
{
$motivos2.='<option value="'.$row['cjmotcodigo'].'">'.$row['cjmotdesc'].' - '.$row['cjmotcodigo'].'</option>';
}
mysql_free_result($result);
$motivos2.= '</select>';

$result=mysql_query("select * from cjmotivos where cjmotcodigo <> 208 and cjmotcodigo <> 108 order by 2");
$motivos3= '<select name="cla_motivos3" style="background-color:'.$se_color.'"><option value="0">Motivo</option>';
while ($row=mysql_fetch_array($result))
{
$motivos3.='<option value="'.$row['cjmotcodigo'].'">'.$row['cjmotdesc'].' - '.$row['cjmotcodigo'].'</option>';
}
mysql_free_result($result);
$motivos3.= '</select>';

$result=mysql_query("select * from cjmotivos where cjmotcodigo <> 208 and cjmotcodigo <> 108 order by 2");
$motivos4= '<select name="cla_motivos4" style="background-color:'.$se_color.'"><option value="0">Motivo</option>';
while ($row=mysql_fetch_array($result))
{
$motivos4.='<option value="'.$row['cjmotcodigo'].'">'.$row['cjmotdesc'].' - '.$row['cjmotcodigo'].'</option>';
}
mysql_free_result($result);
$motivos4.= '</select>';

?>


<br>
<FORM METHOD="POST"
ACTION="A_Cjmovimientos2.php">

<?
 echo'<Table>';
 echo '<TR><TD>MOVIMIENTO DE</TD><TD>'.$dtipomov.'</TD></TR>';
 echo '<input type="hidden" name= "cla_tipomov" value="'.$tipomov.'" >';
 echo '<TR><TD>FECHA</TD><TD><input disabled="disabled" size= 8 type = "text" name = "cla_fechad" value = "'.$fechad.'"/></TD></TR>';
 echo '<input type="hidden" name= "cla_fecha" value="'.$fecha.'" >';
 echo '<TR><TD>MOTIVO</TD><TD>'.$motivos.'</TD>';
 echo '<TD>IMPORTE</TD><TD><input size= 10 type = "text" name = "cla_importe" /></TD>';
 echo '<TD>NRO OPERAC</TD><TD><input size= 10 type = "text" name = "cla_nroopera" /></TD>';
 echo '<TD>OBSERVACIONES</TD><TD><input size= 50 type = "text" name = "cla_observaciones" /></TD></TR>';

 echo '<input type="hidden" name= "cla_tipomov1" value="'.$tipomov.'" >';
 echo '<TR><TD></TD><TD>'.$motivos1.'</TD>';
 echo '<TD></TD><TD><input size= 10 type = "text" name = "cla_importe1" /></TD>';
 echo '<TD></TD><TD><input size= 10 type = "text" name = "cla_nroopera1" /></TD>';
 echo '<TD></TD><TD><input size= 50 type = "text" name = "cla_observaciones1" /></TD></TR>';

 echo '<input type="hidden" name= "cla_tipomov2" value="'.$tipomov.'" >';
 echo '<TR><TD></TD><TD>'.$motivos2.'</TD>';
 echo '<TD></TD><TD><input size= 10 type = "text" name = "cla_importe2" /></TD>';
 echo '<TD></TD><TD><input size= 10 type = "text" name = "cla_nroopera2" /></TD>';
 echo '<TD></TD><TD><input size= 50 type = "text" name = "cla_observaciones2" /></TD></TR>';

 echo '<input type="hidden" name= "cla_tipomov3" value="'.$tipomov.'" >';
 echo '<TR><TD></TD><TD>'.$motivos3.'</TD>';
 echo '<TD></TD><TD><input size= 10 type = "text" name = "cla_importe3" /></TD>';
 echo '<TD></TD><TD><input size= 10 type = "text" name = "cla_nroopera3" /></TD>';
 echo '<TD></TD><TD><input size= 50 type = "text" name = "cla_observaciones3" /></TD></TR>';

 echo '<input type="hidden" name= "cla_tipomov4" value="'.$tipomov.'" >';
 echo '<TR><TD></TD><TD>'.$motivos4.'</TD>';
 echo '<TD></TD><TD><input size= 10 type = "text" name = "cla_importe4" /></TD>';
 echo '<TD></TD><TD><input size= 10 type = "text" name = "cla_nroopera4" /></TD>';
 echo '<TD></TD><TD><input size= 50 type = "text" name = "cla_observaciones4" /></TD></TR>';

 echo '</table>' ;
?>

<INPUT TYPE="SUBMIT" value="Insertar"></FORM>

<?
echo '<FORM METHOD="POST" ACTION="A_Ctrlcaja.php">';
echo '<input type="hidden" name= "pasaid" value="'.$pasaid.'" >';
?>
<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>


    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
   </BODY>
</HTML>


