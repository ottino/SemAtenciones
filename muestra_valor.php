<?
echo "Palabra encriptada :".base64_encode(gzdeflate($_POST['palabra'],9))."<br>";
echo "Asignar en variable php la siguente linea --->>>>  "."gzinflate(base64_decode('".base64_encode(gzdeflate($_POST['palabra'],9))."'))"."<br>";
echo 'Ejemplo: $variable ='."gzinflate(base64_decode('".base64_encode(gzdeflate($_POST['palabra'],9))."')); es equivalente a ".'$variable ='.$_POST['palabra'].";";
?>