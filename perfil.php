<?php

 echo  "<link rel='stylesheet' href='css/perfil.css' /> ";

mysql_connect("localhost", "root", "");
mysql_select_db("networksocial");

include('conexionamigos.php');

$amistad = new Solicitudamistad();
@$amistad->borraramigo($user);
 /* 
Class T 
{
	 
		
			    

public static function mostrarfoto($user)
{
	$consultaft = " SELECT fotoperfil FROM site_members WHERE id = ".$user." ";
	$queryft = mysql_query($consultaft);

   $rowsft = mysql_num_rows($queryft);

	
	if ($rowsft > 0 )
	{
		while ( $arrayft = mysql_fetch_object($queryft))
	  	 {
	  	 	
			echo "<IMG class = 'fotoperfil'SRC='".$arrayft->fotoperfil. " ' WIDTH=142 HEIGHT=142>  ";
	  		
		}
	
   }
	  		  
	  		
		
	
	
}

function perfil()  
{
   echo '
    <div class="cajacontenidotimeline">
								
             <!--------COVER-IMAGE---> 
	
	                 <div id="coverimagen">
	
	                      <div id="cajaglobalcoversinimagen" class="coversinimagen" >
                              <div id="cajaglobalfootercoverinformacion">
	   
	                      
	 
	                                 <div id="cajafotoperfil"> ';
						  
						  
						                                
					                                
                                                       @T::mostrarfoto($user);    
						  
						  
						  
						         echo '     </div>
									
									 
									 
									  <!-------END CAJA FOTO PERFIL--------->
									
									   <ul id="menufootercoverimagen">
									   	<li class="mfci1"><a href="">Biografia</a></li>
									   	<li class="mfci2">Informacion</li>
									   	<li class="mfci3">Fotos</li>
									   	<li class="mfci4">Amigos</li>
									   	<li class="mfci5">Mas <i class="imagenpestaña"></i></li>
									   </ul>
									 
	 
	                          </div>
	
	                      </div>
	                 </div>
	 <!----END COVER-IMAGE---->
	                                   ' ;
	   
	

} //END FUNCTION PERFIL 

}
  $t = new T();
  $t->perfil();
  
*/
  /*  mostrarfoto($user);*/

?>