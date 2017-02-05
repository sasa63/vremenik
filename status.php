<?php
if(!isset($_SESSION))session_start();


if(!isset($_SESSION['status']) or $_SESSION['status'] < 10){
    echo('Nemate dovoljno ovlasti!<br /><a href="index.php">Klikni za povratak</a>');
    die;
}
include('db.php');
$result = $db->query('select id from godine where aktivan = 1') or die(mysql_error());
$id_godina=$result->fetchColumn();
?>