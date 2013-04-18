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
<TITLE>ABM_Cajas.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>


<?
echo titulo_encabezado ('Modulo de Cajas' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
$legajo = $G_legajo;

$marcaupd = '0';
$marcaupd = $_POST["cla_marcaupd"];


///////////   Si la pantalla anterior es de Movimiento de Caja
if ($marcaupd == '1')
{
$marcaupd = $_POST["cla_marcaupd"];
$motivos = $_POST["motivos"];
$idcaja = $_POST["cla_idcaja"];
$observa = $_POST["cla_observa"];
$importe = $_POST["cla_importe"];


$sSQL="select * from  motmovcajas where id = ".$motivos;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);
$debcre =  $row['debcre'];
$hoy = date("Y-m-d");
$hora = date("H:i:s");

if ($motivos > '0')
 {
   $sSQL="insert into movcaja (idcaja, debcre, fecmov, horamov, idmotdc, observac, importe)
      values ('".$idcaja."','".$debcre."','".$hoy."','".$hora."','".$motivos."','".$observa."','".$importe."')";
   $result=mysql_query($sSQL);

   insertolog($legajo, "ABM_Cajas.php", "movcaja", "insert", "1999-12-01", $sSQL);

   if ($debcre == '1')
      { $importe = $importe * -1;}

   $sSQL="update cajas set saldocierre = saldocierre + '".$importe."' where idcaja = ".$idcaja;
   $result=mysql_query($sSQL);
   insertolog($legajo, "ABM_Cajas.php", "cajas", "update", "1999-12-01", $sSQL);
  }
 else
   {  mensaje_error('ABM_Cajas2.php','No ingresó motivo del movimiento');
    exit;
   }


} ///////////   FIN ---  Si la pantalla anterior es de Movimiento de Caja

///////////   Si la pantalla anterior es de Rendicion de Caja
if ($marcaupd == '3')
{
$claveant = $_POST["cla_clave"];
$marcaupd = $_POST["cla_marcaupd"];
$motivos = $_POST["motivos"];
$idcaja = $_POST["cla_idcaja"];
$observa = $_POST["cla_observa"];
$importe = $_POST["cla_importe"];

$sSQL= "select * from cajas where tipo = 2 and estado < '1'";
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);
$legajoadm = $row["legajo"];
$idcajaadm = $row["idcaja"];

$sSQL= "select * from legajos where legajo = ".$legajoadm;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);
$nombreadm = $row["apeynomb"];

$contrasena = md5($claveant);
$hora = date("H:i:s");
$hoy = date("Y-m-d");

 if ($row[clave] <> $contrasena)
 {  mensaje_error('ABM_Cajas.php','Clave incorrecta');
    exit; }

 $sSQL="update cajas set saldocierre = saldocierre + '".$importe."' where idcaja = ".$idcajaadm;
 $result=mysql_query($sSQL);
 insertolog($legajo, "ABM_Cajas.php", "cajas", "update", "1999-12-01", $sSQL);


 $deb = "1";
 $cre = "2";
 $motivosd = "3";
 $motivosc = "4";
 $nombre = buscopersonal($legajo);

 $observa = 'REND - '.$legajoadm.' - '.$nombreadm;

 $sSQL="insert into movcaja (idcaja, debcre, fecmov, horamov, idmotdc, observac, importe)
       values ('".$idcaja."','".$deb."','".$hoy."','".$hora."','".$motivosd."','".$observa."','".$importe."')";
  $result=mysql_query($sSQL);
  insertolog($legajo, "ABM_Cajas.php", "movcaja", "insert", "1999-12-01", $sSQL);

 $sSQL="update cajas set saldocierre = saldocierre - '".$importe."' where idcaja = ".$idcaja;
 $result=mysql_query($sSQL);
 insertolog($legajo, "ABM_Cajas.php", "cajas", "update", "1999-12-01", $sSQL);


 $nombre = buscopersonal($legajo);
 $observa = 'REND - '.$legajo.' - '.$nombre;

 $sSQL="insert into movcaja (idcaja, debcre, fecmov, horamov, idmotdc, observac, importe)
       values ('".$idcajaadm."','".$cre."','".$hoy."','".$hora."','".$motivosc."','".$observa."','".$importe."')";
  $result=mysql_query($sSQL);
  insertolog($legajo, "ABM_Cajas.php", "movcaja", "insert", "1999-12-01", $sSQL);

  $motivos = '202';
  $tipomov = 'E';
  $nroopera = $legajo;

   $resultin=mysql_query("select idsdosfinales from cjsdosfinales where fechasaldo = '".$hoy."'");
   $rowin=mysql_fetch_array($resultin);
   $idsaldos = $rowin["idsdosfinales"] +0;
   mysql_free_result($resultin);

