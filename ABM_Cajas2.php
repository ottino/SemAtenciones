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
<TITLE>ABM_Cajas2.php</TITLE>
</HEAD>
<body style="background-color:<?echo $body_color?>">

<BODY>
<FORM METHOD="POST"
ACTION="ABM_Cajas.php">

<?
echo titulo_encabezado ('Alta de Movimientos de Caja' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

  $idcaja = $_POST["pasacajas"];
  $rendicion = $_POST["pasrendicion"];

//Ejecutamos la sentencia SQL
$result=mysql_query("select * from motmovcajas order by 2,3");
$motivos= '<select name="motivos" style="background-color:'.$se_color.'"><option value="0">Motivo deb/cre</option>';
while ($row=mysql_fetch_array($result))
{
$motivos.='<option value="'.$row['id'].'">'.$row['descmotdc'].'</option>';
}
mysql_free_result($result);
$motivos.= '</select>';


if ($rendicion == '1')
  echo ' <table width="100%" border="1" align="left">
  <tr>
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="1" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">
            <th>ID CAJA</th>
            <th>MOTIVO</th>
            <th>IMPORTE</th>
            <th>CLAVE</th>
            <th></th>
        </td>';
  else
   echo ' <table width="100%" border="1" align="left" style="background-color:'.$th_color.'">
    <tr>
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="1" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'" style="background-color:'.$td_color.'">
            <th>ID CAJA</th>
            <th>MOTIVO</th>
            <th>OBSERV.</th>
            <th>IMPORTE</th>
            <th></th>
        </td>';

$fecmov = cambiarFormatoFecha($row['fecmov']);
$horamov = cambiarFormatoHora($row['horamov']);

$importe = $row["importe"];

if ($row["debcre"] == '1')
{   $debcre = "D";
    $saldo = $saldo - $importe;
}  else
{   $debcre = "C";
    $saldo = $saldo + $importe;
}
echo '<tr style="background-color:'.$td_color.'"><td align="center">'.$idcaja.'</td>';

$mensaje  = "DEBITO POR RENDICION";

if ($rendicion =='1')
  echo '<td align="center">'.$mensaje.'</td>';
 else
 { echo '<td align="left">'.$motivos.'</td>';
   echo '<TD><input size= 50 type = "text" name = "cla_observa" /></TD>';
 }

echo '<TD><input size= 10 type = "text" name = "cla_importe" /></TD>';



if ($rendicion =='1')
   {    echo '<TD><input size= 10 type = "password"  name = "cla_clave" /></TD>';
     echo '<input size= 10 type = "hidden" name = "cla_marcaupd" value = "3" />';
   }
else
   echo '<input size= 10 type = "hidden" name = "cla_marcaupd" value = "1" />';


echo '<input size= 10 type = "hidden" name = "cla_idcaja" value = "'.$idcaja.'" />';

echo ' <td width="17" align="center" >
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Insertar\' src="imagenes/INSERTAR.ICO" width="30" height="30"/>
                    </label>
                  </td>';


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


