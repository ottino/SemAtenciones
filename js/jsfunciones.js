function isInteger (s)
   {
      var i;

      if (isEmpty(s))
      if (isInteger.arguments.length == 1) return 0;
      else return (isInteger.arguments[1] == true);

      for (i = 0; i < s.length; i++)
      {
         var c = s.charAt(i);

         if (!isDigit(c)) return false;
      }

      return true;
   }

// pregunta antes de eliminar 
function check_emergencia(
fecha,telefono,plan,horallam,socio,nombre,tiposocio,edad,sexo,identificacion,documento,
calle,numero,piso,depto,casa,monoblok,barrio,entre1,entre2,localidad,
referencia,zona,motivo1,color,observa1,observa2,opedesp,
check_traslado , dia_traslado , mes_traslado , anio_traslado , hora_traslado , minuto_traslado ,
nosocio1checked  , nosocio1 , noedad1 , nosexo1, noiden1 , nodocum1 ,
nosocio2checked  , nosocio2 , noedad2 , nosexo2, noiden2 , nodocum2 ,
nosocio3checked  , nosocio3 , noedad3 , nosexo3, noiden3 , nodocum3 ,
nosocio4checked  , nosocio4 , noedad4 , nosexo4, noiden4 , nodocum4 ,
nosocio5checked  , nosocio5 , noedad5 , nosexo5, noiden5 , nodocum5 
)
  {
     //alert (nosocio2checked);
     // VALIDACIONES 
 	 //var motivo_explode = motivo1.split('-');
 	 var motivo_explode = motivo1.substr(0,1);
 	 var fecha_explode = fecha.split('.');
	 //alert (fecha_explode[0]+'/'+fecha_explode[1]+'/'+fecha_explode[2]);


    var bandera = 0;
	var bandera_nosocio1 = 0;
	var bandera_nosocio2 = 0;
	var bandera_nosocio3 = 0;
	var bandera_nosocio4 = 0;
	var bandera_nosocio5 = 0;
	var er = /^[0-9]+$/;  
      
	  if ((sexo != 'M') && (sexo != 'F')&& (sexo != 'm') && (sexo != 'f'))
	     alert ("Ingrese un sexo valido");
      else 
	  if ((nombre == '') || (nombre == null) || (nombre == " "))
	     alert ("Ingrese nombre");
      //else
	  //if (tiposocio.length > 2)
	  //   alert ("Ingresar tipo de socio de dos digitos");
	  else 	 
	  if ((calle == '') || (calle == null))
	     alert ("Ingrese calle");
      else
	  if ((localidad == '') || (localidad == null))
	     alert ("Ingrese localidad");
      else
	  if ((edad == '') || (edad == null))
	     alert ("Ingrese edad");
      else
	  if ((edad == ' ') || (edad == '  ')|| (edad == '   ')|| (edad == '   ')||(edad == ' '))
	     alert ("Ingrese edad");
      else	  
	  if ((edad > 120) || (edad < 0))
	     alert ("Ingrese edad");
      else  
      if (isNaN(edad) == true)
          alert ("Ingrese edad");
      else		  
	  if (zona == 0)
	     alert ("Ingrese zona");		 
  	  else	 
	  if (color == 0)
	    alert ("Ingrese color");
	  else
	  if (plan == 0)
	     alert ("Ingrese plan");		
      else 
      if ((motivo_explode == null) || (motivo_explode == ' ') || (motivo_explode == ''))	  
		 alert ("Ingrese un motivo valido");
	  else if (check_traslado == 1)
             {
			   var fecha_traslado = new Date (mes_traslado+'/'+dia_traslado+'/'+anio_traslado);
			   var fecha_actual   = new Date (fecha_explode[1]+'/'+fecha_explode[0]+'/'+fecha_explode[2]);
			   var fh_traslado  = anio_traslado+'.'+mes_traslado+'.'+dia_traslado;
			   var hs_traslado  = hora_traslado+':'+minuto_traslado+':00';
	           //alert (fecha_traslado); 
               if ((dia_traslado == 'DD') || (dia_traslado > 31) || (dia_traslado == 0) || (dia_traslado == null) || (dia_traslado.length > 2))
                    alert ("Dia de traslado incorrecto"); 			   
			   else if 	((mes_traslado == 'MM') || (mes_traslado > 12) || (mes_traslado == 0) || (mes_traslado.length > 2))
                    alert ("Mes de traslado incorrecto");
               else if 	( (anio_traslado == 'AAAA') || (anio_traslado.length > 4) || (anio_traslado.length < 4) || (anio_traslado == 0))
                    alert ("Anio de traslado incorrecto");
               else if (fecha_traslado < fecha_actual)
                     alert ("Fecha de traslado menor a fecha actual");			   
               else if ((hora_traslado == 'HH') || (hora_traslado > 24) || (hora_traslado < 0) || (hora_traslado.length > 2))
                    alert ("Hora de traslado incorrecta");	
               else if ((minuto_traslado == 'MM') || (minuto_traslado >= 60) || (minuto_traslado < 0) || (minuto_traslado.length > 2))
                    alert ("Minuto de traslado incorrecta");		
               else bandera= 1;		   			
             } 			 
      else bandera = 1;
	// ------------------------------	 

        if (nosocio1checked == true)	  
		 {
		  if ((nosocio1 == '') || (nosocio1 == null) || (nosocio1 == " "))
		   {
	          alert ("Ingrese nombre del cliente no apadronado ( numero 1 )");
              bandera = 0;
		   }
		  else bandera_nosocio1 = 1;		  
		 }
		 
        if (nosocio2checked == true)	  
		 {
		  if ((nosocio2 == '') || (nosocio2 == null) || (nosocio2 == " "))
		   {
	          alert ("Ingrese nombre del cliente no apadronado ( numero 2 )");
              bandera = 0;
		   }
		  else bandera_nosocio2 = 1;		  
		 }
		 
        if (nosocio3checked == true)	  
		 {
		  if ((nosocio3 == '') || (nosocio3 == null) || (nosocio3 == " "))
		   {
	          alert ("Ingrese nombre del cliente no apadronado ( numero 3 )");
              bandera = 0;
		   }
		  else bandera_nosocio3 = 1;		  
		 }	   
        if (nosocio4checked == true)	  
		 {
		  if ((nosocio4 == '') || (nosocio4 == null) || (nosocio4 == " "))
		   {
	          alert ("Ingrese nombre del cliente no apadronado ( numero 4 )");
              bandera = 0;
		   }
		  else bandera_nosocio4 = 1;		  
		 }	   
        if (nosocio5checked == true)	  
		 {
		  if ((nosocio5 == '') || (nosocio5 == null) || (nosocio5 == " "))
		   {
	          alert ("Ingrese nombre del cliente no apadronado ( numero 5 )");
              bandera = 0;
		   }
		  else bandera_nosocio5 = 1;		  
		 }	   

	 
	 if (bandera == 1)
     {	 
	   var ventana_cerrar = window.self; 
	   //ventana=confirm("¿Esta seguro que desea agregar?");                        
	   //if (ventana) 
	    //{
		 if (check_traslado == 1)
		 {
	     xajax_agrega_emergencia_ctraslado(fh_traslado,telefono,plan,hs_traslado,socio,nombre,tiposocio,edad,sexo,identificacion,documento,
	                             calle,numero,piso,depto,casa,monoblok,barrio,entre1,entre2,localidad,
			  				     referencia,zona,motivo1,color,observa1,observa2,opedesp,
								 nosocio1 , noedad1 , nosexo1, noiden1 , nodocum1 , nosocio2 , noedad2 , nosexo2, noiden2 , nodocum2 ,
								 nosocio3 , noedad3 , nosexo3, noiden3 , nodocum3 , nosocio4 , noedad4 , nosexo4, noiden4 , nodocum4 ,
								 nosocio5 , noedad5 , nosexo5, noiden5 , nodocum5 , 
								 bandera_nosocio1  , bandera_nosocio2 ,bandera_nosocio3  ,bandera_nosocio4 ,
								 bandera_nosocio5  
								 )
		 
		 }else { 
	     xajax_agrega_emergencia(fecha,telefono,plan,horallam,socio,nombre,tiposocio,edad,sexo,identificacion,documento,
	                             calle,numero,piso,depto,casa,monoblok,barrio,entre1,entre2,localidad,
			  				     referencia,zona,motivo1,color,observa1,observa2,opedesp,
								 nosocio1 , noedad1 , nosexo1, noiden1 , nodocum1 , nosocio2 , noedad2 , nosexo2, noiden2 , nodocum2 ,
								 nosocio3 , noedad3 , nosexo3, noiden3 , nodocum3 , nosocio4 , noedad4 , nosexo4, noiden4 , nodocum4 ,
								 nosocio5 , noedad5 , nosexo5, noiden5 , nodocum5 ,
								 bandera_nosocio1  , bandera_nosocio2 ,bandera_nosocio3  ,bandera_nosocio4 ,
								 bandera_nosocio5  
								 )
	     }
	    // ventana_cerrar.opener = window.self; 
	    // ventana_cerrar.close(); 
	    //}
	 }

  };

