<?
// CODIGO PARA ENCRIPTAR LAS CLAVES
$html_salida = '
<html>
<head>
 <title>ENCRIPTADOR by OttinoMax</title>
</head>
<body>
<form action="muestra_valor.php" METHOD="POST" NAME="formulario3">
<table>
<tr><td>Palabra a encriptar :</td><td><input type="text" name="palabra" /></td></tr>
<tr><td colspan="2"> <input type="submit" value="ENCRIPTAR" name="" /></td></tr>
</table>
</form>
</body>
</hmtl>

';

echo $html_salida
?>