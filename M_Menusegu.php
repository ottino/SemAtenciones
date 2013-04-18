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

<TITLE>M_Menusegu.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Modificación de Menu Seguridad' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$idsegmenu = $_POST["pasmenu"];
//echo $destino;


echo '<FORM METHOD="POST"
ACTION="M_Menusegu2.php">';

//Creamos la sentencia SQL y la ejecutamos
$sSQL="Select * From segmenu where idsegmenu = ".$idsegmenu;
$result=mysql_query($sSQL);
$row = mysql_fetch_array($result);

//Ejecutamos la sentencia SQL

$p1=$row['p1'];
if ($p1 == 'S')
   $checkp1 = '<label><input type="radio" name="cla_p1" value="S" checked="checked"/>SI</label>
               <label><input type="radio" name="cla_p1" value="N" />NO</label>';
  else
   $checkp1 = '<label><input type="radio" name="cla_p1" value="S" />SI</label>
               <label><input type="radio" name="cla_p1" value="N" checked="checked"/>NO</label>';

$p2=$row['p2'];
if ($p2 == 'S')
   $checkp2 = '<label><input type="radio" name="cla_p2" value="S" checked="checked"/>SI</label>
               <label><input type="radio" name="cla_p2" value="N" />NO</label>';
  else
   $checkp2 = '<label><input type="radio" name="cla_p2" value="S" />SI</label>
               <label><input type="radio" name="cla_p2" value="N" checked="checked"/>NO</label>';

$p3=$row['p3'];
if ($p3 == 'S')
   $checkp3 = '<label><input type="radio" name="cla_p3" value="S" checked="checked"/>SI</label>
               <label><input type="radio" name="cla_p3" value="N" />NO</label>';
  else
   $checkp3 = '<label><input type="radio" name="cla_p3" value="S" />SI</label>
               <label><input type="radio" name="cla_p3" value="N" checked="checked"/>NO</label>';

$p4=$row['p4'];
if ($p4 == 'S')
   $checkp4 = '<label><input type="radio" name="cla_p4" value="S" checked="checked"/>SI</label>
               <label><input type="radio" name="cla_p4" value="N" />NO</label>';
  else
   $checkp4 = '<label><input type="radio" name="cla_p4" value="S" />SI</label>
               <label><input type="radio" name="cla_p4" value="N" checked="checked"/>NO</label>';

$p5=$row['p5'];
if ($p5 == 'S')
   $checkp5 = '<label><input type="radio" name="cla_p5" value="S" checked="checked"/>SI</label>
               <label><input type="radio" name="cla_p5" value="N" />NO</label>';
  else
   $checkp5 = '<label><input type="radio" name="cla_p5" value="S" />SI</label>
               <label><input type="radio" name="cla_p5" value="N" checked="checked"/>NO</label>';

$p6=$row['p6'];
if ($p6 == 'S')
   $checkp6 = '<label><input type="radio" name="cla_p6" value="S" checked="checked"/>SI</label>
               <label><input type="radio" name="cla_p6" value="N" />NO</label>';
  else
   $checkp6 = '<label><input type="radio" name="cla_p6" value="S" />SI</label>
               <label><input type="radio" name="cla_p6" value="N" checked="checked"/>NO</label>';

$p7=$row['p7'];
if ($p7 == 'S')
   $checkp7 = '<label><input type="radio" name="cla_p7" value="S" checked="checked"/>SI</label>
               <label><input type="radio" name="cla_p7" value="N" />NO</label>';
  else
   $checkp7 = '<label><input type="radio" name="cla_p7" value="S" />SI</label>
               <label><input type="radio" name="cla_p7" value="N" checked="checked"/>NO</label>';

$p8=$row['p8'];
if ($p8 == 'S')
   $checkp8 = '<label><input type="radio" name="cla_p8" value="S" checked="checked"/>SI</label>
               <label><input type="radio" name="cla_p8" value="N" />NO</label>';
  else
   $checkp8 = '<label><input type="radio" name="cla_p8" value="S" />SI</label>
               <label><input type="radio" name="cla_p8" value="N" checked="checked"/>NO</label>';

$p9=$row['p9'];
if ($p9 == 'S')
   $checkp9 = '<label><input type="radio" name="cla_p9" value="S" checked="checked"/>SI</label>
               <label><input type="radio" name="cla_p9" value="N" />NO</label>';
  else
   $checkp9 = '<label><input type="radio" name="cla_p9" value="S" />SI</label>
               <label><input type="radio" name="cla_p9" value="N" checked="checked"/>NO</label>';

