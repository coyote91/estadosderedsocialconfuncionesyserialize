<?php
session_start();
mysql_connect("localhost", "root", "");
mysql_select_db("test");
include ("conexionamigos.php");

$amistad = new Solicitudamistad ();
@$amistad->mostrarsolicitudamistad($idaceptar);


echo " <a style=' position:relative; margin: 180px 0px 0px 160px; ' href='index.php'>Regresar</a>";


?>