<?php
//Make a database connection
session_start();
mysql_connect("localhost", "root", "");
mysql_select_db("test");

include ("conexionamigos.php");
//Login section start
if(!isset($_SESSION["logged"])) 
{
  if(isset($_POST["username"]) && ($_POST['password'])) 
  
  {
    $query = mysql_query("SELECT id FROM site_members WHERE username = '".$_POST["username"]."' AND  password = '". $_POST["password"]."' ");
    if(mysql_num_rows($query) > 0) 
	{
      $row = mysql_fetch_array($query);
      $_SESSION["logged"] = $row["id"];
      header("Location: " . $_SERVER["PHP_SELF"]);
    }
  } 
  else 
  {
    echo("<!DOCTYPE HTML>
	<html lang='en-US'>
	<head>
		<meta charset='UTF-8'>
		<title></title>
	</head>
	<body>
		
		
		 <fieldset style='width:490px; position: relative; margin:0 auto;'>
		 
		  <legend >The Facebook </legend>
		
			<form method=\"POST\">
                 <input type=\"text\" name=\"username\" placeholder=\"Nombre\">
	             <input type=\"password\" name=\"password\" placeholder=\"Contraseña\">
                 <input type=\"submit\" name=\"submit\">  
           </form>
	
	    </fieldset>
	
	
	</body>
	</html>");
  }
} 
                                /*================================*/
else {
//end of login section

echo "<div style='width:100px; height:auto; position:relative; margin: 0 auto; background-color:lime;'><a href='logout.php'>Cerrar Sesion</a></div>";

$amistad = new Solicitudamistad ();
$amistad->nombreusuario ();
   
 	
              echo "<a  style=' position:relative; margin:20px 0px 0px 200px; '  href='aceptaramigos.php'>Ver solicitud de amistad</a> ";
   
 
$amistad->listarmiembros ();
@$amistad->agregarusuario($add);
$amistad->listaramigos ();
@$amistad->borraramigo($borrar);


} 


?>