if ($idsaldos < '1')
    {

     $resultmax=mysql_query("select max(idsdosfinales) as idmax from cjsdosfinales");
     $rowmax=mysql_fetch_array($resultmax);
     $pasaidmax = $rowmax["idmax"] +0;
     mysql_free_result($resultmax);

      $resulta=mysql_query("select * from cjsdosfinales WHERE idsdosfinales = ".$pasaidmax." order by 1");
      $rowa=mysql_fetch_array($resulta);
      $asbanco    = $rowa['sdobanco'];
      $asefectivo = $rowa['sdoefectivo'];
      $ascheque   = $rowa['sdocheques'];
      mysql_free_result($resulta);

      $sSQL="insert into cjsdosfinales (fechasaldo, sdobanco, sdocheques, sdoefectivo)
           values ('".$hoy."','".$asbanco."','".$ascheque."','".$asefectivo."')";
      mysql_query($sSQL);
      insertolog($legajo, "ABM_Cajas.php", "cjsdosfinales", "insert", "1999-12-01", $sSQL);
    }

  $sSQL="insert into cjmovimientos (cjmovfecha, cjmovmotivo, cjmovtipo, cjmovimporte, cjmovnro, cjmovobs)
      values ('".$hoy."','".$motivos."','".$tipomov."','".$importe."','".$nroopera."','".$observa."')";
  mysql_query($sSQL);

  $sSQL="update cjsdosfinales set sdoefectivo = sdoefectivo + '".$importe."' where fechasaldo >= '".$hoy."'";
  mysql_query($sSQL);


} ///////////   FIN ---  Si la pantalla anterior es de Rendicion de Caja


///////////   Si la pantalla anterior es de Alta de una Caja
if ($marcaupd == '2')
{
$marcaupd = $_POST["cla_marcaupd"];
$claveant = $_POST["cla_clave"];
$idcajaant = $_POST["cla_idcaja"];
$legajoant = $_POST["cla_legajo"];
$saldoant = $_POST["cla_saldo"];

$sSQL= "select * from legajos where legajo = ".$legajoant;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);
$nombreant = $row["apeynomb"];

$contrasena = md5($claveant);
$hora = date("H:i:s");
$hoy = date("Y-m-d");

 if ($row[clave] <> $contrasena)
 {  mensaje_error('ABM_Cajas.php','Clave incorrecta');
    exit; }

$sSQL="update cajas set
               fcierre = '".$hoy."',
               estado  = 1,
               saldocierre = 0
               where idcaja = ".$idcajaant;
$result=mysql_query($sSQL);
insertolog($legajo, "ABM_Cajas.php", "cajas", "update", "1999-12-01", $sSQL);

$tipo = "1";

$sSQL="insert into cajas (tipo, fapertura, legajo)
      values ('".$tipo."','".$hoy."','".$legajo."')";
$result=mysql_query($sSQL);
insertolog($legajo, "ABM_Cajas.php", "cajas", "insert", "1999-12-01", $sSQL);

$sSQL="select * from cajas where estado < 1 and legajo = ".$legajo;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$idcaja = $row["idcaja"];


$deb = "1";
$cre = "2";
$motivosd = "5";
$motivosc = "6";
$nombre = buscopersonal($legajo);

$observa = $legajoant.' - '.$nombreant;

$sSQL="insert into movcaja (idcaja, debcre, fecmov, horamov, idmotdc, observac, importe)
      values ('".$idcaja."','".$cre."','".$hoy."','".$hora."','".$motivosc."','".$observa."','".$saldoant."')";
 $result=mysql_query($sSQL);
insertolog($legajo, "ABM_Cajas.php", "movcaja", "insert", "1999-12-01", $sSQL);

$sSQL="update cajas set saldocierre = '".$saldoant."' where idcaja = ".$idcaja;
$result=mysql_query($sSQL);
insertolog($legajo, "ABM_Cajas.php", "cajas", "update", "1999-12-01", $sSQL);


$observa = $legajo.' - '.$nombre;

$sSQL="insert into movcaja (idcaja, debcre, fecmov, horamov, idmotdc, observac, importe)
      values ('".$idcajaant."','".$deb."','".$hoy."','".$hora."','".$motivosd."','".$observa."','".$saldoant."')";
 $result=mysql_query($sSQL);
 insertolog($legajo, "ABM_Cajas.php", "movcaja", "insert", "1999-12-01", $sSQL);

} ///////////   FIN ---  Si la pantalla anterior es de Alta de una Caja



