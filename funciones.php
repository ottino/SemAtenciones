<?php

require_once("cookie.php");

function conexion (){
   $dbd= mysql_connect('localhost','root','');
   if (!$dbd)
      {
        die('Error: ' . mysql_error());
      }
   return $dbd;
}

function conectar_db ($host , $db , $usr , $pass){
    
   $dbd= mysql_connect($host, $usr, $pass);
   
   if (!$dbd)
      {
        die('Error al conectar con la base de datos : ' . mysql_error());
      }
      
   mysql_select_db($db, $dbd);
   
}

function sel_db ($db)
{
  $db = mysql_select_db($db);
  if (!$db)
      {
        die('No existe base: ' . mysql_error());
      }
  return $db;
}

function titulo_encabezado ($titulo , $imagen)
{
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
$G_funcion = $cookie->get("funcion");
$G_datoliq  = $cookie->get("datoliq");
$G_nick  = $cookie->get("nick");
$imagen_home = "imagenes/home.jpg";
$imagen_salida = "imagenes/salida.jpg";
$imagen_volver = "imagenes/Volver.ico";

global $body_color, $th_color, $td_color, $se_color,$bo_color,$fontdef, $fontt, $fontreg;

if ($G_usuario == null)
   $html_salida = 'Error -----  Usuario no conectado';
else
 $html_salida = '
 <table width="100%" height="79" border="0" align="">
  <tr>
    <td scope="col" width="15%"> <img  src="'.$imagen.'" width="120" height="73"  align="top" /></td>
    <td scope="col" width="65%"><h1>'.$titulo.'</h1></td>
    <td scope="col" width="25%">
    <div id="infoUsuario">
    <b>Usuario: </b>'.$G_legajo.' <br />
    <b>Nombre: </b>'.$G_usuario.'<br />
    <b>Mensajes Nuevos: </b>'.muestra_msg().' </td>
    </div>
  </tr>

  <p>
 </table>
 <table width="100%" border="0">
  <tr>
    <td ><a href="Principal.php">Inicio</a></td>

    <td  >
    <SELECT onclick="this.style.width = auto;" onblur="this.style.width = 130px;" style="width:130px; background-color:'.$se_color.';"  NAME="Atenciones" onchange="window.location.href=this.options[this.selectedIndex].value" style="background-color:'.$se_color.'" style="border:none">
       <OPTION VALUE= "atenciones.php" selected="selected">Atenciones</OPTION>
       <OPTION VALUE= "atenciones.php">Despacho</OPTION>
       <OPTION VALUE= "online_consultas.php">Consulta Despacho</OPTION>
       <OPTION VALUE= "L_Atencionespend.php">Listado Pendientes</OPTION>
       <OPTION VALUE= "ABM_Mensajes.php">Mensajes</OPTION>
       <OPTION VALUE= "ABM_Agenda0.php">Agenda</OPTION>
       <OPTION VALUE= "indes.php?usuario='.$G_nick.'">Chat</OPTION>
       <OPTION>-----------------</OPTION>
       <OPTION VALUE= "ABM_Cajas.php">Adm de Caja</OPTION>
       <OPTION VALUE= "ABM_Cajascerr.php">Cajas Cerradas</OPTION>
    </SELECT>
    </td>

    <td >
    <SELECT onclick="this.style.width = auto;" onblur="this.style.width = 130px;" style="width:130px; background-color:'.$se_color.';"  NAME="Atenciones" onchange="window.location.href=this.options[this.selectedIndex].value" style="background-color:'.$se_color.'" style="border:none">
       <OPTION VALUE= "Principal.php" selected="selected">Listados</OPTION>
       <OPTION>-----------------</OPTION>
       <OPTION VALUE= "ABM_CAtenciones.php">Consulta Atenciones</OPTION>
       <OPTION VALUE= "C1_Atenciones.php">Consulta Unitaria</OPTION>
       <OPTION VALUE= "L_Prestaciones0.php">Resumen Atenciones</OPTION>
       <OPTION VALUE= "ABM_Atenciones.php">Listado Atenciones</OPTION>
       <OPTION VALUE= "L_Estadisticas.php">Estad�sticas</OPTION>
       <OPTION VALUE= "L_Estachofer.php">Estad. x Chofer</OPTION>
       <OPTION>-----------------</OPTION>
       <OPTION VALUE= "AR_Atencionespend.php">Pendientes PDF</OPTION>
       <OPTION VALUE= "AR_Atenciones.php">Atenciones PDF</OPTION>
    </SELECT>
    </td>

    <td >
    <SELECT onclick="this.style.width = auto;" onblur="this.style.width = 130px;" style="width:130px; background-color:'.$se_color.';"  NAME="Atenciones" onchange="window.location.href=this.options[this.selectedIndex].value" style="background-color:'.$se_color.'" style="border:none">
       <OPTION VALUE= "Principal.php" selected="selected">Tablas</OPTION>
       <OPTION VALUE= "ABM_Clientes0.php">ABM Clientes</OPTION>
       <OPTION VALUE= "ABM_Contratos0.php">ABM Contratos</OPTION>
       <OPTION VALUE= "ABM_Destinos.php">ABM Destinos</OPTION>
       <OPTION VALUE= "ABM_Motivos.php">ABM Motivos</OPTION>
       <OPTION VALUE= "ABM_Planes0.php">ABM Planes</OPTION>
       <OPTION VALUE= "ABM_Motctrlcaja.php">ABM Mot Caja</OPTION>
       <OPTION>-----------------</OPTION>
       <OPTION VALUE= "ABM_Legajos.php">ABM Usuarios</OPTION>
       <OPTION VALUE= "ABM_Legajosb.php">Usuarios Baja</OPTION>
    </SELECT>
    </td>
    <td >
    <SELECT onclick="this.style.width = auto;" onblur="this.style.width = 130px;" style="width:130px; background-color:'.$se_color.';"  NAME="Atenciones" onchange="window.location.href=this.options[this.selectedIndex].value" style="background-color:'.$se_color.'" style="border:none">
       <OPTION VALUE= "Principal.php" selected="selected">Moviles</OPTION>
       <OPTION VALUE= "ABM_Moviles.php">ABM Moviles</OPTION>
       <OPTION VALUE= "ABM_Tareaspend.php">Mant Pendiente</OPTION>
       <OPTION VALUE= "ABM_Tareasreal.php">Mant Realizado</OPTION>
       <OPTION>-----------------</OPTION>
       <OPTION VALUE= "C_Movdisp1.php">Control Moviles</OPTION>
    </SELECT>
    </td>
    <td >
    <SELECT onclick="this.style.width = auto;" onblur="this.style.width = 130px;" style="width:130px; background-color:'.$se_color.';"  NAME="Atenciones" onchange="window.location.href=this.options[this.selectedIndex].value" style="background-color:'.$se_color.'" style="border:none">
       <OPTION VALUE= "Guardias.php" selected="selected">Guardias</OPTION>
       <OPTION VALUE= "ABM_Movdisp.php">Guardias Activas</OPTION>
       <OPTION VALUE= "C_Movdisp.php">Guardias Cerradas</OPTION>
       <OPTION>-----------------</OPTION>
       <OPTION VALUE= "ABM_Liqguardia0.php">Liquidaci�n Guardias</OPTION>
       <OPTION VALUE= "ABM_LiqguardiaMes.php">Liquidaci�n Mensual</OPTION>
       <OPTION VALUE= "EXP_LiqguardiaMes.php">Liq Mensual Excel</OPTION>
       <OPTION VALUE= "ABM_Datosliq.php">Par�metros Liquidaci�n</OPTION>
       <OPTION>-----------------</OPTION>
       <OPTION VALUE= "A_Guardias.php">Carga Guardias</OPTION>
       <OPTION VALUE= "ABM_Guardias.php">Consulta Guardias</OPTION>
    </SELECT>
    </td>
    <td >
    <SELECT onclick="this.style.width = auto;" onblur="this.style.width = 130px;" style="width:130px; background-color:'.$se_color.';"  NAME="Atenciones" onchange="window.location.href=this.options[this.selectedIndex].value" style="background-color:'.$se_color.'" style="border:none">
       <OPTION VALUE= "Farmacia.php" selected="selected">Farmacia</OPTION>
       <OPTION VALUE= "ABM_Articulos.php">ABM de stock</OPTION>
       <OPTION VALUE= "ABM_Novarticulos.php">Novedades stock</OPTION>
       <OPTION VALUE= "ABM_Botiquines.php">Botiquines</OPTION>
       <OPTION VALUE= "ABM_Actbotiquines.php">Recarga Botiquines</OPTION>
       <OPTION>-----------------</OPTION>
       <OPTION VALUE= "L_Gastobotiquines.php">Listado Consumo</OPTION>
    </SELECT>
    </td>
    <td >
    <SELECT onclick="this.style.width = auto;" onblur="this.style.width = 130px;" style="width:130px; background-color:'.$se_color.';"  NAME="Atenciones" onchange="window.location.href=this.options[this.selectedIndex].value" style="background-color:'.$se_color.'" style="border:none">
       <OPTION VALUE= "Facturaci�n.php" selected="selected">Facturaci�n</OPTION>
       <OPTION VALUE= "ABM_Facturas.php">Cons Facturas</OPTION>
       <OPTION VALUE= "A_Comprobantes.php">Genera Cuotas</OPTION>
       <OPTION VALUE= "A_Archtarjetas.php">Genera Arch Tarj</OPTION>
       <OPTION VALUE= "A_Impcomprobantes.php">Impr. Cupones</OPTION>
       <OPTION VALUE= "A_Pagocuotas.php">Cancela Cuotas</OPTION>
       <OPTION>-----------------</OPTION>
       <OPTION VALUE= "ABM_Cobranzas.php">Cobranzas</OPTION>
       <OPTION>-----------------</OPTION>
       <OPTION VALUE= "A_Ctrlcaja.php">Control Caja</OPTION>
       <OPTION>-----------------</OPTION>
       <OPTION VALUE= "EXP_Catenciones.php">Exportar Atenciones</OPTION>
    </SELECT>
    </td>
    <td >
    <SELECT onclick="this.style.width = auto;" onblur="this.style.width = 130px;" style="width:130px; background-color:'.$se_color.';"  NAME="Atenciones" onchange="window.location.href=this.options[this.selectedIndex].value" style="background-color:'.$se_color.'" style="border:none">
       <OPTION VALUE= "Seguridad.php" selected="selected">Seguridad</OPTION>
       <OPTION VALUE= "Cambio_clave.php">Cambio Clave</OPTION>
       <OPTION VALUE= "Forzar_clave.php">Mant Clave</OPTION>
       <OPTION VALUE= "ABM_Menusegu.php">Mant Seguridad</OPTION>
    </SELECT>
    </td>
    <td > <a href="Logout.php">Salir</a></td>
  </tr>
</table>';


//       <OPTION VALUE= "creafont.php">Fuentes</OPTION>
//       <OPTION VALUE= "ABM_Comprobantes.php">Impr. Cupones</OPTION>
//    <td ><a href="javascript:history.back(1)"</a><img border="0" src="'.$imagen_volver.'" width="55" height="35"  align="top" /></td>


 return $html_salida;

}


