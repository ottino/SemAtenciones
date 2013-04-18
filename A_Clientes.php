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
<TITLE>A_Clientes.php</TITLE>
</HEAD>
<script>
 function valida (nombre,perfis,perju,tipodni,tipolc,tipole,tipodne,dni,afil,dia,mes,anio,calle,nro,postal,cuit,sexo_m,sexo_f,
                  estcivil,entre1,entre2,piso,dpto,barrio,codpostal,zona,locali,tel,cel,mail,contac,obs)
 {
   var bandera_1= 0;
   var bandera_2= 0;
  if ((nombre == null) || (nombre == ''))
   {
     alert ("Ingrese un nombre valido!!")
   } else if ((perfis == false) && (perju == false))
             {
              alert ("Seleccione un tipo de persona valido!!")
             } else if ((perfis == true)&&((tipodni == false)&&(tipolc== false)&&(tipole==false )&&(tipodne==false)))
                      {
                       alert (" Seleccione un tipo de documento valido!!")
                      } else if ((perfis == true)&&(dni < 1000000))
                                {
                                 alert ("Seleccione un dni valido!!")
                                }else if ((afil < 0) || (afil == null) || (afil == ''))
                                         {
                                          alert ("Seleccione un numero de afiliado correcto!!")
                                         } else if ((perfis == true) && ((dia == '')|| (mes== '')|| (anio== '')))
                                                   {
                                                     alert ("Ingresar Fecha de nacimiento!!");
                                                   }else if ((dia < 0) || (dia > 31))
                                                            {
                                                             alert ("Ingrese un dia correcto")
                                                            }else if ((mes < 0) && (mes >12))
                                                                    {
                                                                     alert ("Ingrese un mes correcto");
                                                                    }else if ((anio < 0) && (anio > 2050))
                                                                             {
                                                                              alert ("Seleccione un anio correcto!!")
                                                                             }else if ((calle == null) || (calle == ''))
                                                                                     {
                                                                                      alert("Ingrese un domicilio valido")
                                                                                     }else if ((nro == null) || (nro == ''))
                                                                                     {
                                                                                      alert("Ingrese un numero de calle valido")
                                                                                     }else if ((postal == null) || (postal == ''))
                                                                                     {
                                                                                      alert("Ingrese un numero postal valido")
                                                                                     }else if (perfis==true &&((sexo_m==false) || (sexo_f==false)))
                                                                                            {
                                                                                             alert ("Ingrese sexo de la persona")
                                                                                            }
                                                                                       else {
                                                                                             bandera_1 = 1;
                                                                                             //window.location.href("A_clientes2.php");
                                                                                            }

    // rutina para validar cuit
   var vec=Array(10);
    esCuit=false;
    cuit_rearmado="";
    errors = ''
    for (i=0; i < cuit.length; i++) {
        caracter=cuit.charAt( i);
        if ( caracter.charCodeAt(0) >= 48 && caracter.charCodeAt(0) <= 57 )     {
            cuit_rearmado +=caracter;
        }
    }
    cuit=cuit_rearmado;
    if ( cuit.length != 11) {  // si to estan todos los digitos
        esCuit=false;
        errors = 'Cuit <11 ';
        //alert( "CUIT Menor a 11 Caracteres" );
    } else {
        x=i=dv=0;
        // Multiplico los dígitos.
        vec[0] = cuit.charAt(  0) * 5;
        vec[1] = cuit.charAt(  1) * 4;
        vec[2] = cuit.charAt(  2) * 3;
        vec[3] = cuit.charAt(  3) * 2;
        vec[4] = cuit.charAt(  4) * 7;
        vec[5] = cuit.charAt(  5) * 6;
        vec[6] = cuit.charAt(  6) * 5;
        vec[7] = cuit.charAt(  7) * 4;
        vec[8] = cuit.charAt(  8) * 3;
        vec[9] = cuit.charAt(  9) * 2;

        // Suma cada uno de los resultado.
        for( i = 0;i<=9; i++) {
            x += vec[i];
        }
        dv = (11 - (x % 11)) % 11;
        if ( dv == cuit.charAt( 10) ) {
            esCuit=true;
        }
    }
    if ( !esCuit ) {
        alert( "CUIT Invalido" );
        document.formulario.cla_cuit.focus();
        document.formulario.cla_cuit.value= "INGRESE CUIT VALIDO";
        errors = 'Cuit Invalido ';
    } else bandera_2 = 1
  //document.MM_returnValue1 = (errors == '');

    if ((bandera_1 == 1) && (bandera_2 == 1))
      {
       alert ("todo bien validado");
       // nombre,perfis,perju,tipodni,tipolc,tipole,tipodne,dni,afil,dia,mes,anio,calle,nro,postal,cuit,sexo_m,sexo_f
       location.href = "A_Clientes2.php?nom="+nombre+"&perfis="+perfis+"&perju="+perju+"&tipodni="+
                              tipodni+"&tipolc="+tipolc+"&tipole="+tipole+"&tipodne="+tipodne+"&dni="+
                              dni+"&afil="+afil+"&dia="+dia+"&mes="+mes+"&anio="+anio+"&calle="+
                              calle+"&nro="+nro+"&postal="+postal+"&cuit="+cuit+"&sexo_m="+sexo_m+"&sexo_f="+sexo_f+
                              "&estcivil="+estcivil+"&entre1="+entre1+"&entre2="+entre2+"&piso="+piso+
                              "&dpto="+dpto+"&barrio="+barrio+"&codpostal="+codpostal+"&zona="+zona
                              +"&locali="+locali+"&tel="+tel+"&cel="+cel+"&mail="+mail+"&contac="+contac+"&obs="+obs;
      }
 }
