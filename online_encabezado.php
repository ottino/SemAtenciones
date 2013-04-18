<?
include ('funciones.php');


//*  CONEXION A LA BASEDE DATOS
conexion();
$base = 'GNsys';
sel_db ($base);
//*

$html_salidaa = '
<table width="43%" height="61" border="1" style="border:inherit">
<tr>
 <td width="7%" style=" background-color:#999999" align="center">418722</td>
 <td width="30%">
   <table width="242"> 
    <tr><td width="234" align="center" style=" background-color:#999999">DESPACHADOR</td>
    </tr>
	<tr><td align="center"> OTTINO MAXIMILIANO</td></tr> 
   </table> </td>
 <td width="63%">
   <table> 
    <tr><td width="225" align="center" style=" background-color:#999999">CANTIDAD DE LLAMADOS</td>
    </tr>
	<tr><td align="center">50</td></tr> 
   </table> </td>
</table>
';

echo $html_salidaa; 
?>