function titulo_encabezado_solo ($titulo , $imagen)
{
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
$G_funcion = $cookie->get("funcion");
$G_datoliq  = $cookie->get("datoliq");
$imagen_home = "imagenes/home.jpg";
$imagen_salida = "imagenes/salida.jpg";
$imagen_volver = "imagenes/Volver.ico";

global $body_color, $th_color, $td_color, $se_color,$bo_color,$fontdef, $fontt, $fontreg;

if ($G_usuario == null)
   $html_salida = 'Error -----  Usuario no conectado';
else
 $html_salida = '
 <table height="50" border="0" align="">
  <tr>
    <td scope="col" width="10%"> <img  src="'.$imagen.'" width="110" height="40"  align="top" /></td>
    <td scope="col" width="75%"><h3>'.$titulo.'</h3></td>
    <td scope="col" width="25%">
    <div id="infoUsuario">
        <b>Usuario: </b>'.$G_legajo.' <br />
        <b>Nombre: </b>'.$G_usuario.'<br />
        <b>Mensajes Nuevos: </b>'.muestra_msg().' </td>
    </div>
  </tr>';

 return $html_salida;

}


function muestra_fecha ()
{
 return $fecha = date("d.m.Y");
}

function muestra_hora ()
{
 return $hora = date("H:i:s");
}

