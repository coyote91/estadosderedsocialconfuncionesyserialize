<?php 
session_start();

$_SESSION = array();

if (isset($_COOKIE['id']))   
{
setcookie("id",  $_SESSION["logged"] ,time ()- 3600,'/');
unset($_SESSION['logged']);



}


else 
{
header ('Location: index.php');

}



session_unset();
session_destroy();

?>