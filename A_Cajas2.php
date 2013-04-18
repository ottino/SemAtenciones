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
<TITLE>A_Cajas2.php</TITLE>
</HEAD>
<body style="background-color:<?echo $body_color?>">

<BODY>
<FORM METHOD="POST"
ACTION="ABM_Cajas.php">

<?
echo titulo_encabezado ('Alta de Cajas' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$idcajaant = $_POST["cajas"];

//Ejecutamos la sentencia SQL
$sSQL="select * from cajas a, legajos b WHERE a.legajo = b.legajo and a.estado < 1 and a.idcaja = ".$idcajaant;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$fecmov = cambiarFormatoFecha($row['fapertura']);

$usuario = buscopersonal($row['legajo']);
$saldo = $row['saldocierre'];

$legajo = $row['legajo'];

mysql_free_result($result);



echo '
  <table width="100%" border="1" align="left">
  <tr>
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
         <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">
            <th>ID CAJA</th>
            <th>CAJA ANTERIOR</th>
            <th>FECHA APERTURA</th>
            <th>SALDO ARRASTRE</th>
            <th>CLAVE CAJA ANT.</th>
        </td>';


echo '<tr style="background-color:'.$td_color.'"><td align="center">'.$idcajaant.'</td>';
echo '<td align="left">'.$usuario.'</td>';
echo '<td align="center">'.$fecmov.'</td>';
echo '<td align="center">'.$saldo.'</td>';
echo '<TD><input size= 10 type = "password" name = "cla_clave" /></TD>';
echo '<TD><input size= 10 type = "hidden" name = "cla_marcaupd" value = "2" />';
echo '<input size= 10 type = "hidden" name = "cla_legajo" value = "'.$legajo.'" />';
echo '<input size= 10 type = "hidden" name = "cla_saldo" value = "'.$saldo.'" />';
echo '<input size= 10 type = "hidden" name = "cla_idcaja" value = "'.$idcajaant.'" /></TD>';

echo ' <td width="17" align="center" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                    <label onclick="this.form.submit();">
                     <img align="middle" alt=\'Insertar\' src="imagenes/INSERTAR.ICO" width="30" height="30"/>
                    </label>
                  </td></TR>';


//echo '<TD><INPUT TYPE="SUBMIT" value="Insertar"></TD>';
echo '</table>' ;


?>

    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
   </BODY>
</HTML>