function mensaje_ok ($pagina, $mensaje)
{
echo $pagina;
$mensaje_ok = '
<html>
<head>
    <script type="text/javascript">

function load()
 {
//  alert("alerta");
     location.href = \''.$pagina.' \'
 }
    </script>

 </head>
   <body onload="load()">
</BODY>

</HTML>
'; ///cierra comilla de $mensaje_ok

echo $mensaje_ok;
}


function mensaje_error ($pagina, $mensaje)
{
$mensaje_error = '
<html>
<head>
    <script type="text/javascript">

function load()
 {
   location.href = \''.$pagina.' \'
  alert("'.$mensaje.'");
 }
    </script>

 </head>
   <body onload="load()">
</BODY>
</HTML>
'; ///cierra comilla de $mensaje_error
echo $mensaje_error;

}


function valida_menu()
{
global $bd_host, $bd_user, $bd_pass, $bd_database, $bd;

$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
$G_funcion = $cookie->get("funcion");

$pagina = $_SERVER['PHP_SELF'];

$pagina = explode("/", $pagina);

$pag = "/".$pagina[2];


$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//Ejecutamos la sentencia SQL

$result=mysql_query("select * from segmenu WHERE pagina = '".$pag."'");

$row=mysql_fetch_array($result);

$per = "p".$G_perfil;

if ($row[$per] == "S")
  $validacion = "OK";
 else
  $validacion = "NO";

return($validacion);
}