// pregunta antes de eliminar 
function check_movil(idatenciontemp,idmovil,control)
  {
  
     //if (control == 0)
	// {
	      if (idmovil == 0)
		  {
	         alert ("Falta asignar movil !!!!!");
	      }
		  else
	      {	  
		    //ventana=confirm("¿Esta seguro que desea realizar el despacho?");                        
		   // if (ventana) 
		    //{
		     xajax_asigna_movil(idatenciontemp,idmovil);
			 xajax_refresca_moviles();
		    //}
		   } 
	 // } else alert ("Ya fue asignado un movil !!!!!");	   
	 
  };
 
// verifica antes de hacer la anular una atencion
function check_anula(idatencion,cod_anula,obs)
  {
  
     if (cod_anula == 0)
	 {
        alert ("CODIGO DE ANULACION INCORRECTO");
	 }else
        {	 
	 	  xajax_anula_atencion(idatencion,cod_anula,obs);
		  window.close();
	    }	 
  };
  
function check_close(ate,obs)
  {
    xajax_func_ingresa_llamado(ate,obs);
    window.close();
  };  
  
function check_ejec ( idemergencia_temp , i_busca_x_rubro, i_busca_x_articulo,
					  movilhidden, cantidad_rest)
{

  
  xajax_ejec(idemergencia_temp , i_busca_x_rubro, i_busca_x_articulo,
					  movilhidden, cantidad_rest);
					  

}						  

