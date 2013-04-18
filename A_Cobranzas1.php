<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');

require_once("cookie.php");
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
?>


<HTML>
<HEAD>
<TITLE>A_Cobranzas1.php</TITLE>

</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Carga de Cobranzas por Lote' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$idcobrador = $_POST["cla_cobrador"];
$nrolote    = $_POST["cla_nrolote"];

$fechad = $_POST["cla_fecha"];

if (substr($fechad,2,1) == "/")
    $fechad = cambiarFormatoFecha2($fechad);


if ($nrolote < '1')
   $nrolote    = $_GET["cla_nrolote"];
   $estado     = "A";
////////////////////////////////

//Creamos la sentencia SQL y la ejecutamos

if ($nrolote < '1')
 {
  $hoy   = date("Y-m-d");
  $sSQL="insert into lotes (lfecgrab, lfecrecep, lidcobrador,lestado, llegajo)
      values ('".$hoy."','".$fechad."','".$idcobrador."','".$estado."','".$G_legajo."')";

  mysql_query($sSQL);

  $aSQL="select max(lnrolote) as maximo from lotes";
  $aresult=mysql_query($aSQL);
  $arow=mysql_fetch_array($aresult);
  $nrolote = $arow['maximo'];
 };

$sSQL="select * from lotes where lnrolote = ".$nrolote;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$fecrendi = $row['lfecrecep'];
$fecgraba = $row['lfecgrab'];
$ltotal   = $row['limporte'];
$lcomis   = $row['lcomision'];
$lneto    = $row['lmontoneto'];
$cncupones= $row['cncupones'];
$lestado  = $row['lestado'];
$cobrador = $row['lidcobrador'];

$ySQL="select * from cobrador where idcob = ".$cobrador;
$yresult=mysql_query($ySQL);
$yrow=mysql_fetch_array($yresult);

$desccobrador = $yrow['desccob'];


$afecrendi = cambiarFormatoFecha($fecrendi);
$afecgraba = cambiarFormatoFecha($fecgraba);
$cla_anula = 'P';

echo '
<table width="100%" border="1" align="left" style="font-size:'.$fontreg.'">
 <TR style="background-color:'.$td_color.'">
<td><table width="100%" border="1" align="left" style="font-size:'.$fontreg.'">
  <TR style="background-color:'.$td_color.'">';

     echo '<td width="40"><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()" style="cursor:pointer;"></td>';
     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Cobranzas.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$nrolote.'" >';
     echo ' <td width="40" align="center">
                     <label onclick="this.form.submit();" style="cursor:pointer;">
                      <img align="middle" alt=\'Volver\' src="imagenes/Volver.ico" width="30" height="30"/>
                     </label></td>';
     echo '</FORM></TD>';

    echo '
    <td rowspan =3 colspan=2 ><FORM METHOD="POST" NAME="formulario3" ACTION="A_Cobranzas2.php">
        <table border="1" align="center" style="font-size:'.$fontreg.'">
          <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">
            <th>INGRESO COMPROB</th></TR>
            <TR><TD align="center"><input size= 20 type = "text" name = "cla_nrocupon" /></TD></TR>
            <TR><TD align="center"><label><input type="radio" name="cla_anula" value="P" checked="checked" />Pago</label>
                                          <label><input type="radio" name="cla_anula" value="A" />Anula</label></TD></TR>
            <TR><td><input size= 10 type = "hidden" name = "cla_fecrendi" value = "'.$fecrendi.'" /><td><TR>
            <TR><td><input size= 10 type = "hidden" name = "cla_fecgraba" value = "'.$fecgraba.'" /><td><TR>
            <TR><td><input size= 10 type = "hidden" name = "cla_nrolote" value = "'.$nrolote.'" /><td><TR>
            <TR><td><input size= 10 type = "hidden" name = "cla_idcob" value = "'.$cobrador.'" /><td><TR>
            <TR><td><input size= 10 type = "hidden" name = "cla_vengo" value = "CUPON" /><td><TR> ';
     if ($lestado == 'A')
           echo '<TR><td align="center" ><INPUT TYPE="SUBMIT" value="Ingreso Cupón" style="cursor:pointer;"></td></TR>';

