<?php
//$mysql_host = "mysql9.000webhost.com";
$mysql_host = "localhost";
//$mysql_database = "a4098905_vremen";
$mysql_database="Vremenik";
//$mysql_user = "a4098905_sasa";
$mysql_user="root";
//$mysql_password = "KVWNU4f4";
$mysql_password="";
$db=new PDO("mysql:host=localhost;dbname=Vremenik","root","");
//mysql_select_db($mysql_database);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//$r=$db->query($mysql_password); $r->rowCount();
?>