function check_cierra_atencion ( idemergencia_temp, s_lista_destino,s_lista_diagnostico,
                                 s_lista_color,cosegurosi,cosegurono,valor_coseguro , obs_final ,
								    cantidad_vincul , 
									nosocio1checked , nosocio1 , noedad1 , nosexo1, noiden1 , nodocum1 , destino1, diagno1 , 
									nosocio2checked , nosocio2 , noedad2 , nosexo2, noiden2 , nodocum2 , destino2, diagno2 , 
									nosocio3checked , nosocio3 , noedad3 , nosexo3, noiden3 , nodocum3 , destino3, diagno3 , 
									nosocio4checked , nosocio4 , noedad4 , nosexo4, noiden4 , nodocum4 , destino4, diagno4 , 
									nosocio5checked , nosocio5 , noedad5 , nosexo5, noiden5 , nodocum5 , destino5, diagno5 , 									
									nosocioid1,nosocioid2,nosocioid3,nosocioid4,nosocioid5, 
									nrecibo,plan_socio,nom_socio,edad_socio,sexo_socio,identi_socio,dni_socio
									
							   )
{
/*
alert (plan_socio);
alert (nom_socio);
alert (edad_socio);
alert (sexo_socio);
alert (identi_socio);
alert (dni_socio);
*/
    var bandera_coseguro = 0;

   	var bandera_nosocio1 = 0;
	var bandera_nosocio2 = 0;
	var bandera_nosocio3 = 0;
	var bandera_nosocio4 = 0;
	var bandera_nosocio5 = 0;
    
	var bandera = 1;	  

	if (nosocio1checked == true) { if ((nosocio1 == '') || (nosocio1 == null) || (nosocio1 == " ")) { alert ("Ingrese nombre del cliente no apadronado ( numero 1 )"); bandera = 0; } else bandera_nosocio1 = 1; }
	if (nosocio2checked == true) { if ((nosocio2 == '') || (nosocio2 == null) || (nosocio2 == " ")) { alert ("Ingrese nombre del cliente no apadronado ( numero 2 )"); bandera = 0; } else bandera_nosocio2 = 1; }
	if (nosocio3checked == true) { if ((nosocio3 == '') || (nosocio3 == null) || (nosocio3 == " ")) { alert ("Ingrese nombre del cliente no apadronado ( numero 3 )"); bandera = 0; } else bandera_nosocio3 = 1; }
	if (nosocio4checked == true) { if ((nosocio4 == '') || (nosocio4 == null) || (nosocio4 == " ")) { alert ("Ingrese nombre del cliente no apadronado ( numero 4 )"); bandera = 0; } else bandera_nosocio4 = 1; }
	if (nosocio5checked == true) { if ((nosocio5 == '') || (nosocio5 == null) || (nosocio5 == " ")) { alert ("Ingrese nombre del cliente no apadronado ( numero 5 )"); bandera = 0; } else bandera_nosocio5 = 1; }
	
   for(i=0;i<valor_coseguro.length;i++)
      {
        if(valor_coseguro.charAt(i)==",") 
		{
		 alert ("EL PUNTO DECIMAL EN EL VALOR COSEGURO ES EL PUNTO");	 
		 bandera_coseguro = 1;
        }
	  }
	
   if (bandera == 1)
   {   
        if ((cosegurosi == true) && ((bandera_coseguro == 1) || (valor_coseguro == null) || (valor_coseguro == 0) || (valor_coseguro < 0)))
	      {
		   alert  ("INGRESE UN VALOR COSEGURO VALIDO");  
		  }	 
	   	else if (s_lista_destino == 'A')
		 {
		  alert ("INGRESE UN DESTINO VALIDO");
		 }   	
		 else if (s_lista_diagnostico== 'A')
		 {
		  alert ("INGRESE UN DIAGNOSTICO VALIDO"); 
		 }   	
		 else if (s_lista_color== 'A')
		 {
		  alert ("INGRESE UN COLOR VALIDO");
		 }
		 else if (s_lista_color== 5)
		 {
		  alert ("DEBE SELECCIONAR COLOR");
		 }
		// else if ((nrecibo == null) || (nrecibo == ''))
		// {
		//  alert ("INGRESE UN NUMERO DE RECIBO VALIDO");
		// }
	     else {

	         xajax_cierra_atencion ( idemergencia_temp, s_lista_destino,s_lista_diagnostico,
	                                 s_lista_color,cosegurosi,cosegurono,valor_coseguro , obs_final ,
									 nosocio1 , noedad1 , nosexo1, noiden1 , nodocum1 , destino1, diagno1 , 
									 nosocio2 , noedad2 , nosexo2, noiden2 , nodocum2 , destino2, diagno2 , 
									 nosocio3 , noedad3 , nosexo3, noiden3 , nodocum3 , destino3, diagno3 , 
									 nosocio4 , noedad4 , nosexo4, noiden4 , nodocum4 , destino4, diagno4 , 
									 nosocio5 , noedad5 , nosexo5, noiden5 , nodocum5 , destino5, diagno5 , 
									 bandera_nosocio1  ,bandera_nosocio2  ,bandera_nosocio3  ,bandera_nosocio4  ,bandera_nosocio5  ,									 
									 cantidad_vincul ,
									 nosocioid1 ,nosocioid2 ,nosocioid3 ,nosocioid4 ,nosocioid5 ,  
									 nrecibo,plan_socio,nom_socio,edad_socio,sexo_socio,identi_socio,dni_socio								 
								   );
								  
			 //alert (nrecibo);					   
	         //window.close();								 
		   }	
   }

}

 function calendario(){
    Calendar.setup({ 
     inputField     :    "cla_fecha",     // id del campo de texto 
      ifFormat     :     "%Y/%m/%d",     // formato de la fecha que se escriba en el campo de texto 
      button     :    "lanzador"     // el id del botón que lanzará el calendario 
 }); 
};

 function calendario1(){
    Calendar.setup({ 
     inputField     :    "cla_fecha1",     // id del campo de texto 
      ifFormat     :     "%Y/%m/%d",     // formato de la fecha que se escriba en el campo de texto 
      button     :    "lanzador1"     // el id del botón que lanzará el calendario 
 }); 
};
//********************************************************************

