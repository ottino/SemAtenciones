<html> 
<head> 

  <title>Calendario de pruebas</title> 

  <!--Hoja de estilos del calendario --> 
  <link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-green.css" title="win2k-cold-1" /> 

  <!-- librer�a principal del calendario --> 
 <script type="text/javascript" src="calendario/calendar.js"></script> 

 <!-- librer�a para cargar el lenguaje deseado --> 
  <script type="text/javascript" src="calendario/lang/calendar-es.js"></script> 

  <!-- librer�a que declara la funci�n Calendar.setup, que ayuda a generar un calendario en unas pocas l�neas de c�digo --> 
  <script type="text/javascript" src="calendario/calendar-setup.js"></script> 

</head> 

<body> 

<!-- formulario con el campo de texto y el bot�n para lanzar el calendario--> 

<input type="text" name="date" id="campo_fecha" /> 
<input type="button" id="lanzador" value="..." onclick="xx();"/> 


<!-- script que define y configura el calendario--> 
<script type="text/javascript"> 
 function xx(){
   Calendar.setup({ 
    inputField     :    "campo_fecha",     // id del campo de texto 
     ifFormat     :     "%d/%m/%Y",     // formato de la fecha que se escriba en el campo de texto 
     button     :    "lanzador"     // el id del bot�n que lanzar� el calendario 
}); 
}
</script> 

</body> 
</html> 
