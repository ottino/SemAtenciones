<?php
//echo $_POST['id_atencion_temp'];
//echo "aaa",$_REQUEST["love"];
//funciones propias
include ('funciones.php');
include ('lista_rapido.php');

//archivo de configuracion
include_once ('config.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');

//login usuario
require_once ('cookie.php');

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// VARIABLES GLOBALES - DATOS DE USUARIO LOGON
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
$G_funcion = $cookie->get("funcion");


################### Control de usuarios##########################
/*
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
*/

//*  CONEXION A LA BASEDE DATOS
$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);
//*

// recupero datos de la emergencia
$idemergencia_temp = ltrim($_POST['id_atencion_temp'],'0');
$imagen_home = "imagenes/home.jpg";
$imagen_atiempo = "imagenes/Logo_a_tiempo.jpg";
$ordenar = $_POST['id_ordenar'];
if ($ordenar < '1')
   $ordenar = '1';

$or_color1 = $td_color;
$or_color2 = $td_color;
$or_color3 = $td_color;
$or_color4 = $td_color;

if ($ordenar == '1')
    $or_color1 = $body_color;
  else
  if ($ordenar == '2')
     $or_color2 = $body_color;
    else
    if ($ordenar == '3')
      $or_color3 = $body_color;
    else
      $or_color4 = $body_color;