echo '
   </FORM></TABLE></TD>
    </tr><TR style="background-color:'.$td_color.'">
     <td width="80%" rowspan="3" valign="top">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="2" width="100%" cellpadding="2" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'">
            <th>LOTE</th>
            <th>RECEPCION</th>
            <th>GRABACION</th>
            <th>COBRADOR</th>
            <th>CUPONES</th>
            <th>BRUTO</th>
            <th>COMISION</th>
            <th>NETO</th>
            <th>ESTADO</th>
            <th>CIERRE</th>
        </td></tr>';


 echo '<TR><td align="center">'.$nrolote.'</td>';
 echo '<td align="center">'.$afecrendi.'</td>';
 echo '<td align="center">'.$afecgraba.'</td>';
 echo '<td align="left">'.$desccobrador.'</td>';
 echo '<td align="center">'.$cncupones.'</td>';
 echo '<td align="center">'.number_format($ltotal,2).'</td>';
 echo '<td align="center">'.number_format($lcomis,2).'</td>';
 echo '<td align="center">'.number_format($lneto,2).'</td>';
 echo '<td align="center">'.$lestado.'</td>';
 echo '<FORM METHOD="POST" NAME="formulario2" ACTION="A_Cobranzas2.php">';
 echo '<input type="hidden" name= "cla_nrolote" value="'.$nrolote.'" >';
 echo '<input type="hidden" name= "cla_vengo" value="CIERRE" >';

 if ($lestado == 'A')
 echo ' <td width="17" align="center" style="background-color:'.$body_color.'">
                    <INPUT TYPE="SUBMIT" value="Cierre" style="cursor:pointer;"> </td></tr>';
 echo '</FORM>';


 echo '</TABLE></table></td></tr>' ;


$sSQL="select *, a.estado as esta from cobranzas a, cobrador b, comprobantes c, contratos d, clientes e where
       a.cidcobrador = b.idcob and a.cidcomprob = c.idcomprob and c.idcontrato = d.idcontrato and
       d.idcliente = e.idcliente and cnrolote = ".$nrolote." order by idcobranzas";

$result=mysql_query($sSQL);

echo '
  <TR style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="0" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0" >
          <tr style="font-size:'.$fontt.'">
            <th>CUPON</th>
            <th>NOMBRE</th>
            <th>IMPORTE</th>
            <th>COMIS.</th>
            <th>NETO</th>
            <th>ESTADO</th>
            <th>CONS</th>
        </td>';


//Mostramos los registros
$c = 0;
$anulados = 0;
$timporte  = 0;
$tcomision = 0;
$tneto     = 0;

while ($row=mysql_fetch_array($result))
{

$afecrendi = cambiarFormatoFecha($row['fecrecep']);
$afecgraba = cambiarFormatoFecha($row['fecgrab']);

$id = $row["id"] + 0;
$timporte  = $timporte +  $row["cimporte"];
$tcomision = $tcomision + $row["ccomision"];
$tneto     = $tneto     + $row["cmontoneto"];

echo '<tr><td align="center">'.$row['cidcomprob'].'</td>';
echo '<td align="left">'.$row["nombre"].'</td>';
echo '<td align="right">'.number_format($row["cimporte"],2).'</td>';
echo '<td align="right">'.number_format($row["ccomision"],2).'</td>';
echo '<td align="right">'.number_format($row["cmontoneto"],2).'</td>';
echo '<td align="center">'.$row["esta"].'</td>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="C_Facturas.php">';
echo '<input type="hidden" name= "pasafact" value="'.$row['cidcomprob'].'" >';
echo '<input type="hidden" name= "cla_nrolote" value="'.$nrolote.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.';" >
                    <label onclick="this.form.submit();" style="cursor:pointer;">
                     <img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="15" height="15"/>
                    </label>
                  </td>';
echo '</FORM></tr>';


}
echo '<tr><td align="center">'.$row['cidcomprob'].'</td>';
echo '<td align="left">TOTAL</td>';
echo '<td align="right">'.number_format($timporte,2).'</td>';
echo '<td align="right">'.number_format($tcomision,2).'</td>';
echo '<td align="right">'.number_format($tneto,2).'</td>';
echo '<td align="center">'.$row["esta"].'</td>';

echo '</TR></table></table></td></tr></table>' ;
mysql_free_result($result);
?>

</FORM>
</BODY>
</HTML>