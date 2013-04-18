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
<TITLE>L_Prestaciones.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>

<?
echo titulo_encabezado ('Listado de Prestaciones' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$plan1 = $_POST["cla_plan"];
$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["cla_nombre"];

if (substr($fechad,2,1) == "/")
    $fechad = cambiarFormatoFecha2($fechad);

if (substr($fechah,2,1) == "/")
    $fechah = cambiarFormatoFecha2($fechah);

if ($fechah == '')
    $fechah = '2999/12/31';
if ($fechad == '')
    $fechad = '2000/01/01';


//Ejecutamos la sentencia SQL
   $sSQL= "TRUNCATE TABLE listadoprestaciones";
   mysql_query($sSQL);

if ($nombre == '')
    $sqlnombre = '';
   else
    $sqlnombre = " and nombre like '%".$nombre."%' ";


if ($plan1 < '1')
  {    $result=mysql_query("select * from atenciones a, planes b WHERE
                     fecha >= '".$fechad."' and fecha <= '".$fechah."' and a.plan = b.idplan ".$sqlnombre." order by plan, color ");
      $lit_plan = "****  TODOS  ****  ";
  }
  else
  {  $result=mysql_query("select * from atenciones a, planes b WHERE
                     fecha >= '".$fechad."' and fecha <= '".$fechah."' and
                     plan = '".$plan1."' and a.plan = b.idplan ".$sqlnombre." order by plan, color ");
      $lit_plan = $row["descplan"];
   }

$fechad1  =  cambiarFormatoFecha1($fechad);
$fechah1  =  cambiarFormatoFecha1($fechah);


$literal = "     LISTADO DEL PLAN: ".$lit_plan."       DESDE ".$fechad1." HASTA ".$fechah1;
$cont  = 0;
$contanul  = 0;
$cont1 = 0;
$cont2 = 0;
$cont3 = 0;
$cont4 = 0;
$cont5 = 0;
$cont6 = 0;
$cont7 = 0;

while ($row=mysql_fetch_array($result))
{

$cont = $cont + 1;
$plan = $row['plan'];
$descplan = $row['descplan'];
if ($cont == 1)
{  $planant = $plan;
   $descplanant = $descplan;
}
$color = $row['color'];
$adicionales = $row['cnadicionales'];

//echo $plan;
//echo " - ";
//echo $planant;

if ($plan != $planant)
 {
    $sSQL= "insert into listadoprestaciones (idplanes, descplan, rojo,amarillo,verde,azul,blanco,gris,anul)
                          values ('".$planant."' , '".$descplanant."','".$cont1."' , '".$cont2."', '".$cont3."',
                                  '".$cont4."', '".$cont6."', '".$cont7."', '".$contanul."')";
//    echo "1";
//    echo $sSQL;
    mysql_query($sSQL);

   $planant = $plan;
   $descplanant = $descplan;
   $cont  = 1;
   $contanul  = 0;
   $cont1 = 0;
   $cont2 = 0;
   $cont3 = 0;
   $cont4 = 0;
   $cont5 = 0;
   $cont6 = 0;
   $cont7 = 0;

 }


if ($row['motanulacion'] > 0)
  $contanul = $contanul +1;
else
 if ($color == '1')
   $cont1 = $cont1 +1 + $adicionales;
  else
 if ($color == '2' || $color == '5')
   $cont2 = $cont2 +1 + $adicionales;
  else
 if ($color == '3')
   $cont3 = $cont3 +1 + $adicionales;
  else
 if ($color == '4')
   $cont4 = $cont4 +1 + $adicionales;
  else
 if ($color == '6')
   $cont6 = $cont6 +1 + $adicionales;
  else
 if ($color == '7')
   $cont7 = $cont7 +1;

}

    $sSQL= "insert into listadoprestaciones (idplanes, descplan, rojo,amarillo,verde,azul,blanco,gris,anul)
                          values ('".$planant."' , '".$descplanant."','".$cont1."' , '".$cont2."', '".$cont3."',
                                  '".$cont4."', '".$cont6."', '".$cont7."', '".$contanul."')";
//    echo "2";
//    echo $sSQL;
    mysql_query($sSQL);

mysql_free_result($result);

$result=mysql_query("select * from listadoprestaciones order by idplanes");

echo '
<table width="100%">
 <tr> <td>
  <table width="100%" border="1" align="left">
  <tr>
    <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td><td><div align="center">'.$literal.'</div></td>
    <td style="width:60px"><th> <a href="javascript:history.back(1)"/a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></th></td>
      </td></tr></table></td></tr> <tr style="background-color:'.$td_color.'"> <td>
  <table width="100%" border="1" align="left" style="background-color:'.$td_color.'">
    <td style="background-color:'.$td_color.'" width="100%" rowspan="3" valign="top"><div align="center">';

echo ' <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$td_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">';

echo ' <tr style="font-size:'.$fontt.'; background-color:'.$td_color.' ">
            <th>ID PLAN</th>
            <th>R</th>
            <th>A</th>
            <th>V</th>
            <th>T</th>
            <th>ENF</th>
            <th>EV</th>
            <th>ANU</th>
            <th>TOTAL</th>
        </td></tr>';


//Mostramos los registros
while ($row=mysql_fetch_array($result))
{
echo '<tr style="background-color:'.$td_color.'"><td align="left">'.$row["idplanes"].' - '.$row["descplan"].'</td>';
echo '<td align="left">'.$row["rojo"].'</td>';
echo '<td align="left">'.$row["amarillo"].'</td>';
echo '<td align="left">'.$row["verde"].'</td>';
echo '<td align="left">'.$row["azul"].'</td>';
echo '<td align="left">'.$row["blanco"].'</td>';
echo '<td align="left">'.$row["gris"].'</td>';
$total = $row["rojo"] + $row["amarillo"] + $row["verde"] + $row["azul"] + $row["blanco"]+ $row["gris"];
echo '<td align="left">'.$row["anul"].'</td>';
echo '<td align="center">'.$total.'</td>';

$rojo = $rojo + $row["rojo"];
$amarillo = $amarillo + $row["amarillo"];
$verde = $verde + $row["verde"];
$azul = $azul + $row["azul"];
$blanco = $blanco + $row["blanco"];
$gris = $gris + $row["gris"];
$anul = $anul + $row["anul"];

}

$ltotal = "TOTAL GENERAL";
echo '<tr style="background-color:'.$td_color.'"><td align="left">'.$ltotal.'</td>';
echo '<td align="left">'.$rojo.'</td>';
echo '<td align="left">'.$amarillo.'</td>';
echo '<td align="left">'.$verde.'</td>';
echo '<td align="left">'.$azul.'</td>';
echo '<td align="left">'.$blanco.'</td>';
echo '<td align="left">'.$gris.'</td>';
$total = $rojo + $amarillo + $verde + $azul + $blanco + $gris;
echo '<td align="left">'.$anul.'</td>';
echo '<td align="center">'.$total.'</td>';

mysql_free_result($result);



?>

</table>
</table>


</BODY>
</HTML>