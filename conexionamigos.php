<?php


 @$session = $_SESSION["logged"];

 
 echo  "<link rel='stylesheet' href='css/estilo.css' /> ";
 

 
Class Solicitudamistad 
{

function nombreusuario ()
{ 
   
   global $session;
   
   $consulta =" SELECT username FROM site_members  WHERE id = ' ".$session." ' ";
   $query = mysql_query($consulta);
   $rows = mysql_num_rows($query);
   if ($rows > 0) 
   {
         while ($fila = mysql_fetch_array( $query) )
	       {
		        echo "Bienvenido ". $fila[ 'username' ];
		   }
	   
	   
   }

}

function mostrarsolicitudamistad()
{
  
	global $session;
   
// Sección para mostrar las solicitudes de amistad
  $query = mysql_query("SELECT * FROM friendship_requests WHERE recipient = '" . $session . "'");
  if(mysql_num_rows($query) > 0) {
    while($row = mysql_fetch_array($query)) { 
      $_query = mysql_query("SELECT * FROM site_members WHERE id = '" . $row["sender"] . "'");
      while($_row = mysql_fetch_array($_query)) 
	  {
      
echo "  <strong> ". $_row["username"] . " </strong>quiere ser tu amigo. <a  class='botonaceptar'  href=\"" .$_SERVER["PHP_SELF"]."?accept=" . $_row["id"] . "\">Confirmar la solicitud</a><br />";
    
		echo "  <a class='botoneliminar' href=\" " . $_SERVER["PHP_SELF"] . "?borrar=" . $_row["id"] . "\">Eliminar</a>  <br />";	
  // Sección de aceptar solicitudes de amistad
  
  @$idaceptar = $_GET["accept"];
  
  if(isset($idaceptar)) 
  {
      $amistad = new Solicitudamistad ();
      $amistad->aceptarsolicitudamistad($idaceptar);
	 
  }
//END SECCION ACEPTAR SOLICITUD AMISTAD



           /******************* BORRAR SOLICITUD AMISTAD ***********************/
     @$borrar = $_GET["borrar"];     
if(isset($borrar)) 
 {
                            
	$amistad = new Solicitudamistad();
    $amistad->borrarsolicitudamistad($borrar);
 }

           /*****************END BORRAR SOLICITUD AMISTAD ************************/
	  }
    }
  }
  
  else 
  {
          echo "No tienes solicitudes por el momento";
		 
   }
   
  
   
   
//END SECCION PARA MOSTRAR SOLICITUD AMISTAD
}

function borrarsolicitudamistad ($borrar)
{
	global $session;
	
   mysql_query("DELETE FROM friendship_requests WHERE sender = '" . $borrar . "' AND recipient = '" . $session. "'");
	
	
}




function aceptarsolicitudamistad ($idaceptar)
{
	global $session;
	
	$query = mysql_query("SELECT * FROM friendship_requests WHERE sender = '" . $idaceptar . "' AND recipient = '" . $session. "'");
    if(mysql_num_rows($query) > 0) {
      
      $_query = mysql_query("SELECT * FROM site_members WHERE id = '" . $idaceptar . " ' ");
      $_row = mysql_fetch_array($_query);
      
      $friends = unserialize ($_row["friends"]);
      $friends[] = $session;      
                
      mysql_query("UPDATE site_members SET friends = '" .serialize($friends). "' WHERE id  = '" . $idaceptar . "'  ");
      
      $_query = mysql_query("SELECT * FROM site_members WHERE id = '" .$session. "'");
      $_row = mysql_fetch_array($_query);
      
      $friends = unserialize($_row["friends"]);
      $friends[] = $idaceptar;      
                
      mysql_query("UPDATE site_members SET friends = '" .serialize($friends). "' WHERE id = '" . $session . "'");
    }
    mysql_query("DELETE FROM friendship_requests WHERE sender = '" . $idaceptar . "' AND recipient = '" . $session. "'");
	
	
	
}








function listarmiembros ()
 { 
 
  
  global $session;

//Sección para mostrar la lista de miembros
  echo "<h2>Lista de Miembros:</h2>";
  $query = mysql_query("SELECT * FROM site_members WHERE id != '" . $session . "'");
  while($row = mysql_fetch_array($query)) {
    $yaamigo = false;
    @$friends = unserialize($row["friends"]);
    if(isset($friends[0])) {
      foreach($friends as $friend) {
        if($friend == $session) $yaamigo = true;
      }
    }
    echo @$row["username"];
    $_query = mysql_query("SELECT * FROM friendship_requests WHERE sender = '" . $session . "' AND recipient = '" . $row["id"] . "'");
    if(mysql_num_rows($_query) > 0) 
	{
       echo " - solicitud de amistad enviada.";
    } elseif($yaamigo == false) 
	{
       echo " - <a href=\"".$_SERVER["PHP_SELF"]."?add=".$row["id"]. "\">Agregar como amigo</a>";
	   //Sección para agregar amigo
            @$add = $_GET["add"];
            if(isset($add)) 
			{
               $amistad = new Solicitudamistad();
			   $amistad->agregarusuario($add);
			        
            }//END SECCION AGREGAR AMIGOS
    } 
	else {
      echo " - Ya son amigos.";
    }
    echo "<br />";
	
	 } //END WHILE
//END

     
}

function agregarusuario($add)
{
	global $session;
	     $query = mysql_query("SELECT id FROM site_members WHERE id = ' " . $add . " '   ");
          if(mysql_num_rows($query) > 0) 
		{
           $_query = mysql_query("SELECT * FROM friendship_requests WHERE sender = ' " . $session . " ' AND recipient = ' " . $add . " '  ");
           if(mysql_num_rows($_query) == 0) 
		    {
              mysql_query("INSERT INTO friendship_requests SET sender = ' " . $session . " ' , recipient = ' " . $add .  " '   ");
            }
        } 
	
	
}

function listaramigos ()
{
 
   global $session;
   

   
//Lista de amigos de inicio ====== Friends list start
  echo "<h2>Lista amigos:</h2>";
  $query = mysql_query("SELECT friends FROM site_members WHERE id = '" . $session . "'");
  while($row = mysql_fetch_array($query)) {
    $friends = unserialize($row["friends"]);
    
    if(isset($friends[0])) {
      foreach($friends as $friend) {
        $_query = mysql_query("SELECT * FROM site_members WHERE id = '" . $friend . "'");
        $_row = mysql_fetch_array($_query);

		    echo " - <a class='nombreamigo' href='perfil.php?user=".$_row["id"]." '> ".$_row["username"]."  </a>  <br /> ";
			
			echo "  <a class='botoneliminaramigo' href=\" " . $_SERVER["PHP_SELF"] . "?borrar=" . $_row["id"] . "\">Eliminar  Amigo </a>  <br />";	
			
		
			@$borrar = $_REQUEST['borrar'];
			        @$user = $_REQUEST["user"];
		
		       if(isset($user)) 
               {
			    @mostrarfoto($user);
		       }
			 
			
			
			 if(isset($borrar))
	         {
		       $amistad = new Solicitudamistad();
			   $amistad->borraramigo($borrar);
			 }
			
      }
    }
  }
//END
}

function borraramigo ($borrar)
{
	
   global $session;
	
   mysql_query("DELETE FROM site_members WHERE friends = '" . serialize($borrar) . "' AND id = '" . $session. "'");
}

			    

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
//end class
?>