</script>
<body style="background-color:<?echo $body_color?>">
<BODY>


<?

echo titulo_encabezado ('Alta de Clientes' , $path_imagen_logo);
/*
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
  */
?>


<br>
<FORM METHOD="GET" name="formulario"
ACTION="A_Clientes2.php">

<?

//Ejecutamos la sentencia SQL
$result=mysql_query("SELECT * FROM provincias order by 2");
while ($row=mysql_fetch_array($result))
{
$provincias.='<option value="'.$row['idprovincia'].'">'.$row['provincia'].'</option>';
}
mysql_free_result($result);

$result=mysql_query("SELECT * FROM localidad order by 3");
while ($row=mysql_fetch_array($result))
{
$localidad.='<option value="'.$row['idlocalidad'].'">'.$row['localidad'].'</option>';
}
mysql_free_result($result);

$result=mysql_query("SELECT * FROM estadocivil order by 2");
while ($row=mysql_fetch_array($result))
{
$estadocivil.='<option value="'.$row['idestado'].'">'.$row['estado'].'</option>';
}
mysql_free_result($result);

$result=mysql_query("SELECT * FROM zonas order by 1");
while ($row=mysql_fetch_array($result))
{
$zonas.='<option value="'.$row['idzonas'].'">'.$row['desczonas'].'</option>';
}
mysql_free_result($result);

 echo'<Table>';
 echo '<TR><TD>Nombre   </TD><TD><input size= 50 type = "text" name = "cla_nombre" /></TD>';
 echo '<TD>Tipo Pers</TD><TD>
     <label>
       <input type="radio" name="cla_tipoper_fis" value="F" onclick="document.formulario.cla_tipoper_ju.checked=false"/>
       P.Fisica</label>
     <label>
       <input type="radio" name="cla_tipoper_ju" value="J" onclick="document.formulario.cla_tipoper_fis.checked=false
                                                                     document.formulario.cla_sexo_m.checked=false
                                                                     document.formulario.cla_sexo_f.checked=false
                                                                     document.formulario.cla_tipodoc_dni.checked=false
                                                                     document.formulario.cla_tipodoc_lc.checked=false
                                                                     document.formulario.cla_tipodoc_le.checked=false
                                                                     document.formulario.cla_tipodoc_dne.checked=false
                                                                     document.formulario.cla_documento.value= \' \'
                                                                     "/>
       P.Juridica</label></TD></TR>';

 echo '<TR><TD>Cuit     </TD><TD><input size= 30 type = "text" name = "cla_cuit" /></TD>';

 echo '<TD>Sexo</TD><TD>
     <label>
       <input type="radio" name="cla_sexo_m" value="M" onclick=" document.formulario.cla_sexo_f.checked=false"/>
       Masculino</label>
     <label>
       <input type="radio" name="cla_sexo_f" value="F" onclick=" document.formulario.cla_sexo_m.checked=false"/>
       Femenino</label></TD></TR>';


 echo '<TR><TD>Tipo Doc</TD><TD>
      <label>
        <input type="radio" name="cla_tipodoc_dni" value="DNI" onclick="document.formulario.cla_tipodoc_le.checked=false,
                                                                        document.formulario.cla_tipodoc_lc.checked=false ,
                                                                        document.formulario.cla_tipodoc_dne.checked=false ">
        DNI</label><label>
        <input type="radio" name="cla_tipodoc_le" value="LE" onclick="document.formulario.cla_tipodoc_dni.checked=false,
                                                                        document.formulario.cla_tipodoc_lc.checked=false,
                                                                        document.formulario.cla_tipodoc_dne.checked=false">
        LE</label><label>
        <input type="radio" name="cla_tipodoc_lc" value="LC" onclick="document.formulario.cla_tipodoc_dni.checked=false,
                                                                        document.formulario.cla_tipodoc_le.checked=false,
                                                                        document.formulario.cla_tipodoc_dne.checked=false">
        LC</label><label>
        <input type="radio" name="cla_tipodoc_dne" value="DNE" onclick="document.formulario.cla_tipodoc_dni.checked=false,
                                                                        document.formulario.cla_tipodoc_le.checked=false,
                                                                        document.formulario.cla_tipodoc_lc.checked=false">
        DNE</label></td>';


