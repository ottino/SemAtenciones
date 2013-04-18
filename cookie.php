<?php
class cookieClass
{
  function constructor()
   {
     // definir constructor
   }
  public function parametros($nombre_var , $valor_var , $tiempo_session=0,$ruta="" , $dominio="" , $seguro=0)
    {
	  setcookie ($nombre_var , $valor_var); 
	}							 
  public function get($nombre_var)
    {
      if (isset ($_COOKIE [$nombre_var])){
	   return $_COOKIE[$nombre_var];
      } else {
	   return false;
	  } 	   
    }
  public function borrar_cookie($nombre_var)
     {
	   setcookie ($nombre_var);
	 }  
}
?>