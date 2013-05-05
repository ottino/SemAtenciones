<?php

include ('funciones.php');
include_once ('config.php');
require ('xajax/xajax.inc.php');
require_once ('cookie.php');

// Datos del usuario
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
$G_funcion = $cookie->get("funcion");

// Def. de variables
$_FILAVINC      = null;
$load_xajax_noa = null;
$plan_desc      = null;

$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

// Conexion con la base
conectar_db ($bd_host , $bd_database , $bd_user , $bd_pass);

// recupero datos de la emergencia
$idemergencia_temp = $_GET['id'];

if (!$idemergencia_temp)
    {
        die('');
    }    
else
    {
        $consulta_atencion = mysql_query("select * from atenciones_temp where id=".$idemergencia_temp);
        $atencion_datos = mysql_fetch_array($consulta_atencion);

        if (mysql_affected_rows () == 0)
        {
            $mensaje_error = '
                <html>
                    <head>
                        <script type="text/javascript">
                        function load()
                         {
                          alert("EMERGENCIA YA CERRADA");
                          window.close();
                         }
                        </script>

                    </head>
                    <body onload="load()">
                    </body>
                </html>
            ';

            echo $mensaje_error;
            echo die('');
        }

        $consulta_plan = mysql_query ("select * from convenios where id=".$atencion_datos['plan']);
        $plan = mysql_fetch_array($consulta_plan);

        $consulta_receptor = mysql_query ("select * from legajos where legajo=".$atencion_datos['operec']);
        $receptor = mysql_fetch_array($consulta_receptor);
        $receptor_nombre= explode(",",$receptor['apeynomb']);

        if ($atencion_datos['opedesp'] != null)
         {
          $consulta_ope_desp_nombre = mysql_query("select * from legajos where legajo=".$atencion_datos['opedesp']);
          $opedesp_nombre = mysql_fetch_array($consulta_ope_desp_nombre);
          $opedesp_nombre = $opedesp_nombre['apeynomb'];
         }
        else $opedesp_nombre="";

if ($atencion_datos['plan'] != null)
 {
  $consulta_plan_desc = mysql_query("select * , 'S/D' as datos from convenios where id =".$atencion_datos['plan']);
  $plan_desc = mysql_fetch_array($consulta_plan_desc);
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

//******************  PREPAR INFO PARA MOSTRAR VINCULADOS ******************************
$consulta_vinculados = mysql_query ("select * from clientes_nopadron where idatencion = ".$idemergencia_temp);
$cantidad_vinculados = mysql_affected_rows();

if ($atencion_datos['color'] == 3 || $atencion_datos['color'] == 5)
{

 $busca_imp_coseguro = mysql_fetch_array(mysql_query ("select * from convenios where id = ".$atencion_datos['plan'] ));
 $importe_mostrar = ($busca_imp_coseguro['impcoseguro'] * $cantidad_vinculados) + $busca_imp_coseguro['impcoseguro'];
 //$chekco_t ='document.formulario.cosegurosi.checked=true';
 //$chekco_f ='document.formulario.cosegurosi.checked=false';
 $check = 'document.formulario.cosegurosi.checked=true';

} else {
          $importe_mostrar = 0;
          // $chekco_t ='document.formulario.cosegurosi.checked=false';
          // $chekco_f ='document.formulario.cosegurosi.checked=false';
          $check = '';
       }
$numero_vinc = 1;
$_FILAVINC.='
<tr>
 <td colspan="11" align="center">DATOS DE LAS ATENCIONES SIMULTANEAS</td>
</tr>
<tr>
                    <td width="4%"></td>
                    <td width="2%"></td>
                    <td width="10%">NOMBRE Y APELLIDO</td>
                    <td>&nbsp;</td>
                    <td>EDAD</td>
                    <td>SEXO</td>
                    <td>&nbsp;</td>
                    <td>OBRA SOCIAL</td>
                    <td>DOC</td>
                    <td>DESTINO</td>
                    <td>DIAGNOSTICO</td>

</tr>
';

while ($fila=mysql_fetch_array ($consulta_vinculados))
 {
    $_FILAVINC.='
              <tr>
                    <td width="4%"><input id="nosocioid'.$numero_vinc.'" value ="'.$fila['idnopadron'].'" type="hidden" size="2%"/></td>
                    <td width="2%"><input id="nosocio'.$numero_vinc.'"   type="checkbox" value="" size="6%"/></td>
                    <td width="10%"><input id="no_socio_'.$numero_vinc.'" type="text" value = "'.elimina_caracteres(htmlentities($fila['nombre'])).'" size="30%"/></td>  <td>&nbsp;</td>
                    <td><input  id="no_edad_'.$numero_vinc.'" type="text" value = "'.elimina_caracteres(htmlentities($fila['edad'])).'" size="2%" /></td>
                    <td><input  id="no_sexo_'.$numero_vinc.'" type="text" value = "'.elimina_caracteres(htmlentities($fila['sexo'])).'" size="2%" /></td><td>&nbsp;</td>
                    <td><input  id="no_iden_'.$numero_vinc.'" type="text" value = "'.elimina_caracteres(htmlentities($fila['os'])).'"  size="12%" /></td>
                    <td><input  id="no_docum_'.$numero_vinc.'" type="text" value = "'.elimina_caracteres(htmlentities($fila['dni'])).'" size="7%" /></td>
                            <td align="center">
                             <table>
                              <tr>
                               <td><div id="input_busca_destino_div'.$numero_vinc.'"></div></td><td><div id="lista_destino'.$numero_vinc.'"></div></td>
                              </tr>
                             </table>
                            </td>
                            <td align="center">
                             <table>
                              <tr>
                               <td><div id="input_busca_diagnostico_div'.$numero_vinc.'"></div></td><td><div id="lista_diagnostico'.$numero_vinc.'"></div></td>
                              </tr>
                             </table>
                            </td>
              </tr>
               ';
            $load_xajax_noa .='
                               xajax_lista_destino_noa(0 , '.$numero_vinc.');
                               xajax_input_busca_destino_noa(0 , '.$numero_vinc.');
                               xajax_lista_diagnostico_noa(0 , '.$numero_vinc.');
                               xajax_input_busca_diagnostico_noa(0 , '.$numero_vinc.');
                              ';
    $numero_vinc++;
 }

$cantidad_vinculos = 5 - $numero_vinc;
for ($c=0 ; $c <= $cantidad_vinculos ; $c++)
          {
           $_FILAVINC.='
                      <tr>
                            <td width="4%"><input  id="nosocioid'.$numero_vinc.'" value="" type="hidden"  size="2%"/></td>
                            <td width="2%"><input id="nosocio'.$numero_vinc.'" type="checkbox" value="" size="6%"/></td>
                            <td width="10%"><input id="no_socio_'.$numero_vinc.'" type="text" size="30%"/></td>  <td>&nbsp;</td>
                            <td><input id="no_edad_'.$numero_vinc.'"    type="text"  size="2%"/></td>
                            <td><input id="no_sexo_'.$numero_vinc.'"    type="text"  size="2%"/></td> <td>&nbsp;</td>
                            <td><input id="no_iden_'.$numero_vinc.'"    type="text" size="12%"/></td>
                            <td><input  id="no_docum_'.$numero_vinc.'"  type="text" size="7%"/></td>
                            <td align="center">
                             <table>
                              <tr>
                               <td><div id="input_busca_destino_div'.$numero_vinc.'"></div></td><td><div id="lista_destino'.$numero_vinc.'"></div></td>
                              </tr>
                             </table>
                            </td>
                            <td align="center">
                             <table>
                              <tr>
                               <td><div id="input_busca_diagnostico_div'.$numero_vinc.'"></div></td><td><div id="lista_diagnostico'.$numero_vinc.'"></div></td>
                              </tr>
                             </table>
                            </td>
                      </tr>
                       ';
            $load_xajax_noa .='
                               xajax_lista_destino_noa(0 , '.$numero_vinc.');
                               xajax_input_busca_destino_noa(0 , '.$numero_vinc.');
                               xajax_lista_diagnostico_noa(0 , '.$numero_vinc.');
                               xajax_input_busca_diagnostico_noa(0 , '.$numero_vinc.');
                              ';
            $numero_vinc++;
          }

}

/*
<img style="CURSOR: hand" src="imagenes/busca.ico" width="15" height="15"
                                                onClick="window.open(\'busca_destinos.php\',\'DESTINOS\', \'width=490,height=80,scrollbars=yes\');" />
                                               <input id="destino_'.$numero_vinc.'" size="3%" type="text" />

<img style="CURSOR: hand" src="imagenes/busca.ico" width="15" height="15"
                                               onClick="window.open(\'busca_diagnostico.php\',\'DIAGNOSTICOS\', \'width=490,height=80,scrollbars=yes\');" />
                                               <input id="diagno_'.$numero_vinc.'" size="3%" type="text" />
*/
######### XAJAX ##############################
//instanciamos el objeto de la clase xajax
$xajax = new xajax();
// funciones para la libreria

//LOS PLANES NO SE MODIFICAN *****************************
function lista_planes ($idplan)
{

    $consulta_planes = mysql_query ("SELECT id , descripcion , 'S/D' as datos FROM convenios");

     $list='<select name="s_lista_planes" onchange="xajax_input_busca_plan(document.formulario.s_lista_planes.value);">';

     if ($idplan == 0)
     $list.='<option selected="selected" value="0">PLANES</option>';


     while ($fila=mysql_fetch_array($consulta_planes))
     {
      if ($idplan == $fila['id'])
      $list.= '<option selected="selected" value="'.$fila['id'].'">'.elimina_caracteres(htmlentities($fila['descripcion'])).'</option>';
      else
       $list.= '<option value="'.$fila['id'].'">'.elimina_caracteres(htmlentities($fila['descripcion'])).'</option>';
     }

   $list.='</select>';

   $salida = $list;
   //$salida2='<input type="text" name="" value="'.$idplan.'" onKeyUp="xajax_lista_planes('.$idplan.')">';
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("lista_planes","innerHTML",$salida);
   //$respuesta->addAssign("input_busca_plan","innerHTML",$salida);
   return $respuesta;
}

function input_busca_plan ($idplan)
{
   $input='<input type="text" id="i_busca_plan" value="'.$idplan.'" onKeyUp="xajax_lista_planes(document.formulario.i_busca_plan.value);">';

   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_busca_plan_div","innerHTML",$salida);
   return $respuesta;
}
// ############################################################

function lista_diagnostico($iddiagnostico)
{
     $consulta_diagnostico = mysql_query ("SELECT *
                                     FROM diagnosticos ORDER BY descdiagnostico ASC");

     $list='<select name="s_lista_diagnostico" onchange="xajax_input_busca_diagnostico(document.formulario.s_lista_diagnostico.value);">';

     $bandera=0;
     if ($iddiagnostico == -1)
     $list.='<option selected="selected" value="A">DIAGNOSTICO</option>';

     while ($fila=mysql_fetch_array($consulta_diagnostico))
     {
      if ($iddiagnostico == $fila['iddiagnostico'])
         {
          $list.= '<option selected="selected" value="'.$fila['iddiagnostico'].'">'.elimina_caracteres(htmlentities($fila['descdiagnostico'])).'</option>';
          $bandera=1;
         }
      else
         {
          $list.= '<option value="'.$fila['iddiagnostico'].'">'.elimina_caracteres(htmlentities($fila['descdiagnostico'])).'</option>';
         }
     }
   if ($bandera==0) $list.='<option selected="selected" value="A">DIAGNOSTICO</option>';
   $list.='</select>';

   $salida = $list;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("lista_diagnostico","innerHTML",$salida);

   return $respuesta;
}

function input_busca_diagnostico ($iddiagnostico)
{
   $input='<input size="7" type="text" name="i_busca_diagnostico" tabindex="1" id="i_busca_diagnostico" value="'.$iddiagnostico.'" 
            onKeyUp="xajax_lista_diagnostico(document.formulario.i_busca_diagnostico.value);">';

   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_busca_diagnostico_div","innerHTML",$salida);
   return $respuesta;
}

function lista_destino($iddestino)
{
     $consulta_destino = mysql_query ("SELECT *
                                      FROM destino ORDER BY destino ASC");

     $list='<select name="s_lista_destino" onchange="xajax_input_busca_destino(document.formulario.s_lista_destino.value);">';

     if ($iddestino == 0)
     $list.='<option selected="selected" value="A">DESTINO</option>';

     while ($fila=mysql_fetch_array($consulta_destino))
     {
      if ($iddestino == $fila['iddestino'])
         $list.= '<option selected="selected" value="'.$fila['iddestino'].'">'.elimina_caracteres(htmlentities($fila['destino'])).'</option>';
      else
       $list.= '<option value="'.$fila['iddestino'].'">'.elimina_caracteres(htmlentities($fila['destino'])).'</option>';
     }

   $list.='</select>';

   $salida = $list;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("lista_destino","innerHTML",$salida);

   return $respuesta;
}

function input_busca_destino ($iddestino)
{
   $input='<input type="text" size="7" id="i_busca_destino" value="'.$iddestino.'" onKeyUp="xajax_lista_destino(document.formulario.i_busca_destino.value);">';

   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_busca_destino_div","innerHTML",$salida);
   return $respuesta;
}

function lista_color($idcolor)
{
     $consulta_color = mysql_query ("SELECT *
                                      FROM colores");

     $list='<select name="s_lista_color" onchange="xajax_input_busca_color(document.formulario.s_lista_color.value);">';
     $list.='<option selected="selected" value="A">COLOR</option>';

     while ($fila=mysql_fetch_array($consulta_color))
     {
      if ($idcolor == $fila['idcolor'])
         $list.= '<option selected="selected" value="'.$fila['idcolor'].'">'.$fila['desc'].'</option>';
      else
       $list.= '<option value="'.$fila['idcolor'].'">'.$fila['desc'].'</option>';
     }

   $list.='</select>';

   $salida = $list;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("lista_color","innerHTML",$salida);

   return $respuesta;
}

function input_busca_color ($idcolor)
{
   $input='<input size="3" type="text" id="i_busca_color" value="'.$idcolor.'" onKeyUp="xajax_lista_color(document.formulario.i_busca_color.value);">';

   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_busca_color_div","innerHTML",$salida);
   return $respuesta;
}

function input_muestra_articulo($idmovil,$idarticulo,$idrubro)
{

     if ((is_numeric($idarticulo)) and (is_numeric($idrubro)))
     {
     $consulta_existe = mysql_query ("SELECT *
                                      FROM botiquines
                                      WHERE idmovil   = ".$idmovil.
                                      " and  idarticulo = ".$idarticulo.
                                      " and  rubro    = ".$idrubro);

     $consulta_existe = mysql_fetch_array($consulta_existe);


     if (!$consulta_existe)
      {
      //$input_desc= '<input type="text" name="" value="">';
          $consulta_art = mysql_query ("SELECT *
                                          FROM botiquines a , articulos b
                                          WHERE idmovil    = ".$idmovil."
                                                and a.idarticulo = b.idarticulo and
                                                a.rubro      = b.rubro
                                                ORDER BY b.articulo asc");

         $list_art='<select name="s_lista_art_desc"  style="width:150px"
                                  onchange="expl_js (document.formulario.s_lista_art_desc.value);">';
         $list_art.= '<option selected = "selected" value="0-0">BUSCAR</option>';
         while ($fila=mysql_fetch_array($consulta_art))
         {
             $list_art.= '<option value="'.$fila['rubro'].'-'.$fila['idarticulo'].'">'.elimina_caracteres(htmlentities($fila['articulo'])).'</option>';
         }
         $list_art.='</select>';


         $input_desc=$list_art;
      }
     else
      {
/*         $consulta_articulos = mysql_query("SELECT * FROM articulos
                                            WHERE idarticulo = ".$idarticulo.
                                            " and  rubro      = ".$idrubro);

         $descri_articulo= mysql_fetch_array($consulta_articulos);

         $input_desc='<input type="text" name="" value="'.elimina_caracteres(htmlentities($descri_articulo['articulo'])).'">';
*/
          $consulta_art = mysql_query ("SELECT *
                                          FROM botiquines a , articulos b
                                          WHERE idmovil    = ".$idmovil."
                                                and a.idarticulo = b.idarticulo and
                                                a.rubro      = b.rubro
                                                ORDER BY b.articulo asc");

         $list_art='<select name="s_lista_art_desc"  style="width:150px"
                                  onchange="expl_js (document.formulario.s_lista_art_desc.value);">';

         $PASO = 0;
         while ($fila=mysql_fetch_array($consulta_art))
         {
            if (($fila['idarticulo'] == $idarticulo) and ($fila['rubro'] == $idrubro))
             {
              $list_art.= '<option selected = "selected" value="'.$fila['rubro'].'-'.$fila['idarticulo'].'">'.elimina_caracteres(htmlentities($fila['articulo'])).'</option>';
        //    $PASO=1;
             }
            else
             $list_art.= '<option value="'.$fila['rubro'].'-'.$fila['idarticulo'].'">'.elimina_caracteres(htmlentities($fila['articulo'])).'</option>';
         }

         //if ($PASO == 0)
         //$list_art.= '<option selected = "selected" value="0-0">RUB-ART</option>';

         $list_art.='</select>';


         $input_desc=$list_art;
      }
   } else
    {
          $consulta_art = mysql_query ("SELECT *
                                          FROM botiquines a , articulos b
                                          WHERE idmovil    = ".$idmovil."
                                                and a.idarticulo = b.idarticulo and
                                                a.rubro      = b.rubro
                                                ORDER BY b.articulo asc");

         $list_art='<select name="s_lista_art_desc"  style="width:150px"
                                  onchange="expl_js (document.formulario.s_lista_art_desc.value);">';
         $list_art.= '<option selected = "selected" value="0-0">BUSCAR</option>';
         while ($fila=mysql_fetch_array($consulta_art))
         {
             $list_art.= '<option value="'.$fila['rubro'].'-'.$fila['articulo'].'">'.elimina_caracteres(htmlentities($fila['articulo'])).'</option>';
         }


         $list_art.='</select>';


         $input_desc=$list_art;

     //$input_desc= '<input type="text" name="" value="">';
    }

   $salida = $input_desc;

   //$salida=$idmovil.'-'.$idarticulo.'-'.$idrubro;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_descarticulo_div","innerHTML",$salida);

   return $respuesta;
}

function input_busca_x_articulo ($idarticulo)
{

   $input='<input size="7" type="text" id="i_busca_x_articulo" value="'.$idarticulo.'"
            onKeyUp="xajax_input_muestra_articulo(document.formulario.movilhidden.value,
                                            document.formulario.i_busca_x_articulo.value,
                                            document.formulario.i_busca_x_rubro.value);">';

   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_busca_x_articulo_div","innerHTML",$salida);
   return $respuesta;
}

function input_busca_x_rubro ($idrubro)
{

   $input='<input size="7" type="text" id="i_busca_x_rubro" value="'.$idrubro.'"
            onKeyUp="xajax_input_muestra_articulo(document.formulario.movilhidden.value,
                                            document.formulario.i_busca_x_articulo.value,
                                            document.formulario.i_busca_x_rubro.value);">';

   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_busca_x_rubro_div","innerHTML",$salida);
   return $respuesta;
}

function input_valor_coseguro ($xsino)
{
   if ($xsino == 1)
      $input='<input type="text" id="valor_coseguro" onKeyUp="js_control_importe_coseg(document.formulario.valor_coseguro.value);">';
   else
   $input='';


   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_coseguro_div","innerHTML",$salida);
   return $respuesta;
}

function ejec ($id_atencion,$id_rubro,$id_articulo,$id_movil,$cantidad)
{
  // validaciones

  if ((is_numeric($id_rubro)==true) and (is_numeric($id_articulo)==true) and (is_numeric($cantidad)==true) )
      {
         if (($id_articulo <> 0) and ($id_rubro <> 0) and ($cantidad <> 0))
          {
             $consulta_existe = mysql_query ("SELECT *
                                              FROM botiquines
                                              WHERE idmovil   = ".$id_movil.
                                              " and  idarticulo = ".$id_articulo.
                                              " and  rubro    = ".$id_rubro);

             $consulta_existe = mysql_fetch_array($consulta_existe);

             $mensaje_cantidad ='&nbsp;';
             if (!$consulta_existe)
              $INSERT = ''; // no pasa nada
             else
              {
                $control_cantidad = $consulta_existe['cantidad'] - $cantidad;

               // if ($control_cantidad >= 0)
               //    {
                   $INSERT = mysql_query("insert into botiquin_cierre values (".$id_atencion.",".$id_rubro.",".$id_articulo.",".$id_movil.",".$cantidad.")");
                   //idbotiquines  idmovil  idarticulo  rubro
                   $RESTA  = mysql_query("update botiquines set cantidad = ".$control_cantidad."
                                          where  idmovil   = ".$id_movil." and  idarticulo = ".$id_articulo." and  rubro    = ".$id_rubro);
              //     }
              //    else $mensaje_cantidad = '<input  size="30" disabled="disabled" type="text" value="CANTIDAD INSUFICIENTE" /><br><br><br>';
              }
          }
      }



  $consulta_insert = mysql_query("select * from botiquin_cierre
                                  where id_atencion =".$id_atencion);
  $html_salida =
         '<input   size="7"  disabled="disabled" type="text"  value="Rubro." />
          <input   size="7"  disabled="disabled" type="text"  value="Art." />
          <input   size="7"  disabled="disabled" type="text"  value="Cantidad" /><br>';

  while ($fila=mysql_fetch_array($consulta_insert))
  {
  $html_salida.=
         '<input  size="7"  disabled="disabled" type="text"  value='.$fila['id_rubro'].' />
          <input size="7"   disabled="disabled" type="text"   value='.$fila['id_articulo'].' />
          <input  size="7"  disabled="disabled" type="text"  value='.$fila['cantidad'].' />
          <input  size="10" disabled="disabled" type="text" value="ASIGNADO" /><br> ';
  }

   $salida =$mensaje_cantidad.$html_salida;

   //$salida = $INSERT;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("muestra_ejec_div","innerHTML",$salida);
   return $respuesta;
}

function cierra_atencion($id_atencion,$destino,$diagnostico,$color,$coseg_si_chek,$coseg_no_chek,$valor_coseg , $obs_final,
                            $_nosocio1 , $_noedad1 , $_nosexo1, $_noiden1 , $_nodocum1 , $_destino1, $_diagno1 ,
                            $_nosocio2 , $_noedad2 , $_nosexo2, $_noiden2 , $_nodocum2 , $_destino2, $_diagno2 ,
                            $_nosocio3 , $_noedad3 , $_nosexo3, $_noiden3 , $_nodocum3 , $_destino3, $_diagno3 ,
                            $_nosocio4 , $_noedad4 , $_nosexo4, $_noiden4 , $_nodocum4 , $_destino4, $_diagno4 ,
                            $_nosocio5 , $_noedad5 , $_nosexo5, $_noiden5 , $_nodocum5 , $_destino5, $_diagno5 ,
                            $_bandera_nosocio1 ,$_bandera_nosocio2 ,$_bandera_nosocio3 ,$_bandera_nosocio4 ,$_bandera_nosocio5 ,
                            $_catidad_vincul ,
                            $_nosocioid1 ,$_nosocioid2 ,$_nosocioid3 ,$_nosocioid4 ,$_nosocioid5 ,
                            $nrecibo, $_plan_socio,$_nom_socio,$_edad_socio,$_sexo_socio,$_identi_socio,$_dni_socio
                        )
{

   if ( (is_numeric($id_atencion)==true) and (is_numeric($destino)==true) and
        (is_numeric($diagnostico)==true) and (is_numeric($id_atencion)==true) )
    {

      // preparo valor coseguro
      if (($coseg_no_chek == 'true') or ($coseg_si_chek == 'false') or ($valor_coseg < 0) or (is_numeric($valor_coseg) == false))
         {
           $valor_coseg_si_no ='no';
           $valor_coseg = 0;
         } else $valor_coseg_si_no='si';
      $_plan_socio = $_plan_socio + 0;
      $UPDATE_ATENCION =mysql_query ("update atenciones_temp set
                                              destino     = '".$destino."'
                                            , nombre      = '".$_nom_socio."'
                                            , edad        = '".$_edad_socio."'
                                            , sexo        = '".$_sexo_socio."'
                                            , identificacion = '".$_identi_socio."'
                                            , documento   = '".$_dni_socio."'
                                            , plan        = '".$_plan_socio."'
                                            , coseguro    = '".$valor_coseg_si_no."'
                                            , impcoseguro = ".$valor_coseg."
                                            , diagnostico = '".$diagnostico."'
                                            , colormedico = '".$color."'
                                            , abierta = 2 where id = ".$id_atencion);

     $CONSULTA_MOVIL =mysql_fetch_array( mysql_query ("select * from atenciones_temp where id = ".$id_atencion) );
     $UPDATE_MOVIL_DISP =mysql_query ("update movildisponible SET disponible = 0 where idmovildisp = ".$CONSULTA_MOVIL['movil_2']);

      $INSERT_ATENCION =mysql_query ("
                                          INSERT INTO atenciones
                                          SELECT
                                          id  ,fecha , telefono  , plan , operec , horallam  , socio , integrante , nombre ,
                                          tiposocio  ,edad  ,sexo  ,identificacion,  documento , calle ,numero , piso  ,depto ,
                                          casa,  monoblok,  barrio  ,entre1  ,entre2,  localidad ,referencia , zona , motivo1 ,
                                          motivo2  ,motivodesc , color ,observa1 , observa2 , obrasocial ,opedesp ,movil , horadesp ,
                                          horasalbase , horallegdom  ,horasaldom ,horalleghosp  ,horasalhosp  ,horadisp ,
                                          destino  ,coseguro  ,impcoseguro , chofer , medico , enfermero , colormedico  ,tiporecibo ,
                                          nrorecibo , diagnostico , motanulacion , movil_2 , abierta  , ' ' , ' ' , ' ', ' ' , ' ' , reclamo_1, reclamo_2, reclamo_3 ,
                                          horalib , fechallam
                                          FROM atenciones_temp
                                          WHERE id =".$id_atencion);

      if  (($CONSULTA_MOVIL['color'] == 4)||($CONSULTA_MOVIL['color'] == 7))
          {
                  $date = date("Y-m-d");
                  $AGREGA_OBS_FINAL = mysql_query ("UPDATE atenciones SET observa1 = '', observa2 = '', obs_final = '".$obs_final."' , nrecibo = '".$nrecibo."' , fecha =  NOW()
                                                    WHERE id =".$id_atencion);
          }else {
                  $AGREGA_OBS_FINAL = mysql_query ("UPDATE atenciones SET  observa1 = '', observa2 = '', obs_final = '".$obs_final."' , nrecibo = '".$nrecibo."'
                                                    WHERE id =".$id_atencion);
                }

      $DELETE_ATENCION_TEMP = mysql_query ("
                                          DELETE FROM atenciones_temp
                                          WHERE  id =".$id_atencion);

      if (!$DELETE_ATENCION_TEMP)
        {
         $boton ='
                    <input type="button" value="** Error! modificar y presionar nuevamente **" onclick="check_cierra_atencion(
                    '.$idemergencia_temp.',
                    document.formulario.s_lista_destino.value,
                    document.formulario.s_lista_diagnostico.value,
                    document.formulario.s_lista_color.value,
                    document.formulario.cosegurosi.checked,
                    document.formulario.cosegurono.checked,
                    document.formulario.valor_coseguro.value,
                    document.formulario.text_obs_final.value ,

                    '.$cantidad_vinculados.',

                    document.formulario.nosocio1.checked , document.formulario.no_socio_1.value , document.formulario.no_edad_1.value , document.formulario.no_sexo_1.value , document.formulario.no_iden_1.value , document.formulario.no_docum_1.value , document.formulario.destino_1.value , document.formulario.diagno_1.value ,
                    document.formulario.nosocio2.checked , document.formulario.no_socio_2.value , document.formulario.no_edad_2.value , document.formulario.no_sexo_2.value , document.formulario.no_iden_2.value , document.formulario.no_docum_2.value , document.formulario.destino_2.value , document.formulario.diagno_2.value ,
                    document.formulario.nosocio3.checked , document.formulario.no_socio_3.value , document.formulario.no_edad_3.value , document.formulario.no_sexo_3.value , document.formulario.no_iden_3.value , document.formulario.no_docum_3.value , document.formulario.destino_3.value , document.formulario.diagno_3.value ,
                    document.formulario.nosocio4.checked , document.formulario.no_socio_4.value , document.formulario.no_edad_4.value , document.formulario.no_sexo_4.value , document.formulario.no_iden_4.value , document.formulario.no_docum_4.value , document.formulario.destino_4.value , document.formulario.diagno_4.value ,
                    document.formulario.nosocio5.checked , document.formulario.no_socio_5.value , document.formulario.no_edad_5.value , document.formulario.no_sexo_5.value , document.formulario.no_iden_5.value , document.formulario.no_docum_5.value , document.formulario.destino_5.value , document.formulario.diagno_5.value ,

                    document.formulario.nosocioid1.value ,document.formulario.nosocioid2.value ,document.formulario.nosocioid3.value ,document.formulario.nosocioid4.value ,
                    document.formulario.nosocioid5.value ,
                    document.formulario.nrecibo.value ,
                    document.formulario.i_busca_plan.value ,document.formulario.nom_socio.value, document.formulario.edad_socio.value , document.formulario.sexo_socio.value ,
                    document.formulario.identi_socio.value , document.formulario.dni_socio.value
                    );">';
        }else
         {
        $boton = '<input  type="button" value="CERRAR CON EXITO"  onclick="window.close();" />';
        # UPDATE & INSERT DE CLIENTES NO APDRONADOS EN EL CIERRE

        if ($_bandera_nosocio1== 1) { $existe_socio1 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid1."'"); if (mysql_affected_rows() == 0) { $insert_nosocio1 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio1.'" , "'.$_noedad1.'" , "'.$_nosexo1.'" , "'.$_noiden1.'" , "'.$_nodocum1.'" , "'.$_destino1.'" , "'.$_diagno1.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio1.'" , edad = "'.$_noedad1.'" , sexo = "'.$_nosexo1.'" , os = "'.$_noiden1.'" , dni = "'.$_nodocum1.'" , cod_destino = "'.$_destino1.'" , cod_diagnostico = "'.$_diagno1.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid1); } }
        if ($_bandera_nosocio2== 1) { $existe_socio2 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid2."'"); if (mysql_affected_rows() == 0) { $insert_nosocio2 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio2.'" , "'.$_noedad2.'" , "'.$_nosexo2.'" , "'.$_noiden2.'" , "'.$_nodocum2.'" , "'.$_destino2.'" , "'.$_diagno2.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio2.'" , edad = "'.$_noedad2.'" , sexo = "'.$_nosexo2.'" , os = "'.$_noiden2.'" , dni = "'.$_nodocum2.'" , cod_destino = "'.$_destino2.'" , cod_diagnostico = "'.$_diagno2.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid2); } }
        if ($_bandera_nosocio3== 1) { $existe_socio3 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid3."'"); if (mysql_affected_rows() == 0) { $insert_nosocio3 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio3.'" , "'.$_noedad3.'" , "'.$_nosexo3.'" , "'.$_noiden3.'" , "'.$_nodocum3.'" , "'.$_destino3.'" , "'.$_diagno3.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio3.'" , edad = "'.$_noedad3.'" , sexo = "'.$_nosexo3.'" , os = "'.$_noiden3.'" , dni = "'.$_nodocum3.'" , cod_destino = "'.$_destino3.'" , cod_diagnostico = "'.$_diagno3.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid3); } }
        if ($_bandera_nosocio4== 1) { $existe_socio4 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid4."'"); if (mysql_affected_rows() == 0) { $insert_nosocio4 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio4.'" , "'.$_noedad4.'" , "'.$_nosexo4.'" , "'.$_noiden4.'" , "'.$_nodocum4.'" , "'.$_destino4.'" , "'.$_diagno4.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio4.'" , edad = "'.$_noedad4.'" , sexo = "'.$_nosexo4.'" , os = "'.$_noiden4.'" , dni = "'.$_nodocum4.'" , cod_destino = "'.$_destino4.'" , cod_diagnostico = "'.$_diagno4.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid4); } }
        if ($_bandera_nosocio5== 1) { $existe_socio5 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid5."'"); if (mysql_affected_rows() == 0) { $insert_nosocio5 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio5.'" , "'.$_noedad5.'" , "'.$_nosexo5.'" , "'.$_noiden5.'" , "'.$_nodocum5.'" , "'.$_destino5.'" , "'.$_diagno5.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio5.'" , edad = "'.$_noedad5.'" , sexo = "'.$_nosexo5.'" , os = "'.$_noiden5.'" , dni = "'.$_nodocum5.'" , cod_destino = "'.$_destino5.'" , cod_diagnostico = "'.$_diagno5.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid5); } }

        $salida='';

         $CONT_CLI_NO_APADRONADOS = mysql_fetch_array( mysql_query ("
                                                                    SELECT count( * ) as CANTIDAD
                                                                    FROM clientes_nopadron
                                                                    WHERE idatencion =".$id_atencion) );

         $UPDATE_CLI_ADI =mysql_query ("update atenciones SET cnadicionales = ".$CONT_CLI_NO_APADRONADOS['CANTIDAD']."
                                        where id = ".$id_atencion);
       }
   }




   //$salida=$_catidad_vincu.'-'.$_nosocio3.'-'.$_noedad3.'-'.$_nosexo3.'-'.$_noiden3.'-'.$_nodocum3.'-'.$_nosocioid3;
   //$salida = $existe_socio3;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("muestra_insert_cierre","innerHTML",$boton );
   return $respuesta;
}

function lista_destino_noa($iddestino , $reg)
{
     $consulta_destino = mysql_query ("SELECT *
                                      FROM destino ORDER BY destino ASC");

     $list='
     <select name="destino_'.$reg.'"
     onchange="xajax_input_busca_destino_noa(document.formulario.destino_'.$reg.'.value , '.$reg.');">';

     if ($iddestino == 0)
     $list.='<option selected="selected" value="A">DESTINO</option>';

     while ($fila=mysql_fetch_array($consulta_destino))
     {
      if ($iddestino == $fila['iddestino'])
         $list.= '<option selected="selected" value="'.$fila['iddestino'].'">'.elimina_caracteres(htmlentities($fila['destino'])).'</option>';
      else
       $list.= '<option value="'.$fila['iddestino'].'">'.elimina_caracteres(htmlentities($fila['destino'])).'</option>';
     }

   $list.='</select>';

   $salida = $list;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("lista_destino".$reg,"innerHTML",$salida);

   return $respuesta;
}

function input_busca_destino_noa($iddestino , $reg)
{
   $input='<input type="text" size="3" id="i_busca_destino'.$reg.'" value="'.$iddestino.'"
           onKeyUp="xajax_lista_destino_noa(document.formulario.i_busca_destino'.$reg.'.value , '.$reg.');">';

   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_busca_destino_div".$reg,"innerHTML",$salida);
   return $respuesta;
}

function lista_diagnostico_noa($iddiagnostico , $reg)
{
     $consulta_diagnostico = mysql_query ("SELECT *
                                           FROM diagnosticos ORDER BY descdiagnostico ASC");

     $list='<select name="diagno_'.$reg.'"  style="width:286px"
       onchange="xajax_input_busca_diagnostico_noa(document.formulario.diagno_'.$reg.'.value , '.$reg.');">';

     $bandera=0;
     if ($iddiagnostico == -1)
     $list.='<option selected="selected" value="A">DIAGNOSTICO</option>';

     while ($fila=mysql_fetch_array($consulta_diagnostico))
     {
      if ($iddiagnostico == $fila['iddiagnostico'])
         {
          $list.= '<option selected="selected" value="'.$fila['iddiagnostico'].'">'.elimina_caracteres(htmlentities($fila['descdiagnostico'])).'</option>';
          $bandera=1;
         }
      else
         {
          $list.= '<option value="'.$fila['iddiagnostico'].'">'.elimina_caracteres(htmlentities($fila['descdiagnostico'])).'</option>';
         }
     }
   if ($bandera==0) $list.='<option selected="selected" value="A">DIAGNOSTICO</option>';
   $list.='</select>';

   $salida = $list;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("lista_diagnostico".$reg,"innerHTML",$salida);

   return $respuesta;
}

function input_busca_diagnostico_noa ($iddiagnostico , $reg)
{
   $input='<input size="6" type="text" id="i_busca_diagnostico'.$reg.'" value="'.$iddiagnostico.'"
           onKeyUp="xajax_lista_diagnostico_noa(document.formulario.i_busca_diagnostico'.$reg.'.value , '.$reg.');">';

   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_busca_diagnostico_div".$reg,"innerHTML",$salida);
   return $respuesta;
}

$xajax->registerFunction("lista_planes");
$xajax->registerFunction("input_busca_plan");
$xajax->registerFunction("lista_diagnostico");
$xajax->registerFunction("input_busca_diagnostico");
$xajax->registerFunction("lista_destino");
$xajax->registerFunction("input_busca_destino");
$xajax->registerFunction("lista_color");
$xajax->registerFunction("input_busca_color");
$xajax->registerFunction("input_muestra_articulo");
$xajax->registerFunction("input_busca_x_articulo");
$xajax->registerFunction("input_busca_x_rubro");
$xajax->registerFunction("input_valor_coseguro");
$xajax->registerFunction("ejec");
$xajax->registerFunction("cierra_atencion");
$xajax->registerFunction("lista_destino_noa");
$xajax->registerFunction("input_busca_destino_noa");
$xajax->registerFunction("lista_diagnostico_noa");
$xajax->registerFunction("input_busca_diagnostico_noa");
$xajax->processRequests();
//PLAN <input type="text" disabled="disabled" size=8 value="'.$plan['idplan'].'"> &nbsp; <input type="text" disabled="disabled" size=50  value="'.elimina_caracteres(htmlentities($plan['descplan'])).'">
$html_salida = '
<html>
 <head>
    <script defer type="text/javascript" src="js/jsfunciones.js"></script>
    <style type="text/css">
    <!--
    .style1 {
    font-size: 24px;
    font-weight: bold;
    }
    .style2 {font-family: "Courier New"}
    -->
    </style>
  <script>
   function js_control_importe_coseg(importe) {
    if (importe == 0)
    {
     alert("Importe incorrecto");
     xajax_input_valor_coseguro(1);
    }
   }

	function getfocus2()
	{
	        document.getElementById(\'i_busca_x_rubro\').focus();
	}
   
  
   function getfocus()
    {
            document.getElementById(\'i_busca_diagnostico\').focus();
    }

    ejecuta = 0
	


	function mueveReloj(){
		momentoActual = new Date()
		hora = momentoActual.getHours()
		minuto = momentoActual.getMinutes()
		segundo = momentoActual.getSeconds()	
		contador = segundo
         
        if (ejecuta == 10) {
		 getfocus();
       }	  
		 ejecuta = ejecuta + 1
 		setTimeout("mueveReloj()",250)
	}	
	
	
   function load_func() {
   
   xajax_lista_planes('.$plan['id'].');
   xajax_lista_diagnostico(-1);
   xajax_input_busca_plan('.$plan['id'].');
   xajax_input_busca_diagnostico(0);
   xajax_lista_destino(1);
   xajax_input_busca_destino(1);
   xajax_lista_color('.$atencion_datos['color'].');
   xajax_input_busca_color('.$atencion_datos['color'].');
   xajax_input_muestra_articulo('.$atencion_datos['movil'].',0,0);
   xajax_input_busca_x_articulo(0);
   xajax_input_busca_x_rubro(0);
   mueveReloj();
   
  // xajax_input_valor_coseguro(1);
   //xajax_ejec(0,0,0);
   '.$load_xajax_noa.'

   }

 

  
  </script>
  <link href="estilos.css" rel="stylesheet" type="text/css" />
  <title>Emergencias</title>
   '.$xajax->printJavascript("xajax/").'
  </head>
  <body onload="load_func();'.$check.';" 
               style="background-color:'.$body_color.' ;  font-size:'.$fontdef.' ; '.$font_family.'">
  '.titulo_encabezado_2 ('Cierre de Emergencia' , $path_imagen_logo).'
  <form name="formulario" id="formulario"  class="style1 style2" >
 
  <input type="hidden" value="'.$atencion_datos['movil'].'" id="movilhidden">
  <table width="80%" border="0" valign="top" style="font-size:'.$fontdef.'">
   <tr>
    <td align="left">
     LLAMADO <input name="legajo" type="text" disabled="disabled" value="'.$idemergencia_temp.'" size="10" />
    </td>
    <td>
    <table>
     <tr>
      <td>PLAN&nbsp; </td><td><div id="input_busca_plan_div"> </div></td><td><div id="lista_planes"> </div></td>
     </tr>
   </table>
    </td>
   <tr>
  </table>

  <table width="90%" border="0" style="font-size:'.$fontdef.'">
  <tr>
    <td colspan="3" align="center" style=" background-color:'.$td_color.'">Socio</td>
    <td width="4%">&nbsp;</td>
    <td width="5%" align="center" style=" background-color:'.$td_color.'">Edad</td>
    <td width="5%" align="center" style=" background-color:'.$td_color.'">Sexo</td>
    <td width="7%" >&nbsp;</td>
    <td width="20%" align="center" style=" background-color:'.$td_color.'">Identificacion</td>
    <td width="14%" align="center" style=" background-color:'.$td_color.'">Documento</td>
  </tr>
  <tr>
    <td width="%"><input  disabled="disabled" type="hidden" name="" value="'.elimina_caracteres(htmlentities($atencion_datos['socio'])).'" size="7%"/></td>
    <td width="2%"><input  disabled="disabled" type="hidden" name="" value="'.elimina_caracteres(htmlentities($atencion_datos['tiposocio'])).'" size="2%"/></td>
    <td width="10%" ><input   type="text" name="nom_socio" value="'.elimina_caracteres(htmlentities($atencion_datos['nombre'])).'" size="92%"/></td>
    <td>&nbsp;</td>
    <td><input  type="text"  name="edad_socio" value="'.$atencion_datos['edad'].'" size="2%"/></td>
    <td><input  type="text"  name="sexo_socio" value="'.$atencion_datos['sexo'].'" size="2%"/></td>
    <td>&nbsp;</td>
    <td><input  type="text"  name="identi_socio" value="'.elimina_caracteres(htmlentities($atencion_datos['identificacion'])).'" size="42%"/></td>
    <td><input  type="text"  name="dni_socio" value="'.$atencion_datos['documento'].'" size="38%"/></td>
  </tr>
</table>
<div class="barra_4" align="center">
<table width="91%" border="0" style=" background-color:'.$td_color.' ; font-size:'.$fontdef.'">
  '.$_FILAVINC.'
</table>
</div>
<table width="100%" border="0" style = "font-size:'.$fontdef.'">
 <tr>
  <td style=" background-color:'.$td_color.'">DIAGNOSTICO</td><td style=" background-color:'.$td_color.'">DESTINO</td><td style=" background-color:'.$td_color.'">COLORES</td>
 </tr>
 <tr>
  <td valign="top">
   <table>
    <tr>
    <td><div id="input_busca_diagnostico_div"></td><td></div><div id="lista_diagnostico"></div></td>
    </tr>
   </table>
  </td>
  <td valign="top">
  <table>
   <tr>
   <td><div id="input_busca_destino_div"></div><td></td><td><div id="lista_destino"></div></td>
   </tr>
  </table>
  </td>
  <td valign="top">
   <table>
    <tr>
        <td><div id="input_busca_color_div"></div></td><td><div id="lista_color"></div></td>
    </tr>
   </table>
  </td>
  </tr>
  <tr>
  <td colspan="3">
  <table align="center" border="0">
    <tr>
     <td colspan="2" align="center">OBSERVACIONES FINALES</td> <td align="center">ARTICULOS</td>
    </tr>
    <tr>
     <td valign="top"  colspan="2">
       <textarea id="text_obs_final" name="text_obs_final" cols="70" rows="10">'.$atencion_datos['observa1'].'</textarea>
     </td>

     <td>
  <table border="0">
   <tr>
    <td>
  <div class="barra_2">
    <table border="0" style = "font-size:'.$fontdef.'">
     <tr style=" background-color:'.$td_color.' ; font-size:'.$fontdef.'"><td>RUBRO</td><td>ARTICULO</td><td>DESCRIPCION</td><td>CANTIDAD</td><td>IMPACTAR</td></tr>
     <tr><td>
         <div id="input_busca_x_rubro_div"></div></td><td><div id="input_busca_x_articulo_div"></div>
         </td>
         <td><div id="input_descarticulo_div"></div></td><td><input type="text" id="cantidad_rest" size=10 value=0></td>
         <td ALIGN="CENTER"><input type="button" name="EJEC" VALUE="EJEC" onclick="check_ejec ( '.$idemergencia_temp.',
                                                                                                document.formulario.i_busca_x_rubro.value,
                                                                                                document.formulario.i_busca_x_articulo.value,
                                                                                                document.formulario.movilhidden.value,
                                                                                                document.formulario.cantidad_rest.value),
																								getfocus2();
																								"></td>
     </tr>
     <tr><td>&nbsp;</td></tr>
     <tr>
      <td colspan=5>
      <div id="muestra_ejec_div"></div>
      </td>
     </tr>
    </table>
    </div>
    </tr>
   </td>

    </tr>
  </table>
  </td>
 </tr>
</table>

<table border="0" width="100%" valing="top" style = "font-size:'.$fontdef.'">
 <tr>
   <td valign="top">
   <table width="400" border="0"  align="right" style = "font-size:'.$fontdef.'">
    <tr>
      <td colspan=2 align="left">Coseguro</td><td>No. de Recibo</td>
    <tr>
    <tr>
      <td>
        <label>
         <input type="radio" name="cosegurosi" value="SI"
                                                          onclick="document.formulario.cosegurono.checked=false;
                                                                   xajax_input_valor_coseguro(1); "/>
         Cobra
        </label>
        <td>
         <div id="input_coseguro_div"><input type="text"
                                                                   id="valor_coseguro" value="'.$importe_mostrar.'" /> </div>
        </td>
      </td>
      <td valign="top">
       <input type="text" id="nrecibo" />
     </td>

    </tr>
    <tr>
      <td colspan=3 align="left">
        <label>
         <input type="radio" name="cosegurono" value="NO" onclick="document.formulario.cosegurosi.checked=false ;
                                                                   xajax_input_valor_coseguro(1); "/>
         No Cobra
        </label>
      </td>
    </tr>
   </table>
   </td>
   <td>
    <table border="0" width="" >
<tr>
 <td width="" align="left">
 <div id="muestra_insert_cierre">
  <input type="button" value="** OK **" onclick="check_cierra_atencion(
   '.$idemergencia_temp.',
   document.formulario.s_lista_destino.value,
   document.formulario.s_lista_diagnostico.value,
   document.formulario.s_lista_color.value,
   document.formulario.cosegurosi.checked,
   document.formulario.cosegurono.checked,
   document.formulario.valor_coseguro.value,
   document.formulario.text_obs_final.value ,

   '.$cantidad_vinculados.',

document.formulario.nosocio1.checked , document.formulario.no_socio_1.value , document.formulario.no_edad_1.value , document.formulario.no_sexo_1.value , document.formulario.no_iden_1.value , document.formulario.no_docum_1.value , document.formulario.destino_1.value , document.formulario.diagno_1.value ,
document.formulario.nosocio2.checked , document.formulario.no_socio_2.value , document.formulario.no_edad_2.value , document.formulario.no_sexo_2.value , document.formulario.no_iden_2.value , document.formulario.no_docum_2.value , document.formulario.destino_2.value , document.formulario.diagno_2.value ,
document.formulario.nosocio3.checked , document.formulario.no_socio_3.value , document.formulario.no_edad_3.value , document.formulario.no_sexo_3.value , document.formulario.no_iden_3.value , document.formulario.no_docum_3.value , document.formulario.destino_3.value , document.formulario.diagno_3.value ,
document.formulario.nosocio4.checked , document.formulario.no_socio_4.value , document.formulario.no_edad_4.value , document.formulario.no_sexo_4.value , document.formulario.no_iden_4.value , document.formulario.no_docum_4.value , document.formulario.destino_4.value , document.formulario.diagno_4.value ,
document.formulario.nosocio5.checked , document.formulario.no_socio_5.value , document.formulario.no_edad_5.value , document.formulario.no_sexo_5.value , document.formulario.no_iden_5.value , document.formulario.no_docum_5.value , document.formulario.destino_5.value , document.formulario.diagno_5.value ,

document.formulario.nosocioid1.value ,document.formulario.nosocioid2.value ,document.formulario.nosocioid3.value ,document.formulario.nosocioid4.value ,
document.formulario.nosocioid5.value ,
document.formulario.nrecibo.value ,
document.formulario.i_busca_plan.value ,document.formulario.nom_socio.value, document.formulario.edad_socio.value , document.formulario.sexo_socio.value ,
document.formulario.identi_socio.value , document.formulario.dni_socio.value
  );">
  </div>
 </td>
</tr>
</table>

   </td>
  </tr>
</table>

</form>
</body>
</html>
';

echo $html_salida;

/*
"xajax_ejec ( '.$idemergencia_temp.',
                                                                                                document.formulario.i_busca_x_rubro.value,
                                                                                                document.formulario.i_busca_x_articulo.value,
                                                                                                document.formulario.movilhidden.value,
                                                                                                document.formulario.cantidad_rest.value)"
*/
?>