echo '<TD>Nro Docum</TD><TD><input size= 10 type = "text" name = "cla_documento" /></TD></TR>';
echo '<TR><TD>Nro Afil.</TD><TD><input size= 10 type = "text" name = "cla_nroafiliado" /></TD></TR>';
echo '<TR><TD>Est.Civil</TD><TD><select name="cla_estadocivil">'.$estadocivil.'</select></TD>';
echo '<TD>Fec.Nac. </TD><TD><input size= 2 type = "text" name = "cla_fdnac" /><input size= 2 type = "text" name = "cla_fmnac" />
      <input size= 4 type = "text" name = "cla_fanac" /></TD></TR>';
echo '<TR><TD>Calle    </TD><TD><input size= 50 type = "text" name = "cla_calle" /></TD>';
echo '<TD>Nro      </TD><TD><input size= 4 type = "text" name = "cla_nrocalle" /></TD></TR>';
echo '<TR><TD>Entre   </TD><TD><input size= 50 type = "text" name = "cla_entre1" /></TD>';
echo '<TD>Y</TD><TD><input size= 50 type = "text" name = "cla_entre2" /></TD></TR>';
echo '<TR><TD>Piso     </TD><TD><input size= 4 type = "text" name = "cla_piso" /></TD>';
echo '<TD>Depto    </TD><TD><input size= 6 type = "text" name = "cla_depto" /></TD></TR>';
echo '<TR><TD>Barrio   </TD><TD><input size= 30 type = "text" name = "cla_barrio" /></TD>';
echo '<TD>Cod.Post.</TD><TD><input size= 4 type = "text" name = "cla_cpostal" /></TD></TR>';
echo '<TR><TD>Zona</TD><TD><select name="cla_zona">'.$zonas.'</select></TD>';
echo '<TR><TD>Localidad</TD><TD><select name="cla_localidad">'.$localidad.'</select></TD>';
echo '<TD>Provincia</TD><TD><select name="cla_provincia">'.$provincias.'</select></TD></TR>';
echo '<TR><TD>Telefono </TD><TD><input size= 20 type = "text" name = "cla_telefono" /></TD>';
echo '<TD>Celular  </TD><TD><input size= 20 type = "text" name = "cla_celular" /></TD></TR>';
echo '<TR><TD>E-mail   </TD><TD><input size= 40 type = "text" name = "cla_email" /></TD></TR>';
echo '<TR><TD>Contacto </TD><TD><input size= 50 type = "text" name = "cla_contacto" /></TD></TR>';
echo '<TR><TD>Observaciones</TD><TD><textarea name="cla_observaciones" rows="5" cols="40"></textarea></TD></TR>';
echo '</table>' ;
echo '<input type="hidden" value="">'
?>
<td><INPUT TYPE="button" value="Insertar" onclick="
                                                   valida (document.formulario.cla_nombre.value ,
                                                           document.formulario.cla_tipoper_fis.checked ,
                                                           document.formulario.cla_tipoper_ju.checked ,
                                                           document.formulario.cla_tipodoc_dni.checked,
                                                           document.formulario.cla_tipodoc_lc.checked,
                                                           document.formulario.cla_tipodoc_le.checked,
                                                           document.formulario.cla_tipodoc_dne.checked,
                                                           document.formulario.cla_documento.value,
                                                           document.formulario.cla_nroafiliado.value ,
                                                           document.formulario.cla_fdnac.value ,
                                                           document.formulario.cla_fmnac.value ,
                                                           document.formulario.cla_fanac.value ,
                                                           document.formulario.cla_calle.value ,
                                                           document.formulario.cla_nrocalle.value ,
                                                           document.formulario.cla_cpostal.value ,
                                                           document.formulario.cla_cuit.value ,
                                                           document.formulario.cla_sexo_m.value ,
                                                           document.formulario.cla_sexo_f.value ,

                                                           document.formulario.cla_estadocivil.value ,
                                                           document.formulario.cla_entre1.value ,
                                                           document.formulario.cla_entre2.value ,
                                                           document.formulario.cla_piso.value  ,
                                                           document.formulario.cla_depto.value ,
                                                           document.formulario.cla_barrio.value ,
                                                           document.formulario.cla_cpostal.value ,

                                                           document.formulario.cla_zona.value ,
                                                           document.formulario.cla_localidad.value ,
                                                           document.formulario.cla_telefono.value ,
                                                           document.formulario.cla_celular.value ,
                                                           document.formulario.cla_email.value ,
                                                           document.formulario.cla_contacto.value ,
                                                           document.formulario.cla_observaciones.value
                                                           );"></td>


    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
   </BODY>
</HTML>