//Ejecutamos la sentencia SQL
$sSQL="select * from cajas a, legajos b WHERE a.legajo = b.legajo and a.estado < 1 and a.legajo = ".$G_legajo;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);
//echo $row['id'];

 if (!$row)
   echo '
    <table width="20%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:'.$th_color.'; border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
        <tr>
          <td><a href="A_Cajas.php"/a>NUEVA CAJA</td>
        </tr>
    </table><br><br><br>';
 else
{
 echo '
<table><tr><td>
  <table width="100%" border="1" align="left">
  <tr>
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="1" width="100%" cellpadding="5" align="left" style="background-color:'.$body_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
         <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">
            <th>ID</th>
            <th>USUARIO</th>
            <th>F.APERTURA</th>
            <th>SALD.APERT.</th>
            <th>ESTADO</th>
            <th>MOVIM</th>
            <th>RENDICION</th>
        </td></tr>';

//Mostramos los registros
$usuario = buscopersonal($row['legajo']);
$fecalta = cambiarFormatoFecha($row['fapertura']);
$estado  = "ABIERTA";
$idcaja  = $row["idcaja"];
$saldoaper = $row["saldoaper"];

echo '<tr style="background-color:'.$td_color.'"><td align="left">'.$row["idcaja"].'</td>';
echo '<td align="left">'.$usuario.'</td>';
echo '<td align="center">'.$fecalta.'</td>';
echo '<td align="center">'.$saldoaper.'</td>';
echo '<td align="center">'.$estado.'</td>';


echo '<FORM METHOD="POST" NAME="formulario3" ACTION="ABM_Cajas2.php">';
echo '<input type="hidden" name= "pasacajas" value="'.$idcaja.'" >';
$rendicion = '0';
echo '<input type="hidden" name= "pasrendicion" value="'.$rendicion.'" >';
echo ' <td width="17" align="center" >
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Agregar movimiento\' src="imagenes/INSERTAR.ICO" width="30" height="30"/>
                    </label>
                  </td>';

echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario4" ACTION="ABM_Cajas2.php">';
echo '<input type="hidden" name= "pasacajas" value="'.$idcaja.'" >';
$rendicion = '1';
echo '<input type="hidden" name= "pasrendicion" value="'.$rendicion.'" >';
echo ' <td width="17" align="center" >
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Rendición\' src="imagenes/moneypak.ico" width="30" height="30"/>
                    </label>
                  </td>';

echo '</FORM>';



echo '</TR></table></table></td></tr>' ;

mysql_free_result($result);

////////////////////////////////////////////////////////////

$sSQL="select * from movcaja a, cajas b, motmovcajas c where
       a.idcaja = b.idcaja and a.debcre = c.debcre and a.idmotdc = c.id
       and b.estado < 1 and b.legajo = ".$G_legajo." order by 4,5";

//echo $sSQL;

$result=mysql_query($sSQL);


$c = 0;
$coseguros = 0;
echo '
  <table width="100%" border="1" align="left">
  <tr style="background-color:'.$td_color.'">
    <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td></tr><tr>
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="1" width="100%" cellpadding="5" align="left" style="background-color:'.$td_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'; background-color:'.$td_color.' ">
            <th>ID CAJA</th>
            <th>D/C</th>
            <th>MOTIVO</th>
            <th>F.MOVIM</th>
            <th>OBSERV.</th>
            <th>IMPORTE</th>
            <th>SALDO</th>
        </td>';


//Mostramos los registros

$saldo = $saldoaper;

while ($row=mysql_fetch_array($result))
{

$fecmov = cambiarFormatoFecha($row['fecmov']);
$horamov = cambiarFormatoHora($row['horamov']);

$importe = $row["importe"];

if ($row["debcre"] == '1')
{   $debcre = "D";
    $saldo = $saldo - $importe;
}  else
{   $debcre = "C";
    $saldo = $saldo + $importe;
}
echo '<tr style="background-color:'.$td_color.'"><td align="center">'.$idcaja.'</td>';
echo '<td align="center">'.$debcre.'</td>';
echo '<td align="left">'.$row["descmotdc"].'</td>';
echo '<td align="center">'.$fecmov.' - '.$horamov.'</td>';
echo '<td align="left">'.$row["observac"].'</td>';
echo '<td align="center">'.round($row["importe"],02).'</td>';
echo '<td align="center">'.round($saldo,02).'</td>';
}

echo '</TR></table></table></td></tr></table>' ;
mysql_free_result($result);

}

?>

</table>


</BODY>
</HTML>