function check_emergencia_edit(
fecha,telefono,plan,horallam,socio,nombre,tiposocio,edad,sexo,identificacion,documento,
calle,numero,piso,depto,casa,monoblok,barrio,entre1,entre2,localidad,
referencia,zona,motivo1,color,observa1,observa2,opedesp,
check_traslado , dia_traslado , mes_traslado , anio_traslado , hora_traslado , minuto_traslado ,id_ate_edit)
{
//alert (nombre);   
  

	 var motivo_explode = motivo1.substr(0,1);
 	 var fecha_explode = fecha.split('.');


    var bandera = 0;
  
      
	  if ((sexo != 'M') && (sexo != 'F')&& (sexo != 'm') && (sexo != 'f'))
	     alert ("Ingrese un sexo valido");
      else 
	  if ((nombre == '') || (nombre == null) || (nombre == " "))
	     alert ("Ingrese nombre");
	  else 	 
	  if ((calle == '') || (calle == null))
	     alert ("Ingrese calle");
      else
	  if ((localidad == '') || (localidad == null))
	     alert ("Ingrese localidad");
      else
	  if (zona == 0)
	     alert ("Ingrese zona");		 
  	  else	 
	  if ((edad == '') || (edad == null))
	     alert ("Ingrese edad");
      else
	  if ((edad == ' ') || (edad == '  ')|| (edad == '   ')|| (edad == '   ')||(edad == ' '))
	     alert ("Ingrese edad");
      else	  
	  if ((edad > 120) || (edad < 0))
	     alert ("Ingrese edad");
      else  
      if (isNaN(edad) == true)
          alert ("Ingrese edad");
      else		  
	  if (color == 0)
	    alert ("Ingrese color");
	  else
	  if (plan == 0)
	     alert ("Ingrese plan");		
      else 
      if ((motivo_explode == null) || (motivo_explode == ' ') || (motivo_explode == ''))	  
		 alert ("Ingrese un motivo valido");
	  else if (check_traslado == 1)
             {
			   var fecha_traslado = new Date (mes_traslado+'/'+dia_traslado+'/'+anio_traslado);
			   var fecha_actual   = new Date (fecha_explode[1]+'/'+fecha_explode[0]+'/'+fecha_explode[2]);
			   var fh_traslado  = anio_traslado+'.'+mes_traslado+'.'+dia_traslado;
			   var hs_traslado  = hora_traslado+':'+minuto_traslado+':00';
	           //alert (fecha_traslado); 
               if ((dia_traslado == 'DD') || (dia_traslado > 31) || (dia_traslado == 0) || (dia_traslado == null) || (dia_traslado.length > 2))
                    alert ("Dia de traslado incorrecto"); 			   
			   else if 	((mes_traslado == 'MM') || (mes_traslado > 12) || (mes_traslado == 0) || (mes_traslado.length > 2))
                    alert ("Mes de traslado incorrecto");
               else if 	( (anio_traslado == 'AAAA') || (anio_traslado.length > 4) || (anio_traslado.length < 4) || (anio_traslado == 0))
                    alert ("Anio de traslado incorrecto");
               else if (fecha_traslado < fecha_actual)
                     alert ("Fecha de traslado menor a fecha actual");			   
               else if ((hora_traslado == 'HH') || (hora_traslado > 24) || (hora_traslado < 0) || (hora_traslado.length > 2))
                    alert ("Hora de traslado incorrecta");	
               else if ((minuto_traslado == 'MM') || (minuto_traslado >= 60) || (minuto_traslado < 0) || (minuto_traslado.length > 2))
                    alert ("Minuto de traslado incorrecta");		
               else bandera= 1;		   			
             } 			 
      else bandera = 1;
	// ------------------------------	 

 
	 
	 if (bandera == 1)
     {	 
	   var ventana_cerrar = window.self; 
//	   ventana=confirm("¿Esta seguro que desea agregar?");                        
//	   if (ventana) 
	   // {
		 if (check_traslado == 1)
		 {
	     xajax_agrega_emergencia_ctraslado_edit(fh_traslado,telefono,plan,hs_traslado,socio,nombre,tiposocio,edad,sexo,identificacion,documento,
	                             calle,numero,piso,depto,casa,monoblok,barrio,entre1,entre2,localidad,
			  				     referencia,zona,motivo1,color,observa1,observa2,opedesp,id_ate_edit
								 )
		 
		 }else { 
	     xajax_agrega_emergencia_edit(fecha,telefono,plan,horallam,socio,nombre,tiposocio,edad,sexo,identificacion,documento,
	                             calle,numero,piso,depto,casa,monoblok,barrio,entre1,entre2,localidad,
			  				     referencia,zona,motivo1,color,observa1,observa2,opedesp,id_ate_edit
								 )
	     }
	     ventana_cerrar.opener = window.self; 
	     ventana_cerrar.close(); 
	    //}
	 }

  };
function expl_js (parametro)
{
var art_explode = parametro.split('-');
//alert (art_explode[1]);

document.formulario.i_busca_x_articulo.value = art_explode[0];
document.formulario.i_busca_x_rubro.value = art_explode[1];

} 