<?php
include ('funciones.php');

//*  CONEXION A LA BASEDE DATOS
conexion();
$base = 'GNsys';
sel_db ($base);
//*

$consulta = mysql_query ("SELECT * FROM destino");

$html_salida = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<body>
<form method="post" action="prajax.php">
<table width="495" height="198" border="1">
';

while ($fila=mysql_fetch_array($consulta)){
//            <input type="submit" name="ok" value="'.$fila['destino'].'" size="45" align="center"/>

 $html_salida.='<tr>
            <td>
			 <input size="45" readonly="true"  type="hidden" name="documento" value="'.$fila['iddestino'].'">
			  '.$fila['iddestino'].'
			</td>
            <td>
			 <input size="45" readonly="true"  type="hidden" name="documento" value="'.$fila['destino'].'">
			 '.$fila['destino'].'</td>
            <td>
			 <input size="45" readonly="true"  type="hidden" name="documento" value="'.$fila['domicilio'].'">
			 '.$fila['domicilio'].'</td>
		   </tr>
          ';
}
$html_salida.= 
'
</table>
<input type="text" name="textfield" />
</form>
</body>
</html>
'; 
echo $html_salida;
//echo "<META HTTP-EQUIV='refresh' CONTENT='5; URL=ajax.php'>";
//echo $result.'<input type="text" name="textfield" />';


/*
echo '

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form method="post" action="prajax.php">
<table width="495" height="198" border="1">
 '.$result.'
</table>
<input type="text" name="textfield" />
</body>
</html>
'; 
					             
<input type="submit" name="ok" value="GENERAR" size="45" align="center"/>
	<td width="300" height="5" align="center" class="tablaApe3">'.$row['wnombre'].'</td>';
		                  echo '   
				                 <td width="300" height="5" align="center" class="tablaApe3">
 					              <input size="45" readonly="true"  type="hidden" name="documento" value="'.$row['wdocu'].'">
					              '.$row['wdocu'].'
				                 </td>';

*/
?>