function muestra_msg()
{
global $bd_host, $bd_user, $bd_pass, $bd_database, $bd;

$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
$G_funcion = $cookie->get("funcion");

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//Ejecutamos la sentencia SQL

$result=mysql_query("select * from mensajes where leido < '1' and a = '".$G_legajo."'");

$cant = mysql_num_rows($result);

return($cant);
}

function insertolog($usuario, $programa, $tabla, $accion, $fecha, $query)
{
    $hoy = date ("Y-m-d H:i:s");
    $log= 'insert into log (usuario, programa, tabla, accion, fecha, query)
         values ("'.$usuario.'","'.$programa.'","'.$tabla.'","'.$accion.'","'.$hoy.'","'.$query.'")';
    //echo $log;
    mysql_query($log);
    return($log);
}



function cambiarFormatoFecha($fecha)
{
    list($anio,$mes,$dia)=explode("-",$fecha);
    return $dia."/".$mes."/".$anio;
}

function cambiarFormatoFecha1($fecha)
{
    list($anio,$mes,$dia)=explode("/",$fecha);
    return $dia."/".$mes."/".$anio;
}

function cambiarFormatoFecha2($fecha)
{
    list($dia,$mes,$anio)=explode("/",$fecha);
    if ($anio < '2000')
       $anio = $anio + 2000;
    return $anio."/".$mes."/".$dia;
}

function cambiarFormatoHora($hora)
{
    list($hora,$min,$seg)=explode(":",$hora);
    return $hora.":".$min;
}


function buscopersonal($legajo)
{

$result=mysql_query("select * from legajos where legajo = '".$legajo."'");

$row=mysql_fetch_array($result);

return($row['apeynomb']);
}

function buscocliente($idcliente)
{

$result=mysql_query("select * from clientes where idcliente = '".$idcliente."'");

$row=mysql_fetch_array($result);

return($row['nombre']);
}

function buscocolor($idcolor)
{

$result=mysql_query("select * from colores where idcolor = '".$idcolor."'");

$row=mysql_fetch_array($result);

return($row['desc']);
}