$p10=$row['p10'];
if ($p10 == 'S')
   $checkp10 = '<label><input type="radio" name="cla_p10" value="S" checked="checked"/>SI</label>
               <label><input type="radio" name="cla_p10" value="N" />NO</label>';
  else
   $checkp10 = '<label><input type="radio" name="cla_p10" value="S" />SI</label>
               <label><input type="radio" name="cla_p10" value="N" checked="checked"/>NO</label>';

$p11=$row['p11'];
if ($p11 == 'S')
   $checkp11 = '<label><input type="radio" name="cla_p11" value="S" checked="checked"/>SI</label>
               <label><input type="radio" name="cla_p11" value="N" />NO</label>';
  else
   $checkp11 = '<label><input type="radio" name="cla_p11" value="S" />SI</label>
               <label><input type="radio" name="cla_p11" value="N" checked="checked"/>NO</label>';

$p12=$row['p12'];
if ($p12 == 'S')
   $checkp12 = '<label><input type="radio" name="cla_p12" value="S" checked="checked"/>SI</label>
               <label><input type="radio" name="cla_p12" value="N" />NO</label>';
  else
   $checkp12 = '<label><input type="radio" name="cla_p12" value="S" />SI</label>
               <label><input type="radio" name="cla_p12" value="N" checked="checked"/>NO</label>';

$p13=$row['p13'];
if ($p13 == 'S')
   $checkp13 = '<label><input type="radio" name="cla_p13" value="S" checked="checked"/>SI</label>
               <label><input type="radio" name="cla_p13" value="N" />NO</label>';
  else
   $checkp13 = '<label><input type="radio" name="cla_p13" value="S" />SI</label>
               <label><input type="radio" name="cla_p13" value="N" checked="checked"/>NO</label>';

$p14=$row['p14'];
if ($p14 == 'S')
   $checkp14 = '<label><input type="radio" name="cla_p14" value="S" checked="checked"/>SI</label>
               <label><input type="radio" name="cla_p14" value="N" />NO</label>';
  else
   $checkp14 = '<label><input type="radio" name="cla_p14" value="S" />SI</label>
               <label><input type="radio" name="cla_p14" value="N" checked="checked"/>NO</label>';

$p15=$row['p15'];
if ($p15 == 'S')
   $checkp15 = '<label><input type="radio" name="cla_p15" value="S" checked="checked"/>SI</label>
               <label><input type="radio" name="cla_p15" value="N" />NO</label>';
  else
   $checkp15 = '<label><input type="radio" name="cla_p15" value="S" />SI</label>
               <label><input type="radio" name="cla_p15" value="N" checked="checked"/>NO</label>';

 echo'<Table>';

 echo '<TR><TD>Página</TD><TD><input size= 50 type = "text" name = "cla_pagina" value = "'.$row[pagina].'" /></TD></TR>';
 echo '<TR><TD>P1</TD><TD>'.$checkp1.'</TD></TR>';
 echo '<TR><TD>P2</TD><TD>'.$checkp2.'</TD></TR>';
 echo '<TR><TD>P3</TD><TD>'.$checkp3.'</TD></TR>';
 echo '<TR><TD>P4</TD><TD>'.$checkp4.'</TD></TR>';
 echo '<TR><TD>P5</TD><TD>'.$checkp5.'</TD></TR>';
 echo '<TR><TD>P6</TD><TD>'.$checkp6.'</TD></TR>';
 echo '<TR><TD>P7</TD><TD>'.$checkp7.'</TD></TR>';
 echo '<TR><TD>P8</TD><TD>'.$checkp8.'</TD></TR>';
 echo '<TR><TD>P9</TD><TD>'.$checkp9.'</TD></TR>';
 echo '<TR><TD>P10</TD><TD>'.$checkp10.'</TD></TR>';
 echo '<TR><TD>P11</TD><TD>'.$checkp11.'</TD></TR>';
 echo '<TR><TD>P12</TD><TD>'.$checkp12.'</TD></TR>';
 echo '<TR><TD>P13</TD><TD>'.$checkp13.'</TD></TR>';
 echo '<TR><TD>P14</TD><TD>'.$checkp14.'</TD></TR>';
 echo '<TR><TD>P15</TD><TD>'.$checkp15.'</TD></TR>';
 echo '<input type="hidden" name= "pasmenu" value="'.$idsegmenu.'" >';

 echo '</table>' ;

?>

    </span></th>
  </tr>
</table>
<br>
</select>

<INPUT name="SUBMIT" TYPE="submit" value="Actualizar"></FORM>
    <th width="769" scope="col">

</FORM>
</div>
   </BODY>
</HTML>