<?php
include 'db.php';
$f=fopen('ljudi.txt', 'w');
$sql ='select id, pravo_ime from %PREFIKS%nastavnici';
$result=$db->query($sql);
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
fwrite($f, trim($row['id']).','.trim($row['pravo_ime'])."\r\n" );
}
fclose($f);
echo "<pre>";
echo file_get_contents('ljudi.txt');
echo '</pre>';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