######### XAJAX ##############################
//instanciamos el objeto de la clase xajax
$xajax = new xajax();
// funciones para la libreria
function refresca_moviles ()
{

     global $td_color , $idemergencia_temp;
    //*
    $consulta_movil_disponilbe = mysql_query (" SELECT a.idmovil AS idemovila, a. * , d. *
                                                FROM movildisponible a, moviles d
                                                WHERE a.idmovil = d.idmovil
                                                AND a.disponible = 0
                                                AND a.vigente    = '0'
                                                ORDER BY 1 ASC ");

    $vector_md= '<td align="center" width="" style=" background-color:'.$td_color.'">
                  <select name="moviles_disp" style=" background-color:'.$td_color.'" style="width:190px"
                   onchange="xajax_refresca_equipo(document.formulario.moviles_disp.value);oncli ();">
                   <option value="0" selected="selected">&nbsp;DISPONIBLES</option>';
    while ($fila=mysql_fetch_array($consulta_movil_disponilbe))
    $vector_md.= '<option value="'.$fila['idmovildisp'].'-'.$fila['idemovila'].'">'
                  .$fila['idemovila'].'&nbsp;-&nbsp;'.$fila['descmovil'].'</option>';

    $vector_md.= '<option value="DESASIGNAR" >&nbsp;DESASIGNAR</option>';
    $vector_md.= '</select></td>';

    $salida = $vector_md;
    //$salida="asdasd";
    $respuesta = new xajaxResponse();
    //escribimos en la capa con id="respuesta" el texto que aparece en $salida
    $respuesta->addAssign("muestra_moviles","innerHTML",$salida);

   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;

}

function refresca_equipo($idmovildisp){

   global $td_color;
   global $fontdef;

   $idmovildisp = explode ("-",$idmovildisp);
   $idmovildisp = $idmovildisp[0];
   if (($idmovildisp[0] <> 0))
   {
   // consulta los tres legajos
   $consulta_legajos = mysql_query ("SELECT legmedico , legchofer , legenfermero
                                     FROM movildisponible
                                     WHERE idmovildisp =".$idmovildisp); //idplan - descplan
   //*

   $legajos_disponibles=mysql_fetch_array($consulta_legajos);

   $consulta_medico = mysql_query ("SELECT apeynomb
                                     FROM legajos
                                     WHERE legajo =".$legajos_disponibles['legmedico']); //idplan - descplan
   $medico=mysql_fetch_array($consulta_medico);


   $consulta_chofer = mysql_query ("SELECT apeynomb
                                     FROM legajos
                                     WHERE legajo =".$legajos_disponibles['legchofer']); //idplan - descplan
   $chofer=mysql_fetch_array($consulta_chofer);

   $consulta_enfermero = mysql_query ("SELECT apeynomb
                                     FROM legajos
                                     WHERE legajo =".$legajos_disponibles['legenfermero']); //idplan - descplan
   $enfermero=mysql_fetch_array($consulta_enfermero);

   $td_medico='
   <table width="100%"  border="0" style="border:inherit">
   <tr>
    <td style=" background-color:'.$td_color.' ;  font-size:'.$fontdef.'">
     <img src="imagenes/68.ico" width="16" height="15" />&nbsp;&nbsp;Medico:&nbsp;'.elimina_caracteres(htmlentities($medico['apeynomb'])).'&nbsp;&nbsp;&nbsp;
     <img src="imagenes/68.ico" width="16" height="15" />&nbsp;&nbsp;Chofer:&nbsp;'.elimina_caracteres(htmlentities($chofer['apeynomb'])).'&nbsp;&nbsp;&nbsp;
     <img src="imagenes/68.ico" width="16" height="15" />&nbsp;&nbsp;Enfermero:&nbsp;'.elimina_caracteres(htmlentities($enfermero['apeynomb'])).'&nbsp;&nbsp;&nbsp;
    </td>
   <tr>
   <table>
    ';


   //$salida = .'-'.$chofer['apeynomb'].'-'.$enfermero['apeynomb'];
   $salida= $td_medico.$td_chofer.$td_enfermero;
   } else
   $salida = '
               <table width="100%"  border="0" style="border:inherit">
               <tr>
                <td style=" background-color:'.$td_color.'  ;  font-size:'.$fontdef.'">
                 <img src="imagenes/68.ico" width="16" height="15" />&nbsp;&nbsp;Medico:&nbsp;ASIGNAR&nbsp;&nbsp;&nbsp;
                 <img src="imagenes/68.ico" width="16" height="15" />&nbsp;&nbsp;Chofer:&nbsp;ASIGNAR&nbsp;&nbsp;&nbsp;
                 <img src="imagenes/68.ico" width="16" height="15" />&nbsp;&nbsp;Enfermero:&nbsp;ASIGNAR&nbsp;&nbsp;&nbsp;
                </td>
               <tr>
               <table> ';

   //$salida = $idmovildisp;
   //$salida = "asdasd";
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("muestra_equipo","innerHTML",$salida);

   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function asigna_movil($idatencion_temp,$idmovildisp)
{
   $hora_cero = 0;
   if ($idmovildisp == 'DESASIGNAR')
   {
    $CONSULTA_MOVIL =mysql_fetch_array( mysql_query ("select * from atenciones_temp where id = ".$idatencion_temp) );
    if ($CONSULTA_MOVIL['movil'] <> '0')
    {
     $UPDATE_MOVIL_DISP =mysql_query ("update movildisponible SET disponible = 0 where idmovildisp = ".$CONSULTA_MOVIL['movil_2']);
     $update_atencion   = mysql_query("update atenciones_temp
                                             set 
											     fecha = fechallam,
												 movil        = 0 ,
                                                 movil_2      = 0 ,
                                                 horadesp     = '00:00:00' ,
                                                 horasalbase  = '00:00:00' ,
                                                 horallegdom  = '00:00:00' ,
                                                 horasaldom   = '00:00:00' ,
                                                 horalleghosp = '00:00:00' ,
                                                 horasalhosp  = '00:00:00' ,
                                                 horadisp     = '00:00:00' ,
                                                 horalib      = '00:00:00' ,
												 fechallam    = fecha
                                             where id = ".$idatencion_temp);
     $hora_cero = 1;
    }
   }
   else
   {
   $CONSULTA_MOVIL =mysql_fetch_array( mysql_query ("select * from atenciones_temp where id = ".$idatencion_temp) );
   if ($CONSULTA_MOVIL['horalib'] == '00:00:00')
   {
    $UPDATE_MOVIL_DISP =mysql_query ("update movildisponible SET disponible = 0 where idmovildisp = ".$CONSULTA_MOVIL['movil_2']);
    $update_atencion   = mysql_query("update atenciones_temp set movil = 0 , movil_2 = 0 where id = ".$idatencion_temp);
   }
   // para mostrar despachador
   global $G_legajo , $G_usuario;

   $idmovildisp   =  explode ("-",$idmovildisp);
   $idmovildisp_1 =  $idmovildisp[0];
   $idmovildisp_2 =  $idmovildisp[1];

   $consulta_control = mysql_query("select * from atenciones_temp where id=".$idatencion_temp);
   $control = mysql_fetch_array($consulta_control);

   $consulta_doctores = mysql_query("select * from movildisponible where idmovildisp='".$idmovildisp_1."'");
   $doctores = mysql_fetch_array($consulta_doctores);

   if ($control['movil'] == '0')
      {
       $horapase = date("H:i:s");
       $update_atencion   = mysql_query("update atenciones_temp set
                                                                chofer = '".$doctores['legchofer']."' ,
                                                                medico = '".$doctores['legmedico']."' ,
                                                                enfermero = '".$doctores['legenfermero']."' ,
                                                                opedesp = ".$G_legajo." ,
                                                                movil= '".$idmovildisp_2."' ,
                                                                movil_2='".$idmovildisp_1."'  ,
                                                                horadesp ='".$horapase."'
                                                                where id='".$idatencion_temp."'");
       $update_movil_disp = mysql_query("update movildisponible set disponible= 1  where idmovildisp='".$idmovildisp_1."'");
       $horapase =date("H:i:s");
      }
    }
    $CONSULTA_MOVIL =mysql_fetch_array( mysql_query ("select * from atenciones_temp where id = ".$idatencion_temp) );

   /*
     update atenciones_temp set movil = 0 , movil_2 = 0;
     update movildisponible set disponible= 0;
      */
   //$salida = $update;
   $salida = '';
   //$salida = $update_movil_disp;
   //$salida = $update_atencion ;
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("update","innerHTML",$salida);
   $respuesta->addAssign("muestra_pasedespacho","innerHTML",$CONSULTA_MOVIL['horadesp']);
   $respuesta->addAssign("muestra_despachador","innerHTML",substr($G_usuario,0,10));

   if ($hora_cero == 1)
   {
    $hora_cero = '00:00:00';
    $BOTON = '';
    $respuesta->addAssign("muestra_salida_base","innerHTML",$hora_cero);
    $respuesta->addAssign("muestra_llegada_dom","innerHTML",$hora_cero);
    $respuesta->addAssign("muestra_salida_dom","innerHTML",$hora_cero);
    $respuesta->addAssign("muestra_llegada_hosp","innerHTML",$hora_cero);
    $respuesta->addAssign("muestra_salida_hosp","innerHTML",$hora_cero);
    $respuesta->addAssign("muestra_liberado","innerHTML",$hora_cero);
    $respuesta->addAssign("muestra_boton","innerHTML",$BOTON );
   }
   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;

}

function control_salida_base($idatencion_temp)
{
   $consulta_control = mysql_query("select * from atenciones_temp where id=".$idatencion_temp);
   $control = mysql_fetch_array($consulta_control);

   if (($control['movil'] <> '0') and ($control['horadesp'] <> '00:00:00') and ($control['horasalbase'] == '00:00:00'))
     {
       $salida= date("H:i:s");
       $update_atencion   = mysql_query("update atenciones_temp set horasalbase ='".$salida."'
                                                                where id='".$idatencion_temp."'");
     }
   else if ($control['horasalbase']  <> '00:00:00')
            {
             $salida= $control['horasalbase'] ;
            }
            else $salida=' <img src="imagenes/11.ico" width="23" height="23"  /> &nbsp; Falta asignar despacho';

   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("muestra_salida_base","innerHTML",$salida);

   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function control_llegada_dom($idatencion_temp)
{
   $consulta_control = mysql_query("select * from atenciones_temp where id=".$idatencion_temp);
   $control = mysql_fetch_array($consulta_control);

   if (($control['movil'] <> '0')              and
       ($control['horadesp'] <> '00:00:00')    and
       ($control['horasalbase'] <> '00:00:00') and
       ($control['horallegdom'] == '00:00:00'))
     {
       $salida= date("H:i:s");
	   $_fecha_= date("Y.m.d");
       $update_atencion   = mysql_query("update atenciones_temp set
																fechallam = fecha ,
																fecha = '".$_fecha_."' ,
																horallegdom ='".$salida."'
                                                                where id='".$idatencion_temp."'");
     }
   else if ($control['horallegdom']  <> '00:00:00')
            {
             $salida= $control['horallegdom'] ;
            }
            else $salida=' <img src="imagenes/11.ico" width="23" height="23"  /> &nbsp Asignar salida de base';

   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("muestra_llegada_dom","innerHTML",$salida);

   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function control_salida_dom($idatencion_temp)
{
   $consulta_control = mysql_query("select * from atenciones_temp where id=".$idatencion_temp);
   $control = mysql_fetch_array($consulta_control);
   $mostrar_boton='F';

   if (($control['movil'] <> '0')              and
       ($control['horadesp'] <> '00:00:00')    and
       ($control['horasalbase'] <> '00:00:00') and
       ($control['horallegdom'] <> '00:00:00') and
       ($control['horasaldom'] == '00:00:00'))
     {
       $salida= date("H:i:s");
       $update_atencion   = mysql_query("update atenciones_temp set horasaldom ='".$salida."'
                                                                where id='".$idatencion_temp."'");
       $mostrar_boton='V';
     }
   else if ($control['horasaldom']  <> '00:00:00')
            {
             $salida= $control['horasaldom'] ;
            }
            else $salida=' <img src="imagenes/11.ico" width="23" height="23"  /> &nbsp; Asignar lleg. domicilio';

//   if ($mostrar_boton == 'V')
//      $BOTON = '<input type="button"  value ="cerrar" width="30" height="12" onclick="load_cierre();"/>';
//    else  $BOTON = '';

/*
   function load_cierre()
  {
   window.open("cierre_atencion.php?idate_temp");
  }

</script>
*/
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("muestra_salida_dom","innerHTML",$salida);
//   $respuesta->addAssign("muestra_boton","innerHTML",$BOTON);


   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function control_liberado($idatencion_temp)
{
   $consulta_control = mysql_query("select * from atenciones_temp where id=".$idatencion_temp);
   $control = mysql_fetch_array($consulta_control);
   $mostrar_boton='F';

   if (($control['movil'] <> '0')              and
       ($control['horadesp'] <> '00:00:00')    and
       ($control['horasalbase'] <> '00:00:00') and
       ($control['horallegdom'] <> '00:00:00') and
       ($control['horasaldom'] <> '00:00:00') and
       ($control['horalib'] == '00:00:00')
       )
     {
       $salida= date("H:i:s");
       $update_atencion   = mysql_query("update atenciones_temp set horalib ='".$salida."' ,
                                                                    abierta = 1
                                                                    where id='".$idatencion_temp."'");

      //$CONSULTA_MOVIL =mysql_fetch_array( mysql_query ("select * from atenciones_temp where id = ".$idatencion_temp) );
      //$UPDATE_MOVIL_DISP =mysql_query ("update movildisponible SET disponible = 0 where idmovildisp = ".$CONSULTA_MOVIL['movil_2']);


       $mostrar_boton='V';
     }
   else if ($control['horalib']  <> '00:00:00')
            {
             $salida= $control['horalib'] ;
            }
            else $salida=' <img src="imagenes/11.ico" width="23" height="23"  /> &nbsp; Asignar salida domicilio';

   if (($mostrar_boton == 'V') || ($control['horalib']  <> '00:00:00'))
      $BOTON = '<form> <input type="button"  value ="cerrar" width="30" height="12" onclick="this.form.submit();load_cierre();"/> </form>';
    else  $BOTON = '';


/*
   function load_cierre()
  {
   window.open("cierre_atencion.php?idate_temp");
  }

</script>
*/
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("muestra_liberado","innerHTML",$salida);
   $respuesta->addAssign("muestra_boton","innerHTML",$BOTON);


   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}


function control_llegada_hosp($idatencion_temp)
{
   $consulta_control = mysql_query("select * from atenciones_temp where id=".$idatencion_temp);
   $control = mysql_fetch_array($consulta_control);

    //   ($control['horasalbase'] <> '00:00:00') and
    //   ($control['horallegdom'] <> '00:00:00') and
    //   ($control['horasaldom'] <> '00:00:00')  and

   if (($control['movil'] <> '0')              and
       ($control['horadesp'] <> '00:00:00')    and
       ($control['horalleghosp'] == '00:00:00'))
     {
       $salida= date("H:i:s");
       $update_atencion   = mysql_query("update atenciones_temp set horalleghosp ='".$salida."'
                                                                where id='".$idatencion_temp."'");
     }
   else if ($control['horalleghosp']  <> '00:00:00')
            {
             $salida= $control['horalleghosp'] ;
            }
            else $salida=' <img src="imagenes/11.ico" width="23" height="23"  /> &nbsp; Faltar asignar despacho';

   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("muestra_llegada_hosp","innerHTML",$salida);

   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function control_salida_hosp($idatencion_temp)
{
   $consulta_control = mysql_query("select * from atenciones_temp where id=".$idatencion_temp);
   $control = mysql_fetch_array($consulta_control);

      // ($control['horasalbase'] <> '00:00:00')  and
      // ($control['horallegdom'] <> '00:00:00')  and
      // ($control['horasaldom'] <> '00:00:00')   and
      // ($control['horalleghosp'] <> '00:00:00') and

   if (($control['movil'] <> '0')               and
       ($control['horadesp'] <> '00:00:00')     and
       ($control['horasalhosp'] == '00:00:00'))
     {
       $salida= date("H:i:s");
       $update_atencion   = mysql_query("update atenciones_temp set horasalhosp ='".$salida."'
                                                                where id='".$idatencion_temp."'");
     }
   else if ($control['horasalhosp']  <> '00:00:00')
            {
             $salida= $control['horasalhosp'] ;
            }
            else $salida=' <img src="imagenes/11.ico" width="23" height="23"  /> &nbsp; Faltar asignar despacho';

   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("muestra_salida_hosp","innerHTML",$salida);

   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function control_llegada_base($idatencion_temp)
{
   $consulta_control = mysql_query("select * from atenciones_temp where id=".$idatencion_temp);
   $control = mysql_fetch_array($consulta_control);

   if (($control['movil'] <> '0')               and
       ($control['horadesp'] <> '00:00:00')     and
       ($control['horasalbase'] <> '00:00:00')  and
       ($control['horallegdom'] <> '00:00:00')  and
       ($control['horasaldom'] <> '00:00:00')   and
       ($control['horalleghosp'] <> '00:00:00') and
       ($control['horasalhosp'] <> '00:00:00')  and
       ($control['horadisp'] == '00:00:00'))
     {
       $salida= date("H:i:s");
       $update_atencion   = mysql_query("update atenciones_temp set horadisp ='".$salida."',
                                                                    abierta = 1
                                                                where id='".$idatencion_temp."'");
       $hora_aux = $salida;
     }
   else if ($control['horadisp']  <> '00:00:00')
            {
             $salida= $control['horadisp'] ;
             $hora_aux = $salida;
            }
            else {
                  $salida=' <img src="imagenes/11.ico" width="23" height="23"  /> &nbsp; Asignar salida hospital';
                  $hora_aux = '00:00:00';
                 }

   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("muestra_llegada_base","innerHTML",$salida);
   $respuesta->addAssign("muestra_hora_disp","innerHTML",$hora_aux);
   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function control_reclamo_1($idatencion_temp)
{
   $consulta_control = mysql_query("select * from atenciones_temp where id=".$idatencion_temp);
   $control = mysql_fetch_array($consulta_control);

   $salida= date("H:i:s");
   $update_atencion   = mysql_query("update atenciones_temp set reclamo_1 ='".$salida."'
                                                                where id='".$idatencion_temp."'");
   if (mysql_affected_rows() == 0)
      $salida = '00:00:00';

   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("muestra_reclamo_1","innerHTML",$salida);

   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function control_reclamo_2($idatencion_temp)
{
   $consulta_control = mysql_query("select * from atenciones_temp where id=".$idatencion_temp);
   $control = mysql_fetch_array($consulta_control);

   if (($control['reclamo_1']  <> '00:00:00'))
     {
       $salida= date("H:i:s");
       $update_atencion   = mysql_query("update atenciones_temp set reclamo_2 ='".$salida."'
                                                                where id='".$idatencion_temp."'");
     }else $salida = '00:00:00';

   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("muestra_reclamo_2","innerHTML",$salida);

   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function control_reclamo_3($idatencion_temp)
{
   $consulta_control = mysql_query("select * from atenciones_temp where id=".$idatencion_temp);
   $control = mysql_fetch_array($consulta_control);

   if (($control['reclamo_2']  <> '00:00:00'))
     {
       $salida= date("H:i:s");
       $update_atencion   = mysql_query("update atenciones_temp set reclamo_3 ='".$salida."'
                                                                where id='".$idatencion_temp."'");
     }else $salida = '00:00:00';

   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("muestra_reclamo_3","innerHTML",$salida);

   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}
$xajax->registerFunction("refresca_equipo");
$xajax->registerFunction("asigna_movil");
$xajax->registerFunction("refresca_moviles");
$xajax->registerFunction("control_salida_base");
$xajax->registerFunction("control_llegada_dom");
$xajax->registerFunction("control_salida_dom");
$xajax->registerFunction("control_llegada_hosp");
$xajax->registerFunction("control_salida_hosp");
$xajax->registerFunction("control_liberado");
$xajax->registerFunction("control_llegada_base");
$xajax->registerFunction("control_reclamo_1");
$xajax->registerFunction("control_reclamo_2");
$xajax->registerFunction("control_reclamo_3");
//$xajax->registerFunction("text_pasedespacho");
//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequests();


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
if (($idemergencia_temp <> null)) //and ($atencion_datos <> null))
{
$consulta_atencion = mysql_query("select * from atenciones_temp where id=".$idemergencia_temp);
$atencion_datos = mysql_fetch_array($consulta_atencion);
$consulta_zona = mysql_query ("select * from zonas where idzonas= '".$atencion_datos['zona']."'");
$zona = mysql_fetch_array($consulta_zona);
$consulta_plan = mysql_query ("select * from planes where idplan= '".$atencion_datos['plan']."'");
$plan = mysql_fetch_array($consulta_plan);
$consulta_receptor = mysql_query ("select * from legajos where legajo=".$atencion_datos['operec']);
$receptor = mysql_fetch_array($consulta_receptor);
$receptor_nombre= explode(",",$receptor['apeynomb']);

$cons_padron_datos = mysql_query("select * from padron where idpadron='".$atencion_datos['socio']."'");
$padron_datos_para_obs = mysql_fetch_array($cons_padron_datos );

if ($atencion_datos['opedesp'] != null)
 {
  $consulta_ope_desp_nombre = mysql_query("select * from legajos where legajo=".$atencion_datos['opedesp']);
  $opedesp_nombre = mysql_fetch_array($consulta_ope_desp_nombre);
  $opedesp_nombre = $opedesp_nombre['apeynomb'];
 }
else $opedesp_nombre="";

if ($atencion_datos['plan'] != null)
 {
  $consulta_plan_desc = mysql_query("select * from planes where idplan= '".$atencion_datos['plan']."'");
  $plan_desc = mysql_fetch_array($consulta_plan_desc);
  $plan_desc_1 = $plan_desc['descplan'];
  $plan_desc = $plan_desc['datos'];
 }
else $plan_desc="&nbsp;";

if ($atencion_datos['motivo1'] != null)
 {
  $consulta_motivo_desc = mysql_query("select * from motivos where idmotivo=".$atencion_datos['motivo1']." and idmotivo2 =".$atencion_datos['motivo2']);
  $fila_motivos = mysql_fetch_array($consulta_motivo_desc);
  $motivo_desc = $fila_motivos['desc'];
 }
else $motivo_desc="&nbsp;";

if ($atencion_datos['abierta'] == '1')
 $BOTON = '<form><input type="button"  value ="cerrar" width="30" height="12" onclick="this.form.submit();load_cierre();"/></form>';
else $BOTON = '&nbsp;';

// ESTADISTICAS DE TOTALES POR FOQUITOS
$cons_cantidad_traslados_pendi = mysql_query ("
                                          SELECT count(*) AS CANTIDAD
                                          FROM atenciones_temp
                                          WHERE (color = '4')
                                          AND traslado_aux > now( )
                                          AND abierta <> '2'
                                          ORDER BY color ASC , id ASC ");
$cantidad_traslados_pendi = mysql_fetch_array($cons_cantidad_traslados_pendi);

$cons_cantidad_eventos_pendi = mysql_query ("
                                          SELECT count(*) AS CANTIDAD
                                          FROM atenciones_temp
                                          WHERE (color = '7')
                                          AND traslado_aux > now( )
                                          AND abierta <> '2'
                                          ORDER BY color ASC , id ASC");
$cantidad_eventos_pendi = mysql_fetch_array($cons_cantidad_eventos_pendi);

$consulta_foquitos_est = mysql_query ("SELECT color, count( * ) AS cantidad
                                       FROM atenciones_temp
                                       WHERE abierta <> '2'
                                       GROUP BY color
                                       ORDER BY 2 desc");

while ($fila=mysql_fetch_array($consulta_foquitos_est))
{
if ($fila['color'] == 4)
 {
  //if ($cantidad_traslados_pendi['CANTIDAD'] < $fila['cantidad'])
  $foquitos_est.=$fila['cantidad']-$cantidad_traslados_pendi['CANTIDAD'].'&nbsp;&nbsp;<img src="imagenes/'.$fila['color'].'.ico" width="15" height="15" />&nbsp;&nbsp;';
 }else
 if ($fila['color'] == 7)
 {
  //if ($cantidad_traslados_pendi['CANTIDAD'] < $fila['cantidad'])
  $foquitos_est.=$fila['cantidad']-$cantidad_eventos_pendi['CANTIDAD'].'&nbsp;&nbsp;<img src="imagenes/'.$fila['color'].'.ico" width="15" height="15" />&nbsp;&nbsp;';
 }else
 {
   $foquitos_est.=$fila['cantidad'].'&nbsp;&nbsp;<img src="imagenes/'.$fila['color'].'.ico" width="15" height="15" />&nbsp;&nbsp;';
 }
}
$consulta_cantidad_total_est = mysql_query ("SELECT count( * ) AS cantidad
                                       FROM atenciones_temp
                                       WHERE abierta <> '2'");

$cantidad_total_est = mysql_fetch_array($consulta_cantidad_total_est);
//----------


}
$html_salida = '
<html>
<head>
<title>Modulo para alta de Emergencias</title>
   '.$xajax->printJavascript("xajax/").'
</head>
<style type="text/css">
<!--
.style2 {color: #0000CC}
-->
</style>
<script defer type="text/javascript" src="jsfunciones.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language="javascript"  type="text/javascript">
function load_cierre()
 {
  window.open("cierre_atencion.php?id='.$idemergencia_temp.'");
 }
function load_alta()
 {
  window.open("mod_alta.php");
 }

 function func_onload() {
   xajax_refresca_moviles();
   xajax_refresca_equipo('.$atencion_datos['movil_2'].'-0);
   mueveReloj();
 }
//*******************************
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

if (!xmlhttp && typeof XMLHttpRequest!=\'undefined\') {
 xmlhttp = new XMLHttpRequest();
}
return xmlhttp;
}



function cargarContenido(){
 nombre = "llamados";
 pagina1="online_atenciones.php";
 var contenedor;
 contenedor = document.getElementById(nombre);
 ajax=nuevoAjax();
 ajax.open(\'GET\', pagina1 + "?id_AA='.$idemergencia_temp.'&orden='.$ordenar.'", true);

 ajax.onreadystatechange=function	() {
  if (ajax.readyState==4) {
   contenedor.innerHTML = ajax.responseText
  }
  }

ajax.send(null)
}
setInterval("cargarContenido();",10000);
//*******************************

function oncli ()
{
 var objeto= document.getElementById("imagen");
 objeto.onclick();
}
</script>
<script language="JavaScript">
function mueveReloj(){
    momentoActual = new Date()
    hora = momentoActual.getHours()
    minuto = momentoActual.getMinutes()
    segundo = momentoActual.getSeconds()

    horaImprimible = hora + " : " + minuto + " : " + segundo

    document.formulario.reloj.value = horaImprimible

    setTimeout("mueveReloj()",7000)
    setTimeout("xajax_refresca_moviles(); ",7000)
    //setTimeout("xajax_refresca_equipo('.$atencion_datos['movil_2'].'-0); ",30000)
}
</script>
</head>
<body style="background-color:'.$body_color.'" onload="func_onload();cargarContenido();" >
<div id="encabezado"></div>
<table width="100%"  border="0" style="font-size:'.$fontdef.'">
  <tr>
    <td width="10%" rowspan="2" style=" background-color:'.$td_color.'" align="center"><img border="0" src="'.$imagen_atiempo.'" width="55" height="35"  align="center" /></td>
    <td width="6%" style=" background-color:'.$td_color.'" height="30">Socio</td>
    <td width="3%" style=" background-color:'.$td_color.'"><input size = 30 type="text" disabled="disabled" value="'.$idemergencia_temp.'&nbsp;-&nbsp;'.elimina_caracteres(htmlentities($atencion_datos['nombre'])).'" /></td>
    <td width="2%" style=" background-color:'.$td_color.'" >Edad</td>
    <td width="2%" style=" background-color:'.$td_color.'"><input size = 2 type="text" disabled="disabled" value="'.$atencion_datos['edad'].'" /></td>
    <td width="4%" style=" background-color:'.$td_color.'" >Sexo</td>
    <td width="1%" style=" background-color:'.$td_color.'"><input size = 1 type="text" disabled="disabled" value="'.$atencion_datos['sexo'].'" /></td>
    <td width="3%" style=" background-color:'.$td_color.'" >Tel</td>
    <td width="5%" style=" background-color:'.$td_color.'"><input size = 15 type="text" disabled="disabled" value="'.$atencion_datos['telefono'].'" /></td>
    <td width="4%" style=" background-color:'.$td_color.'" >Zona</td>
    <td width="3%" style=" background-color:'.$td_color.'"><input size = 7 type="text" disabled="disabled" value="'.$zona['idzonas'].'" /></td>
    <td width="1%" style=" background-color:'.$td_color.'"><input size = 1 type="text" disabled="disabled" value="'.$zona['fuerazona'].'" /></td>
    <td width="20%" style=" background-color:'.$td_color.'"><input size = 45 type="text" disabled="disabled" value="'.elimina_caracteres(htmlentities($zona['desczonas'])).'" /></td>
    <td rowspan="2" style=" background-color:'.$td_color.'" align="center"><a href="Principal.php?"</a> <img border="0" src="'.$imagen_home.'" width="55" height="35"  align="center" /></td>
  </tr>
  <tr>
    <td width="6%" style=" background-color:'.$td_color.'" height="30" align="">Plan</td>
    <td width="3%" style=" background-color:'.$td_color.'" colspan=3><input size = 55 type="text" disabled="disabled" value="'.$plan['idplan'].'&nbsp;&nbsp;-&nbsp;&nbsp;'.elimina_caracteres(htmlentities($plan['descplan'])).'" /></td>
    <td width="4%" style=" background-color:'.$td_color.'" colspan=2 style=" background-color:#999999" align="">IDENT</td>
    <td width="4%" style=" background-color:'.$td_color.'" colspan=3 ><input size = 20 type="text" disabled="disabled" value="'.elimina_caracteres(htmlentities($atencion_datos['identificacion'])).'" /></td>
    <td width="4%" style=" background-color:'.$td_color.'" colspan=1 style=" background-color:#999999" align="">Barrio</td>
    <td width="4%" style=" background-color:'.$td_color.'" colspan=2 ><input size = 48 type="text" disabled="disabled" value="'.elimina_caracteres(htmlentities($atencion_datos['barrio'])).'" /></td>
  </tr>
  <tr>
   <td colspan=12 align="center" style=" background-color:'.$td_color.' ; '.$font_family.' ; font-size:'.$fontdef.'">
    <img src="imagenes/241.ico" width="16" height="15" />&nbsp;EN LINEA:&nbsp;'.($cantidad_total_est['cantidad']  - $cantidad_traslados_pendi['CANTIDAD'] - $cantidad_eventos_pendi['CANTIDAD']).'&nbsp;&nbsp;&nbsp;'.$foquitos_est.'
    PENDIENTES ('.($cantidad_traslados_pendi['CANTIDAD'] + $cantidad_eventos_pendi['CANTIDAD']).'): Traslados '.$cantidad_traslados_pendi['CANTIDAD'].'  Eventos '.$cantidad_eventos_pendi['CANTIDAD'].'
    DETALLE  <img style="CURSOR: hand" src="imagenes/Alert 01.ico" width="16" height="16" onClick="window.open(\'popup_traslados_pendi.php\',\'ANULACIONES\', \'width=1200,height=700,scrollbars=yes\');"/>
   </td>
   <td colspan=8>
    <table style=" background-color:'.$td_color.' ; '.$font_family.' ; font-size:'.$fontdef.'">
    <tr>
    <td  align="left" style=" background-color:'.$td_color.' ; '.$font_family.' ; font-size:'.$fontdef.'">
        <img src="imagenes/ordenar.ico" width="15" height="16" />&nbsp;Ordenar :
    </td>
    <td>&nbsp;</td>
   <form method="POST" action="atenciones.php">
    <td  align="left" style=" background-color:'.$or_color1.' ; '.$font_family.' ; font-size:'.$fontdef.'">
      <label onclick="this.form.submit();" style="CURSOR: hand">
      ID
      <input type="hidden" name="id_ordenar" value="1" />
      <input type="hidden" name="id_atencion_temp" value="'.$idemergencia_temp.'" />
      </label>
    </td>
    <td>&nbsp;</td>
    </form>
    <form method="POST" action="atenciones.php">
    <td align="left" style=" background-color:'.$or_color2.' ; '.$font_family.' ; font-size:'.$fontdef.'">
     <label onclick="this.form.submit();" style="CURSOR: hand">
      Zona
      <input type="hidden" name="id_ordenar" value="2" />
      <input type="hidden" name="id_atencion_temp" value="'.$idemergencia_temp.'" />
      </label>
    </td>
    <td>&nbsp;</td>
   </form>
     <form method="POST" action="atenciones.php">
    <td align="left" style=" background-color:'.$or_color4.' ; '.$font_family.' ; font-size:'.$fontdef.'">
     <label onclick="this.form.submit();" style="CURSOR: hand">
      Plan
      <input type="hidden" name="id_ordenar" value="4" />
      <input type="hidden" name="id_atencion_temp" value="'.$idemergencia_temp.'" />
      </label>
    </td>
    <td>&nbsp;</td>
   </form>
     <form method="POST" action="atenciones.php">
    <td align="left" style=" background-color:'.$or_color3.' ; '.$font_family.' ; font-size:'.$fontdef.'">
     <label onclick="this.form.submit();" style="CURSOR: hand">
      Movil
      <input type="hidden" name="id_ordenar" value="3" />
      <input type="hidden" name="id_atencion_temp" value="'.$idemergencia_temp.'" />
      </label>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </form>
   </tr>
  </table>
  </td>
  </tr>

</table>
<table border="0" style="font-size:'.$fontdef.'">
<tr>
 <td valign="top">
 <table   border="0"  style="border:inherit ; font-size:'.$fontdef.'">
  <tr>
    <form name="formulario">
    <input style=" background-color:'.$td_color.'"type="hidden" name="reloj" size="8">
    <td colspan="2" align="center" style=" background-color:'.$td_color.'">Moviles</td></tr>
    <tr><td width="25%"><div id="muestra_moviles"></div></td>
    <td width="10%" align="center" style="CURSOR: hand">
      <input type="hidden" name="imagen" value="imagen" onclick="check_movil('.$idemergencia_temp.',
                                document.formulario.moviles_disp.value,
                                '.$atencion_datos['movil'].');" />
    <tr></tr><tr></tr><tr></tr></td>
    </form></table>
  <table  width="100%" border="0"  style="border:inherit ; font-size:'.$fontdef.'">
  </tr>
  <tr>
    <td width="50%" style=" background-color:'.$td_color.'">Llamado</td>
    <td width="15%" align="center"  style=" background-color:'.$td_color.'">&nbsp;'.$atencion_datos['horallam'].'&nbsp;</td>
    <td width="30%" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td style=" background-color:'.$td_color.'">Pase a Despacho</td>
    <td align="center" style=" background-color:'.$td_color.'"><div id="muestra_pasedespacho">'.$atencion_datos['horadesp'].'</div></td>
    <td align="center" >&nbsp;</td>
  </tr>
  <tr>
    <td style=" background-color:'.$td_color.'">&nbsp;</td>
    <td style=" background-color:'.$td_color.'" align="center">Demora</td>
    <td align="center" >&nbsp;</td>
  </tr>
  <tr>
    <td style=" background-color:'.$td_color.'">Salida Base</td>
    <td align="center" style=" background-color:'.$td_color.'"><div id="muestra_salida_base">'.$atencion_datos['horasalbase'].'</div></td>
    <td align="center">
     <img src="imagenes/reloj.gif" width="41" height="27" style="CURSOR: hand" alt=\'Asignar salida base\'
          onclick="xajax_control_salida_base('.$idemergencia_temp.')"/>
    </td>
  </tr>
  <tr>
    <td style=" background-color:'.$td_color.'">Lleg. Domicilio</td>
    <td align="center" style=" background-color:'.$td_color.'"><div id="muestra_llegada_dom">'.$atencion_datos['horallegdom'].'</div></td>
    <td align="center">
        <img src="imagenes/reloj.gif" width="41" height="27" style="CURSOR: hand" alt=\'Asignar llegada domicilio\'
          onclick="xajax_control_llegada_dom('.$idemergencia_temp.')"/>
    </td>
  </tr>
  <tr>
    <td style=" background-color:'.$td_color.'">Salida Domicilio</td>
    <td align="center" style=" background-color:'.$td_color.'"><div id="muestra_salida_dom">'.$atencion_datos['horasaldom'].'</div></td>
    <td align="center">
       <img src="imagenes/reloj.gif" width="41" height="27" style="CURSOR: hand" alt=\'Asignar salida domicilio\'
          onclick="xajax_control_salida_dom('.$idemergencia_temp.')"/>
    </td>
  </tr>
  <tr>
    <td style=" background-color:'.$td_color.'">Lleg Hospital</td>
    <td align="center" style=" background-color:'.$td_color.'"><div id="muestra_llegada_hosp">'.$atencion_datos['horalleghosp'].'</div></td>
    <td align="center">
           <img src="imagenes/reloj.gif" width="41" height="27" style="CURSOR: hand" alt=\'Asignar llegada hospital\'
          onclick="xajax_control_llegada_hosp('.$idemergencia_temp.')"/>
    </td>
  </tr>
  <tr>
    <td style=" background-color:'.$td_color.'">Salida Hospital</td>
    <td align="center" style=" background-color:'.$td_color.'"><div id="muestra_salida_hosp">'.$atencion_datos['horasalhosp'].'</div></td>
    <td align="center" >
           <img src="imagenes/reloj.gif" width="41" height="27" style="CURSOR: hand" alt=\'Asignar salida hospital\'
          onclick="xajax_control_salida_hosp('.$idemergencia_temp.')"/>
    </td>
  </tr>
  <tr>
    <td style=" background-color:'.$td_color.'">Liberado</td>
    <td align="center" style=" background-color:'.$td_color.'"><div id="muestra_liberado">'.$atencion_datos['horalib'].'</div></td>
    <td align="center">
       <img src="imagenes/reloj.gif" width="41" height="27" style="CURSOR: hand" alt=\'Asignar hora liberado\'
          onclick="xajax_control_liberado('.$idemergencia_temp.')"/>
    </td>
  </tr>
    <tr>
   <td colspan=3 align="right"><div id="muestra_boton">'.$BOTON.'</div></td>
  </tr>
  <tr></tr><tr></tr><tr></tr><tr></tr></table>

  <table   border="0"  style="border:inherit ; font-size:'.$fontdef.'">
  <tr>
    <td colspan="2" style=" background-color:'.$td_color.'" align="center">Reclamos</td>
  </tr>
  <tr>
    <td colspan="2" align="center" style=" background-color:'.$td_color.'">&nbsp;&nbsp;
     <img src="imagenes/reloj.gif" width="41" height="27" alt=\'Asignar hora de primer reclamo\'  style="CURSOR: hand"
     onclick="xajax_control_reclamo_1('.$idemergencia_temp.')";
     />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <img src="imagenes/reloj.gif" width="41" height="27" alt=\'Asignar hora de segundo reclamo\' style="CURSOR: hand"
     onclick="xajax_control_reclamo_2('.$idemergencia_temp.')";
     />&nbsp;&nbsp;&nbsp;&nbsp;
     <img src="imagenes/reloj.gif" width="41" height="27" alt=\'Asignar hora de tercer reclamo\'  style="CURSOR: hand"
     onclick="xajax_control_reclamo_3('.$idemergencia_temp.')";
     />&nbsp;&nbsp;&nbsp;
    </td>
  </tr>
  <tr>
    <td colspan="2">
     <table border="0">
      <tr>
       <td width="10%" align="center" style=" background-color:'.$td_color.'">
         <div id="muestra_reclamo_1" width="80%">'.$atencion_datos['reclamo_1'].'</div>
       </td>
       <td width="10%" align="center" style=" background-color:'.$td_color.'">
         <div id="muestra_reclamo_2" width="80%">'.$atencion_datos['reclamo_2'].'</div>
       </td>
       <td width="10%" align="center" style=" background-color:'.$td_color.'">
         <div id="muestra_reclamo_3" width="80%">'.$atencion_datos['reclamo_3'].'</div>
       </td>
      </tr>
      </table>
   </td>
  <tr></table>
 <table  width="100%"  border="0"  style="border:inherit ; font-size:'.$fontdef.'">
  <tr>
    <td colspan="3" align="center" style=" background-color:'.$td_color.'">RECEPTOR</td></tr>
    <tr><td colspan="3" align="center" style=" background-color:'.$body_color.'">'.elimina_caracteres(htmlentities(substr($receptor['apeynomb'],0,14))).'</td>
  </tr>
  <tr>
    <td colspan="3" align="center" style=" background-color:'.$td_color.'">DESPACHADOR</td></tr>
  <tr><td colspan="3" align="center" style=" background-color:'.$body_color.'"><div id="muestra_despachador">'.elimina_caracteres(htmlentities(substr($opedesp_nombre,0,14))).'</div>
    </td>
  </tr>
</table>
 </td>
 <td>&nbsp;&nbsp;</td>
 <td width="990"  height="" valign="top">
  <div id="llamados" class="barra">'.muestra_listado_temp ($idemergencia_temp,$ordenar).'
  </div>
 </td>
 <td width="50" valign="top">
  <img onclick="window.open(\'mod_alta.php\',\'ALTA\', \'width=2000,height=2000,scrollbars=yes\');" src="imagenes/boton_alta.PNG"  style="CURSOR: hand" alt=\'ALTA DE EMERGENCIA\'/>
  <img onclick="window.open(\'principal.php\');" src="imagenes/boton_panel.PNG"  style="CURSOR: hand" alt=\'CONSULTAS\'/>
 </td>
 </tr>
</table>
<br>
<br>
<table width="100%" cellspacing="0" style= "font-size:'.$fontdef.'">
 <tr>
  <td style=" background-color:'.$td_color.' ; font-size:'.$fontdef.'" alig="left">
       <div align="left" id="muestra_equipo" style=" font-size:'.$fontdef.'"></div>
  </td>
  <td style=" background-color:'.$td_color.' ; font-size:'.$fontdef.'" alig="right">
   <table border=1><tr><td style=" background-color:'.$td_color.' ; font-size:'.$fontdef.'"><label>MOTIVOS DEL LLAMADO:&nbsp;&nbsp;&nbsp;'.$atencion_datos['motivo1'].'-'.$atencion_datos['motivo2'].'-'.elimina_caracteres(htmlentities($motivo_desc)).'</label></tr></td></table>
  </td>
</tr>
</table>
       <div id="update"></div>
       <textarea type="text" name="notas" rows="20" cols="152" align="left">
       '.$plan_desc.'

       *********************************       Información personal del cliente.        *********************************

       * Apellido y nombre    : '.elimina_caracteres(htmlentities($atencion_datos['nombre'])).'
       * Edad                 : '.$atencion_datos['edad'].'
       * Sexo                 : '.$atencion_datos['sexo'].'
       * Calle                : '.elimina_caracteres(htmlentities($atencion_datos['calle'])).'
       * Numero               : '.$atencion_datos['numero'].'
       * Piso                 : '.$atencion_datos['piso'].'
       * Departamento         : '.$atencion_datos['depto'].'
       * Casa                 : '.$atencion_datos['casa'].'
       * Monoblok             : '.$atencion_datos['monoblok'].'
       * Barrio               : '.elimina_caracteres(htmlentities($atencion_datos['barrio'])).'
       * Entre                : '.elimina_caracteres(htmlentities($atencion_datos['entre1'])).' y '.elimina_caracteres(htmlentities($atencion_datos['entre2'])).'
       * Localidad            : '.elimina_caracteres(htmlentities($atencion_datos['localidad'])).'
       * Referencia           : '.elimina_caracteres(htmlentities($atencion_datos['referencia'])).'
       * Observaciones        : '.elimina_caracteres(htmlentities($atencion_datos['observa1'])).'   -   '.elimina_caracteres(htmlentities($atencion_datos['observa2'])).'
       * Telefono             : '.$atencion_datos['telefono'].'
       * Plan                 : '.$padron_datos_para_obs['plan'].'
       * Fecha nacimiento     : '.$padron_datos_para_obs['fnacimiento'].'
       * Documento            : '.$padron_datos_para_obs['documento'].'
       * Tipo de Socio        : '.$padron_datos_para_obs['tiposocio'].'

       ******************************************************************************************************************
       *********************************          Información sobre horarios.           *********************************

       * LLAMADOS
       * Hora llamado    : '.$atencion_datos['horallam'].'
       * Despacho        : '.$atencion_datos['horadesp'].'
       * Salida base     : '.$atencion_datos['horasalbase'].'
       * Llegada dom     : '.$atencion_datos['horallegdom'].'
       * Salida  dom     : '.$atencion_datos['horasaldom'].'
       * Llegada hosp    : '.$atencion_datos['horalleghosp'].'
       * Salida  hosp    : '.$atencion_datos['horasalhosp'].'


       * RECLAMOS
       * Primer  reclamo : '.$atencion_datos['reclamo_1'].'
       * Segundo reclamo : '.$atencion_datos['reclamo_2'].'
       * Tercer  reclamo : '.$atencion_datos['reclamo_3'].'


       ******************************************************************************************************************
       *********************************             Información sobre Plan.            *********************************
       * Codigo Plan          : '.$atencion_datos['plan'].'
       * Descripcion del plan : '.$plan_desc_1.'
       * Datos                : '.$plan_desc.'
       </textarea>

</body>
</html>
</body>
</html>
';
echo $html_salida;
// <div id="muestra_boton">'.$BOTON.'</div>
?>