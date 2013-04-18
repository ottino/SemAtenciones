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
<TITLE>ABM_Cajascerr.php</TITLE>
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

$marcaupd = '0';
$marcaupd = $_POST["cla_marcaupd"];
$pasaid = $_POST["pasaid"];



//Ejecutamos la sentencia SQL

$resultmax=mysql_query("select max(idcaja) as id from cajas where estado = '1'");
$rowmax=mysql_fetch_array($resultmax);
$ultcaja = $rowmax["id"] +0;
mysql_free_result($resultmax);
$ultpag = round(($ultcaja),0);

if ($pasaid > $ultpag || $pasaid < 1)
   {
     $pasaid = $ultpag;
     $idbase = $ultpag;
   };

     $idbase = $pasaid;

if ($G_perfil == '1' || $G_perfil == '3')
    $sSQL= "select * from cajas a, legajos b WHERE a.legajo = b.legajo and
                         idcaja <= ".$idbase." and a.estado = 1 order by idcaja desc limit 0,20";
else
     $sSQL= "select * from cajas a, legajos b WHERE a.legajo = b.legajo and
                         idcaja <= ".$idbase." and a.estado = 1 and a.legajo = ".$G_legajo." order by idcaja desc limit 0,20";
$result=mysql_query($sSQL);


     $antpag = $idbase +20;
     $propag = $idbase -20;


//echo $row['id'];
echo '<table width="100%" border="1" align="left" ><tr><td>';
echo '<table width="100%" border="1" align="left" ><tr>
    <td style="width:2000px"><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td>';
     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Cajascerr.php">';
     echo '<input type="hidden" name= "pasaid" value  = "40" >';
     echo '<input type="hidden" name= "marca" value  ="0" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();"  style="CURSOR: pointer" >
                      <img align="middle" alt=\'Inicio\' src="imagenes/117.ico" width="30" height="30"/>
                     </label></td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Cajascerr.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$propag.'" >';
     echo '<input type="hidden" name= "marca" value  ="0" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();"  style="CURSOR: pointer" >
                      <img align="middle" alt=\'Pag Anterior\' src="imagenes/118.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Cajascerr.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$antpag.'" >';
     echo '<input type="hidden" name= "marca" value  ="0" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();"  style="CURSOR: pointer" >
                      <img align="middle" alt=\'Pag Posterior\' src="imagenes/119.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Cajascerr.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$ultcaja.'" >';
     echo '<input type="hidden" name= "marca" value  ="0" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'" >
                     <label onclick="this.form.submit();"  style="CURSOR: pointer" >
                      <img align="middle" alt=\'Final\' src="imagenes/120.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Cajascerr.php">';
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
            <th>ID</th>
            <th>USUARIO</th>
            <th>F.APERTURA</th>
            <th>SALD.APERT.</th>
            <th>F.CIERRE</th>
            <th>ESTADO</th>
            <th></th>
            <th></th>
        </td></tr>';

//Mostramos los registros
while ($row=mysql_fetch_array($result))
{

$usuario = buscopersonal($row['legajo']);
$fecalta = cambiarFormatoFecha($row['fapertura']);
$feccierre = cambiarFormatoFecha($row['fcierre']);
$estado  = "CERRADA";
$idcaja  = $row["idcaja"];
$saldoaper = $row["saldoaper"];

echo '<tr style="background-color:'.$td_color.'"><td align="left">'.$row["idcaja"].'</td>';
echo '<td align="left">'.$usuario.'</td>';
echo '<td align="center">'.$fecalta.'</td>';
echo '<td align="center">'.$saldoaper.'</td>';
echo '<td align="center">'.$feccierre.'</td>';
echo '<td align="center">'.$estado.'</td>';


echo '<FORM METHOD="POST" NAME="formulario3" ACTION="ABM_Cajascerr2.php">';

//$idcaja = $row["idcaja"];
echo '<input type="hidden" name= "pasacajas" value="'.$idcaja.'" >';
echo '<input type="hidden" name= "pasaid" value  = "'.$idbase.'" >';

echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Continuar\' src="imagenes/INSERTAR.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '<input type="hidden" name= "pasacajas" value="'.$idcaja.'" >';

echo '</FORM>';


}
echo '</TR></table></table></td></tr>' ;

mysql_free_result($result);





?>

</table>


</BODY>
</HTML>