function buscodiagnostico($iddiagnostico)
{

$result=mysql_query("select * from diagnosticos where iddiagnostico = '".$iddiagnostico."'");

$row=mysql_fetch_array($result);

return($row['descdiagnostico']);
}

function buscodestino($iddestino)
{

$result=mysql_query("select * from destino where iddestino = '".$iddestino."'");

$row=mysql_fetch_array($result);

return($row['destino']);
}

function buscoanulacion($idanulacion)
{

$result=mysql_query("select * from anulacion where idanulacion = '".$idanulacion."'");

$row=mysql_fetch_array($result);

return($row['descanulacion']);
}

function buscozona($idzonas)
{

$result=mysql_query("select * from zonas where idzonas = '".$idzonas."'");

$row=mysql_fetch_array($result);

return($row['desczonas']);
}

function buscoplan($idplan)
{

$result=mysql_query("select * from planes where idplan = '".$idplan."'");

$row=mysql_fetch_array($result);

return($row['descabrev']);
}

function buscomovil($idmovil)
{

$result=mysql_query("select * from moviles where idmovil = '".$idmovil."'");

$row=mysql_fetch_array($result);

return($row['descmovil']);
}

function buscomotivo($idmotivo, $idmotivo2)
{

$result=mysql_query("select * from motivos where idmotivo = '".$idmotivo."' and idmotivo2 = '".$idmotivo2."'");

$row=mysql_fetch_array($result);

return($row['desc']);
}

function buscoarticulo($idarticulo, $idrubro)
{

$result=mysql_query("select * from articulos where idarticulo = '".$idarticulo."' and rubro = '".$idrubro."'");

$row=mysql_fetch_array($result);

return($row['articulo']);
}

// Calcula la edad (formato: a�o/mes/dia)
function edad($edad)
{
list($anio,$mes,$dia) = explode("-",$edad);
$anio_dif = date("Y") - $anio;
$mes_dif = date("m") - $mes;
$dia_dif = date("d") - $dia;
if ($dia_dif < 0 || $mes_dif < 0)
$anio_dif--;
return $anio_dif;

}

function elimina_acentos($cadena){
$tofind = "�����������������������������������������������������";
$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
return(strtr($cadena,$tofind,$replac));
}

function elimina_caracteres($cadena){
$tofind = "/*.&$%=!";
$replac = " ";
return(strtr($cadena,$tofind,$replac));
}

function restaFechas ($dia,$mes,$anio) {
    return  (strftime("%d/%m/%Y",mktime(0,0,0,$mes,$dia,$anio) - 86400*1));
}

function restaHoras($horaIni, $horaFin){
    return (date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni) ));
}

function restaTimestamp ($dia , $mes , $anio , $hora , $min , $parametro_hora)
{
     $traslado_aux =  strftime("%d/%m/%Y",mktime($hora,$min,0,$mes,$dia,$anio) - ($parametro_hora*3600)).' '.
                      strftime("%H:%M:%S",mktime($hora,$min,0,$mes,$dia,$anio) - ($parametro_hora*3600));

    return substr ($traslado_aux , 6 , 4).'-'.substr ($traslado_aux , 3 , 2).'-'.substr ($traslado_aux , 0 , 2).substr ($traslado_aux , 10 , 9);
}

