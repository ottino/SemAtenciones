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

################### Conexion a la base de datos ##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
?>


<HTML>
<HEAD>
<TITLE>L_Estadisticas1.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>

<?
echo titulo_encabezado ('Listado de Atenciones' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$estadistica1 = $_POST["cla_estad1"];
$estadistica2 = $_POST["cla_estad2"];
$estadistica3 = $_POST["cla_estad3"];
$estadistica4 = $_POST["cla_estad4"];
$estadistica5 = $_POST["cla_estad5"];
$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$color  = $_POST["cla_color"];
$hora1  = $_POST["hora1"];
$hora2  = $_POST["hora2"];
$minutos  = $_POST["cla_minuto"];

if (substr($fechad,2,1) == "/")
    $fechad = cambiarFormatoFecha2($fechad);

if (substr($fechah,2,1) == "/")
    $fechah = cambiarFormatoFecha2($fechah);

if ($fechah == '')
    $fechah = '2999/12/31';
if ($fechad == '')
    $fechad = '2000/01/01';


$fechad1=  cambiarFormatoFecha1($fechad);
$fechah1=  cambiarFormatoFecha1($fechah);


//Ejecutamos la sentencia SQL


$result1=mysql_query("select * from estadisticas where id = ".$estadistica1." order by id");
$row1=mysql_fetch_array($result1);
   $esta1 = $row1["literal1"];
   $sta1 = $row1["literal2"];
   $L1 = $row1["nombre"];
   $V1 = $row1[literal3];
mysql_free_result($result1);

if ($estadistica2 > '0')
if ($estadistica2 < '99')
{
 $result1=mysql_query("select * from estadisticas where id = ".$estadistica2." order by id");
  $row1=mysql_fetch_array($result1);
   $esta2 = ", ".$row1["literal1"];
   $sta2 = ", ".$row1["literal2"];
   $L2 = $row1["nombre"];
  mysql_free_result($result1);
}

if ($estadistica1 == '5' || $estadistica2 == '5' || $estadistica3 == '5' || $estadistica4 == '5')
  $filtrorechazo = "diagnostico in (0,1,2,3,15,16,75) and ";

if ($estadistica1 == '8' || $estadistica2 == '8' || $estadistica3 == '8' || $estadistica4 == '8')
 {
//   $filtrodifcolor= "color <> colormedico and ";
     $ordenadifcolor = " order by color , abs(color - colormedico) ";
  }

if ($estadistica3 > '0')
if ($estadistica3 < '99')
{
 $result1=mysql_query("select * from estadisticas where id = ".$estadistica3." order by id");
  $row1=mysql_fetch_array($result1);
   $esta3 = ", ".$row1["literal1"];
   $sta3 = ", ".$row1["literal2"];
   $L3 = $row1["nombre"];
  mysql_free_result($result1);
}

if ($estadistica4 > '0')
if ($estadistica4 < '99')
{
 $result1=mysql_query("select * from estadisticas where id = ".$estadistica4." order by id");
  $row1=mysql_fetch_array($result1);
   $esta4 = ", ".$row1["literal1"];
   $sta4 = ", ".$row1["literal2"];
   $L4 = $row1["nombre"];
  mysql_free_result($result1);
}

$elquery = "select ".$esta1.$esta2.$esta3.$esta4.", sum(cnadicionales) as adic, count(*) as cantidad from atenciones WHERE ".$filtrorechazo.$filtrodifcolor." motanulacion < '1' and fecha >= '".$fechad."' and fecha <= '".$fechah."' group by ".$sta1.$sta2.$sta3.$sta4.$ordenadifcolor." ";

$literal = "     ESTADISTICAS POR: ".$L1." - ".$L2." - ".$L3." - ".$L4."       DESDE ".$fechad1." HASTA ".$fechah1;

//echo $elquery;

$result= mysql_query($elquery);

?>
</p>
<?
echo '
<table width="100%">
 <tr> <td>
  <table width="100%" border="1" align="left">
  <tr>
    <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td><td><div align="center">'.$literal.'</div>
      </td>
           <FORM METHOD="POST" NAME="formulario2" ACTION="L_Estadisticas.php">
            <td width="17" align="center" style="background-color:'.$td_color.'">
                                 <label onclick="this.form.submit();" style="CURSOR: pointer"  >
                                  <img align="middle" alt=\'Volver\' src="imagenes/Volver.ico" width="30" height="30"/>
                                 </label>
                         </td></FORM></FORM>
      </tr></tr></table></tr> </td>
  <table width="100%" border="0" align="left" style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
         <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">';

   if ($estadistica1 > '0')
     echo ' <th>'.$L1.'</th>';

   if ($estadistica2 > '0')
    if ($estadistica2 < '99')
     echo ' <th>'.$L2.'</th>';

   if ($estadistica3 > '0')
    if ($estadistica3 < '99')
     echo ' <th>'.$L3.'</th>';

   if ($estadistica4 > '0')
    if ($estadistica4 < '99')
     echo ' <th>'.$L4.'</th>';
?>
            <th>CANTIDAD</th>
            <th>CONS</th>
        </td></tr>

<?

while ($row=mysql_fetch_array($result))
{

$fecha  =  cambiarFormatoFecha($row["fecha"]);
$zona   =  buscozona($row["zona"]);
$color  =  buscocolor($row["color"]);


$dcolor = explode("-",$row["difcolor"]);
//echo $difcolor;
$colora = $dcolor[0];
$colorb = $dcolor[1];
$colora1 =  buscocolor($colora);
$colorb1 =  buscocolor($colorb);

$dicolor   = $colora1.'-'.$colorb1;
$plan   =  buscoplan($row["plan"]);
$edad   = $row["edad"];
$horag   = $row["hora"];
$difcolor   = $row["difcolor"];
$acolor = abs($colora - $colorb);
$diagnostico =  buscodiagnostico($row["diagnostico"]);
$movil  =  $row["movil"];
$mov = '';
$pla = '';
$col = '';
$zon = '';
$hor = '';

if ($estadistica1 == '8' || $estadistica2 == '8' || $estadistica3 == '8' || $estadistica4 == '8')
   if ($acolor == 0)
   echo '<tr style="background-color:'.$body_color.'">';
  else
   echo '<tr style="background-color:'.$td_color.'">';

if ($estadistica1 == '1')
{   echo '<td align="left">'.$zona.'</td>';
    $zon = $row["zona"];}
if ($estadistica1 == '2')
{   echo '<td align="left">'.$plan.'</td>';
    $pla = $row["plan"];}
if ($estadistica1 == '3')
{   echo '<td align="left">'.$color.'</td>';
    $col = $row["color"];}
if ($estadistica1 == '4')
{   echo '<td align="left">'.$movil.'</td>';
    $mov = $row["movil"];}
if ($estadistica1 == '5')
{   echo '<td align="left">'.$diagnostico.'</td>';
    $diag = $row["diagnostico"];}
if ($estadistica1 == '6')
{   echo '<td align="left">'.$edad.'</td>';
    $edad = $edad;}
if ($estadistica1 == '7')
{   echo '<td align="left">'.$horag.'</td>';
    $hor = $horag;}
if ($estadistica1 == '8')
{   echo '<td align="left">'.$dicolor.'</td>';
    $difc = $difcolor;}

if ($estadistica2 == '1')
{   echo '<td align="left">'.$zona.'</td>';
    $zon = $row["zona"];}
if ($estadistica2 == '2')
{   echo '<td align="left">'.$plan.'</td>';
    $pla = $row["plan"];}
if ($estadistica2 == '3')
{   echo '<td align="left">'.$color.'</td>';
    $col = $row["color"];}
if ($estadistica2 == '4')
{   echo '<td align="left">'.$movil.'</td>';
    $mov = $row["movil"];}
if ($estadistica2 == '5')
{   echo '<td align="left">'.$diagnostico.'</td>';
    $diag = $row["diagnostico"];}
if ($estadistica2 == '6')
{   echo '<td align="left">'.$edad.'</td>';
    $edad = $edad;}
if ($estadistica2 == '7')
{   echo '<td align="left">'.$horag.'</td>';
    $hor = $horag;}
if ($estadistica2 == '8')
{   echo '<td align="left">'.$dicolor.'</td>';
    $difc = $difcolor;}

if ($estadistica3 == '1')
{   echo '<td align="left">'.$zona.'</td>';
    $zon = $row["zona"];}
if ($estadistica3 == '2')
{   echo '<td align="left">'.$plan.'</td>';
    $pla = $row["plan"];}
if ($estadistica3 == '3')
{   echo '<td align="left">'.$color.'</td>';
    $col = $row["color"];}
if ($estadistica3 == '4')
{   echo '<td align="left">'.$movil.'</td>';
    $mov = $row["movil"];}
if ($estadistica3 == '5')
{   echo '<td align="left">'.$diagnostico.'-'.$diag.'</td>';
    $diag = $row["diagnostico"];}
if ($estadistica3 == '6')
{   echo '<td align="left">'.$edad.'</td>';
    $edad = $edad;}
if ($estadistica3 == '7')
{   echo '<td align="left">'.$horag.'</td>';
    $hor = $horag;}
if ($estadistica3 == '8')
{   echo '<td align="left">'.$dicolor.'</td>';
    $difc = $difcolor;}

if ($estadistica4 == '1')
{   echo '<td align="left">'.$zona.'</td>';
    $zon = $row["zona"];}
if ($estadistica4 == '2')
{   echo '<td align="left">'.$plan.'</td>';
    $pla = $row["plan"];}
if ($estadistica4 == '3')
{   echo '<td align="left">'.$color.'</td>';
    $col = $row["color"];}
if ($estadistica4 == '4')
{   echo '<td align="left">'.$movil.'</td>';
    $mov = $row["movil"];}
if ($estadistica4 == '5')
{   echo '<td align="left">'.$diagnostico.'</td>';
    $diag = $row["diagnostico"];}
if ($estadistica4 == '6')
{   echo '<td align="left">'.$edad.'</td>';
    $edad = $edad;}
if ($estadistica4 == '7')
{   echo '<td align="left">'.$horag.'</td>';
    $hor = $horag;}
if ($estadistica4 == '8')
{   echo '<td align="left">'.$dicolor.'</td>';
    $difc = $difcolor;}

$total = $row["cantidad"] + $row["adic"];

echo '<td align="center">'.$total.'</td>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="L_Estadisticas2.php">';
echo '<input type="hidden" name= "cla_fecha" value="'.$fechad.'" >';
echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
echo '<input type="hidden" name= "pasacolor" value="'.$col.'" >';
echo '<input type="hidden" name= "pasazona" value="'.$zon.'" >';
echo '<input type="hidden" name= "pasamovil" value="'.$mov.'" >';
echo '<input type="hidden" name= "pasaplan" value="'.$pla.'" >';
echo '<input type="hidden" name= "pasadiag" value="'.$diag.'" >';
echo '<input type="hidden" name= "pasaedad" value="'.$edad.'" >';
echo '<input type="hidden" name= "pasahora" value="'.$horag.'" >';
echo '<input type="hidden" name= "pasadifcolor" value="'.$difcolor.'" >';
echo '<input type="hidden" name= "demora" value="NO" >';

echo '<input type="hidden" name= "lestad1" value="'.$_POST["cla_estad1"].'" >';
echo '<input type="hidden" name= "lestad2" value="'.$_POST["cla_estad2"].'" >';
echo '<input type="hidden" name= "lestad3" value="'.$_POST["cla_estad3"].'" >';
echo '<input type="hidden" name= "lestad4" value="'.$_POST["cla_estad4"].'" >';
echo '<input type="hidden" name= "lestad5" value="'.$_POST["cla_estad5"].'" >';
echo '<input type="hidden" name= "lestadf" value="'.$_POST["cla_fecha"].'" >';
echo '<input type="hidden" name= "lestadf1" value="'.$_POST["cla_fecha1"].'" >';
echo '<input type="hidden" name= "lestadcol" value="'.$_POST["cla_color"].'" >';
echo '<input type="hidden" name= "lestadh1" value="'.$_POST["hora1"].'" >';
echo '<input type="hidden" name= "lestadh2" value="'.$_POST["hora2"].'" >';
echo '<input type="hidden" name= "lestadmin" value="'.$_POST["cla_minuto"].'" >';

echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

}

mysql_free_result($result);

?>

</table>
</table>


</BODY>
</HTML>