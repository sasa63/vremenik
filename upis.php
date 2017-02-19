<?php
include 'db.php';
$data = file('ljudi-ansi.txt');

foreach ($data as $row) {
   
    $row1= explode(',', trim( $row));
    if($row1[0]>0)
    {
       
        //echo $row1[0],', ',$row1[1],'<br /';
        echo $sql="update %PREFIKS%nastavnici set". " pravo_ime=".$db->quote($row1[1])."" . " where id=$row1[0]";
        $result=$db->query($sql);
    }
}
/