function determinocuota($periodo, $periodocont, $frecuencia)
{

$anio = substr($periodo, 0, 4);
$mes  = substr($periodo, 4, 2);

$aniocont = substr($periodocont, 0, 4);
$mescont  = substr($periodocont, 4, 2);

$retorno = '0';

if ($frecuencia == 'M')
{    if ($periodo == $periodocont)
      {$retorno = '0';}
     else
     { $retorno = '1';}
}

if ($frecuencia == 'B')
{     if ($anio == $aniocont)
        if ($mescont + 1 < $mes)
          { $retorno = '1';}
            else
            { $retorno = '0';}

       else
        {
         $mes = ($mes + (12 * ($anio - $aniocont)));
          if ($mescont + 1 < $mes)
           { $retorno = '1';}
             else
             { $retorno = '0';}

        }
}

if ($frecuencia == 'S')
{     if ($anio == $aniocont)
        if ($mescont + 5 < $mes)
           {  $retorno = '1';}
           else
            {$retorno = '0';}
       else
        {
         $mes = ($mes + (12 * ($anio - $aniocont)));
          if ($mescont + 5 < $mes)
             {$retorno = '1';}
            else
            {$retorno = '0';}

        }
}

if ($frecuencia == 'A')
{     if ($anio == $aniocont)
        { if ($mescont + 11 < $mes)
            {$retorno = '1';}
           else
            {$retorno = '0';}
         }
       else
        {
         $mes = ($mes + (12 * ($anio - $aniocont)));
          if ($mescont + 11 < $mes)
               {$retorno = '1';}
                 else
               {$retorno = '0';}

        }
}
//echo $retorno;
return($retorno);
}


function calcular_tiempo($hora1,$hora2)
{
    $separar[1]=explode(':',$hora1);
    $separar[2]=explode(':',$hora2);

    $total_minutos_trasncurridos[1] = ($separar[1][0]*60)+$separar[1][1];
    $total_minutos_trasncurridos[2] = ($separar[2][0]*60)+$separar[2][1];
    $total = $total_minutos_trasncurridos[1]-$total_minutos_trasncurridos[2];

    if ($hora1 < $hora2)
       $total = $total + 1440;


    return($total);

}

function calcular_horas($fecha1,$hora1,$fecha2,$hora2)
{
    $separar[1]=explode(':',$hora1);
    $separar[2]=explode(':',$hora2);

    list($ano1,$mes1,$dia1)=explode("-",$fecha1);
    list($ano2,$mes2,$dia2)=explode("-",$fecha2);

    //calculo timestam de las dos fechas
    $timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
    $timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2);

    $segundos_diferencia = $timestamp1 - $timestamp2;

    $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
    $dias_diferencia = abs($dias_diferencia);
    $dias_diferencia = floor($dias_diferencia);

    $total_minutos_trasncurridos[1] = ($separar[1][0]*60)+$separar[1][1];
    $total_minutos_trasncurridos[2] = ($separar[2][0]*60)+$separar[2][1];
    $total = $total_minutos_trasncurridos[1]-$total_minutos_trasncurridos[2];

  //  if ($hora1 < $hora2)
  //     {$total = $total + 1440;}

  //  if ($dias_diferencia > '0')
        $total = $total + ($dias_diferencia * 1440);

    return($total);

}

function titulo_encabezado_2 ($titulo , $imagen)
{
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
$G_funcion = $cookie->get("funcion");
$G_datoliq  = $cookie->get("datoliq");
$imagen_home = "imagenes/home.jpg";
$imagen_salida = "imagenes/salida.jpg";
$imagen_volver = "imagenes/Volver.ico";

global $body_color, $th_color, $td_color, $se_color,$bo_color,$fontdef, $fontt, $fontreg;

if ($G_usuario == null)
   $html_salida = 'Error -----  Usuario no conectado';
else
 $html_salida = '
 <table width="100%" height="70" border="0" align="" style=" font-family:\'Courier New\', Courier, monospace; font-size:12px">
  <tr>
    <td colspan = "3" scope="col"  > <img  src="'.$imagen.'" width="110" height="60"  align="top" /></td>
    <td  scope="col" align="center"><h1>'.$titulo.'</h1></td>
    <td  scope="col" align="right">('.$G_legajo.') '.$G_usuario.'<BR>
    '.muestra_fecha ().'<BR>
    '.muestra_hora().'<BR>
    '.muestra_msg().' MENSAJES NUEVOS</td>
  </tr>
</table>';

//    <td ><a href="javascript:history.back(1)"</a><img border="0" src="'.$imagen_volver.'" width="55" height="35"  align="top" /></td>


 return $html_salida;

}

/**
 * Funcionp para imprimir un array
 * formateado por tags <pre>
 *
 * @param array $str  Array para mostrar
 */
function pr($array){
    echo sprintf("<pre>%s</pre>", print_r($array, true));
}
?>