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
<TITLE>ABM_Cobranzas.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>


<?
echo titulo_encabezado ('Modulo de Cajas Cerradas' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
$legajo = $G_legajo;

$pasaid = $_POST["pasaid"];



//Ejecutamos la sentencia SQL
$aSQL="select max(lnrolote) as maximo from lotes";
$resultmax=mysql_query("select max(lnrolote) as maximo from lotes");
$rowmax=mysql_fetch_array($resultmax);
$ultlote = $rowmax["maximo"] +0;
mysql_free_result($resultmax);
$maxlote = round(($rowmax["maximo"]),0);

if ($pasaid > $maxlote || $pasaid < 1)
   {
     $pasaid = $maxlote;
   };

     $idbase = $pasaid;

$sSQL= "select * from lotes a, cobrador b WHERE a.lidcobrador = b.idcob and lnrolote <= ".$idbase." order by lnrolote desc limit 0,20";
$result=mysql_query($sSQL);


     $antpag = $idbase +20;
     $propag = $idbase -20;


//echo $row['id'];
echo '<table width="100%" border="1" align="left" ><tr><td>';
echo '<table width="100%" border="1" align="left" ><tr>';
     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="A_Cobranzas0.php">';
     echo ' <td width="40" align="center">
                     <label onclick="this.form.submit();" style="cursor:pointer;">
                      <img align="middle" alt=\'Volver\' src="imagenes/Ingreso.ico" width="30" height="30"/>
                     </label></td>';
     echo '</FORM></TD>';

     echo '<td style="width:2000px"><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td>';
     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Cobranzas.php">';
     echo '<input type="hidden" name= "pasaid" value  = "20" >';
     echo '<input type="hidden" name= "marca" value  ="0" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();"  style="CURSOR: pointer" >
                      <img align="middle" alt=\'Inicio\' src="imagenes/117.ico" width="30" height="30"/>
                     </label></td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Cobranzas.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$propag.'" >';
     echo '<input type="hidden" name= "marca" value  ="0" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();"  style="CURSOR: pointer" >
                      <img align="middle" alt=\'Pag Anterior\' src="imagenes/118.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Cobranzas.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$antpag.'" >';
     echo '<input type="hidden" name= "marca" value  ="0" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();"  style="CURSOR: pointer" >
                      <img align="middle" alt=\'Pag Posterior\' src="imagenes/119.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Cobranzas.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$ultlote.'" >';
     echo '<input type="hidden" name= "marca" value  ="0" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'" >
                     <label onclick="this.form.submit();"  style="CURSOR: pointer" >
                      <img align="middle" alt=\'Final\' src="imagenes/120.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Cobranzas.php">';
     echo '<input type="text" name= "pasaid" >';
     echo '<input type="hidden" name= "marca" value  ="1" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'" >
                     <label onclick="this.form.submit();"  style="CURSOR: pointer" >
                      <img align="middle" alt=\'Ir a\' src="imagenes/120.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM>';
     echo '</tr></table></td></tr><tr><td>';


echo '<table><tr><td>
  <table width="100%" border="1" align="left">
  <tr style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$td_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
         <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">
            <th>LOTE</th>
            <th>RECEPCION</th>
            <th>GRABACION</th>
            <th>COBRADOR</th>
            <th>CUPONES</th>
            <th>BRUTO</th>
            <th>COMISION</th>
            <th>NETO</th>
            <th>ESTADO</th>
        </td></tr>';

//Mostramos los registros
while ($row=mysql_fetch_array($result))
{

$nrolote = $row['lnrolote'];
$fecrendi = $row['lfecrecep'];
$fecgraba = $row['lfecgrab'];
$ltotal   = $row['limporte'];
$lcomis   = $row['lcomision'];
$lneto    = $row['lmontoneto'];
$cncupones= $row['cncupones'];
$lestado  = $row['lestado'];
$cobrador = $row['lidcobrador'];
$desccobrador = $row['desccob'];


$afecrendi = cambiarFormatoFecha($fecrendi);
$afecgraba = cambiarFormatoFecha($fecgraba);
$cla_anula = 'P';

 echo '<TR><td align="center">'.$nrolote.'</td>';
 echo '<td align="center">'.$afecrendi.'</td>';
 echo '<td align="center">'.$afecgraba.'</td>';
 echo '<td align="left">'.$desccobrador.'</td>';
 echo '<td align="center">'.$cncupones.'</td>';
 echo '<td align="center">'.number_format($ltotal,2).'</td>';
 echo '<td align="center">'.number_format($lcomis,2).'</td>';
 echo '<td align="center">'.number_format($lneto,2).'</td>';
 echo '<td align="center">'.$lestado.'</td>';
 echo '<FORM METHOD="POST" NAME="formulario2" ACTION="A_Cobranzas1.php">';
 echo '<input type="hidden" name= "cla_nrolote" value="'.$nrolote.'" >';
 echo '<input type="hidden" name= "cla_vengo" value="CIERRE" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Continuar\' src="imagenes/INSERTAR.ICO" width="20" height="20"/>
                    </label>
                  </td>';
 echo '</FORM>';


}
echo '</TR></table></table></td></tr>' ;

mysql_free_result($result);





?>

</table>


</BODY>
</HTML>