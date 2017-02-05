<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include 'db.php';
$sql = "Select * FROM datumi WHERE aktivan=1 ORDER BY id ASC" ;
$rb = 0;
$tj = -2;
$rtj = 0;
$result = mysql_query($sql);
While($row = mysql_fetch_array($result)){
    $rb++;
    if ($tj != date('W', strtotime($row['dan']))){
        $rtj++;
        $tj = date('W', strtotime($row['dan']));
    }
    $sql = "UPDATE datumi SET redbr= $rb, tjedan=$rtj WHERE id=$row[id]";
    mysql_query($sql) or die (mysql_error());
}
?>
