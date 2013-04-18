<?php
include ('funciones.php');

//*  CONEXION A LA BASEDE DATOS
conexion();
$base = 'GNsys';
sel_db ($base);
//*
?>

<html>   
  <head>   
  <title>Ejemplo</title>   
</head>   
<script language="javascript"  type="text/javascript">   
function nuevoAjax(){
var xmlhttp=false;
try {
xmlhttp = new XMLHttpRequest();
} catch (e) {
 try {
 xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 } catch (E) {
 xmlhttp = false;
 }
 }

if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
 xmlhttp = new XMLHttpRequest();
}
return xmlhttp;
}



function cargarContenido(){
 nombre = "online";
 pagina1="online_atenciones_2.php";
 var contenedor;
 contenedor = document.getElementById(nombre);
 ajax=nuevoAjax();
 ajax.open("GET", pagina1,true);
 
 //ajax.open("GET", pagina1,true);
ajax.onreadystatechange=function() {
if (ajax.readyState==4) {
 contenedor.innerHTML = ajax.responseText
}
}

ajax.send(null)
}
setInterval("cargarContenido();",1000);

</script>   
<body onload="cargarContenido();">
<input type="text" name="textfield" value ="<?php echo $_POST['ok']?>" />   
<h2>Online </h2>   
  <div id="online"></div>   
</body>   
</html>   
